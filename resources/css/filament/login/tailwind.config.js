import preset from '../../../../vendor/filament/filament/tailwind.config.preset'

export default {
    presets: [preset],
    content: [
        './app/Filament/**/*.php',
        './resources/views/filament/**/*.blade.php',
        "./resources/**/*.blade.php",
        './vendor/filament/**/*.blade.php',
    ],
    safelist: [
    'no-print',
    'print-label-page',
    'print-label-container',
    'page-break', ],
}
