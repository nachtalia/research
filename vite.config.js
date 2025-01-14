import { defineConfig } from 'vite';
import laravel from 'laravel-vite-plugin';
import vue from '@vitejs/plugin-vue';

export default defineConfig({
    plugins: [
        laravel({
            input: [
                'resources/js/app.js', // Main frontend script
                'resources/js/ssr.js', // SSR (if applicable)
                'resources/css/app.css', // CSS entry point (optional)
            ],
            refresh: true, // Enables hot module replacement
        }),
        vue({
            template: {
                transformAssetUrls: {
                    base: '/storage/',
                    includeAbsolute: false,
                },
            },
        }),
    ],
    server: {
        host: '127.0.0.1',
        port: 5173, // Ensure this matches your environment setup
        https: false,
    },
    build: {
        rollupOptions: {
            output: {
                manualChunks: {
                    vendor: ['vue', 'axios'], // Split vendor libraries
                },
            },
        },
    },
});
