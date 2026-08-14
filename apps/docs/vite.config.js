import { fileURLToPath, URL } from 'node:url';
import { defineConfig } from 'vite';
import tailwindcss from '@tailwindcss/vite';

export default defineConfig({
    plugins: [
        tailwindcss(),
    ],
    resolve: {
        alias: {
            '@ui': fileURLToPath(new URL('../../packages/ui', import.meta.url)),
        },
    },
    server: {
        port: 3000,
        open: false
    }
});
