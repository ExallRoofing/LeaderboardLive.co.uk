import { defineConfig } from 'vite';
import laravel from 'laravel-vite-plugin';

export default defineConfig({
    plugins: [
        laravel({
            input: [
                'resources/css/app.css',
                'resources/css/prelaunch.css',
                'resources/js/app.js',
                'resources/js/subscribe.js',
            ],
            refresh: true,
        }),
    ],
});
