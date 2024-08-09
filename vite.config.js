import { defineConfig } from 'vite';
import vue from '@vitejs/plugin-vue';
import laravel from 'laravel-vite-plugin';
import { resolve } from 'path';

export default defineConfig({
    plugins: [
        laravel({
            input: ['resources/css/app.css', 'resources/js/app.js'],
            refresh: true,
        }),
        vue(),
    ],
    build: {
        outDir: 'public/dist', // Set your desired output directory
        assetsDir: '', // Optional: Define assets directory inside outDir if needed
    },
    resolve: {
        alias: {
            '@': resolve(__dirname, 'resources/js'),
            'vue': 'vue/dist/vue.esm-bundler.js',
        },
    },
});
