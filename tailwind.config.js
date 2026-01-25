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
                // primary: "#2563eb",
                // secondary: "#FFFEFE",
                // accent: "#f8fafc",
                // highlight: "#f8fe06",
                // danger: "#8C2F39",

                success: {
                    DEFAULT: 'oklch(62.7% 0.194 149.214)', // green-600
                },

                danger: {
                    DEFAULT: 'oklch(57.7% 0.245 27.325)', // red-600
                    light: 'oklch(97.1% 0.013 17.38)', // red-50
                },

                primary: {
                    DEFAULT: 'oklch(54.6% 0.245 262.881)', // blue-600
                    dark: 'oklch(48.8% 0.243 264.376)', // blue-700
                    darker: 'oklch(42.4% 0.199 265.638)', // blue-800
                    light: 'oklch(97% 0.014 254.604)', // blue-50 untuk background aktif
                },

                // Orange-500 sebagai aksen (Urgent, Alert, Hilang)
                accent: {
                    DEFAULT: 'oklch(70.5% 0.213 47.604)', // orange-500
                    hover: 'oklch(64.6% 0.222 41.116)', // orange-600
                    surface: 'oklch(98% 0.016 73.684)', // orange-50 untuk bg soft
                },

                // Slate-800 untuk teks utama dan elemen gelap
                dark: {
                    DEFAULT: 'oklch(27.9% 0.041 260.031)', // slate-800
                    hover: 'oklch(20.8% 0.042 265.755)', // slate-900
                    soft: 'oklch(55.4% 0.046 257.417)', // slate-500 untuk teks sekunder
                },

                netral: {
                    50: 'oklch(98.5% 0.005 247.8)', // slate-50 (Background)
                    100: 'oklch(96.2% 0.01 247.8)', // slate-100 (Input BG)
                    200: 'oklch(91.5% 0.015 247.8)', // gray-200 (Border halus)
                    300: 'oklch(82.8% 0.019 247.8)', // gray/slate-300 (Border input)
                    400: 'oklch(70.7% 0.022 254.1)', // gray/slate-400 (Placeholder)
                    500: 'oklch(62.4% 0.011 255.5)', // gray-500 (Text Muted)
                }
            },
        },
    },
    plugins: [],
};
