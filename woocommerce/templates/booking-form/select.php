<?php

/**

 * The template used for radio fields in the booking form, such as resources

 *

 * This template can be overridden by copying it to yourtheme/woocommerce-bookings/booking-form/select.php.

 *

 * HOWEVER, on occasion WooCommerce will need to update template files and you

 * (the theme developer) will need to copy the new files to your theme to

 * maintain compatibility. We try to do this as little as possible, but it does

 * happen. When this occurs the version of the template file will be bumped and

 * the readme will list any important changes.

 *

 * @see     https://docs.woocommerce.com/document/bookings-templates/

 * @author  Automattic

 * @version 1.8.0

 * @since   1.0.0

 */



if ( ! defined( 'ABSPATH' ) ) {

	exit; // Exit if accessed directly.

}

$class   = $field['class'];

$label   = $field['label'];

$name    = $field['name'];

$options = $field['options'];

$resource_prices = array(); // To store resource prices

global $product;;
$currency_symbol = get_woocommerce_currency_symbol() ;

if ( $product instanceof WC_Product_Booking ) {
    $resource_base_costs = $product->get_resource_base_costs();
    foreach ( $resource_base_costs as $resource_id => $base_cost ) {
        $resource_prices[$resource_id] = $base_cost; 
    }
}
if ( $product ) {
    $tax_class = $product->get_tax_class(); 
    $tax_rates = WC_Tax::get_rates($tax_class);
    if ( ! empty( $tax_rates ) ) {
        $first_rate = reset($tax_rates);
        $tax_percentage = $first_rate['rate'];
    
    } 
}

$services_heading = get_field('services_heading');
$services_subheading = get_field('services_subheading');
echo '<h1 class="product_title entry-title services_heading">'.$services_heading.'</h1>';
echo '<p class="services_subheading">'.$services_subheading .'</p>';
?>

<p class="form-field form-field-wide <?php echo esc_attr( implode( ' ', $class ) ); ?>">

    <?php foreach ( $options as $key => $value ) : ?>
    <?php
    $tooltip = get_field('tooltip_text',$key);
    ?>
        <div class="text-tooltip" id="tooltip-input-container" style="margin-top:8px;">
        <label>
           <input type="radio" name="<?php echo esc_attr( $name ); ?>" id="<?php echo esc_attr( $name . '_' . $key ); ?>" value="<?php echo esc_attr( $key ); ?>" />
           <div class="tooltip_container">
                <span><?php echo esc_html( $value ); ?></span>
                <?php if(!empty($tooltip)) :?>
                <svg xmlns="http://www.w3.org/2000/svg" tool-tip-text="<?=$tooltip;?>" class="tooltip_style tippy_tooltip" id='tooltip-input-<?=$key;?>' viewBox="0 0 50 50" width="12px" height="12px">
                    <path d="M 25 2 C 12.309295 2 2 12.309295 2 25 C 2 37.690705 12.309295 48 25 48 C 37.690705 48 48 37.690705 48 25 C 48 12.309295 37.690705 2 25 2 z M 25 4 C 36.609824 4 46 13.390176 46 25 C 46 36.609824 36.609824 46 25 46 C 13.390176 46 4 36.609824 4 25 C 4 13.390176 13.390176 4 25 4 z M 25 11 A 3 3 0 0 0 22 14 A 3 3 0 0 0 25 17 A 3 3 0 0 0 28 14 A 3 3 0 0 0 25 11 z M 21 21 L 21 23 L 22 23 L 23 23 L 23 36 L 22 36 L 21 36 L 21 38 L 22 38 L 23 38 L 27 38 L 28 38 L 29 38 L 29 36 L 28 36 L 27 36 L 27 21 L 26 21 L 22 21 L 21 21 z" fill="#ffffff" stroke="none"></path>
                </svg>
                <?php endif; ?>
            </div>
            
        </label>
        </div>
    <?php endforeach; ?>

</p>

<div class="resources-price">
    <div>
    </div>
</div>
<div class="_divider"></div>



<script type="text/javascript">
    document.addEventListener('DOMContentLoaded', function() {
        const radioInputs = document.querySelectorAll('input[name="<?php echo esc_js( $name ); ?>"]');
        const priceDisplay = document.querySelector('.resources-price div')
        const resourcePrices = <?php echo json_encode($resource_prices); ?>;
        const currency = "<?= html_entity_decode($currency_symbol); ?>";
        const tax_percentage = <?=intval($tax_percentage);?>
        

        function updatePriceDisplay() {
            const selectedRadio = document.querySelector('input[name="<?php echo esc_js( $name ); ?>"]:checked');
            if (selectedRadio) {
                const selectedKey = selectedRadio.value;
                const price = resourcePrices[selectedKey];
                let text = `( ${currency}${price} + VAT )`;

		        let total_price = price * (1 + (tax_percentage / 100));
                if (price !== undefined) {
                    // priceDisplay.innerHTML = '< ?php echo esc_js( wc_price( 0 ) ); ?>'.replace('0.00', price.toFixed(2));
                    priceDisplay.innerHTML = `<span>${currency}</span><span class="_price">${total_price}</span><span class="">${text}</span>`;
                } else {
                    priceDisplay.innerHTML = '';
                }
            }

        }
        radioInputs.forEach(function(radio) {
            radio.addEventListener('change', updatePriceDisplay);

        });
        updatePriceDisplay();

    });

</script>

