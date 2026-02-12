import defaultTheme from 'tailwindcss/defaultTheme';
import forms from '@tailwindcss/forms';

/** @type {import('tailwindcss').Config} */
export default {
    // 1. Enable Dark Mode
    darkMode: 'class', 

    // 2. Define where your classes are used
    content: [
        './vendor/laravel/framework/src/Illuminate/Pagination/resources/views/*.blade.php',
        './storage/framework/views/*.php',
        './resources/views/**/*.blade.php',
        './resources/**/*.js',
    ],

    theme: {
        extend: {
            fontFamily: {
                // Keeping your default Figtree font
                sans: ['Figtree', ...defaultTheme.fontFamily.sans],
            },
        },
    },

    // 3. Keep the Laravel Forms plugin
    plugins: [forms],
};