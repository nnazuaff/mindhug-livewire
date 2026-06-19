import defaultTheme from 'tailwindcss/defaultTheme';

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
                sans: ['Poppins', ...defaultTheme.fontFamily.sans],
                baloo: ['"Baloo 2"', 'cursive'],
            },
            colors: {
                softBrown: '#d7c6b8',
                darkBrown: '#8b6f5c',
            },
        },
    },
    plugins: [],
};
