<?php
/**
 * Checkout Form
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/checkout/form-checkout.php.
 *
 * HOWEVER, on occasion WooCommerce will need to update template files and you
 * (the theme developer) will need to copy the new files to your theme to
 * maintain compatibility. We try to do this as little as possible, but it does
 * happen. When this occurs the version of the template file will be bumped and
 * the readme will list any important changes.
 *
 * @see https://woocommerce.com/document/template-structure/
 * @package WooCommerce\Templates
 * @version 3.5.0
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

do_action( 'woocommerce_before_checkout_form', $checkout );

// If checkout registration is disabled and not logged in, the user cannot checkout.
if ( ! $checkout->is_registration_enabled() && $checkout->is_registration_required() && ! is_user_logged_in() ) {
	echo esc_html( apply_filters( 'woocommerce_checkout_must_be_logged_in_message', __( 'You must be logged in to checkout.', 'woocommerce' ) ) );
	return;
}

?>

<form name="checkout" method="post" class="checkout woocommerce-checkout"
    action="<?php echo esc_url( wc_get_checkout_url() ); ?>" enctype="multipart/form-data">

    <?php if ( $checkout->get_checkout_fields() ) : ?>

    <?php do_action( 'woocommerce_checkout_before_customer_details' ); ?>

    <div class="col2-set" id="customer_details">
        <div class="col-1">
            <?php do_action( 'woocommerce_checkout_billing' ); ?>
        </div>

        <div class="col-2">
            <h1 class="_heading_2">Payment Information</h1>
			<?php remove_action('woocommerce_checkout_order_review', 'woocommerce_checkout_payment', 20) ;?>
			<?php woocommerce_checkout_payment();  ?>
            <?php if ( ! is_user_logged_in() && $checkout->is_registration_enabled() ) : ?>
            <div class="woocommerce-account-fields">
                <?php if ( ! $checkout->is_registration_required() ) : ?>
                <h1 class="_heading_2">Create Account</h1>
                <p class="form-row form-row-wide create-account">
                    <label class="woocommerce-form__label woocommerce-form__label-for-checkbox checkbox">
                        <input class="woocommerce-form__input woocommerce-form__input-checkbox input-checkbox"
                            id="createaccount"
                            <?php checked( ( true === $checkout->get_value( 'createaccount' ) || ( true === apply_filters( 'woocommerce_create_account_default_checked', false ) ) ), true ); ?>
                            type="checkbox" name="createaccount" value="1" />
                        <span><?php esc_html_e( 'Create an account?', 'woocommerce' ); ?></span>
                    </label>
                </p>

                <?php endif; ?>

                <?php do_action( 'woocommerce_before_checkout_registration_form', $checkout ); ?>

                <?php if ( $checkout->get_checkout_fields( 'account' ) ) : ?>

                <div class="create-account">
                    <?php foreach ( $checkout->get_checkout_fields( 'account' ) as $key => $field ) : ?>
                    <?php woocommerce_form_field( $key, $field, $checkout->get_value( $key ) ); ?>
                    <?php endforeach; ?>
                    <div class="clear"></div>
                </div>

                <?php endif; ?>

                <?php do_action( 'woocommerce_after_checkout_registration_form', $checkout ); ?>

            </div>
            <?php endif; ?>

        </div>
    </div>

    <?php do_action( 'woocommerce_checkout_after_customer_details' ); ?>

    <?php endif; ?>

    <?php do_action( 'woocommerce_checkout_before_order_review_heading' ); ?>

    <h3 id="order_review_heading"><?php esc_html_e( 'Your order', 'woocommerce' ); ?></h3>

    <?php do_action( 'woocommerce_checkout_before_order_review' ); ?>

    <div id="order_review" class="woocommerce-checkout-review-order">
        <?php do_action( 'woocommerce_checkout_order_review' ); ?>
    </div>

    <?php do_action( 'woocommerce_checkout_after_order_review' ); ?>

</form>

<?php do_action( 'woocommerce_after_checkout_form', $checkout ); ?>