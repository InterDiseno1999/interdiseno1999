import { defineConfig } from 'vite';
import laravel from 'laravel-vite-plugin';
import tailwindcss from '@tailwindcss/vite';

export default defineConfig({
    theme: {
      extend: {
        colors: {
          'bg-inter-dark': '#333333', 
          'text-inter-dark': '#333333', 
        'bg-inter-beige': '#C0B7B1',
        },
        fontFamily: {
          'poppins': ['Poppins', 'sans-serif'],
        },
      },
    },
    plugins: [
        laravel({
            input: ['resources/css/app.css', 'resources/js/app.js'],
            refresh: true,
        }),
        tailwindcss(),
    ],
    server: {
        watch: {
            ignored: ['**/storage/framework/views/**'],
        },
    },
});
