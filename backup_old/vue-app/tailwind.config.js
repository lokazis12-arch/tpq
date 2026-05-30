/** @type {import('tailwindcss').Config} */
export default {
  content: [
    "./index.html",
    "./src/**/*.{vue,js,ts,jsx,tsx}",
  ],
  theme: {
    extend: {
      colors: {
        // Primary — Emerald
        primary: {
          DEFAULT: '#004d34',
          container: '#006747',
          fixed: '#a0f4ca',
          'fixed-dim': '#84d7af',
        },
        'on-primary': {
          DEFAULT: '#ffffff',
          container: '#8fe2ba',
          fixed: '#002114',
          'fixed-variant': '#005137',
        },
        'inverse-primary': '#84d7af',

        // Secondary — Mint
        secondary: {
          DEFAULT: '#4f635b',
          container: '#d1e7dd',
          fixed: '#d1e7dd',
          'fixed-dim': '#b6cbc2',
        },
        'on-secondary': {
          DEFAULT: '#ffffff',
          container: '#556961',
          fixed: '#0c1f19',
          'fixed-variant': '#374b44',
        },

        // Tertiary — Dark Slate
        tertiary: {
          DEFAULT: '#3d4446',
          container: '#545b5d',
          fixed: '#dde4e6',
          'fixed-dim': '#c1c8ca',
        },
        'on-tertiary': {
          DEFAULT: '#ffffff',
          container: '#ccd3d5',
        },

        // Surface system
        surface: {
          DEFAULT: '#f7faf5',
          dim: '#d7dbd6',
          bright: '#f7faf5',
          'container-lowest': '#ffffff',
          'container-low': '#f1f5f0',
          container: '#ebefea',
          'container-high': '#e5e9e4',
          'container-highest': '#e0e3df',
          tint: '#0b6c4b',
          variant: '#e0e3df',
        },
        'on-surface': {
          DEFAULT: '#181d1a',
          variant: '#3f4943',
        },
        'inverse-surface': '#2d312e',
        'inverse-on-surface': '#eef2ed',

        // Outline
        outline: {
          DEFAULT: '#6f7a72',
          variant: '#bec9c1',
        },

        // Error
        error: {
          DEFAULT: '#ba1a1a',
          container: '#ffdad6',
        },
        'on-error': {
          DEFAULT: '#ffffff',
          container: '#93000a',
        },

        // Semantic shortcuts
        emerald: '#006747',
        mint: '#d1e7dd',
        'deep-emerald': '#004d34',
      },

      fontFamily: {
        sans: ['"Plus Jakarta Sans"', 'system-ui', '-apple-system', 'sans-serif'],
        jakarta: ['"Plus Jakarta Sans"', 'sans-serif'],
      },

      fontSize: {
        'h1': ['40px', { lineHeight: '1.2', fontWeight: '700', letterSpacing: '-0.02em' }],
        'h2': ['32px', { lineHeight: '1.3', fontWeight: '600', letterSpacing: '-0.01em' }],
        'h3': ['24px', { lineHeight: '1.4', fontWeight: '600' }],
        'body-lg': ['18px', { lineHeight: '1.6', fontWeight: '400' }],
        'body-md': ['16px', { lineHeight: '1.6', fontWeight: '400' }],
        'body-sm': ['14px', { lineHeight: '1.5', fontWeight: '400' }],
        'label-md': ['14px', { lineHeight: '1.2', fontWeight: '600', letterSpacing: '0.01em' }],
        'label-sm': ['12px', { lineHeight: '1.2', fontWeight: '500' }],
      },

      borderRadius: {
        'sm': '4px',
        DEFAULT: '8px',
        'md': '12px',
        'lg': '16px',
        'xl': '24px',
        'full': '9999px',
      },

      boxShadow: {
        'level-1': '0 1px 3px rgba(0,103,71,0.04), 0 4px 8px rgba(0,103,71,0.04)',
        'level-2': '0 4px 12px rgba(0,103,71,0.08), 0 8px 24px rgba(0,103,71,0.06)',
        'level-3': '0 8px 32px rgba(0,103,71,0.12), 0 16px 48px rgba(0,103,71,0.08)',
        'inner-soft': 'inset 0 2px 4px rgba(0,103,71,0.04)',
      },

      spacing: {
        'xs': '4px',
        'sm-space': '12px',
        'gutter': '16px',
        'md-space': '24px',
        'lg-space': '48px',
        'xl-space': '80px',
      },

      backdropBlur: {
        'glass': '20px',
      },

      animation: {
        'fade-in': 'fadeIn 0.3s ease-out',
        'slide-up': 'slideUp 0.3s ease-out',
        'slide-down': 'slideDown 0.3s ease-out',
        'slide-in-right': 'slideInRight 0.3s ease-out',
        'scale-in': 'scaleIn 0.2s ease-out',
        'pulse-soft': 'pulseSoft 2s ease-in-out infinite',
      },

      keyframes: {
        fadeIn: {
          '0%': { opacity: '0' },
          '100%': { opacity: '1' },
        },
        slideUp: {
          '0%': { opacity: '0', transform: 'translateY(12px)' },
          '100%': { opacity: '1', transform: 'translateY(0)' },
        },
        slideDown: {
          '0%': { opacity: '0', transform: 'translateY(-12px)' },
          '100%': { opacity: '1', transform: 'translateY(0)' },
        },
        slideInRight: {
          '0%': { opacity: '0', transform: 'translateX(24px)' },
          '100%': { opacity: '1', transform: 'translateX(0)' },
        },
        scaleIn: {
          '0%': { opacity: '0', transform: 'scale(0.95)' },
          '100%': { opacity: '1', transform: 'scale(1)' },
        },
        pulseSoft: {
          '0%, 100%': { opacity: '1' },
          '50%': { opacity: '0.7' },
        },
      },
    },
  },
  plugins: [],
}
