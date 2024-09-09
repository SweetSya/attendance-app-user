/** @type {import('tailwindcss').Config} */
export default {
    content: [
        "./resources/**/*.blade.php",
        "./resources/**/*.js",
        "./resources/**/*.vue",
        "./node_modules/flowbite/**/*.js",
    ],
    theme: {
        extend: {
            screens: {
                xs: "376px",
            },
            colors: {
                ocean: {
                    50: "#eff9ff",
                    100: "#dff2ff",
                    200: "#b7e6ff",
                    300: "#78d4ff",
                    400: "#30beff",
                    500: "#05a7f2",
                    600: "#0085d0",
                    700: "#006aa8",
                    800: "#025a8a",
                    900: "#074367",
                    950: "#052f4c",
                },
                cinnabar: {
                    50: "#fff1f1",
                    100: "#ffdfdf",
                    200: "#ffc5c5",
                    300: "#ff9d9d",
                    400: "#ff6566",
                    500: "#ff3435",
                    600: "#ee2425",
                    700: "#c80d0e",
                    800: "#a50f10",
                    900: "#881415",
                    950: "#4a0505",
                },
            },
        },
    },
    plugins: [require("flowbite/plugin")],
};
