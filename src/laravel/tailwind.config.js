/** @type {import('tailwindcss').Config} */
export default {
  content: [
    "./resources/**/*.blade.php",
    "./resources/**/*.js",
    "./resources/**/*.vue",
    "./formkit.theme.mjs"
  ],
  theme: {
    extend: {},
  },
  plugins: [],
  darkMode: 'class',
}

