import { fontFamily as _fontFamily } from "tailwindcss/defaultTheme";

/** @type {import('tailwindcss').Config} */
export const content = [
    "./vendor/laravel/framework/src/Illuminate/Pagination/resources/views/*.blade.php",
    "./storage/framework/views/*.php",
    "./resources/views/**/*.blade.php",
    "./resources/**/*.svelte",
];
export const theme = {
    extend: {
        fontFamily: {
            sans: ["Nunito", ..._fontFamily.sans],
        },
    },
};
export const plugins = [require("daisyui")];
