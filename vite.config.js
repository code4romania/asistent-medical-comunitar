import { defineConfig } from 'vite';
import laravel from 'laravel-vite-plugin';

export default defineConfig({
    plugins: [
        laravel({
            refresh: true,
            detectTls: 'amc.test',
            input: ['resources/css/app.css', 'resources/js/app.js'],
        }),
    ],
});
