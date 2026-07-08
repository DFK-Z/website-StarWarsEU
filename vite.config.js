import { defineConfig } from 'vite';
import laravel from 'laravel-vite-plugin';

export default defineConfig({
    plugins: [
        laravel({
            input: [
                'resources/css/app.css',  // <-- этот файл должен существовать
                'resources/js/app.js'
            ],
            refresh: true,
        }),
    ],
});
