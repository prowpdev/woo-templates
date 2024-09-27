<?php

global $product;

$product_id = $product->get_id();

$product = wc_get_product($product_id); // Get the product object by ID

$grouped_products = $product->get_children();

$services_heading = get_field('services_heading');

$services_subheading = get_field('services_subheading');

$special_instruction = get_field('special_instruction');


?>



<div class="__heading-container">

    <h1><?= $services_heading ?></h1>

    <p><?= $services_subheading ?></p>

</div>

<form id="order-form" method="POST" action="">

    <div class="order-form">
        <div class="order-header">
            <!-- <div class="order-cell required" style="display:none;">ID</div> -->
            <div class="order-cell required">Aggregates</div>
            <div class="order-cell required">Volume</div>
            <div class="order-cell">Per Tonne</div>
            <div class="order-cell">Amount</div>
            <div class="order-cell required">Date</div>
            <div class="order-cell required">Slot</div>
            <div class="order-cell"></div>
        </div>
      
    </div>
    <button type="submit" name="checkout">Add to cart</button>
</form>
<?php
echo '<select class="get_product" id="selected_product">';
echo '<option value="">Add+</option>'; // Add an empty value for the default option
foreach ($grouped_products as $product_id) {
    $child_product = wc_get_product($product_id);
    $product_name = $child_product->get_name();
    echo "<option value='" . $product_id . "'>" . $product_name . "</option>";
}
echo '</select>';
?>


<hr id="horizontal__line">

<section class="special__instruction__container">

    <div class="special-instructions">

        <div class="_heading">

            <h2>Special Instructions</h2>

        </div>

        <textarea name="sepcial_instructions" id="sepcial_instructions"><?php echo strip_tags($special_instruction); ?></textarea>

    </div>

    <div class="_group">

        <div class="tnc">

            <input type="checkbox" name="tnc">

            <label for="">I accept <a href="/terms-of-business/" class="underline">terms of service</a></label>

        </div>

        <div class="btn__container">

            <div class="_checkout">

                <?php do_action('woocommerce_before_add_to_cart_button'); ?>

                <input type="hidden" name="add-to-cart" value="<?php echo esc_attr(is_callable(array($product, 'get_id')) ? $product->get_id() : $product->id); ?>" class="wc-booking-product-id" />

                <!-- <button type="submit" class="wc-bookings-booking-form-button single_add_to_cart_button button alt disabled" style="display:none">< ?php echo esc_html( $product->single_add_to_cart_text() ); ?></button> -->

                <button type="submit" class="wc-bookings-booking-form-button single_add_to_cart_button button alt" disabled>Checkout</button>

                <input type="hidden" id="min_date" name="min_date" value="0" />

                <input type="hidden" id="max_date" name="max_date" value="0" />

                <input type="hidden" id="timezone_offset" name="timezone_offset" value="0" />

                <?php do_action('woocommerce_after_add_to_cart_button'); ?>

            </div>

            <div class="_continue_shopping">

                <button type="button" class="">

                    <?php

                    $shop_url = get_permalink(wc_get_page_id('shop'));

                    ?>

                    <a href="<?= $shop_url; ?>">

                        Add Services

                    </a>

                </button>

            </div>

        </div>

    </div>

</section>





<?php


if (isset($_POST['checkout'])) {
    $volumes = $_POST['volume'];
    $dates = $_POST['date']; 
    $times = $_POST['time']; 

    foreach ($volumes as $product_id => $volume) {
        $volume = $volumes[$product_id];
        $time = $times[$product_id];
        $time = $times[$product_id];
        // print_r( 'Product id is ' .$product_id . 'Volume is '. $volume );
        custom_add_to_cart($product_id, $volume, $date,$time);
        // https://staging2.dadhaulage.com/?add-to-cart=1382&quantity=1
        // Add logic for adding products to cart, calculating totals, etc.
    }
}

?>

<script>
    const price = document.querySelector('#price');

    function changeVolume(event, delta) {

        const input = event.target.closest('.volume-input').querySelector('input[type="text"]');

        let currentValue = parseInt(input.value);

        currentValue += delta;

        if (currentValue < 10) currentValue = 10;  // Minimum value of 10
        if (currentValue > 17) currentValue = 17;  // Maximum value of 17
        //if (currentValue < 1) currentValue = 1; // Prevent negative or zero volume

        input.value = currentValue;



        changeTotalPrice(input, input.value);

    }



    function removeRow(button) {

        const row = button.closest('.order-row');

        row.remove();

    }

    function changeTotalPrice(input, value) {

        const row = input.closest('.order-row');

        const price = parseFloat(row.querySelector('.total-amount').getAttribute('price'));

        console.log(price)

        const volume = parseInt(input.value);

        const totalAmount = price * volume;

        row.querySelector('.total-amount').textContent = `£${totalAmount.toFixed(2)}`; // Format to 2 decimal places

    }
</script>