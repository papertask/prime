<?php
add_action( 'wp_enqueue_scripts', '_action_olympus_youzer_scripts', 9999 );

function _action_olympus_youzer_scripts() {
	$theme_version = olympus_get_theme_version();

	wp_enqueue_style( 'youzer-customization', get_template_directory_uri() . '/css/youzer-customization.css', false, $theme_version );
}

//Register Public Scripts .
add_action( 'wp_enqueue_scripts', '_action_olympus_yz_scripts', 9999 );

function _action_olympus_yz_scripts() {

	global $Youzer, $post;

	if ( !$Youzer ) {
		return;
	}

	wp_deregister_style( 'yz-profile' );
	wp_register_style( 'yz-profile', get_theme_file_uri( 'css/youzer/yz-profile-style.css' ), null, '10.0.0' );

	wp_deregister_style( 'yz-bp-uploader' );
	wp_register_style( 'yz-bp-uploader', get_theme_file_uri( 'css/youzer/yz-bp-uploader.css' ), null, '10.0.0' );

	wp_deregister_style( 'yz-iconpicker' );
	wp_register_style( 'yz-iconpicker', get_theme_file_uri( 'css/youzer/yz-icon-picker.css' ), null, '10.0.0' );

	wp_dequeue_style( 'youzer' );
	wp_deregister_style( 'youzer' );
	wp_enqueue_style( 'youzer', get_theme_file_uri( 'css/youzer/youzer.css' ), null, '10.0.0' );

	wp_dequeue_style( 'yz-headers' );
	wp_deregister_style( 'yz-headers' );
	wp_enqueue_style( 'yz-headers', get_theme_file_uri( 'css/youzer/yz-headers.css' ), array( 'yz-lato', 'yz-roboto' ), '10.0.0' );


	wp_dequeue_style( 'yz-woocommerce' );
	wp_deregister_style( 'yz-woocommerce' );
	wp_enqueue_style( 'yz-woocommerce', get_theme_file_uri( 'css/youzer/yz-woocommerce.css' ), null, '10.0.0' );

	// Member Pages CSS
	if ( !bp_is_members_directory() && !bp_is_groups_directory() ) {
		wp_dequeue_style( 'yz-social' );
		wp_deregister_style( 'yz-social' );
		wp_enqueue_style( 'yz-social', get_theme_file_uri( 'css/youzer/yz-social.css' ), array( 'dashicons' ), '10.0.0' );
	}

	wp_dequeue_style( 'yz-wall' );
	wp_deregister_style( 'yz-wall' );
	wp_enqueue_style( 'yz-wall', get_theme_file_uri( 'css/youzer/yz-wall.css' ), null, '10.0.0' );

	if ( yz_is_reviews_active() ) {
		wp_dequeue_style( 'yz-reviews' );
		wp_deregister_style( 'yz-reviews' );
		wp_enqueue_style( 'yz-reviews', get_theme_file_uri( 'css/youzer/yz-reviews.css' ), null, '10.0.0' );
	}

	if ( function_exists( 'yz_is_mycred_active' ) && yz_is_mycred_active() ) {
		wp_dequeue_style( 'yz-mycred' );
		wp_deregister_style( 'yz-mycred' );

		wp_register_style( 'yz-mycred', get_theme_file_uri( 'css/youzer/yz-mycred.css' ), null, '10.0.0' );
		wp_enqueue_style( 'yz-mycred' );
	}

	if ( (function_exists( 'is_bbpress' ) && is_bbpress()) || is_singular() ) {
		wp_dequeue_style( 'yz-bbpress' );
		wp_deregister_style( 'yz-bbpress' );

		wp_register_style( 'yz-bbpress', get_theme_file_uri( 'css/youzer/yz-bbpress.css' ), null, '10.0.0' );
		wp_enqueue_style( 'yz-bbpress' );
	}

	if ( bp_is_groups_component() && !bp_is_groups_directory() ) {
		wp_dequeue_style( 'yz-groups' );
		wp_deregister_style( 'yz-groups' );
		wp_enqueue_style( 'yz-groups', get_theme_file_uri( 'css/youzer/yz-groups.css' ), array( 'yz-bp-uploader' ), '10.0.0' );
	}

	if ( bp_is_members_directory() || bp_is_groups_directory() ) {
		wp_dequeue_style( 'yz-directories' );
		wp_deregister_style( 'yz-directories' );
		wp_enqueue_style( 'yz-directories', get_theme_file_uri( 'css/youzer/yz-directories.css' ), array( 'dashicons' ), '10.0.0' );
	}

	wp_dequeue_style( 'yz-account-css' );
	wp_deregister_style( 'yz-account-css' );
	wp_enqueue_style( 'yz-account-css', get_theme_file_uri( 'css/youzer/yz-account-style.css' ), array( 'yz-panel-css' ), '10.0.0' );

	if ( !is_user_logged_in() ) {
		wp_dequeue_style( 'logy-style' );
		wp_deregister_style( 'logy-style' );
		wp_enqueue_style( 'logy-style', get_theme_file_uri( 'css/youzer/logy.css' ), array( 'yz-opensans', 'yz-icons' ), '10.0.0' );
	}
}

