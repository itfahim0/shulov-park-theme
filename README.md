# Shulov Park (শুলভ পার্ক) - Premium WooCommerce Theme

[![WordPress](https://img.shields.io/badge/WordPress-21759B?style=for-the-badge&logo=wordpress&logoColor=white)](https://wordpress.org)
[![WooCommerce](https://img.shields.io/badge/WooCommerce-96588A?style=for-the-badge&logo=woocommerce&logoColor=white)](https://woocommerce.com)
[![PHP](https://img.shields.io/badge/PHP-777BB4?style=for-the-badge&logo=php&logoColor=white)](https://php.net)
[![Vite](https://img.shields.io/badge/Vite-646CFF?style=for-the-badge&logo=vite&logoColor=white)](https://vitejs.dev)
[![Tailwind CSS](https://img.shields.io/badge/Tailwind_CSS-38B2AC?style=for-the-badge&logo=tailwind-css&logoColor=white)](https://tailwindcss.com)

A high-performance, responsive WooCommerce theme designed specifically for **Shulov Park (শুলভ পার্ক)**, a modern online grocery store & daily essentials shop in Bangladesh. Engineered to deliver premium aesthetic quality on par with Chaldal, Meena Click, and Daraz Grocery.

This theme has been fully modernized and upgraded into a production-ready storefront powered by **Vite**, **Tailwind CSS**, and modern asynchronous eCommerce interfaces (AJAX mini-cart, quick-view, and custom cookie-based wishlist integrations).

---

## 🎨 Design System & Brand Identity

The theme features a luxurious, professional green and gold branding design tailored for fresh and organic retail stores:
- **Deep Green (`#0F6B35`):** Represents freshness, security, and organic trust (used in core headers, widgets, and key call-to-actions).
- **Fresh Green (`#2E8B57`):** Represents life and premium quality (used in secondary indicators and active hovers).
- **Luxurious Golden (`#D4AF37`):** Adds a premium shopping aesthetic (used in tags, offer countdowns, and prices).
- **Harmonized Light Gold (`#F4D03F`):** Used in overlays, accent text, and custom badges.
- **Harmonized White (`#FFFFFF`):** High-contrast background plates for clean grids.
- **Glassmorphic Dark Mode:** High-end dark theme mapping seamlessly with the `dark:` Tailwind class with local persistent cookies.

---

## 📁 Modern Code & Assets Directory

Below is the directory tree and description of the complete production-ready theme:

```text
shulov-park/
├── package.json                    # Dev dependencies (Vite, Tailwind, PostCSS, Autoprefixer) and script commands
├── vite.config.js                  # Vite configuration enqueuing entrypoints, CORS headers, and manifest files
├── postcss.config.js               # PostCSS plugin settings for Tailwind compilation
├── tailwind.config.js              # Tailwind custom colors, dark selectors, and layout overrides
├── style.css                       # Standard WordPress theme metadata definitions card (CSS rules migrated to main.css)
├── functions.php                   # Theme setups, performance tuning (script deferring, preconnects, blocks dequeuing)
├── header.php                      # FOUC-prevention Dark Mode class, sticky navigation, and drawer triggers
├── footer.php                      # Dynamic widget sections, checkout paths, and Quick View modal slots
├── front-page.php                  # Homepage grids utilizing highly optimized custom WP_Query loops
├── woocommerce.php                 # Unified container wrapper for WooCommerce page architectures
├── inc/
│   ├── customizer.php              # Multi-section customizer options panel (contacts, socials, operating hours)
│   ├── vite-assets.php             # Dynamic Vite dev server client enqueuer and manifest production loader
│   ├── acf-settings.php            # Programmatic ACF groups and native WordPress Admin Settings API Panel
│   └── ajax-actions.php            # Secure nonce-verified endpoints for Cart updates, Wishlist, and Quick Views
├── template-parts/
│   ├── common/
│   │   ├── mini-cart-drawer.php    # Slide-out AJAX cart drawer displaying item lists, quantity triggers, and subtotals
│   │   └── schema.php              # Injects rich JSON-LD SEO structured data for products, website, and organizations
│   └── product/
│       ├── product-card.php        # Reusable product grid card (ACF custom badges, quick view hooks, wishlist)
│       └── quick-view-modal.php    # Detailed specifications drawer handling variable attribute selectors
├── assets/
│   ├── demo-products-import.xml    # Standard product importing WXR XML data
│   ├── images/                     # Graphic banner resources and brand assets
│   ├── src/                        # MODERN FRONTEND ENTRYPOINTS
│   │   ├── css/
│   │   │   └── main.css            # Standard base sheet enjecting Tailwind directives and all custom style overrides
│   │   └── js/
│   │       └── main.js             # Main Javascript entrypoint handling drawers, modals, countdowns, and dark mode cookies
│   └── dist/                       # PRODUCTION COMPILED ASSETS (Hashed and cached-busted by Vite)
│       ├── .vite/
│       │   └── manifest.json       # Asset map read by inc/vite-assets.php to load hashed bundles
│       ├── css/                    # Autoprefixed, minified utility stylesheet
│       └── js/                     # Modular compiled storefront javascript
```

---

## ⚙️ Operating Instructions & Commands

### Local Development Environment
Start by installing your packages and spinning up Vite's HMR server:

1.  **Install all dependencies**:
    ```bash
    npm install
    ```
2.  **Start Vite HMR server**:
    ```bash
    npm run dev
    ```
    *Vite will boot a local development engine at `http://localhost:5173`. WordPress automatically detects this active server, enqueues Vite's dev client, and starts hot-reloading. Any edits you make to css/main.css or js/main.js reflect instantly on the browser without page refreshes!*

### Production Compilation
When preparing to deploy your theme to production:

1.  **Generate production bundle**:
    ```bash
    npm run build
    ```
    *Vite empty-cleans the `assets/dist/` directory, bundles and tree-shakes assets into hashed production files, and writes the `manifest.json` file. WordPress will read this manifest and serve the production bundles automatically.*

---

## 👨‍💻 Developer & Repository Info
- **GitHub Repository**: [https://github.com/itfahim0/shulov-park-theme](https://github.com/itfahim0/shulov-park-theme)
- **Git Clone URL**: `https://github.com/itfahim0/shulov-park-theme.git`
- **Maintained & Developed by**: **[@itfahim0](https://github.com/itfahim0)**
- **License**: Licensed under the **GNU General Public License v2 or later**.
