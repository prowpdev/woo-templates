<?php
/**
 * Product Variations
 */
// Step 1: Add custom heading field for bookable products

add_action( 'woocommerce_product_after_variable_attributes', 'add_custom_heading_field', 10, 3 );



function add_custom_heading_field( $loop, $variation_data, $variation ) {

    $heading_value = get_post_meta( $variation->ID, '_wc_booking_resource_heading', true );

    ?>

<div class="form-row">

    <label><?php esc_html_e( 'Resource Heading', 'woocommerce-bookings' ); ?></label>

    <?php

        woocommerce_wp_text_input( array(

            'id'          => "_wc_booking_resource_heading[{$loop}]",

            'placeholder' => __( 'Type', 'woocommerce-bookings' ),

            'label'       => __( 'Label', 'woocommerce-bookings' ),

            'value'       => esc_attr( $heading_value ),

            'desc_tip'    => true,

            'description' => __( 'The heading shown on the frontend if the resource is customer defined.', 'woocommerce-bookings' ),

        ) );

        ?>

</div>

<?php

}