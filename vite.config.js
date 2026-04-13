import { defineConfig } from 'vite';
import laravel from 'laravel-vite-plugin';
import tailwindcss from '@tailwindcss/vite';

export default defineConfig({
    plugins: [
        tailwindcss(),
        laravel({
            input: [
                'resources/css/app.css',
                'resources/js/app.js',
                'resources/js/nav.js',
                'resources/js/appointments/index.js',
                'resources/js/transactions/index.js'
            ],
            refresh: true,
        }),
    ],
    server: {
        host: '127.0.0.1', // This forces Vite to use this exact IP
        port: 5173,
        strictPort: true,
        watch: {
            ignored: ['**/storage/framework/views/**'],
        },
    },
});
