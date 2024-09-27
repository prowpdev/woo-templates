<?php
/**
 * Template Name: Checkout Template
 */

get_header(); 

?>

<?php
if( !is_admin() ):
global $woocommerce;
$items = $woocommerce->cart->get_cart();
if ( strpos( $_SERVER['REQUEST_URI'], 'order-received' ) === false ) :
echo '<h2>Your Cart Contains</h2>';
echo '<div class="cart-grid">';
if( $items  ):
foreach (WC()->cart->get_cart() as $cart_item_key => $cart_item) {
    $_product = apply_filters('woocommerce_cart_item_product', $cart_item['data'], $cart_item, $cart_item_key);
    $product_id = apply_filters('woocommerce_cart_item_product_id', $cart_item['product_id'], $cart_item, $cart_item_key);

    if ($_product && $_product->exists() && $cart_item['quantity'] > 0 && apply_filters('woocommerce_cart_item_visible', true, $cart_item, $cart_item_key)) {
        echo '<div class="cart-item">';
        
        // Image
        echo '<div class="item-image">' . $_product->get_image() . '</div>';
        
        // Product details
        echo '<div class="item-details">';
        echo '<h2 class="item-name">' . $_product->get_name() . '</h2>';
		$waste_type_options = get_field('waste_type_options',$product_id);
		echo '<h3 class="item-waste-type">' . $waste_type_options[0]['input_option']. '</p>';
		echo '<p class="item-date">Collection date: 5 Nov 2024</h3>';
		
        echo '<p class="item-desc">' . $_product->get_short_description() . '</p>';
 
        echo '<p class="item-price">' . WC()->cart->get_product_price($_product) . '</p>';
        
   
        echo apply_filters('woocommerce_cart_item_remove_link', 
            sprintf('<a href="%s" class="remove" aria-label="%s" data-product_id="%s" data-product_sku="%s">Remove</a>',
                esc_url(wc_get_cart_remove_url($cart_item_key)),
                esc_html__('Remove this item', 'woocommerce'),
                esc_attr($product_id),
                esc_attr($_product->get_sku())
            ), 
            $cart_item_key
        );
        
        echo '</div>'; 
        echo '</div>'; 
    }
}
endif;
echo '</div>'; // Close cart-grid



// Continue Shopping button
echo '<div class="continue-shopping-container">';
	echo '<a href="' . wc_get_page_permalink('shop') . '" class="button continue-shopping">Continue Shopping</a>';
echo '</div>';
endif;// end check if order received
endif; //end check if admin

// thank you page template
if ( strpos( $_SERVER['REQUEST_URI'], 'order-received' ) !== false ) :
$request_uri = $_SERVER['REQUEST_URI'];
$uri_segments = explode('/', trim($request_uri, '/'));
$order_received_index = array_search('order-received', $uri_segments);


if ( $order_received_index !== false && isset( $uri_segments[$order_received_index + 1] ) ) {
    // The order ID will be the segment after 'order-received'
    $order_id = intval( $uri_segments[$order_received_index + 1] );
    
} 

// $order_id = 1234; // Replace this with your order ID
$order = wc_get_order( $order_id );

if ( $order ) {
    // Get Order Data
    echo '<h2>Order Details:</h2>';
    echo '<p>Order ID: ' . $order->get_id() . '</p>';
    echo '<p>Order Date: ' . wc_format_datetime( $order->get_date_created() ) . '</p>';
    echo '<p>Order Status: ' . wc_get_order_status_name( $order->get_status() ) . '</p>';

    // Get Billing Details
    echo '<h3>Billing Details:</h3>';
    echo '<p>Name: ' . $order->get_billing_first_name() . ' ' . $order->get_billing_last_name() . '</p>';
    echo '<p>Email: ' . $order->get_billing_email() . '</p>';
    echo '<p>Phone: ' . $order->get_billing_phone() . '</p>';
    echo '<p>Address: ' . $order->get_billing_address_1() . ', ' . $order->get_billing_city() . ', ' . $order->get_billing_postcode() . '</p>';

    // Get Shipping Details
    if ( $order->get_shipping_method() ) {
        echo '<h3>Shipping Details:</h3>';
        echo '<p>Shipping Method: ' . $order->get_shipping_method() . '</p>';
        echo '<p>Address: ' . $order->get_shipping_address_1() . ', ' . $order->get_shipping_city() . ', ' . $order->get_shipping_postcode() . '</p>';
    }

    // Get Items in the Order
    echo '<h3>Order Items:</h3>';
    foreach ( $order->get_items() as $item_id => $item ) {
        $product = $item->get_product();
        echo '<p>Product: ' . $product->get_name() . '</p>';
        echo '<p>Quantity: ' . $item->get_quantity() . '</p>';
        echo '<p>Price: ' . wc_price( $item->get_total() ) . '</p>';
    }

    // Get Order Total
    echo '<h3>Order Total:</h3>';
    echo '<p>Total: ' . wc_price( $order->get_total() ) . '</p>';
} else {
    echo 'Order not found.';
}
endif;
?>

<?php get_footer(); ?>
