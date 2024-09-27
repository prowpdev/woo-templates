<?php

/**
 * AJAX
 */

#############################################################################################################################
// ajax file ( move this section after dev mode )
add_action('wp_ajax_my_custom_ajax_action', 'handle_my_custom_ajax_function');
add_action('wp_ajax_nopriv_my_custom_ajax_action', 'handle_my_custom_ajax_function');

function handle_my_custom_ajax_function()
{
    // Verify the nonce
    check_ajax_referer('my_custom_nonce', 'nonce');
    $item = $_POST['post_id'];
    
    if (empty($item)) return;

    $html_output = ''; // Initialize a variable to store the HTML
    $child_product = wc_get_product($item);

    if ($child_product->is_type('booking')) {
        $current_product_loop = wc_get_product($item);
        $product_id = $item;
        $product_name = get_the_title($product_id);
        $price = $current_product_loop->get_price();
        $currency_symbol = get_woocommerce_currency_symbol();

        // Append the HTML for each product to the output variable
        $html_output .= '<div class="order-row">';
        //$html_output .= '<div class="order-cell">' . $product_id . '</div>';
        $html_output .= '<div class="order-cell">' . $product_name . '</div>';
        $html_output .= '<div class="order-cell">
                                <div class="volume-input">
                                    <button type="button" onclick="changeVolume(event, -1)">-</button>
                                    <input type="text" name="volume[' . $product_id . ']" value="10" readonly>
                                    <button type="button" onclick="changeVolume(event, 1)">+</button>
                                </div>
                             </div>';
        $html_output .= '<div class="order-cell">' . $currency_symbol . $price . '/tonne</div>';
        $html_output .= '<div class="order-cell total-amount" price="' . $price . '" quantity="1">' . $currency_symbol . '0.00</div>';
        $html_output .= '<div class="order-cell">
                                <select name="date[' . $product_id . ']">
                                    <option value="2024-09-09">30 Oct 2024</option>
                                </select>
                             </div>';
        $html_output .= '<div class="order-cell">
                                <select name="time[' . $product_id . ']">
                                    <option value="AM">AM</option>
                                    <option value="PM">PM</option>
                                </select>
                             </div>';
        $html_output .= '<div class="order-cell">
                                <button type="button" class="remove-btn" onclick="removeRow(this)">×</button>
                             </div>';
        $html_output .= '</div>';
    }


    // Return the generated HTML as the AJAX response
    wp_send_json_success($html_output);

    // Always die after handling AJAX requests to prevent further execution
    wp_die();
}


add_action('wp_ajax_aggregate_product_html_action', 'aggregate_product_html');
add_action('wp_ajax_nopriv_aggregate_product_html_action', 'aggregate_product_html');
function aggregate_product_html($product_ids = [])
{

    foreach ($product_ids as $item):

        $child_product = new WC_Product_Booking($item);

        $oCustomPostMeta = get_post_custom($item);

        $child_product = wc_get_product($item);

        if ($child_product->is_type('booking')) {

            $plugin_template_dir = plugin_dir_path(__FILE__);

            // wc_get_template( 'content-group-item-product.php', array( 'product' => 1682,'source'=>'group' ) );

            $product_id = $item;

            // include $plugin_template_dir.'content-group-item-product.php';
            $current_product_loop = wc_get_product($product_id);

            // wc_get_template( 'content-single-product.php',['current_product' => $current_product_loop ]);

            $product_name = get_the_title($product_id);

            $price = $current_product_loop->get_price();

            $currency_symbol = get_woocommerce_currency_symbol();
?>
            <div class="order-row">

                <div class="order-cell"><?= $product_id ?></div>

                <div class="order-cell"><?= $product_name ?></div>

                <div class="order-cell">

                    <div class="volume-input">

                        <button type="button" onclick="changeVolume(event, -1)">-</button>

                        <input type="text" name="volume[<?= $product_id ?>]" value="0" readonly>

                        <button type="button" onclick="changeVolume(event, 1)">+</button>

                    </div>

                </div>

                <div class="order-cell"><?= $currency_symbol; ?><?= $price ?>/tonne</div>

                <div class="order-cell total-amount" price="<?= $price; ?>" quantity="1">£0.00</div>

                <div class="order-cell">

                    <select name="date[<?= $product_id ?>]">

                        <option value="2024-09-09">9 Sep 2024</option>

                        <!-- Add more dates if necessary -->

                    </select>

                </div>

                <div class="order-cell">

                    <select name="time[<?= $product_id ?>]">

                        <option value="AM">AM</option>

                        <option value="PM">PM</option>

                    </select>

                </div>

                <div class="order-cell">

                    <button type="button" class="remove-btn" onclick="removeRow(this)">×</button>

                </div>

            </div>
<?php

        }

    endforeach;
}
