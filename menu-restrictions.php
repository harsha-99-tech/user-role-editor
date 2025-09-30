<?php
/**
 * Plugin Name: Role-Based Menu Restrictions
 * Description: Restrict WordPress admin menus for a specific user role. Only show selected menus.
 * Author: Your Name
 * Version: 1.0.0
 *
 * Note: This is a Must-Use plugin (mu-plugin). Place this file in wp-content/mu-plugins/
 * so it is always active and cannot be deactivated via the WordPress admin.
 */

if ( ! is_admin() ) {
    return; // Safety: only run in admin context
}

add_action('admin_menu', function() {
    $user = wp_get_current_user();

    /**
     * 🔧 Customize the role name here.
     * Example: 'csr', 'editor', 'shop_manager', etc.
     */
    $restricted_role = 'your_role_slug_here';

    // Only apply restrictions if the current user has the restricted role
    if ( ! in_array( $restricted_role, $user->roles, true ) ) {
        return;
    }

    global $menu, $submenu;

    /**
     * 🚨 Step 1: Remove everything
     * Clears all default and plugin menus.
     */
    $menu    = [];
    $submenu = [];

    /**
     * ✅ Step 2: Add back ONLY what this role should see
     * Adjust/add/remove these menu items as needed.
     */

    // Example 1: Custom plugin page
    add_menu_page(
        'My Plugin',                 // Page title
        'My Plugin',                 // Menu title
        'read',                      // Capability
        'my-plugin-slug',            // Menu slug (change to your plugin’s slug)
        '',                          // Callback (not needed if handled by plugin)
        'dashicons-admin-generic',   // Icon
        2                            // Position
    );

    // Example 2: Another custom panel
    add_menu_page(
        'Custom Panel',
        'Custom Panel',
        'read',
        'custom-panel-slug',         // Replace with your plugin/feature slug
        '',
        'dashicons-dashboard',
        3
    );

    // Example 3: WooCommerce
    add_menu_page(
        'WooCommerce',
        'WooCommerce',
        'read',
        'woocommerce',
        function() {
            // Redirect to WooCommerce dashboard
            echo '<script>window.location.href="' . admin_url('admin.php?page=wc-admin') . '";</script>';
            exit;
        },
        'dashicons-cart',
        4
    );

    // Example 4: Products
    add_menu_page(
        'Products',
        'Products',
        'read',
        'edit.php?post_type=product',
        '',
        'dashicons-products',
        5
    );

    // Example 5: Reviews
    add_menu_page(
        'Product Reviews',
        'Reviews',
        'read',
        'product-reviews-slug',      // Custom slug (redirect used below)
        function() {
            echo '<script>window.location.href="' . admin_url('edit-comments.php?post_type=product') . '";</script>';
            exit;
        },
        'dashicons-star-filled',
        6
    );
}, 999);

/**
 * 🔧 Step 3: Clean up the admin bar
 * Remove unwanted top-bar items for the restricted role.
 */
add_action('admin_bar_menu', function($wp_admin_bar) {
    $user = wp_get_current_user();

    $restricted_role = 'your_role_slug_here'; // <-- Customize this

    if ( in_array( $restricted_role, $user->roles, true ) ) {
        $wp_admin_bar->remove_node('wp-logo');
        $wp_admin_bar->remove_node('comments');
        $wp_admin_bar->remove_node('new-content');
        $wp_admin_bar->remove_node('updates');
        $wp_admin_bar->remove_node('customize');
    }
}, 999);

/**
 * 🔄 Step 4: Redirect restricted role after login
 * Change the redirect page slug as needed.
 */
add_filter('login_redirect', function($redirect_to, $request, $user) {
    $restricted_role = 'your_role_slug_here'; // <-- Customize this

    if ( isset($user->roles) && is_array($user->roles) ) {
        if ( in_array( $restricted_role, $user->roles, true ) ) {
            return admin_url('admin.php?page=custom-panel-slug#/dashboard'); // <-- Customize destination
        }
    }
    return $redirect_to;
}, 10, 3);
