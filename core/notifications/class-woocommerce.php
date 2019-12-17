<?php
/**
 * WooCommerce notifications.
 *
 * @package     Slack_Notifications\Notifications
 * @subpackage  Comment
 * @author      Dor Zuberi <webmaster@dorzki.co.il>
 * @link        https://www.dorzki.co.il
 * @since       2.0.0
 * @version     2.0.6
 */

namespace Slack_Notifications\Notifications;

use WC_Order;
use WC_Product;

// Block direct access to the file via url.
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}


/**
 * Class WooCommerce
 *
 * @package Slack_Notifications\Notifications
 */
class WooCommerce extends Notification_Type {

	/**
	 * WooCommerce constructor.
	 */
	public function __construct() {

		$this->object_type    = 'woocommerce';
		$this->object_label   = esc_html__( 'WooCommerce', 'dorzki-notifications-to-slack' );
		$this->object_options = [
			'new_order'        => [
				'label'    => esc_html__( 'New Order', 'dorzki-notifications-to-slack' ),
				'hooks'    => [
					'woocommerce_checkout_order_processed' => 'new_order',
				],
				'priority' => 10,
				'params'   => 1,
			],
			'order_completed'  => [
				'label'    => esc_html__( 'Order Status: Completed', 'dorzki-notifications-to-slack' ),
				'hooks'    => [
					'woocommerce_order_status_completed' => 'order_transition',
				],
				'priority' => 10,
				'params'   => 1,
			],
			'order_pending'    => [
				'label'    => esc_html__( 'Order Status: Pending', 'dorzki-notifications-to-slack' ),
				'hooks'    => [
					'woocommerce_order_status_pending' => 'order_transition',
				],
				'priority' => 10,
				'params'   => 1,
			],
			'order_processing' => [
				'label'    => esc_html__( 'Order Status: Processing', 'dorzki-notifications-to-slack' ),
				'hooks'    => [
					'woocommerce_order_status_processing' => 'order_transition',
				],
				'priority' => 10,
				'params'   => 1,
			],
			'order_on_hold'    => [
				'label'    => esc_html__( 'Order Status: On Hold', 'dorzki-notifications-to-slack' ),
				'hooks'    => [
					'woocommerce_order_status_on-hold' => 'order_transition',
				],
				'priority' => 10,
				'params'   => 1,
			],
			'order_cancelled'  => [
				'label'    => esc_html__( 'Order Status: Cancelled', 'dorzki-notifications-to-slack' ),
				'hooks'    => [
					'woocommerce_order_status_cancelled' => 'order_transition',
				],
				'priority' => 10,
				'params'   => 1,
			],
			'order_refunded'   => [
				'label'    => esc_html__( 'Order Status: Refunded', 'dorzki-notifications-to-slack' ),
				'hooks'    => [
					'woocommerce_order_status_refunded' => 'order_transition',
				],
				'priority' => 10,
				'params'   => 1,
			],
			'order_failed'     => [
				'label'    => esc_html__( 'Order Status: Failed', 'dorzki-notifications-to-slack' ),
				'hooks'    => [
					'woocommerce_order_status_failed' => 'order_transition',
				],
				'priority' => 10,
				'params'   => 1,
			],
			'new_order_note'   => [
				'label'    => esc_html__( 'New Order Note', 'dorzki-notifications-to-slack' ),
				'hooks'    => [
					'woocommerce_new_customer_note' => 'new_order_note',
				],
				'priority' => 10,
				'params'   => 1,
			],
			'low_stock'        => [
				'label'    => esc_html__( 'Product Low Stock', 'dorzki-notifications-to-slack' ),
				'hooks'    => [
					'woocommerce_low_stock' => 'product_low_stock',
				],
				'priority' => 10,
				'params'   => 1,
			],
			'no_stock'         => [
				'label'    => esc_html__( 'Product Out of Stock', 'dorzki-notifications-to-slack' ),
				'hooks'    => [
					'woocommerce_no_stock' => 'product_low_stock',
				],
				'priority' => 10,
				'params'   => 1,
			],
		];

		parent::__construct();

	}


	/* ------------------------------------------ */


	/**
	 * Build order attachments.
	 *
	 * @param WC_Order $order WooCommerce order data.
	 *
	 * @return array
	 */
	private function build_order_attachments( $order ) {

		if ( ! $order instanceof WC_Order ) {
			return [];
		}

		$attachments   = [ 'multiple' => true ];
		$attachments[] = [
			[
				'title' => esc_html__( 'Order ID', 'dorzki-notifications-to-slack' ),
				'value' => $order->get_order_number(),
				'short' => true,
			],
			[
				'title' => esc_html__( 'Order Status', 'dorzki-notifications-to-slack' ),
				'value' => ucwords( $order->get_status() ),
				'short' => true,
			],
			[
				'title' => esc_html__( 'Order Total', 'dorzki-notifications-to-slack' ),
				'value' => html_entity_decode( wp_strip_all_tags( wc_price( $order->get_total() ) ) ),
				'short' => true,
			],
			[
				'title' => esc_html__( 'Paid Via', 'dorzki-notifications-to-slack' ),
				'value' => $order->get_payment_method_title(),
				'short' => true,
			],
		];

		foreach ( $order->get_items() as $product_data ) {

			$product = $product_data->get_product();

			if ( ! $product instanceof WC_Product ) {
				continue;
			}

			$attachments[] = [
				[
					'title' => esc_html__( 'Product Name', 'dorzki-notifications-to-slack' ),
					'value' => sprintf( '%s *x%s*', $product->get_name(), $product_data->get_quantity() ),
					'short' => true,
				],
				[
					'title' => esc_html__( 'Product Total', 'dorzki-notifications-to-slack' ),
					'value' => html_entity_decode( wp_strip_all_tags( wc_price( $product_data->get_total() ) ) ),
					'short' => true,
				],
			];

		}

		return $attachments;

	}


