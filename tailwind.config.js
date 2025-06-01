export default {
  mode: 'jit',
  content: [
    "./index.html",
    "./src/**/*.{js,ts,jsx,tsx}",
    "./resources/**/*.{php}",
  ],
  theme: {
    extend: {
      fontFamily: {
        custom: ['is', 'sans-serif'],
        custom: ['is-i', 'sans-serif'],
        custom: ['is-b', 'sans-serif'],
        custom: ['is-m', 'sans-serif'],
      }
    },
  },
  plugins: [],
}