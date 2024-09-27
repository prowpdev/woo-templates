<?php
/**
 * Enqueue
 */
// add_action( 'wp_enqueue_scripts', 'enqueue_woo_template_js' );
// function enqueue_woo_template_js() {
//     wp_enqueue_script( 'popper-js', 'https://unpkg.com/@popperjs/core@2/dist/umd/popper.min.js', array(), null, true );
//     wp_enqueue_script( 'tippy-js', 'https://unpkg.com/tippy.js@6/dist/tippy-bundle.umd.js', array( 'popper-js' ), null, true );
//     wp_enqueue_script( 'woo_template_js', plugin_dir_url( __FILE__ ) . 'assets/js/app.js', array( 'jquery' ), '1.0', true );
//     wp_enqueue_script( 'woo_tooltip_js', plugin_dir_url( __FILE__ ) . 'assets/js/tooltip.js', array( 'jquery','popper-js','tippy-js' ), null, true );
//     // 
//     wp_enqueue_style('form-billing', plugins_url('assets/css/form-billing.css', __FILE__), array(), '1.0', 'all');
//     wp_enqueue_style('content-group-item-product', plugins_url('assets/css/content-group-item-product.css', __FILE__), array(), '1.0', 'all');
//     wp_enqueue_style('woo_template_wc_bookings_styles', plugins_url('assets/css/wc_bookings.css', __FILE__), array(), '1.0', 'all');

//     // Pass the AJAX URL and nonce to the script
//     wp_localize_script( 'woo_template_js', 'my_ajax_object', array(
//         'ajax_url' => admin_url( 'admin-ajax.php' ),
//         'nonce'    => wp_create_nonce( 'my_custom_nonce' )
//     ));
// }
