<?php
/**
 * Plugin Name: Menu Restrictions
 * Description: Restrict WordPress admin menus for the CSR role. Only show: My Plugin, CSR Panel, WooCommerce, Products, and Reviews.
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

    // Only apply restrictions if user has the CSR role
    if ( ! in_array('csr', $user->roles, true) && ! in_array('CSR', $user->roles, true) ) {
        return;
    }

    global $menu, $submenu;

    /**
     * 🚨 Step 1: Remove everything
     * Clear out the global $menu and $submenu arrays so no default/admin menus appear.
     */
    $menu    = [];
    $submenu = [];

    /**
     * ✅ Step 2: Add back ONLY what CSR should see
     */

    // 1. My Plugin
    add_menu_page(
        'My Plugin',                                // Page title
        'My Plugin',                                // Menu title
        'read',                                     // Capability
        'wordpress-plugin-boilerplate',             // Slug
        '',                                         // Callback (not needed, handled by plugin)
        'dashicons-admin-generic',                  // Icon
        2                                           // Position
    );

    // 2. CSR Panel
    add_menu_page(
        'CSR Panel',
        'CSR Panel',
        'read',
        'mdz-lightSpeed-sync',
        '',                                         // The plugin handles content
        'dashicons-dashboard',
        3
    );

    // 3. WooCommerce (redirect to wc-admin)
    add_menu_page(
        'WooCommerce',
        'WooCommerce',
        'read',
        'woocommerce',
        function() {
            echo '<script>window.location.href="' . admin_url('admin.php?page=wc-admin') . '";</script>';
            exit;
        },
        'dashicons-cart',
        4
    );

    // 4. Products
    add_menu_page(
        'Products',
        'Products',
        'read',
        'edit.php?post_type=product',
        '',
        'dashicons-products',
        5
    );

    // 5. Reviews (redirect to product reviews)
    add_menu_page(
        'Product Reviews',
        'Reviews',
        'read',
        'product-reviews-csr',
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
 * Remove unnecessary nodes from the top bar for CSR users.
 */
add_action('admin_bar_menu', function($wp_admin_bar) {
    $user = wp_get_current_user();
    if ( in_array('csr', $user->roles, true) || in_array('CSR', $user->roles, true) ) {
        $wp_admin_bar->remove_node('wp-logo');
        $wp_admin_bar->remove_node('comments');
        $wp_admin_bar->remove_node('new-content');
        $wp_admin_bar->remove_node('updates');
        $wp_admin_bar->remove_node('customize');
    }
}, 999);

/**
 * 🔄 Step 4: Redirect CSR after login
 * Automatically send CSR users to the CSR Panel dashboard.
 */
add_filter('login_redirect', function($redirect_to, $request, $user) {
    if ( isset($user->roles) && is_array($user->roles) ) {
        if ( in_array('csr', $user->roles, true) || in_array('CSR', $user->roles, true) ) {
            return admin_url('admin.php?page=mdz-lightSpeed-sync#/dashboard');
        }
    }
    return $redirect_to;
}, 10, 3);