add_filter( 'yz_profile_navbar_menu_icon', '_action_olympus_yz_profile_icons', 10, 2 );
add_filter( 'yz_profile_tab_submenu_icons', '_action_olympus_yz_profile_icons', 10, 2 );

function _action_olympus_yz_profile_icons( $icon_html, $item ) {
	$icon = '';

	switch ( $icon_html ) {
		case '<i class="fas fa-globe"></i>':
			$icon	 = 'olymp-albums-icon';
			break;
		case '<i class="fas fa-address-card"></i>':
			$icon	 = 'olymp-newsfeed-icon';
			break;
		case '<i class="fas fa-info"></i>':
			$icon	 = 'olymp-status-icon';
			break;
		case '<i class="fas fa-handshake"></i>':
			$icon	 = 'olymp-happy-faces-icon';
			break;
		case '<i class="fas fa-users"></i>':
			$icon	 = 'olymp-groups-icon';
			break;
		case '<i class="fas fa-pencil-alt"></i>':
			$icon	 = 'olymp-blog-icon';
			break;
		case '<i class="far fa-comments"></i>':
			$icon	 = 'olymp-comments-post-icon';
			break;
		case '<i class="fas fa-globe-asia"></i>':
			$icon	 = 'olymp-albums-icon';
			break;
		case '<i class="fas fa-bookmark"></i>':
			$icon	 = 'olymp-manage-widgets-icon';
			break;
		case '<i class="fas fa-star"></i>':
			$icon	 = 'olymp-star-icon';
			break;
		case '<i class="fas fa-user-circle"></i>':
			$icon	 = 'olymp-thunder-icon';
			break;
		case '<i class="fas fa-at"></i>':
			$icon	 = 'olymp-add-to-conversation-icon';
			break;
		case '<i class="fas fa-heart"></i>':
			$icon	 = 'olymp-heart-icon';
			break;
		case '<i class="fas fa-eye-slash"></i>':
			$icon	 = 'olymp-unread-icon';
			break;
		case '<i class="fas fa-eye"></i>':
			$icon	 = 'olymp-read-icon';
			break;
		case '<i class="fas fa-trophy"></i>':
			$icon	 = 'olymp-trophy-icon';
			break;
		case '<i class="fas fa-paper-plane"></i>':
			$icon	 = 'olymp-friendships';
			break;
		case '<i class="fas fa-file-alt"></i>':
			$icon	 = 'olymp-friendships';
			break;
		case '<i class="fas fa-thumbs-up"></i>':
			$icon	 = 'olymp-heart-icon';
			break;
		case '<i class="fas fa-bell"></i>':
			$icon	 = 'olymp-add-to-conversation-icon';
			break;
		case '<i class="fas fa-edit"></i>':
			$icon	 = 'olymp-edit-icon';
			break;
		case '<i class="fas fa-bullhorn"></i>':
			$icon	 = 'olymp-pin-icon';
			break;
		case '<i class="fas fa-inbox"></i>':
			$icon	 = 'olymp-project-icon';
			break;
		case '<i class="fas fa-shopping-cart"></i>':
			$icon	 = 'olymp-shopping-bag-icon';
			break;
		case '<i class="far fa-credit-card"></i>':
			$icon	 = 'olymp-checkout-icon';
			break;
		case '<i class="fas fa-truck-moving"></i>':
			$icon	 = 'olymp-track-icon';
			break;
		case '<i class="fas fa-shopping-basket"></i>':
			$icon	 = 'olymp-orders-icon';
			break;
		case '<i class="fas fa-download"></i>':
			$icon	 = 'olymp-downloads-icon';
			break;
		case '<i class="fas fa-credit-card"></i>':
			$icon	 = 'olymp-payment-methods-icon';
			break;
		case '<i class="far fa-user-circle"></i>':
			$icon	 = 'olymp-account-icon';
			break;
		case '<i class="fas fa-rss"></i>':
			$icon	 = 'olymp-star-icon';
			break;
		case '<i class="fas fa-share"></i>':
			$icon	 = 'olymp-star-icon';
			break;
		case '<i class="fas fa-reply"></i>':
			$icon	 = 'olymp-read-icon';
			break;

		default:
			return $icon_html;
			break;
	}

	ob_start();
	?>
	<svg class="olymp-menu-icon">
	<use xlink:href="<?php echo get_template_directory_uri(); ?>/images/icons.svg#<?php echo esc_attr( $icon ); ?>"></use>
	</svg>
	<?php
	return ob_get_clean();
}

add_filter( 'youzer_edit_options', '_filter_olympus_yz_edit_options', 10, 2 );

function _filter_olympus_yz_edit_options( $option_value, $option_id ) {

	switch ( $option_id ) {
		case 'yz_enable_settings_copyright':
			$option_value = 'off';
			break;
	}

	return $option_value;
}
