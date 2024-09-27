<?php

/**
 * Plugin Name: Woo Oxygen Templates
 * Description: A plugin that provides custom templates for woocommerce
 * Version: 1.0
 * Author: Jhomel Ignacio
 */

if (! defined('ABSPATH')) {
    exit;
}
if (!defined('WOO_TEMPLATE_PLUGIN_DIR')) {
    define('WOO_TEMPLATE_PLUGIN_DIR', plugin_dir_path(__FILE__));
}
/********************* Admin *****************/
/**
 * description: Use for adding fields in Product attributes
 */
require_once(WOO_TEMPLATE_PLUGIN_DIR . '/admin/woo/class/product-variation-fields.php');
/**
 * description: Use to display product variations as table
 */
require_once(WOO_TEMPLATE_PLUGIN_DIR . '/admin/woo/class/product-variants.php');

/**
 * description: Use for adding fields in Product attributes
 */
require_once(WOO_TEMPLATE_PLUGIN_DIR . '/admin/woo/class/product-attributes.php');
new Product_Attributes();

/********************* Class *****************/

// add_action('init', 'woo_template_require_files');

function woo_template_require_files()
{
    $plugin_template_dir = WOO_TEMPLATE_PLUGIN_DIR . 'class/';
    if (is_dir($plugin_template_dir)) {
        $files = scandir($plugin_template_dir);
        foreach ($files as $file) {
            if ($file !== '.' && $file !== '..') {
                require_once($plugin_template_dir . $file);
            }
        }
    }
}

add_action('wp_enqueue_scripts', 'enqueue_woo_template_js');
function enqueue_woo_template_js()
{
    wp_enqueue_script('popper-js', 'https://unpkg.com/@popperjs/core@2/dist/umd/popper.min.js', array(), null, true);
    wp_enqueue_script('tippy-js', 'https://unpkg.com/tippy.js@6/dist/tippy-bundle.umd.js', array('popper-js'), null, true);
    wp_enqueue_script('woo_template_js', plugin_dir_url(__FILE__) . 'assets/js/app.js', array('jquery'), '1.0', true);
    wp_enqueue_script('woo_tooltip_js', plugin_dir_url(__FILE__) . 'assets/js/tooltip.js', array('jquery', 'popper-js', 'tippy-js'), null, true);
    // 
    wp_enqueue_style('form-billing', plugins_url('assets/css/form-billing.css', __FILE__), array(), '1.0', 'all');
    wp_enqueue_style('content-group-item-product', plugins_url('assets/css/content-group-item-product.css', __FILE__), array(), '1.0', 'all');
    wp_enqueue_style('woo_template_wc_bookings_styles', plugins_url('assets/css/wc_bookings.css', __FILE__), array(), '1.0', 'all');

    // Pass the AJAX URL and nonce to the script
    wp_localize_script('woo_template_js', 'my_ajax_object', array(
        'ajax_url' => admin_url('admin-ajax.php'),
        'nonce'    => wp_create_nonce('my_custom_nonce')
    ));
}

// add_action('init', 'test_add_to_cart');

