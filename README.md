# Role-Based Menu Restrictions

A **WordPress Must-Use plugin (MU plugin)** that restricts the WordPress admin menu for a specific user role.  
It removes all default menus, then adds back only the ones you define.

---

## 📦 Installation

1. Clone or download this repository.
2. Copy the file `role-based-menu-restrictions.php` into: wp-content/mu-plugins/role-based-menu-restrictions.php

> If the `mu-plugins` folder doesn’t exist, create it.

3. Edit the file and replace:

- `your_role_slug_here` → your role (e.g., `csr`, `editor`, `shop_manager`).
- `my-plugin-slug`, `custom-panel-slug`, etc. → the actual slugs of your plugins or pages.
- Update icons, positions, and titles as needed.

4. Done! The plugin activates automatically and can’t be disabled via the dashboard.

---

## 🎯 Features

- Restrict menus for one specific role.
- Clean admin area: remove all menus, then add only chosen ones.
- Hide unwanted items from the admin bar.
- Redirects restricted role to a custom dashboard after login.

---

## 🔧 Customization Points

- **Role Name** → update `$restricted_role`.
- **Menu Items** → adjust/add `add_menu_page()` calls.
- **Login Redirect** → update the destination page slug.

---

## 📜 License

MIT License – free to use and modify.
