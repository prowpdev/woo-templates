|<?php
// If this file isn't already being loaded, include it in your main plugin file
// include_once 'includes/product/product-ajax.php';

// Add the action hooks for logged-in and logged-out users
add_action( 'wp_ajax_my_custom_ajax_action', 'handle_my_custom_ajax_function' );
add_action( 'wp_ajax_nopriv_my_custom_ajax_action', 'handle_my_custom_ajax_function' );

function handle_my_custom_ajax_function() {
    // Verify the nonce
    check_ajax_referer( 'my_custom_nonce', 'nonce' );

    // Process the AJAX request
    $custom_data = sanitize_text_field( $_POST['custom_data'] );

    // Perform your desired actions with the data
    $response = 'You sent: ' . $custom_data;

    // Send the response back to the JavaScript
    wp_send_json_success( $response );

    // Always die after handling AJAX requests to prevent further execution
    wp_die();
}
