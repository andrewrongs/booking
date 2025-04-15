import defaultTheme from 'tailwindcss/defaultTheme'
import forms from '@tailwindcss/forms'
import type { Config } from 'tailwindcss'

/** @type {import('tailwindcss').Config} */
export default {
    content: [
        './vendor/laravel/framework/src/Illuminate/Pagination/resources/views/*.blade.php',
        './storage/framework/views/*.php',
        './resources/views/**/*.blade.php',
        './resources/ts/**/*.vue',
    ],
    darkMode: 'class',
    theme: {
        extend: {
            fontFamily: {
                sans: ['Figtree', ...defaultTheme.fontFamily.sans],
            },
            colors: {
                current: 'currentColor',
                transparent: 'transparent',
                white: '#FFFFFF',
                black: '#1C1C1C',
                'black-2': '#1C1C1C',
                bodydark: '#AEB7C0',
                bodydark1: '#DEE4EE',
                bodydark2: '#8A99AF',
                boxdark: '#24303F',
                'boxdark-2': '#1A222C',
                strokedark: '#2E3A47',
                'graydark': '#1d2430',
            },
            width: {
                '20': '5rem',
                '72.5': '18.125rem',
            },
            spacing: {
                '5.5': '1.375rem',
                '6.5': '1.625rem',
            },
            zIndex: {
                '9999': '9999',
            },
        },
    },
    plugins: [forms],
} satisfies Config;
