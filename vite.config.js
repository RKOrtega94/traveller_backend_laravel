import { defineConfig } from "vite";
import laravel from "laravel-vite-plugin";

/**
 * Vite configuration file for the Traveller Backend Laravel project.
 * @typedef {import('vite').UserConfig} UserConfig
 * @typedef {import('vite-plugin-laravel').LaravelPluginOptions} LaravelPluginOptions
 * @type {UserConfig}
 */
export default defineConfig({
    plugins: [
        /**
         * Vite plugin for Laravel projects.
         * @type {import('vite-plugin-laravel').VitePluginLaravel}
         */
        laravel({
            input: ["resources/css/app.css", "resources/js/app.js"],
            refresh: true,
        }),
    ],
    build: {
        outDir: "my-docs",
    },
});
