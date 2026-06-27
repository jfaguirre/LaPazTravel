import { defineConfig } from 'vite';
import laravel from 'laravel-vite-plugin';

export default defineConfig({
    plugins: [
        laravel({
            input: 
            [
                'resources/css/app.css', 
                'resources/js/app.js',
                'resources/js/menu.js' //agregado para trabajar el script en un documento a parte de la vista
            ],
            refresh: true,
        }),
    ],
});
