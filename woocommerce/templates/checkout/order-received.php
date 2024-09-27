<?php
/**
 * "Order received" message.
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/checkout/order-received.php.
 *
 * @see https://woocommerce.com/document/template-structure/
 * @package WooCommerce\Templates
 * @version 8.8.0
 *
 * @var WC_Order|false $order
 */

defined( 'ABSPATH' ) || exit;
// print_r($order);
?>

<p class="woocommerce-notice woocommerce-notice--success woocommerce-thankyou-order-received">
	<?php
	$message = apply_filters(
		'woocommerce_thankyou_order_received_text',
		esc_html( __( 'Thank you. Your order has been received.', 'woocommerce' ) ),
		$order
	);

	// phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped
	echo $message;
	?>
</p>

<h2><?php esc_html_e( 'Order Details', 'woocommerce' ); ?></h2>

<table class="woocommerce-table woocommerce-table--order-details shop_table order_details">
	<thead>
		<tr>
			<th class="woocommerce-table__product-name"><?php esc_html_e( 'Product', 'woocommerce' ); ?></th>
			<th class="woocommerce-table__product-total"><?php esc_html_e( 'Total', 'woocommerce' ); ?></th>
		</tr>
	</thead>
	<tbody>
		<?php
		if ( $order ) {
			foreach ( $order->get_items() as $item_id => $item ) {
				$product = $item->get_product();
				$product_name = $item->get_name(); // Product name
				$product_total = $item->get_total(); // Total price for this item

				// Display product details
				echo '<tr>';
				echo '<td class="woocommerce-table__product-name">' . esc_html( $product_name ) . '</td>';
				echo '<td class="woocommerce-table__product-total">' . wc_price( $product_total ) . '</td>';
				echo '</tr>';
			}
		}
		?>
	</tbody>
</table>

<p class="woocommerce-thankyou-order-received">
	<?php esc_html_e( 'Thank you for your purchase!', 'woocommerce' ); ?>
</p>
