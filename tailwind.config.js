import defaultTheme from 'tailwindcss/defaultTheme';
import forms from '@tailwindcss/forms';

/** @type {import('tailwindcss').Config} */
export default {
    content: [
        './vendor/laravel/framework/src/Illuminate/Pagination/resources/views/*.blade.php',
        './storage/framework/views/*.php',
        './resources/views/**/*.blade.php',
    ],

    theme: {
        extend: {
            fontFamily: {
                sans: ['Figtree', ...defaultTheme.fontFamily.sans],
            },
            colors: {
                brandGreen: {
                    lightest : '#d7e0d8',
                    light: '#69886c',
                    mid: '#008f01',
                    dark: '#023805',
                },
                brandYellow: {
                    dark: '#e3a924',
                    light: '#f6eccc',
                },
                brandGrey: {
                    dark: '#',
                    light: '#e5e4e4',
                },
                borderWidth: {
                    3: '3px',
                    4: '4px',
                },
            },
        },
    },

    plugins: [forms],
    safelist: [
        'score-par',
        'score-birdie',
        'score-eagle',
        'score-bogey',
        'score-double'
    ],
};
