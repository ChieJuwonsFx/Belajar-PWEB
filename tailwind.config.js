import defaultTheme from 'tailwindcss/defaultTheme';
import forms from '@tailwindcss/forms';

/** @type {import('tailwindcss').Config} */
export default {
    content: [
        './vendor/laravel/framework/src/Illuminate/Pagination/resources/views/*.blade.php',
        './storage/framework/views/*.php',
        './resources/views/**/*.blade.php',
    ],
    darkMode: 'class',

    theme: {
        extend: {
            fontFamily: {
                'body': [
                    'Inter', 
                    'ui-sans-serif', 
                    'system-ui', 
                    '-apple-system', 
                    'system-ui', 
                    'Segoe UI', 
                    'Roboto', 
                    'Helvetica Neue', 
                    'Arial', 
                    'Noto Sans', 
                    'sans-serif', 
                    'Apple Color Emoji', 
                    'Segoe UI Emoji', 
                    'Segoe UI Symbol', 
                    'Noto Color Emoji'
                  ],
                'sans': [
                    'Inter', 
                    'ui-sans-serif', 
                    'system-ui', 
                    '-apple-system', 
                    'system-ui', 
                    'Segoe UI', 
                    'Roboto', 
                    'Helvetica Neue', 
                    'Arial', 
                    'Noto Sans', 
                    'sans-serif', 
                    'Apple Color Emoji', 
                    'Segoe UI Emoji', 
                    'Segoe UI Symbol', 
                    'Noto Color Emoji',
                    // 'Figtree', ...defaultTheme.fontFamily.sans
                  ]
                // sans: ['Figtree', ...defaultTheme.fontFamily.sans],
            },
            colors: {
                primary: '#1E376A',
                secondary: '#555555', 
                terti: '#FFB800',
                warning : '#8A7300',
                danger: '#850000',
                success: '#048730',
                card: {
                    danger: '#B71C1C',       
                    dangerSoft: '#FFA7A5',  
                    dangerBg: '#FFD6DA',     
            
                    warning: '#FFA114',  
                    warningSoft: '#FFF193', 
                    warningBg: '#FFF9C4',    
            
                    success: '#388E3C',      
                    successSoft: '#A0D9A0',  
                    successBg: '#C8E6C9',   
                },
            },   
        },
    },

    plugins: [forms],
};
