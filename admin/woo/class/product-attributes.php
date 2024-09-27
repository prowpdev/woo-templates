<?php

class Product_Attributes {
    public function __construct(){

        $this->add_actions();
    }

    public function add_actions(){

        add_action( 'woocommerce_after_add_attribute_fields', [$this,'my_edit_wc_attribute_hide_attribute'] );
        add_action( 'woocommerce_after_edit_attribute_fields', [$this,'my_edit_wc_attribute_hide_attribute'] );

        add_action( 'woocommerce_attribute_added', [$this,'my_save_wc_attribute_hide_attribute'] );
        add_action( 'woocommerce_attribute_updated', [$this,'my_save_wc_attribute_hide_attribute'] );
        
        add_action( 'woocommerce_attribute_deleted', function ( $id ) {
            delete_option( "wc_attribute_hide_attribute-$id" );
        } );

    }

    public function my_edit_wc_attribute_hide_attribute() {
        $id = isset( $_GET['edit'] ) ? absint( $_GET['edit'] ) : 0;
        $value = $id ? get_option( "wc_attribute_hide_attribute-$id" ) : '';
        ?>
        <tr class="form-field">
            <th scope="row" valign="top">
                <label for="hide-attri">Hidden</label>
            </th>
            <td>
                <input type="checkbox" name="hide_attribute" id="hide-attri" <?php checked( $value, 1 ); ?> />
            </td>
        </tr>
        <?php
    }
    

    public function my_save_wc_attribute_hide_attribute( $id ) {
        if ( is_admin() )  {
            (isset( $_POST['hide_attribute'])) ? $value = 1 : $value = 0;
           
            $option = "wc_attribute_hide_attribute-$id";
            update_option( $option, $value );
        }
    }
    

    
}