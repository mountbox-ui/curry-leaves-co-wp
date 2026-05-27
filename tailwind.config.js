/** @type {import('tailwindcss').Config} */
module.exports = {
  content: [
    "./*.php",
    "./template-parts/**/*.php",
    "./templates/**/*.php",
    "./menu/**/*.php",
    "./inc/**/*.php",
    "./src/**/*.js"
  ],
  theme: {
    extend: {
      colors: {
        gold: {
          50: '#fdf8ef',
          100: '#faefd6',
          200: '#f4dcab',
          300: '#edc476',
          400: '#e5a73e',
          500: '#d4942a',  /* Primary warm gold */
          600: '#b87520',
          700: '#99581d',
          800: '#7d471f',
          900: '#673b1d',
        },
        charcoal: {
          50: '#f6f6f6',
          100: '#e7e7e7',
          200: '#d1d1d1',
          300: '#b0b0b0',
          400: '#888888',
          500: '#6d6d6d',
          600: '#5d5d5d',
          700: '#4f4f4f',
          800: '#454545',
          900: '#1a1a1a',  /* Deep black/charcoal */
          950: '#0d0d0d',
        },
        cream: {
          50: '#fefdfb',
          100: '#fdf9f0',
          200: '#faf3e0',  /* Soft cream */
          300: '#f5e8c8',
          400: '#f0d9a6',
          500: '#e8c67e',
        },
        olive: {
          50: '#f6f7f0',
          100: '#eaecdd',
          200: '#d6dabe',
          300: '#bcc298',
          400: '#a3aa76',
          500: '#879059',
          600: '#6a7345',  /* Dark olive */
          700: '#525939',
          800: '#434831',
          900: '#3a3e2c',
        },
        orange: {
          50: '#fff7ed',
          100: '#ffedd5',
          200: '#fed7aa',
          300: '#fdba74',
          400: '#fb923c',
          500: '#f97316',
          600: '#ea580c',
          700: '#c2410c',
          800: '#9a3412',
          900: '#7c2d12',
        }
      },
      fontFamily: {
        'serif-luxury': ['"Playfair Display"', 'Georgia', 'serif'],
        'serif-elegant': ['"Cormorant Garamond"', 'Georgia', 'serif'],
        'sans': ['"Inter"', 'system-ui', 'sans-serif'],
      },
      animation: {
        'float': 'float 6s ease-in-out infinite',
        'float-slow': 'float 8s ease-in-out infinite',
        'glow': 'glow 2s ease-in-out infinite alternate',
        'shimmer': 'shimmer 2s linear infinite',
        'fade-up': 'fadeUp 0.8s ease-out forwards',
        'fade-in': 'fadeIn 1s ease-out forwards',
        'scale-in': 'scaleIn 0.5s ease-out forwards',
        'slide-right': 'slideRight 0.8s ease-out forwards',
        'slide-left': 'slideLeft 0.8s ease-out forwards',
        'pulse-gold': 'pulseGold 2s ease-in-out infinite',
        'spin-slow': 'spin 20s linear infinite',
      },
      keyframes: {
        float: {
          '0%, 100%': { transform: 'translateY(0px)' },
          '50%': { transform: 'translateY(-20px)' },
        },
        glow: {
          '0%': { boxShadow: '0 0 5px rgba(212, 148, 42, 0.2)' },
          '100%': { boxShadow: '0 0 20px rgba(212, 148, 42, 0.4)' },
        },
        shimmer: {
          '0%': { backgroundPosition: '-200% 0' },
          '100%': { backgroundPosition: '200% 0' },
        },
        fadeUp: {
          '0%': { opacity: '0', transform: 'translateY(40px)' },
          '100%': { opacity: '1', transform: 'translateY(0)' },
        },
        fadeIn: {
          '0%': { opacity: '0' },
          '100%': { opacity: '1' },
        },
        scaleIn: {
          '0%': { opacity: '0', transform: 'scale(0.9)' },
          '100%': { opacity: '1', transform: 'scale(1)' },
        },
        slideRight: {
          '0%': { opacity: '0', transform: 'translateX(-40px)' },
          '100%': { opacity: '1', transform: 'translateX(0)' },
        },
        slideLeft: {
          '0%': { opacity: '0', transform: 'translateX(40px)' },
          '100%': { opacity: '1', transform: 'translateX(0)' },
        },
        pulseGold: {
          '0%, 100%': { boxShadow: '0 0 0 0 rgba(212, 148, 42, 0.4)' },
          '50%': { boxShadow: '0 0 0 12px rgba(212, 148, 42, 0)' },
        },
      },
      backgroundImage: {
        'gradient-radial': 'radial-gradient(var(--tw-gradient-stops))',
        'gradient-luxury': 'linear-gradient(135deg, #0d0d0d 0%, #1a1a1a 50%, #0d0d0d 100%)',
      },
      backdropBlur: {
        'xs': '2px',
      },
    },
  },
  plugins: [],
}
