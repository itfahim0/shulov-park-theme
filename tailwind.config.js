/** @type {import('tailwindcss').Config} */
export default {
  content: [
    "./*.php",
    "./inc/**/*.php",
    "./template-parts/**/*.php",
    "./woocommerce/**/*.php"
  ],
  darkMode: 'class', // Enables cookie/class-based Dark Mode
  theme: {
    container: {
      center: true,
      padding: '1.25rem',
      screens: {
        sm: '640px',
        md: '768px',
        lg: '1024px',
        xl: '1240px', // Standard container max-width from style.css
      },
    },
    extend: {
      colors: {
        primary: {
          DEFAULT: '#0F6B35',
          hover: '#1b5e20',
          light: '#2E8B57',
          rgba: 'rgba(46, 139, 87, 0.15)',
        },
        accent: {
          DEFAULT: '#D4AF37',
          hover: '#b89222',
          light: '#F4D03F',
          bg: 'rgba(212, 175, 55, 0.1)',
        },
        neutral: {
          dark: '#1E293B',
          muted: '#64748B',
          light: '#F4F6F5',
          border: '#E2E8F0',
        },
        success: '#10B981',
        warning: '#F59E0B',
        danger: '#EF4444',
      },
      fontFamily: {
        sans: ['Poppins', 'system-ui', '-apple-system', 'BlinkMacSystemFont', 'Segoe UI', 'Roboto', 'sans-serif'],
        bn: ['Hind Siliguri', 'sans-serif'],
      },
      boxShadow: {
        soft: '0 4px 24px rgba(15, 107, 53, 0.06)',
        hover: '0 12px 32px rgba(15, 107, 53, 0.14)',
      },
      borderRadius: {
        sm: '8px',
        md: '12px',
        lg: '20px',
      },
      transitionTimingFunction: {
        smooth: 'cubic-bezier(0.4, 0, 0.2, 1)',
      },
      transitionDuration: {
        smooth: '350ms',
      }
    },
  },
  plugins: [],
}
