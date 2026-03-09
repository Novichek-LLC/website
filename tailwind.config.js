export default {
  content: [
    './resources/**/*.blade.php',
    './resources/**/*.js',
    './resources/**/*.vue',
  ],
  theme: {
    extend: {
      colors: {
        brand: {
          50: '#eef7ff',
          100: '#d8ecff',
          200: '#badeff',
          300: '#89c8ff',
          400: '#53a8ff',
          500: '#2f88f6',
          600: '#1b6ce6',
          700: '#1957d0',
          800: '#1b47a8',
          900: '#1b3d85'
        }
      },
      boxShadow: {
        soft: '0 10px 40px rgba(15, 23, 42, 0.12)',
      },
      borderRadius: {
        '4xl': '2rem',
      }
    },
  },
  plugins: [],
};
