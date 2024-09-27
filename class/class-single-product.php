<?php
/**
 * Single Product Template related code
 */
// Remove the Additional Information tab on the single product page

add_filter( 'woocommerce_product_tabs', 'remove_additional_info_tab', 98 );

function remove_additional_info_tab( $tabs ) {

     return array();

}