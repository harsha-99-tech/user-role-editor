# CSR Menu Restrictions

A **WordPress Must-Use plugin (MU plugin)** that restricts the WordPress admin menu for the **CSR role**.  
It removes all default and plugin menus, then adds back only the following:

- **My Plugin** (`wordpress-plugin-boilerplate`)
- **CSR Panel** (`mdz-lightSpeed-sync`)
- **WooCommerce**
- **Products**
- **Reviews** (redirects to product reviews)

---

## 📦 Installation

1. Clone or download this repository.
2. Copy the file `menu-restrictions.php` into your WordPress site at: wp-content/mu-plugins/csr-menu-restrictions.php

> If the `mu-plugins` folder doesn’t exist, create it.

3. That’s it! MU plugins load automatically and cannot be disabled from the admin dashboard.

---

## 🎯 Features

- Ensures CSR role only sees **approved menus**.
- Hides all other admin menus and submenus.
- Cleans up the admin bar (removes logo, updates, comments, etc.).
- Redirects CSR users to the **CSR Panel dashboard** after login.

---

## 🔑 Requirements

- WordPress 5.0+
- A role named `csr` (or `CSR`) must exist in your site.

---

## ⚠️ Notes

- This plugin is meant for **CSR role only**.
- It does **not** change permissions — only the **menu visibility**. Use a role manager plugin (e.g., User Role Editor) if you need to modify CSR role capabilities.

---

## 📜 License

MIT License – feel free to use and modify.
