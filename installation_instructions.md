# Shulov Park Theme - Setup & Installation Instructions

This guide provides the complete instructions for deploying, configuring, and showcasing the **"Shulov Park" (শুলভ পার্ক)** premium WooCommerce WordPress theme.

---

## 1. Prerequisites & System Requirements
To ensure optimal performance and full feature integration, verify your server matches these requirements:
- **WordPress:** Version 5.6 or higher.
- **WooCommerce:** Version 6.0 or higher (Activated).
- **YITH WooCommerce Wishlist:** (Optional) For wishlist badges and dynamic lists.
- **PHP:** Version 7.4 or higher (8.1+ recommended).

---

## 2. Quick Theme Activation
Since the theme files are already placed directly in the WordPress themes directory (`wp-content/themes/shulov-park/`):
1. Log in to your WordPress dashboard (`/wp-admin`).
2. Go to **Appearance > Themes**.
3. Locate the **Shulov Park** card featuring our luxurious green-and-gold design.
4. Click **Activate**.

---

## 3. Configuring the Homepage & Shop
1. In your WordPress admin, go to **Pages > Add New**.
2. Create a page titled **"Home"** and **Publish** it.
3. Go to **Settings > Reading**.
4. Set "Your homepage displays" to **A static page**.
5. Select **Home** as the Homepage.
6. Click **Save Changes**.
7. Ensure WooCommerce pages are assigned under **WooCommerce > Settings > Advanced** (Cart, Checkout, and My Account pages).

---

## 4. Theme Options & Customization
You can dynamically control all parameters without touch-editing code. Go to **Appearance > Customize > Shulov Park Options**:
- **Contact Info & Socials:** Manage the store support Phone, Email address, Store Address, and Facebook/Instagram/YouTube links.
- **Flash Sale Section:** Toggle this section on/off, edit the section headers, and set a specific target countdown deadline date (Format: `YYYY-MM-DDTHH:MM:SS`, e.g. `2026-06-25T23:59:59`).
- **Mobile App Mockup & Links:** Control App Store and Google Play URLs and change promotion descriptions.
- **Footer Operating Hours:** Update weekly store hours and delivery descriptions dynamically.

---

## 5. Importing Demo Products (BDT Currencies)
We have provided an XML dataset with 5 local grocery items, categories, tags, BDT pricing, and stock metadata:
1. Go to **Tools > Import**.
2. Click **Install Now** under "WordPress" (or Run Importer if already active).
3. Click **Choose File** and select the dataset located in the theme folder:
   `wp-content/themes/shulov-park/assets/demo-products-import.xml`
4. Click **Upload file and import**.
5. Assign posts to your admin user and check the box to **"Download and import file attachments"** if needed.
6. Click **Submit**. The products will immediately render in the homepage best-sellers grid!

---

## 6. Menu Configurations
1. Go to **Appearance > Menus**.
2. Create a menu named **"Main Menu"**.
3. Add links: Home, Shop, specific categories (e.g., Grocery, Vegetables, Dairy), and Contact.
4. Check the display location box for **"Primary Menu"** at the bottom.
5. Save the menu.

---

Enjoy your new premium, responsive grocery store storefront! For developer modifications, contact **@itfahim0**.
