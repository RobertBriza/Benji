module.exports = {
  content: [
    './src/**/*.js',
    './app/**/*.latte'
  ],
  theme: {
    container: {
      center: true,
    },
    screens: {
      sm: '480px',
      md: '768px',
      lg: '976px',
      xl: '1440px',
    },
    extend: {
      animation: {
        fade: 'fadeOut 1s ease-in-out',
      },
      keyframes: theme => ({
        fadeOut: {
          '0%': { opacity: '1' },
          '100%': { opacity: '0' },
        },
      }),
      container: {
        center: true,
        screens: {
          lg: '800px',
          xl: '800px',
        },
      },
    },
  },
  safelist: [
    'border-green-500',
    'border-yellow-500',
    'border-red-500',
    'text-red-400',
    'text-green-400',
    'text-yellow-300',
    'text-sm',
    'py-2',
    'px-10',
    'top-10',
    'w-6',
    'h-6',
    'space-x-4'
  ],
  plugins: [],
}
