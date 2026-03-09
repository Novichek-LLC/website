import defaultTheme from 'tailwindcss/defaultTheme'

/** @type {import('tailwindcss').Config} */
export default {
    content: [
        './resources/**/*.blade.php',
        './resources/**/*.js',
        './resources/**/*.vue',
        './app/Nova/**/*.php',
    ],
    theme: {
        extend: {
            fontFamily: {
                sans: ['Inter', ...defaultTheme.fontFamily.sans],
                display: ['Manrope', ...defaultTheme.fontFamily.sans],
            },
            colors: {
                brand: {
                    bg: '#08111f',
                    bgSoft: '#0b1526',
                    surface: '#0f1b31',
                    surface2: '#13213c',
                    line: '#213250',
                    text: '#f3f7ff',
                    muted: '#96a6c5',
                    primary: '#57c7ff',
                    primarySoft: '#89d9ff',
                    accent: '#8f7cff',
                    accentSoft: '#b8acff',
                    success: '#22c55e',
                    warning: '#f59e0b',
                    danger: '#f43f5e',
                },
            },
            boxShadow: {
                soft: '0 10px 30px rgba(5, 15, 35, 0.25)',
                glow: '0 0 0 1px rgba(87, 199, 255, 0.10), 0 12px 40px rgba(87, 199, 255, 0.14)',
                panel: '0 20px 60px rgba(2, 8, 23, 0.45)',
            },
            borderRadius: {
                '4xl': '2rem',
            },
            backgroundImage: {
                'hero-grid':
                    'radial-gradient(circle at 20% 20%, rgba(87, 199, 255, 0.10), transparent 25%), radial-gradient(circle at 80% 0%, rgba(143, 124, 255, 0.12), transparent 30%), linear-gradient(180deg, rgba(255,255,255,0.02), rgba(255,255,255,0))',
                'panel-gradient':
                    'linear-gradient(180deg, rgba(255,255,255,0.06), rgba(255,255,255,0.02))',
                'button-gradient':
                    'linear-gradient(135deg, #57c7ff 0%, #8f7cff 100%)',
            },
            maxWidth: {
                '8xl': '90rem',
            },
            spacing: {
                18: '4.5rem',
                22: '5.5rem',
                30: '7.5rem',
            },
        },
    },
    plugins: [],
}