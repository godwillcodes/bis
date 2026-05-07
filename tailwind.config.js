/** @type {import('tailwindcss').Config} */
module.exports = {
  content: [
    './**/*.php',
    './template-parts/**/*.php',
    './inc/**/*.php',
    './pages/**/*.php',
    './components/**/*.php',
    './js/**/*.js',
  ],
  theme: {
    extend: {
      colors: {
        'bis-red': '#ED3437', // Custom red color
        'bis-pink': '#EC4899', // Pink-500 equivalent
        red: {
          600: '#ED3437',
          700: '#D12E31',
          800: '#B5282B',
          500: '#ED3437',
        },
      },
      fontFamily: {
        'display': ['"Stilson Display"', 'serif'],
        'sans': ['Montserrat', 'sans-serif'],
      },
    },
  },
  plugins: [],
}

