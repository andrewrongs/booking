import { defineConfig } from 'vite';
import { fileURLToPath } from 'url';
import { dirname } from 'path';
import laravel from 'laravel-vite-plugin';
import vue from '@vitejs/plugin-vue';
import path from 'path';

const __filename = fileURLToPath(import.meta.url);
const __dirname = dirname(__filename);

export default defineConfig({
    plugins: [
        laravel({
            input: 'resources/ts/app.ts',
            refresh: true,
        }),
        vue({
            template: {
                transformAssetUrls: {
                    base: null,
                    includeAbsolute: false,
                },
            },
        }),
    ],
    resolve: {
        alias: {
            '@': path.resolve(__dirname, './resources/ts')
        },
    },
    server: {
        host: 'localhost', // 明確指定主機
        port: 5173,
    }
});