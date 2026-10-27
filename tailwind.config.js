import defaultTheme from 'tailwindcss/defaultTheme';
import forms from '@tailwindcss/forms';

/** @type {import('tailwindcss').Config} */
export default {
    darkMode: 'class',
    content: [
        './vendor/laravel/framework/src/Illuminate/Pagination/resources/views/*.blade.php',
        './storage/framework/views/*.php',
        './resources/views/**/*.blade.php',
        './resources/js/**/*.vue',
    ],

    theme: {
        extend: {
            fontFamily: {
                sans: ['Nunito', ...defaultTheme.fontFamily.sans],
                nunito: ['Nunito', ...defaultTheme.fontFamily.sans],
                poppins: ['Poppins', ...defaultTheme.fontFamily.sans],
                hand: ['"Shantell Sans"', 'cursive'],
                legible: ['"Atkinson Hyperlegible"', ...defaultTheme.fontFamily.sans],
                form: ['"IBM Plex Mono"', ...defaultTheme.fontFamily.mono],
            },
            colors: {
                // Landing "study desk" tokens: notebook paper, ballpoint ink, red pen, 2B pencil, highlighter
                paper: '#FBFCFE',
                rule: '#CFE0F3',
                ink: {
                    DEFAULT: '#1B2A6B',
                    soft: '#4A5683',
                },
                pen: '#C8323F',
                graphite: '#34353B',
                stabilo: '#FFE45E',
                sticky: '#FFF1A6',
            },
            backgroundImage: {
                'notebook-lines': 'repeating-linear-gradient(to bottom, transparent 0, transparent 31px, #CFE0F3 31px, #CFE0F3 32px)',
            },
            keyframes: {
                highlight: {
                    from: { transform: 'scaleX(0) rotate(-1deg)' },
                    to: { transform: 'scaleX(1) rotate(-1deg)' },
                },
                pencil: {
                    from: { opacity: '0', transform: 'scale(0.3)' },
                    to: { opacity: '1', transform: 'scale(1)' },
                },
                slideUp: {
                    from: { opacity: '0', transform: 'translateY(20px)' },
                    to: { opacity: '1', transform: 'translateY(0)' },
                },
                fadeIn: {
                    from: { opacity: '0' },
                    to: { opacity: '1' },
                },
            },
            animation: {
                'slide-up': 'slideUp 0.6s cubic-bezier(0.16, 1, 0.3, 1) forwards',
                'fade-in': 'fadeIn 0.5s ease-out forwards',
                highlight: 'highlight 0.7s cubic-bezier(0.65, 0, 0.35, 1) 0.4s both',
                pencil: 'pencil 0.28s cubic-bezier(0.34, 1.56, 0.64, 1) both',
            },
        },
    },

    plugins: [forms],
};
