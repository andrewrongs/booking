<?php

namespace Database\Seeders;

use App\Models\Country;
use Illuminate\Database\Seeder;

class CountryDatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $countries = [
            [
                'name' => 'Taiwan',
                'code' => 'TW',
                'currency' => 'TWD',
            ],
            [
                'name' => 'Japan',
                'code' => 'JP',
                'currency' => 'JPY',
            ],
            [
                'name' => 'United States',
                'code' => 'US',
                'currency' => 'USD',
            ],
            [
                'name' => 'China',
                'code' => 'CN',
                'currency' => 'CNY',
            ],
            [
                'name' => 'Korea',
                'code' => 'KR',
                'currency' => 'KRW',
            ],
            [
                'name' => 'Thailand',
                'code' => 'TH',
                'currency' => 'THB',
            ],
            [
                'name' => 'Malaysia',
                'code' => 'MY',
                'currency' => 'MYR',
            ],
            [
                'name' => 'Indonesia',
                'code' => 'ID',
                'currency' => 'IDR',
            ]
        ];

        foreach ($countries as $country) {
            Country::create([
                ...$country,
            ]);
        }
    }
}
