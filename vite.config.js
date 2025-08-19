import { defineConfig } from "vite";
import laravel from "laravel-vite-plugin";
import path from "path"; // <-- require path from node
import react from "@vitejs/plugin-react";

export default defineConfig({
    plugins: [
        laravel({
            // edit the first value of the array input to point to our new sass files and folder.
            input: ["resources/scss/app.scss", "resources/js/app.jsx"],
            refresh: true,
        }),
        react(),
    ],
    // Add resolve object and aliases
    resolve: {
        alias: {
            "~icons": path.resolve(
                __dirname,
                "node_modules/bootstrap-icons/font"
            ),
            "~bootstrap": path.resolve(__dirname, "node_modules/bootstrap"),
            "~resources": "/resources/",
        },
    },
});
