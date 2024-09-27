<?php
/**
 * Store all methods hooks filter related to cart
 */

 add_filter('woocommerce_add_cart_item_data', 'add_additional_information_to_cart', 10, 2);

 function add_additional_information_to_cart($cart_item_data, $product_id) {
 
     $sepcial_instructions = isset( $_POST['sepcial_instructions'] ) ? sanitize_text_field( $_POST['sepcial_instructions']) : '';
     $time_preferece = isset( $_POST['time_preferece'] ) ? sanitize_text_field( $_POST['time_preferece']) : '';
 
     if ( isset( $_FILES['custom_image_upload'] ) && ! empty( $_FILES['custom_image_upload']['name'] ) ) {
         $upload = wp_upload_bits( $_FILES['custom_image_upload']['name'], null, file_get_contents( $_FILES['custom_image_upload']['tmp_name'] ) );
         if ( empty( $upload['error'] ) ) {
             $cart_item_data['custom_image'] = $upload['url'];
         }
     }
 
     // Add the additional information to the cart item data
     $cart_item_data['sepcial_instructions'] = $sepcial_instructions;
     $cart_item_data['additional_image'] = $sepcial_instructions;
     $cart_item_data['time_preferece'] = $time_preferece;
     // print_r($cart_item_data);
     // die();
    
     return $cart_item_data;
 }
//  // Display the uploaded image in the cart and checkout pages
//  add_filter( 'woocommerce_get_item_data', 'display_image_in_cart', 10, 2 );
//  function display_image_in_cart( $item_data, $cart_item ) {
//      if ( isset( $cart_item['custom_image'] ) ) {
//          $item_data[] = array(
//              'name'    => 'Uploaded Image',
//              'value'   => '<img src="' . esc_url( $cart_item['custom_image'] ) . '" style="width:50px;height:auto;" />',
//          );
//      }
//      if ( isset( $cart_item['sepcial_instructions'] ) ) {
//          $item_data[] = array(
//              'name'    => 'Special Instructions',
//              'value'   =>  $cart_item['sepcial_instructions'] ,
//          );
//      }
//      if ( isset( $cart_item['time_preferece'] ) ) {
//          $item_data[] = array(
//              'name'    => 'Time Preference',
//              'value'   =>  $cart_item['time_preferece'] ,
//          );
//      }
 
//      return $item_data;
//  }


 // Validate that the image file was uploaded
add_filter( 'woocommerce_add_to_cart_validation', 'validate_image_upload', 10, 3 );
function validate_image_upload( $passed, $product_id, $quantity ) {
    if ( !empty( $_FILES['custom_image_upload']['name'] ) ) {
        // Check if the file is an image
        $file_type = wp_check_filetype( $_FILES['custom_image_upload']['name'] );
        if ( ! in_array( $file_type['type'], array( 'image/jpeg', 'image/png', 'image/gif' ) ) ) {
            wc_add_notice( 'Please upload a valid image file (jpg, png, gif).', 'error' );
            return false;
        }
    }
    return $passed;
}
 
// Hook add to cart action saving
add_action( 'woocommerce_add_to_cart', 'custom_save_to_cart', 10, 6 );

function custom_save_to_cart( $cart_item_key, $product_id, $quantity, $variation_id, $variation, $cart_item_data ) {
    if ( ! empty( $sepcial_instructions ) ) {
        $cart_item_data['sepcial_instructions'] = $sepcial_instructions;
    }
 
    return $cart_item_data; // Ensure to return the cart item data
}
