/** @type {import('tailwindcss').Config} */
export default {
  content: [
    './resources/views/**/*.blade.php',
    './resources/js/**/*.js',
  ],
  theme: {
    extend: {
      colors: {
        // Champagne Sandstone & Burgundy Rose Luxury Palette
        sandstone: {
          base: '#EDE4D8',    // Page Base Background
          light: '#F7F1E8',   // Card & Surface (Soft Champagne Parchment)
          dark: '#E2D5C3',    // Section Background (Toasted Beige)
          border: '#D8CBB8',  // Card Borders
        },
        burgundy: {
          rose: '#6E2C3A',    // Primary Brand Color
          dark: '#58222E',    // Burgundy Hover State
        },
        brass: {
          gold: '#B88A44',    // Antique Brass Gold (Accents, Badges, Icons)
        },
        charcoal: {
          deep: '#2E1F22',    // Deep Plum-Charcoal (Headings, Body Text)
          mauve: '#5E4B4E',   // Warm Mauve-Grey (Subtitles)
        },
      },
      backgroundColor: {
        luxury: {
          base: '#EDE4D8',
          card: '#F7F1E8',
          section: '#E2D5C3',
          hover: '#FAF6F0',
        },
      },
      textColor: {
        luxury: {
          primary: '#2E1F22',
          secondary: '#5E4B4E',
          accent: '#B88A44',
          brand: '#6E2C3A',
        },
      },
      borderColor: {
        luxury: {
          subtle: '#D8CBB8',
          gold: '#B88A44',
        },
      },
      fontFamily: {
        heading: ['Playfair Display', 'serif'],
        body: ['Lato', 'sans-serif'],
        ui: ['Poppins', 'sans-serif'],
      },
      boxShadow: {
        'luxury-sm': '0 2px 8px rgba(46, 31, 34, 0.08)',
        'luxury-md': '0 4px 16px rgba(46, 31, 34, 0.12)',
        'luxury-lg': '0 8px 24px rgba(46, 31, 34, 0.15)',
        'luxury-focus': '0 0 0 3px rgba(110, 44, 58, 0.1)',
      },
      ringColor: {
        luxury: {
          primary: '#6E2C3A',
          gold: '#B88A44',
        },
      },
    },
  },
  plugins: [],
}