	/* ------------------------------------------ */


	/**
	 * Post notification when a new order was submitted.
	 *
	 * @param int $order_id WooCommerce order id number.
	 *
	 * @return bool
	 */
	public function new_order( $order_id ) {

		if ( empty( $order_id ) ) {
			return false;
		}

		// Get order.
		$order = wc_get_order( $order_id );

		// Build notification.
		/* translators: %1$s: Site URL, %2$s: Site Name */
		$message = __( ':shopping_bags: There is a new order on *<%1$s|%2$s>*!', 'dorzki-notifications-to-slack' );
		$message = sprintf( $message, get_bloginfo( 'url' ), get_bloginfo( 'name' ) );

		$attachments = $this->build_order_attachments( $order );

		$channel = $this->get_notification_channel( __FUNCTION__ );

		return $this->slack_bot->send_message(
			$message,
			$attachments,
			[
				'color'   => '#34495e',
				'channel' => $channel,
			]
		);

	}


	/**
	 * Post notification when an order status was changed.
	 *
	 * @param int $order_id WooCommerce order id number.
	 *
	 * @return bool
	 */
	public function order_transition( $order_id ) {

		if ( empty( $order_id ) ) {
			return false;
		}

		// Get order.
		$order = wc_get_order( $order_id );

		// Build notification.
		/* translators: %1$s: Order Status, %2$s: Site URL, %3$s: Site Name */
		$message = __( ':shopping_bags: An order was marked as %1$s on *<%2$s|%3$s>*.', 'dorzki-notifications-to-slack' );
		$message = sprintf( $message, $order->get_status(), get_bloginfo( 'url' ), get_bloginfo( 'name' ) );

		$attachments = $this->build_order_attachments( $order );

		$channel = $this->get_notification_channel( __FUNCTION__ );

		return $this->slack_bot->send_message(
			$message,
			$attachments,
			[
				'color'   => '#2c3e50',
				'channel' => $channel,
			]
		);

	}


	/**
	 * Post notification when a note is added to an order.
	 *
	 * @param array $note_data Note arguments.
	 *
	 * @return bool
	 */
	public function new_order_note( $note_data ) {

		if ( empty( $note_data ) ) {
			return false;
		}

		// Get order.
		$order = wc_get_order( $note_data['order_id'] );

		// Build notification.
		/* translators: %1$s: Site URL, %2$s: Site Name */
		$message = __( ':spiral_note_pad: A new note was added to an order on *<%1$s|%2$s>*', 'dorzki-notifications-to-slack' );
		$message = sprintf( $message, get_bloginfo( 'url' ), get_bloginfo( 'name' ) );

		$attachments = [
			[
				'title' => esc_html__( 'Order ID', 'dorzki-notifications-to-slack' ),
				'value' => $note_data['order_id'],
				'short' => true,
			],
			[
				'title' => esc_html__( 'Order Status', 'dorzki-notifications-to-slack' ),
				'note'  => ucwords( $order->get_status() ),
				'short' => true,
			],
			[
				'title' => esc_html__( 'Customer Name', 'dorzki-notifications-to-slack' ),
				'value' => $order->get_formatted_billing_full_name(),
				'short' => true,
			],
			[
				'title' => esc_html__( 'Customer Email', 'dorzki-notifications-to-slack' ),
				'value' => $order->get_billing_email(),
				'short' => true,
			],
			[
				'title' => esc_html__( 'Note Content', 'dorzki-notifications-to-slack' ),
				'value' => $note_data['customer_note'],
				'short' => false,
			],
		];

		$channel = $this->get_notification_channel( __FUNCTION__ );

		return $this->slack_bot->send_message(
			$message,
			$attachments,
			[
				'color'   => '#2c3e50',
				'channel' => $channel,
			]
		);

	}


	/**
	 * Post notification when a product stock is low or out.
	 *
	 * @param WC_Product $product WooCommerce product.
	 *
	 * @return bool
	 */
	public function product_low_stock( $product ) {

		if ( is_null( $product ) ) {
			return false;
		}

		// Build notification.
		if ( 'instock' === $product->get_stock_status() ) {
			/* translators: %1$s: Site URL, %2$s: Site Name */
			$message = __( ':information_source: Product stock is low on *<%1$s|%2$s>*', 'dorzki-notifications-to-slack' );
		} else {
			/* translators: %1$s: Site URL, %2$s: Site Name */
			$message = __( ':information_source: Product is out of stock *<%1$s|%2$s>*', 'dorzki-notifications-to-slack' );
		}

		$message        = sprintf( $message, get_bloginfo( 'url' ), get_bloginfo( 'name' ) );
		$stock_quantity = $product->get_stock_quantity();

		$attachments = [
			[
				'title' => esc_html__( 'Product Name', 'dorzki-notifications-to-slack' ),
				'value' => $product->get_name(),
				'short' => true,
			],
			[
				'title' => esc_html__( 'Product ID', 'dorzki-notifications-to-slack' ),
				'value' => $product->get_id(),
				'short' => true,
			],
			[
				'title' => esc_html__( 'Product SKU', 'dorzki-notifications-to-slack' ),
				'value' => $product->get_sku(),
				'short' => true,
			],
			[
				'title' => esc_html__( 'Stock Left', 'dorzki-notifications-to-slack' ),
				'value' => intval( $stock_quantity ),
				'short' => true,
			],
		];

		$channel = $this->get_notification_channel( __FUNCTION__ );

		return $this->slack_bot->send_message(
			$message,
			$attachments,
			[
				'color'   => '#2c3e50',
				'channel' => $channel,
			]
		);

	}

}
