<?php
/**
 * Product Resources
 */

// Add a custom text field to bookable resource options

add_action( 'woocommerce_bookings_resource_options', 'add_custom_field_to_resource_options', 10, 2 );



function add_custom_field_to_resource_options( $resource_id, $post_id ) {

    // Get the value of the custom field if it already exists

    $custom_value = get_post_meta( $resource_id, '_custom_resource_field', true );

    ?>

<p class="form-field">

    <label for="custom_resource_field"><?php esc_html_e( 'Custom Resource Field', 'woocommerce-bookings' ); ?></label>

    <input type="text" id="custom_resource_field" name="custom_resource_field[<?php echo esc_attr( $resource_id ); ?>]"
        value="<?php echo esc_attr( $custom_value ); ?>" />

</p>

<?php

}
