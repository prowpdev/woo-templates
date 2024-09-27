<?php
/**
 * Order
 */
// Save image data to the order meta
add_action( 'woocommerce_checkout_create_order_line_item', 'save_image_to_order_item', 10, 4 );
function save_image_to_order_item( $item, $cart_item_key, $values, $order ) {
    if ( isset( $values['custom_image'] ) ) {
        $item->add_meta_data( 'Uploaded Image', $values['custom_image'], true );
    }
    // print_r( $item );
    // die();
}


// Display the image in the email
add_filter( 'woocommerce_email_order_items_args', 'add_image_to_email', 10, 2 );
function add_image_to_email( $args, $order ) {
    foreach ( $order->get_items() as $item_id => $item ) {
        $image_url = wc_get_order_item_meta( $item_id, 'Uploaded Image', true );
        if ( ! empty( $image_url ) ) {
            echo '<p><strong>Uploaded Image:</strong><br /><img src="' . esc_url( $image_url ) . '" style="width:100px;height:auto;" /></p>';
        }
    }
    return $args;
}


// Display the uploaded image in the cart and checkout pages
add_filter( 'woocommerce_get_item_data', 'display_image_in_cart', 10, 2 );
function display_image_in_cart( $item_data, $cart_item ) {
    if ( isset( $cart_item['custom_image'] ) ) {
        $item_data[] = array(
            'name'    => 'Uploaded Image',
            'value'   => '<img src="' . esc_url( $cart_item['custom_image'] ) . '" style="width:50px;height:auto;" />',
        );
    }
    if ( isset( $cart_item['sepcial_instructions'] ) ) {
        $item_data[] = array(
            'name'    => 'Special Instructions',
            'value'   =>  $cart_item['sepcial_instructions'] ,
        );
    }
    if ( isset( $cart_item['time_preferece'] ) ) {
        $item_data[] = array(
            'name'    => 'Time Preference',
            'value'   =>  $cart_item['time_preferece'] ,
        );
    }

    return $item_data;
}