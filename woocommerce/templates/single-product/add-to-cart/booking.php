<?php
/**
 * Booking product add to cart.
 *
 * This template can be overridden by copying it to yourtheme/woocommerce-bookings/single-product/add-to-cart/booking.php
 *
 * HOWEVER, on occasion WooCommerce will need to update template files and you
 * (the theme developer) will need to copy the new files to your theme to
 * maintain compatibility. We try to do this as little as possible, but it does
 * happen. When this occurs the version of the template file will be bumped and
 * the readme will list any important changes.
 *
 * @see     https://docs.woocommerce.com/document/bookings-templates/
 * @author  Automattic
 * @version 1.10.0
 * @since   1.0.0
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

global $product;

if ( ! $product->is_purchasable() ) {
	return;
}
$cart_items = WC()->cart->get_cart();
// echo '<pre>';
// print_r( $cart_items );

$special_instruction = get_field('special_instruction');
$nonce = wp_create_nonce( 'find-booked-day-blocks' );


do_action( 'woocommerce_before_add_to_cart_form' ); ?>

<noscript><?php esc_html_e( 'Your browser must support JavaScript in order to make a booking.', 'woocommerce-bookings' ); ?></noscript>
<section class="">
	<div class="">
		<form class="cart custom-grid-cols-two" method="post" enctype='multipart/form-data' data-nonce="<?php echo esc_attr( $nonce ); ?>" template-path="woo-template/single-product">
			<section class="dad-product-details col">
				<div id="wc-bookings-booking-form" class="wc-bookings-booking-form">
					<?php do_action( 'woocommerce_before_booking_form' ); ?> 
					<?php $booking_form->output(); ?>
					<div class="wc-bookings-booking-cost price" style="display:none" data-raw-price=""></div>
				</div>
				<div class="_select_time_preferece">
					<div class="_heading">
						<h2 class="_heading">Time Preference</h2>
					</div>
					<div class="group">
						<input type="radio" name="time_preferece" value="AM" />
						<label for="time_preferece">AM</label>
					</div>
					<div class="group">
						<input type="radio" name="time_preferece" value="PM"/>
						<label for="time_preferece">PM</label>
					</div>
				</div>
			</section>
			<section class="dad-add-to-cart col">
				<div class="_group">
					<div class="upload_image">
						<div class="_heading">
							<h2>Image</h2>
							<div class="text-tooltip" id="text-tooltip">
								<div class="text">Please Upload an image of your waste.</div>
								<svg xmlns="http://www.w3.org/2000/svg" class="tooltip_style" id="tooltip-img" viewBox="0 0 50 50" width="12px" height="12px">
  									<path d="M 25 2 C 12.309295 2 2 12.309295 2 25 C 2 37.690705 12.309295 48 25 48 C 37.690705 48 48 37.690705 48 25 C 48 12.309295 37.690705 2 25 2 z M 25 4 C 36.609824 4 46 13.390176 46 25 C 46 36.609824 36.609824 46 25 46 C 13.390176 46 4 36.609824 4 25 C 4 13.390176 13.390176 4 25 4 z M 25 11 A 3 3 0 0 0 22 14 A 3 3 0 0 0 25 17 A 3 3 0 0 0 28 14 A 3 3 0 0 0 25 11 z M 21 21 L 21 23 L 22 23 L 23 23 L 23 36 L 22 36 L 21 36 L 21 38 L 22 38 L 23 38 L 27 38 L 28 38 L 29 38 L 29 36 L 28 36 L 27 36 L 27 21 L 26 21 L 22 21 L 21 21 z" fill="#ffffff" stroke="none"/>
								</svg>
							</div>
						</div>
						<!-- <input type="file" name="upload_image" id="upload_image"> -->
						<div class="custom-file-upload">
							<input type="file" name="custom_image_upload" id="custom_image_upload" />
							<label for="custom_image_upload" class="file-upload-btn">Upload</label>
						</div>
					
					</div>
					<div class="special-instructions">
						<div class="_heading">
							<h2>Special Instructions</h2>
						</div>
						<textarea name="sepcial_instructions" id="sepcial_instructions" placeholder="<?php echo strip_tags($special_instruction); ?>"></textarea>
						<div class="tnc">
							<input type="checkbox" id="tnc-checkbox" name="tnc">
							<label for="tnc-checkbox">I accept <a href="/terms-of-business/" class="underline">terms of service</a></label>
						</div>  
					</div>
				</div>
				<div class="_group">
					<div class="_checkout">
						<?php do_action( 'woocommerce_before_add_to_cart_button' ); ?>
						<input type="hidden" name="add-to-cart" value="<?php echo esc_attr( is_callable( array( $product, 'get_id' ) ) ? $product->get_id() : $product->id ); ?>" class="wc-booking-product-id" />
						<button type="submit" id="checkout-button" class="wc-bookings-booking-form-button single_add_to_cart_button button alt" disabled>Checkout</button>
						<input type="hidden" id="min_date" name="min_date" value="0"/>
						<input type="hidden" id="max_date" name="max_date" value="0"/>
						<input type="hidden" id="timezone_offset" name="timezone_offset" value="0"/>
						<?php do_action( 'woocommerce_after_add_to_cart_button' ); ?>
					</div>
					<div class="_continue_shopping">
						<button type="button" class="">
							<?php
							$shop_url = get_permalink( wc_get_page_id( 'shop' ) );
							?>
							<a href="<?=$shop_url;?>">
								Add Services
							</a>
						</button>
					</div>
				</div>
			</section>

		</form>

	</div>
<?php do_action( 'woocommerce_after_add_to_cart_form' ); ?>

