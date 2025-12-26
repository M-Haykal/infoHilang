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
                primary: "#6082B6", // Biru Kepercayaan
                secondary: "#FFFEFE", // Putih Bersih
                accent: "#F5F7FA", // Abu Netral
                highlight: "#f8fe06", // Kuning Hangat
                danger: "#8C2F39", // Merah Emosional
                success: "#02c57a", // Hijau Harapan
            },
        },
    },
    plugins: [],
};
