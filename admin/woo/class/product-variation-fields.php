<?php
/**
 * Class to handle custom field for product variations in WooCommerce
 */
class Product_Variation_Fields {

    public function __construct() {
        add_action( 'woocommerce_product_after_variable_attributes', array( $this, 'add_pdf_file_to_variations' ), 10, 3 );

        add_action( 'woocommerce_save_product_variation', array( $this, 'save_pdf_file_variations' ), 10, 2 );

        add_filter( 'woocommerce_available_variation', array( $this, 'add_pdf_file_variation_data' ) );
    }

    /**
     *  Add custom field input to variations
     */
    public function add_pdf_file_to_variations( $loop, $variation_data, $variation ) {
        woocommerce_wp_text_input( array(
            'id'    => 'date_field[' . $loop . ']',
            'class' => 'date_input_'.$loop,
            'label' => __( 'Date', 'woocommerce' ),
            'placeholder' => __( 'Select a date', 'woocommerce' ),
            'type'  => 'date',  // Specifies the HTML5 date input type
            'value' => get_post_meta( $variation->ID, 'date_field', true ) 
        ) );
        
        woocommerce_wp_checkbox( array(
            'id'          => 'hide_variation[' . $loop . ']',
            'class'       => 'hide_variation' . $loop,
            'label'       => __( '', 'woocommerce' ),
            'value'       => get_post_meta( $variation->ID, 'hide_variation', true ),
            'description' => __( 'Check to hide this variation', 'woocommerce' ),
        ) );
        
    }

    /**
     *  Save custom field on product variation save
     */
    public function save_pdf_file_variations( $variation_id, $i ) {
        $pdf_file = $_POST['pdf_file'][$i];
        $hide_variation = $_POST['hide_variation'][$i];

        if ( isset( $pdf_file ) ) {
            update_post_meta( $variation_id, 'pdf_file', esc_attr( $pdf_file ) );
        }
       
        if ( isset( $hide_variation ) ) {
            update_post_meta( $variation_id, 'hide_variation', esc_attr( $hide_variation ) );
        }else{
            update_post_meta( $variation_id, 'hide_variation', 0 );
        }
    }

    /**
     * Store custom field value into variation data
     */ 
    public function add_pdf_file_variation_data( $variations ) {
        $variations['pdf_file'] = '<div class="woocommerce_pdf_file">Custom Field: <span>' . get_post_meta( $variations['variation_id'], 'pdf_file', true ) . '</span></div>';
        return $variations;
    }


}

// Initialize the class
new Product_Variation_Fields();
