import { fileURLToPath, URL } from 'node:url';
import { defineConfig } from 'vite';
import tailwindcss from '@tailwindcss/vite';

const html = (name) => fileURLToPath(new URL(`./${name}.html`, import.meta.url));

export default defineConfig({
    plugins: [
        tailwindcss(),
    ],
    resolve: {
        alias: {
            '@ui': fileURLToPath(new URL('../../packages/ui', import.meta.url)),
        },
    },
    build: {
        rollupOptions: {
            input: {
                index: html('index'),
                about: html('about'),
                installation: html('installation'),
                theming: html('theming'),
                components: html('components'),
                button: html('button'),
                input: html('input'),
                checkbox: html('checkbox'),
                datepicker: html('datepicker'),
                alert: html('alert'),
                accordion: html('accordion'),
                spinner: html('spinner'),
                icon: html('icon'),
                'form-field': html('form-field'),
            },
        },
    },
    server: {
        port: 3000,
        open: false,
    },
});
