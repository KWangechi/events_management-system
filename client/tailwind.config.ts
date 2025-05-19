/** @type {import('tailwindcss').Config} */
module.exports = {
  content: [
    './components/**/*.{vue,js,ts}',
    './layouts/**/*.vue',
    './pages/**/*.vue',
    './app.vue',
  ],
  theme: {
    extend: {
      colors: {
        primary: '#6C47FF',
        secondary: '#F5F3FF',
        accent: '#F9A826',
        // Add more as needed
      },
      fontFamily: {
        sans: ['Inter', 'ui-sans-serif', 'system-ui'],
      },
      borderRadius: {
        xl: '1.25rem',
      },
      boxShadow: {
        card: '0 2px 12px 0 rgba(44, 62, 80, 0.08)',
      },
    },
  },
//   plugins: [
//     require('@tailwindcss/typography'),
//     require('@tailwindcss/forms'),
//     require('@tailwindcss/line-clamp'),
//   ],
}