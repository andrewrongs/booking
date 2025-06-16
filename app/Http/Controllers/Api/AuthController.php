<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Str;
use Illuminate\Validation\ValidationException;

class AuthController extends Controller
{
    /**
     * 驗證請求簽名
     */
    private function validateRequestSignature(Request $request): void
    {
        $timestamp = $request->header('X-Timestamp');
        $signature = $request->header('X-Signature');
        $clientId = $request->header('X-Client-Id');

        // 檢查必要標頭
        if (!$timestamp || !$signature || !$clientId) {
            throw ValidationException::withMessages([
                'auth' => ['無效的請求'],
            ]);
        }

        // 檢查時間戳是否在 5 分鐘內
        if (abs(time() - $timestamp) > 300) {
            throw ValidationException::withMessages([
                'auth' => ['請求已過期'],
            ]);
        }

        // 從環境變數獲取客戶端密鑰
        $clientSecret = config('app.client_secrets.' . $clientId);
        if (!$clientSecret) {
            throw ValidationException::withMessages([
                'auth' => ['無效的客戶端'],
            ]);
        }

        // 構建簽名字符串
        $stringToSign = $clientId . $timestamp . json_encode($request->all());
        $expectedSignature = hash_hmac('sha256', $stringToSign, $clientSecret);

        // 驗證簽名
        if (!hash_equals($expectedSignature, $signature)) {
            throw ValidationException::withMessages([
                'auth' => ['簽名驗證失敗'],
            ]);
        }
    }

    /**
     * 處理用戶註冊
     */
    public function register(Request $request): JsonResponse
    {
        // 驗證請求簽名
        $this->validateRequestSignature($request);

        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|lowercase|email|max:255|unique:'.User::class,
            'password' => ['required', 'confirmed', Rules\Password::defaults()],
            'role' => 'required|string|in:admin,user',
            'level' => 'required|integer|min:1|max:10',
            'birthday' => 'required|date',
            'phone' => 'required|string|max:255',
        ]);

        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'role' => $request->role,
            'level' => $request->level,
            'birthday' => $request->birthday,
            'phone' => $request->phone,
        ]);

        event(new Registered($user));

        $token = $user->createToken('auth_token')->plainTextToken;

        return response()->json([
            'success' => true,
            'message' => '註冊成功',
            'data' => [
                'user' => $user,
                'token' => $token
            ]
        ], 201);
    }

    /**
     * 處理用戶登入
     */
    public function login(Request $request): JsonResponse
    {
        $request->validate([
            'email' => 'required|email',
            'password' => 'required',
        ]);

        if (!Auth::attempt($request->only('email', 'password'))) {
            return response()->json([
                'message' => '登入憑證不正確'
            ], 401);
        }

        $user = User::where('email', $request->email)->firstOrFail();
        $token = $user->createToken('auth_token')->plainTextToken;

        return response()->json([
            'message' => '登入成功',
            'user' => $user,
            'token' => $token
        ]);
    }

    /**
     * 處理用戶登出
     */
    public function logout(Request $request): JsonResponse
    {
        $request->user()->currentAccessToken()->delete();

        return response()->json([
            'message' => '登出成功'
        ]);
    }

    /**
     * 獲取當前用戶信息
     */
    public function me(Request $request): JsonResponse
    {
        return response()->json($request->user());
    }
} 