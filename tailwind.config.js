/** @type {import('tailwindcss').Config} */
module.exports = {
  content: ['./**/*.{html,js,php}'],
  theme: {
    textColor: {
      primary: '#3E7D60',
      secondary: '#DC052D',
    },
    extend: {
      colors: {
        primary: '#3E7D60',
        secondary: '#DC052D',
      },
    },
  },
  plugins: [],
}