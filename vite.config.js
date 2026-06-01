import { defineConfig } from 'vite';
import path from 'path';

export default defineConfig({
  // Base configuration handles absolute asset URL generation
  base: './',
  build: {
    outDir: 'assets/dist',
    emptyOutDir: true,
    manifest: true, // Crucial: generates the manifest.json so WordPress knows how to resolve hashed filenames
    rollupOptions: {
      input: {
        main: path.resolve(__dirname, 'assets/src/js/main.js')
      },
      output: {
        entryFileNames: 'js/[name]-[hash].js',
        chunkFileNames: 'js/[name]-[hash].js',
        assetFileNames: (assetInfo) => {
          let extType = assetInfo.name.split('.').pop();
          if (/png|jpe?g|svg|gif|tiff|bmp|ico/i.test(extType)) {
            extType = 'images';
          } else if (/css/i.test(extType)) {
            extType = 'css';
          }
          return `${extType}/[name]-[hash].[ext]`;
        }
      }
    }
  },
  server: {
    // Enable CORS so WordPress running on a different origin can load script modules
    cors: true,
    strictPort: true,
    port: 5173,
    hmr: {
      host: 'localhost'
    }
  }
});
