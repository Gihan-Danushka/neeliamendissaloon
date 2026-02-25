/** @type {import('tailwindcss').Config} */
module.exports = {
  content: [
    "./resources/**/*.blade.php",
    "./resources/**/*.js",
    "./resources/**/*.vue",
  ],
  theme: {
    extend: {
      colors: {
        customPalette: {
          light: '#ca8a04',    // Dark Yellow / Gold
          DEFAULT: '#1e40af',  // Medium/Dark Blue
          dark: '#1e3a8a',     // Dark Blue
          button: '#ca8a04',   // Dark Yellow / Gold
          buttonhover: '#a16207', // Darker Gold
          darker: '#172554',   // Very Dark Blue
        },
        fontFamily: {
          lara: ['Lara', 'sans-serif'],
          sans: ['ui-sans-serif', 'system-ui'],
          serif: ['ui-serif', 'Georgia'],
          mono: ['ui-monospace', 'SFMono-Regular'],
          playfair: ['Playfair Display', 'serif'],
        },
      },
    },
  },
  plugins: [],
}

