import { defineConfig } from "vite";
import laravel from "laravel-vite-plugin";
import react from "@vitejs/plugin-react";

export default defineConfig({
  server: {
    port: 5197,
    host: "localhost",
  },
  plugins: [
    laravel({
      input: "src/app.jsx",
      publicDirectory: "../backend/public",
      buildDirectory: "build",
      refresh: ["../backend/resources/views/**", "../backend/routes/**"],
    }),
    react(),
  ],
});
