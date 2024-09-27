<?php

if ( ! defined( 'ABSPATH' ) ) {

    exit; 

}

$current_product_loop = wc_get_product( $product_id );

// wc_get_template( 'content-single-product.php',['current_product' => $current_product_loop ]);

$product_name = get_the_title( $product_id );

$price = $current_product_loop->get_price();

$currency_symbol = get_woocommerce_currency_symbol();


?>


 <div class="order-row">

    <div class="order-cell " style="display: none;"><?=$product_id?></div>

    <div class="order-cell"><?=$product_name?></div>

    <div class="order-cell">

        <div class="volume-input">

            <button type="button" onclick="changeVolume(event, -1)">-</button>

            <input type="text" name="volume[<?=$product_id?>]" value="0" readonly>

            <button type="button" onclick="changeVolume(event, 1)">+</button>

        </div>

    </div>

    <div class="order-cell"><?=$currency_symbol;?><?=$price?>/tonne</div>

    <div class="order-cell total-amount" price="<?=$price;?>" quantity="1">£0.00</div>

    <div class="order-cell">

    <div class="custom-select">
        <div class="select-styled">9 Sep 2024</div>
        <div class="calendar-dropdown">
            <div class="calendar-header">
                <button class="nav-btn prev-month">&lt;</button>
                <div class="month-year"></div>
                <button class="nav-btn next-month">&gt;</button>
            </div>
            <div class="weekdays">
                <div>M</div><div>T</div><div>W</div><div>T</div><div>F</div><div>S</div><div>S</div>
            </div>
            <div class="days"></div>
        </div>
    </div>

    </div>

    <div class="order-cell">

        <select name="time[<?=$product_id?>]">

            <option value="AM">AM</option>

            <option value="PM">PM</option>

        </select>

    </div>

    <div class="order-cell">

        <button type="button" class="remove-btn" onclick="removeRow(this)">×</button>

    </div>

</div>





