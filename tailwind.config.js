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
                highlight: "#ffd57d", // Kuning Hangat
                danger: "#8C2F39", // Merah Emosional
                success: "#568203", // Hijau Harapan
            },
        },
    },
    plugins: [],
};
