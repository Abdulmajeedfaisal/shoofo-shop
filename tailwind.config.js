import defaultTheme from 'tailwindcss/defaultTheme';
import forms from '@tailwindcss/forms';

/** @type {import('tailwindcss').Config} */
export default {
    darkMode: 'class', // Enable dark mode with class strategy
    
    content: [
        './vendor/laravel/framework/src/Illuminate/Pagination/resources/views/*.blade.php',
        './vendor/filament/**/*.blade.php',
        './storage/framework/views/*.php',
        './resources/views/**/*.blade.php',
        './resources/js/**/*.js',
    ],

    theme: {
        extend: {
            // Luxury Color Palette
            colors: {
                midnight: {
                    DEFAULT: '#0A1628',
                    50: '#E8EBF0',
                    100: '#D1D7E1',
                    200: '#A3AFC3',
                    300: '#7587A5',
                    400: '#475F87',
                    500: '#0A1628',
                    600: '#081220',
                    700: '#060D18',
                    800: '#040910',
                    900: '#020408',
                },
                'royal-gold': {
                    DEFAULT: '#D4AF37',
                    50: '#FAF7ED',
                    100: '#F5EFDB',
                    200: '#EBDFB7',
                    300: '#E1CF93',
                    400: '#D7BF6F',
                    500: '#D4AF37',
                    600: '#B8962C',
                    700: '#8C7221',
                    800: '#604E16',
                    900: '#342A0B',
                },
                'rose-gold': {
                    DEFAULT: '#B76E79',
                    50: '#F5E8EA',
                    100: '#EBD1D5',
                    200: '#D7A3AB',
                    300: '#C37581',
                    400: '#B76E79',
                    500: '#A35561',
                    600: '#8F4C53',
                    700: '#6B3940',
                    800: '#47262A',
                    900: '#231315',
                },
                silver: {
                    DEFAULT: '#C0C0C0',
                    50: '#F8F8F8',
                    100: '#F0F0F0',
                    200: '#E0E0E0',
                    300: '#D0D0D0',
                    400: '#C0C0C0',
                    500: '#A8A8A8',
                    600: '#909090',
                    700: '#787878',
                    800: '#606060',
                    900: '#484848',
                },
                charcoal: '#2D3748',
                slate: '#64748B',
                cream: '#FAF9F6',
            },

            // Luxury Typography
            fontFamily: {
                playfair: ['"Playfair Display"', 'Georgia', 'serif'],
                inter: ['Inter', ...defaultTheme.fontFamily.sans],
                cormorant: ['"Cormorant Garamond"', 'Georgia', 'serif'],
                // Arabic Fonts
                tajawal: ['Tajawal', 'sans-serif'],
                cairo: ['Cairo', 'sans-serif'],
                noto: ['"Noto Kufi Arabic"', 'sans-serif'],
            },

            // Generous Spacing Scale
            spacing: {
                '18': '4.5rem',
                '88': '22rem',
                '100': '25rem',
                '112': '28rem',
                '128': '32rem',
            },

            // Sophisticated Shadows
            boxShadow: {
                'elegant': '0 4px 6px -1px rgba(0, 0, 0, 0.1), 0 2px 4px -1px rgba(0, 0, 0, 0.06)',
                'elegant-lg': '0 10px 15px -3px rgba(0, 0, 0, 0.1), 0 4px 6px -2px rgba(0, 0, 0, 0.05)',
                'elegant-xl': '0 20px 25px -5px rgba(0, 0, 0, 0.1), 0 10px 10px -5px rgba(0, 0, 0, 0.04)',
                'elegant-2xl': '0 25px 50px -12px rgba(0, 0, 0, 0.25)',
                'luxury': '0 30px 60px -15px rgba(10, 22, 40, 0.3)',
            },

            // Animation Timing
            transitionDuration: {
                '400': '400ms',
                '600': '600ms',
                '800': '800ms',
                '2000': '2000ms',
            },

            // Custom Border Radius
            borderRadius: {
                '4xl': '2rem',
            },

            // Animation Keyframes
            keyframes: {
                'fade-in': {
                    '0%': { opacity: '0' },
                    '100%': { opacity: '1' },
                },
                'fade-out': {
                    '0%': { opacity: '1' },
                    '100%': { opacity: '0' },
                },
                'fade-in-up': {
                    '0%': { opacity: '0', transform: 'translateY(30px)' },
                    '100%': { opacity: '1', transform: 'translateY(0)' },
                },
                'fade-in-down': {
                    '0%': { opacity: '0', transform: 'translateY(-30px)' },
                    '100%': { opacity: '1', transform: 'translateY(0)' },
                },
                'slide-up': {
                    '0%': { transform: 'translateY(20px)', opacity: '0' },
                    '100%': { transform: 'translateY(0)', opacity: '1' },
                },
                'slide-down': {
                    '0%': { transform: 'translateY(-20px)', opacity: '0' },
                    '100%': { transform: 'translateY(0)', opacity: '1' },
                },
                'scale-in': {
                    '0%': { transform: 'scale(0.95)', opacity: '0' },
                    '100%': { transform: 'scale(1)', opacity: '1' },
                },
                'bounce-elegant': {
                    '0%, 100%': { transform: 'translateY(0)' },
                    '50%': { transform: 'translateY(-10px)' },
                },
                'float': {
                    '0%, 100%': { transform: 'translateY(0)' },
                    '50%': { transform: 'translateY(-10px)' },
                },
                'pulse-gold': {
                    '0%, 100%': { boxShadow: '0 0 0 0 rgba(212, 175, 55, 0.4)' },
                    '50%': { boxShadow: '0 0 0 20px rgba(212, 175, 55, 0)' },
                },
                'shimmer': {
                    '0%': { backgroundPosition: '-200% 0' },
                    '100%': { backgroundPosition: '200% 0' },
                },
            },
            animation: {
                'fade-in': 'fade-in 0.6s ease-out',
                'fade-out': 'fade-out 0.3s ease-out',
                'fade-in-up': 'fade-in-up 0.6s ease-out',
                'fade-in-down': 'fade-in-down 0.6s ease-out',
                'slide-up': 'slide-up 0.5s ease-out',
                'slide-down': 'slide-down 0.5s ease-out',
                'scale-in': 'scale-in 0.3s ease-out',
                'bounce-elegant': 'bounce-elegant 1s ease-in-out infinite',
                'float': 'float 3s ease-in-out infinite',
                'pulse-gold': 'pulse-gold 2s infinite',
                'shimmer': 'shimmer 2s infinite',
            },
        },
    },

    plugins: [
        forms,
        // RTL Support Plugin
        function({ addUtilities }) {
            const newUtilities = {
                '.rtl': {
                    direction: 'rtl',
                },
                '.ltr': {
                    direction: 'ltr',
                },
                '.transition-smooth': {
                    transition: 'all 300ms cubic-bezier(0.4, 0.0, 0.2, 1)',
                },
                '.transition-elegant': {
                    transition: 'all 500ms cubic-bezier(0.25, 0.46, 0.45, 0.94)',
                },
                '.transition-bounce': {
                    transition: 'all 300ms cubic-bezier(0.68, -0.55, 0.265, 1.55)',
                },
                '.hover-lift': {
                    transition: 'transform 300ms cubic-bezier(0.4, 0.0, 0.2, 1), box-shadow 300ms cubic-bezier(0.4, 0.0, 0.2, 1)',
                },
                '.hover-lift:hover': {
                    transform: 'translateY(-8px)',
                    boxShadow: '0 20px 40px rgba(0, 0, 0, 0.2)',
                },
                '.hover-glow': {
                    transition: 'box-shadow 300ms cubic-bezier(0.4, 0.0, 0.2, 1)',
                },
                '.hover-glow:hover': {
                    boxShadow: '0 0 30px rgba(212, 175, 55, 0.5)',
                },
                '.bg-gradient-gold': {
                    background: 'linear-gradient(135deg, #D4AF37 0%, #E8C84A 50%, #D4AF37 100%)',
                },
                '.bg-gradient-luxury': {
                    background: 'linear-gradient(135deg, #0A1628 0%, #1E293B 50%, #2D3748 100%)',
                },
                '.text-gradient-gold': {
                    background: 'linear-gradient(135deg, #D4AF37 0%, #F5EFDB 50%, #D4AF37 100%)',
                    '-webkit-background-clip': 'text',
                    '-webkit-text-fill-color': 'transparent',
                    'background-clip': 'text',
                },
                '.backdrop-blur-luxury': {
                    'backdrop-filter': 'blur(12px) saturate(180%)',
                    'background-color': 'rgba(255, 255, 255, 0.95)',
                },
            }
            addUtilities(newUtilities, ['responsive', 'hover'])
        },
    ],
};
