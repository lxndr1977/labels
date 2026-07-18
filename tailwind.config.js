import preset from './vendor/filament/filament/tailwind.config.preset'

/** @type {import('tailwindcss').Config} */
export default {
    presets: [preset], // Usa as configurações base do Filament

    content: [
        './app/Filament/**/*.php',
        './resources/views/**/*.blade.php', // Caminho simplificado para todas as views
        './vendor/filament/**/*.blade.php',
    ],

    // A REGRA MAIS IMPORTANTE!
    safelist: [
        'no-print',
        'print-label-page',
        'print-label-container',
        'page-break',
    ],
}
