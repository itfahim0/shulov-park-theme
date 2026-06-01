# Shulov Park (শুলভ পার্ক) - Premium WooCommerce Theme

[![WordPress](https://img.shields.io/badge/WordPress-21759B?style=for-the-badge&logo=wordpress&logoColor=white)](https://wordpress.org)
[![WooCommerce](https://img.shields.io/badge/WooCommerce-96588A?style=for-the-badge&logo=woocommerce&logoColor=white)](https://woocommerce.com)
[![PHP](https://img.shields.io/badge/PHP-777BB4?style=for-the-badge&logo=php&logoColor=white)](https://php.net)

A high-performance, responsive WooCommerce theme designed specifically for **Shulov Park (শুলভ পার্ক)**, a modern online grocery store & daily essentials shop in Bangladesh. Engineered to deliver premium aesthetic quality on par with Chaldal, Meena Click, and Daraz Grocery, this theme incorporates dynamic customizers, seamless Swiper JS animations, localized payment graphics, and micro-interactions.

---

## 🎨 Design System & Brand Identity

The theme features a luxurious, professional green and gold branding design tailored for fresh and organic retail stores:
- **Deep Green (`#0F6B35`):** Represents freshness, security, and organic trust (used in core headers, widgets, and key call-to-actions).
- **Fresh Green (`#2E8B57`):** Represents life and premium quality (used in secondary indicators and active hovers).
- **Luxurious Golden (`#D4AF37`):** Adds a premium shopping aesthetic (used in tags, offer countdowns, and prices).
- **Harmonized Light Gold (`#F4D03F`):** Used in overlays, accent text, and custom badges.
- **Harmonized White (`#FFFFFF`):** High-contrast background plates for clean grids.

---

## 📁 Complete Code Structure

Below is the directory tree and description of the complete production-ready theme:

```text
shulov-park/
├── style.css                       # Core design system, variables, responsive typography, and WooCommerce overrides
├── functions.php                   # Theme setup enqueues (Fonts, Swiper, FontAwesome), wrapper hooks, and AJAX fragments
├── header.php                      # Sticky search-centered header, wishlist indicators, and dynamic mini-cart counters
├── footer.php                      # Columned widgets, store hours, newsletter forms, and localized trust payment gateway ribbons
├── front-page.php                  # Interactive storefront homepage grid with premium Swiper slides and custom loops
├── woocommerce.php                 # Unified container wrapper for WooCommerce single views, carts, checkouts, and archives
├── installation_instructions.md       # Extensive setup guide for administrators and customers
├── README.md                       # Comprehensive repository documentation
├── inc/
│   └── customizer.php              # Multi-section customizer options panel (contacts, social, deadlines, store hours)
└── assets/
    ├── demo-products-import.xml    # Standard WXR import file populated with 5 default grocery items in BDT currency
    ├── js/
    │   └── theme.js                # Core JS logic: sticky scroll, mobile drawer toggle, real-time countdown, and AJAX form feedback
    └── images/
        ├── logo.png                # Transparent brand identity logotype (শুলভ পার্ক)
        ├── hero-slide-1.jpg        # Premium supermarket basket banner (আপনার প্রতিদিনের বিশ্বস্ত সঙ্গী)
        ├── hero-slide-2.png        # Fresh vegetables bag banner (তাজা পণ্য, সুস্থ জীবন)
        ├── hero-slide-3.png        # Yellow app promo banner (ঘরে বসেই কেনাকাটা করুন)
        └── hero-slide-4.png        # Dark green premium basket banner (প্রতিদিনের কেনাকাটা হোক সহজ, সাশ্রয়ী ও নিশ্চিন্ত)
```

---

## 💻 File Descriptions & Capabilities

### 1. Typography & Styling (`style.css`)
Implements HSL typography and spacing layouts. Houses responsive grids (`1200px` to mobile stacking), smooth zoom scale overlays, dynamic buttons with interactive transition scales, and detailed styles for all standard WooCommerce checkout fields and cart tables.

### 2. Core Architecture (`functions.php`)
- Enqueues **Hind Siliguri** (Bangla) and **Poppins** (English) Google Fonts alongside Swiper and FontAwesome libraries.
- Implements `woocommerce_add_to_cart_fragments` to automatically update the header's cart count badge via AJAX when products are added to the basket without requiring a page refresh.
- Integrates `shulov_park_get_wishlist_count()` to dynamically display YITH Wishlist product counts.
- Sets BDT (`৳`) as the standard WooCommerce currency symbol.

### 3. Header & Navigation (`header.php`)
Constructs the sticky header with central product search inputs, desktop/mobile responsive nav menus, account dashboard links, and the wishlists/carts items indicators.

### 4. Interactive Frontpage (`front-page.php`)
Combines:
- **Hero Slider:** Full-width Swiper carousel utilizing the four high-resolution graphic banners, configured with hidden screen-reader semantic headings for optimal SEO indexing.
- **Featured Categories:** Eight grid boxes (Grocery, Veggies, Fruits, Dairy, Drinks, Snacks, Cosmetics, Household) styled with rounded curves and hover states.
- **Flash Sale Countdown:** Real-time javascript countdown timer pulling dates dynamically from the admin panel, followed by active sale grids.
- **Why Choose Us:** Five beautiful graphic cards explaining shopping perks.
- **Testimonials & App Promos:** Localized buyer reviews and mobile store download rows.

### 5. Options Panel (`inc/customizer.php`)
Registers customized controls under **Appearance > Customize > Shulov Park Options**:
- **Contacts & Socials:** Phone, Email, Store Address, Facebook page, Instagram profile, and YouTube channel.
- **Flash Sale Deadline:** Set specific deadlines (`YYYY-MM-DDTHH:MM:SS` format) and title headers.
- **Mobile Downloads:** Google Play Store and Apple App Store links.
- **Operating Hours:** Weekly store hours and delivery descriptions.

### 6. JavaScript Functions (`assets/js/theme.js`)
Handles the sticky scroll class additions, toggles the mobile drawer and burger icons, implements the real-time Flash Sale ticking countdown down to the second, and handles dynamic submit states inside the newsletter.

---

## ⚙️ Installation & Quick Setup

For complete, detailed configurations, consult [installation_instructions.md](file:///d:/Ecomerce/Shulove%20park/wp-content/themes/shulov-park/installation_instructions.md).

1. Ensure **WooCommerce** and **YITH WooCommerce Wishlist** are active on your WordPress installation.
2. Activate the **Shulov Park** theme in **Appearance > Themes**.
3. Create a static page titled **Home** and set it as your static Homepage in **Settings > Reading**.
4. Configure your navigation menus in **Appearance > Menus** and check the box for **Primary Menu**.
5. Import standard products, BDT prices, categories, and tags using the WXR XML file:
   Go to **Tools > Import > WordPress** and upload `wp-content/themes/shulov-park/assets/demo-products-import.xml`.
6. Customize deadlines, hours, and app stores in **Appearance > Customize > Shulov Park Options**.

---

## 👨‍💻 Developer & License
- Maintained & Developed by **[@itfahim0](https://github.com/itfahim0)**.
- Licensed under the **GNU General Public License v2 or later**.
