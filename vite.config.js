import { defineConfig } from 'vite';
import laravel, { refreshPaths } from 'laravel-vite-plugin'


export default defineConfig({
    
    plugins: [
        laravel({
            input: [
                'resources/css/app.css',
                'resources/js/app.js', 
                'resources/css/filament/login/theme.css',
                              'resources/css/filament/login/theme.css', // ADICIONE ESTA LINHA
                'resources/css/filament/login/theme.js',   // ADICIONE ESTA LINHA
            ],
            refresh: [
                ...refreshPaths,
                'app/Livewire/**',
            ],
        }),
    ],
});
