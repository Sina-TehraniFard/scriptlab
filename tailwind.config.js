/** @type {import('tailwindcss').Config} */
module.exports = {
  content: [
    "./theme/scriptlab-theme/**/*.php",
    "./theme/scriptlab-theme/**/*.js",
  ],
  theme: {
    extend: {
      colors: {
        primary: '#404040',
        secondary: '#c9356e',
      },
      fontFamily: {
        sans: ['Noto Sans JP', 'sans-serif'],
      },
    },
  },
  plugins: [],
}