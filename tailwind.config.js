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
                primary: "#2563eb", // Biru Kepercayaan
                secondary: "#FFFEFE", // Putih Bersih
                accent: "#f8fafc", // Abu Netral
                highlight: "#f8fe06", // Kuning Hangat
                danger: "#8C2F39", // Merah Emosional
                success: "#02c57a", // Hijau Harapan
            },
        },
    },
    plugins: [],
};
