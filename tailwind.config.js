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
                primary: "#1E88E5", // Biru Kepercayaan
                secondary: "#FFFFFF", // Putih Bersih
                accent: "#F5F7FA", // Abu Netral
                highlight: "#FDD835", // Kuning Hangat
                danger: "#E53935", // Merah Emosional
                success: "#43A047", // Hijau Harapan
            },
        },
    },
    plugins: [],
};
