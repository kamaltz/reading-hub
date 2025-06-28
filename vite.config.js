import { defineConfig } from "vite";
import laravel from "laravel-vite-plugin";
import react from "@vitejs/plugin-react";
import path from "path";
import { fileURLToPath } from "url"; // <-- Impor helper yang benar

// Ini adalah cara yang benar dan robust untuk mendapatkan __dirname di ES Modules
const __filename = fileURLToPath(import.meta.url);
const __dirname = path.dirname(__filename);

export default defineConfig({
    plugins: [
        laravel({
            input: "resources/js/app.jsx",
            refresh: true,
        }),
        react(),
    ],
    resolve: {
        alias: {
            // Alias ini sekarang akan menunjuk ke path yang benar
            "@": path.resolve(__dirname, "resources/js"),
        },
    },
    server: {
        // Gunakan IP eksplisit untuk menghindari masalah resolusi nama host
        host: "127.0.0.1",
        port: 5173,
    },
});
