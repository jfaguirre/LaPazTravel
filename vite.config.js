import { defineConfig } from 'vite';
import laravel from 'laravel-vite-plugin';

export default defineConfig({
    plugins: [
        laravel({
            input: 
            [
                'resources/js/app.js',
                'resources/js/menu.js',
                'resources/css/app.css',
                'resources/css/main.css',
                'resources/css/inicio.css',                                 
                'resources/css/dashboard_sitio.css',                                 
            ],
            refresh: true,
        }),
    ],
});
