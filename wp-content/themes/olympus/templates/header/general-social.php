<?php
/**
 * The template for displaying one of theme headers
 *
 * @link    https://developer.wordpress.org/themes/basics/template-files/#template-partials
 *
 * @package olympus
 */
$olympus	 = Olympus_Options::get_instance();
$show_search = $olympus->get_option( 'top-panel-search', 'yes' );
?>

<header class="header <?php echo (!is_user_logged_in()) ? 'header--logout' : ''; ?>" id="site-header">
    <div class="header-content-wrapper">

		<?php if ( $show_search === 'yes' ) { ?>
			<form id="top-search-form" action="<?php echo home_url( '/' ); ?>" method="GET" class="search-bar w-search notification-list friend-requests">
				<div class="form-group with-button">
					<div class="selectize-control form-control js-user-search multi">
						<div class="selectize-input items not-full has-options">
							<input type="text" autocomplete="off" name="s" id="s" value="<?php echo filter_input( INPUT_GET, 's' ); ?>" placeholder="<?php esc_attr_e( 'Search here people or pages...', 'olympus' ); ?>">
						</div>
						<div class="selectize-dropdown multi form-control js-user-search mCustomScrollbar">
							<div class="selectize-dropdown-content"></div>
						</div>
					</div>
					<button>
						<svg class="olymp-magnifying-glass-icon">
						<use xlink:href="<?php echo get_template_directory_uri(); ?>/images/icons.svg#olymp-magnifying-glass-icon"></use>
						</svg>
					</button>
				</div>
			</form>
		<?php } ?>

		<?php if ( is_user_logged_in() ) { ?>
			<div id="notification-panel-top" class="control-block">
				<?php get_template_part( 'templates/user/notifications' ); ?>
			</div>
			<div id="notification-panel-bottom" class="notification-panel-bottom">
				<div class="control-block"></div>
			</div>
		<?php } else if ( function_exists( 'crumina_get_reg_form_html' ) ) { ?>
			<a href="#" class="side-menu-open" data-toggle="modal" data-target="#registration-login-form-popup">
				<svg class="olymp-login-icon olymp-menu-icon">
				<use xlink:href="<?php echo get_template_directory_uri(); ?>/images/icons.svg#olymp-login-icon"></use>
				</svg>
			</a>
		<?php } ?>

        <div class="fixed-sidebar right">
            <a href="#" class="side-menu-open js-sidebar-open">
                <i class="user-icon far fa-user" data-toggle="tooltip" data-placement="left" data-original-title="Open menu"></i>
                <svg class="olymp-close-icon" data-toggle="tooltip" data-placement="left" data-original-title="Close menu">
                <use xlink:href="<?php echo get_template_directory_uri(); ?>/images/icons.svg#olymp-close-icon"></use>
                </svg>
            </a>

            <div class="fixed-sidebar-right" id="sidebar-right">

                <div id="profile-panel-responsive" class="mCustomScrollbar ps ps--theme_default" data-mcs-theme="dark">

                </div>

            </div>
        </div>

    </div>

</header>



