function test_add_to_cart() {
    $product_id = 1387; // Example product ID
    $quantity = 1; // Example quantity
    $date = '2024-10-26'; // Booking date
    $time = ''; // No specific time for all-day booking

    try {
        custom_add_to_cart($product_id, $quantity, $date, $time);
    } catch (\Throwable $th) {
        // Handle error
        error_log($th); // Log the error
    }
}
// add_action('init', 'custom_add_to_cart');
function custom_add_to_cart() {
    $product_id = 1387; // Example product ID
    $quantity = 1; // Example quantity
    $date = '2024-10-26'; // Booking date
    $time = ''; // No specific time for all-day 
    
    if (!$product_id) {
        return false; // Invalid product ID
    }

    $product = wc_get_product($product_id);
    if (!$product || !$product->is_purchasable() || !$product->is_type('booking')) {
        return false; 
    }

    // Convert the date to the Unix timestamp for start and end times
    $start_timestamp = strtotime('2024-09-27 00:00:00'); // Start of the day
    $end_timestamp = strtotime('2024-09-27 23:59:59'); // End of the day

    // Prepare the booking data
    $booking_data = array(
        'booking' => array(
            '_year'          => '2024', 
            '_month'         => '09',
            '_day'           => '26',
            '_date'          => '2024-09-27',
            'date'           => 'September 27, 2024', // Human-readable date
            '_qty'           => '1',
            '_start_date'    => $start_date, // Unix timestamp for start
            '_end_date'      =>  $end_date,   // Unix timestamp for end
            '_all_day'       => '1',
            '_local_timezone'=> '',  // Optional if no timezone set
            '_cost'          => '320', // Example cost
        )
    );
    // $booking_data = array(
    //     'booking' => array(
    //         '_year'          => '2024', // Year
    //         '_month'         => '09',   // Month (ensure leading zero)
    //         '_day'           => '27',   // Day
    //         '_date'          => '2024-9-27', // Date in 'YYYY-MM-DD' format
    //         'date'           => 'September 27, 2024', // Human-readable date
    //         '_time'          => '', // Empty for all-day booking
    //         '_qty'           => '1', // Quantity
    //         '_start_date'    => '1727366400', // Unix timestamp for start (all-day booking start time)
    //         '_end_date'      => '1727452799', // Unix timestamp for end (all-day booking end time, midnight)
    //         '_all_day'       => '1', // Indicating all-day booking
    //         '_local_timezone'=> '',  // Empty if no timezone set
    //         '_cost'          => '320', // Cost of the booking
    //         '_booking_id'    => '1543' // Booking ID if needed
    //     )
    // );

    // Add the product to the cart with the booking data
    $cart_item_key = WC()->cart->add_to_cart($product_id, $quantity, 0, array(), $booking_data);

    if (!$cart_item_key) {
        return false; // Handle failure to add to cart
    }

    return true; // Return true on success
}



add_action( 'wp_footer', 'bookable_product_script_js');
function bookable_product_script_js() {
    global $product;

    // Only on single bookable products
    if( is_product() && $product->is_type('booking') ) :

    ?>
    <script type='text/javascript'>
    jQuery(function($){
        // Get the date selected value
        $("#wc-bookings-booking-form > fieldset").on('date-selected', function( event, fdate ) {
            console.log( 'Timestamp in seconds: ' + event.timeStamp ); // the selected date timestamp
            console.log( 'Formatted chosen date: ' + fdate ); // The selected formated date in "YYYY-MM-DD" format

            var date  = new Date(Date.parse(fdate)), // The selected DATE Object
                year  = date.getFullYear(), // Year in numeric value with 4 digits
                month = date.getMonth(), // Month in numeric value from 0 to 11
                day   = date.getDate(), // Day in numeric value from 1 to 31
                wDay  = date.getDay(); // Week day in numeric value from 0 to 6

            console.log('Year: '+year+' | month: '+month+' | day: '+day+' | week day: '+wDay);
        });
    });
    </script>
    <?php
    endif;
}


// add_action('woocommerce_cart_contents', 'get_current_cart_data');

// function get_current_cart_data() {
//     // Get the cart contents
//     $cart = WC()->cart->get_cart();
    
//     // Check if the cart is not empty
//     if (!empty($cart)) {
//         foreach ($cart as $cart_item_key => $cart_item) {
//             // Get the product ID
//             $product_id = $cart_item['product_id'];
            
//             // Get the quantity
//             $quantity = $cart_item['quantity'];
            
//             // Get the product object
//             $product = wc_get_product($product_id);
            
//             // Get the price
//             $price = $product->get_price();
            
//             // For bookable products, you can retrieve booking data
//             $booking_data = !empty($cart_item['booking']) ? $cart_item['booking'] : array();
//             $start_date = isset($booking_data['start']) ? $booking_data['start'] : '';
//             $end_date = isset($booking_data['end']) ? $booking_data['end'] : '';
            
//             // Output or process the cart data as needed
//             echo '<div class="cart-item">';
//             echo '<h2>' . esc_html($product->get_name()) . '</h2>';
//             echo '<p>Quantity: ' . esc_html($quantity) . '</p>';
//             echo '<p>Price: ' . wc_price($price) . '</p>';
            
//             if (!empty($booking_data)) {
//                 echo '<p>Booking Start: ' . esc_html($start_date) . '</p>';
//                 echo '<p>Booking End: ' . esc_html($end_date) . '</p>';
//             }
            
//             echo '</div>';
//         }
//     } else {
//         echo '<p>Your cart is currently empty.</p>';
//     }
// }
