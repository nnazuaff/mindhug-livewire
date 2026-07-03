import { defineConfig } from 'vite';
import laravel from 'laravel-vite-plugin';
import { bunny } from 'laravel-vite-plugin/fonts';
import tailwindcss from '@tailwindcss/vite';

export default defineConfig({
    plugins: [
        laravel({
            input: ['resources/css/app.css', 'resources/js/app.js'],
            refresh: true,
            fonts: [
                bunny('Instrument Sans', {
                    weights: [400, 500, 600],
                }),
            ],

        }),
        tailwindcss(),
    ],
    // server: {
    //     host: '0.0.0.0', // Mengizinkan akses dari luar
    //     watch: {
    //         ignored: ['**/storage/framework/views/**'],
    //     },
    //     hmr: {
    //         host: 'lawlessly-unpanoplied-enid.ngrok-free.dev', // URL Ngrok Tuan tanpa https://
    //         protocol: 'wss', // Wajib wss (WebSocket Secure) karena Ngrok pake HTTPS
    //     },
    // },
    server: {
        watch: {
            ignored: ['**/storage/framework/views/**'],
        },
    },
});
