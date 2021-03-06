<?php
/**
 * WooCommerce Admin: Historical Analytics Data Note.
 *
 * Adds a notes to store alerts area concerning the historial analytics data tool.
 *
 * @package WooCommerce Admin
 */

defined( 'ABSPATH' ) || exit;

/**
 * WC_Admin_Notes_Historical_Data.
 */
class WC_Admin_Notes_Historical_Data {
	const NOTE_NAME = 'wc-admin-historical-data';

	/**
	 * Creates a note for regenerating historical data.
	 */
	public static function add_note() {
		$is_upgrading = get_option( WC_Admin_Install::VERSION_OPTION );
		if ( $is_upgrading ) {
			return;
		}

		// First, see if orders exist and if we've already created this kind of note so we don't do it again.
		$data_store = WC_Data_Store::load( 'admin-note' );
		$note_ids   = $data_store->get_notes_with_name( self::NOTE_NAME );
		$orders     = wc_get_orders(
			array(
				'limit' => 1,
			)
		);
		if ( ! empty( $note_ids ) || count( $orders ) < 1 ) {
			return;
		}

		$note = new WC_Admin_Note();
		$note->set_title( __( 'WooCommerce Admin: Historical Analytics Data', 'woocommerce-admin' ) );
		$note->set_content( __( 'To view your historical analytics data, you must process your existing orders and customers.', 'woocommerce-admin' ) );
		$note->set_type( WC_Admin_Note::E_WC_ADMIN_NOTE_UPDATE );
		$note->set_icon( 'info' );
		$note->set_name( self::NOTE_NAME );
		$note->set_content_data( (object) array() );
		$note->set_source( 'woocommerce-admin' );
		// @todo Add remind me later option. See https://github.com/woocommerce/woocommerce-admin/issues/1756.
		$note->add_action(
			'get-started',
			__( 'Get Started', 'woocommerce-admin' ),
			'?page=wc-admin#/analytics/settings',
			'actioned'
		);

		$note->save();
	}
}

new WC_Admin_Notes_Historical_Data();
