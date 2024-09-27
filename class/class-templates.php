<?php
/**
 * Override Woo templates
 */

// Override WooCommerce checkout template

function my_plugin_override_checkout_template( $template, $template_name, $template_path ) {

    $plugin_template_dir = WOO_TEMPLATE_PLUGIN_DIR . 'woocommerce/templates/';
    $plugin_template = $plugin_template_dir . $template_name;

    global $product;
    if ( $product && ( $product->is_type( 'booking' ) || $product->is_type( 'variable' ) ) ) {
        if ( file_exists( $plugin_template ) ) {
            return $plugin_template;
        }
    }
    // print_r( $template_name );
    return $template;
}
add_filter( 'woocommerce_locate_template', 'my_plugin_override_checkout_template', 10, 3 );

// Override content template part for variable products
add_filter( 'wc_get_template_part', 'so_29984159_custom_content_template_part', 10, 3 );

function so_29984159_custom_content_template_part( $template, $slug, $name ) {
    global $product;
    $plugin_template_dir = WOO_TEMPLATE_PLUGIN_DIR . 'woocommerce/templates/';

    // Check for variable product type
    if ( $product && $product->is_type( 'variable' ) ) {
        $plugin_template = $plugin_template_dir . 'content-variable-products.php';
        return $plugin_template;
    }
    
    // Check for booking product type
    if ( $product && $product->is_type( 'booking' ) ) {
        $plugin_template = $plugin_template_dir . 'content-single-product.php';
        return $plugin_template;
    }
    if ( $product && $product->is_type( 'grouped' ) ) {
        $plugin_template = $plugin_template_dir . 'content-group-product.php';
        return $plugin_template;
    }

    // If neither 'booking' nor 'variable', just return the default template
    return $template;
}




