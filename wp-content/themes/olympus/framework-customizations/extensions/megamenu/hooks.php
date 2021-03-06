<?php

/**
 * Replace default walker.
 *
 * @package olympus
 * */

function olympus_wp_setup_nav_menu_item( $menu_item ) {
    if ( isset( $menu_item->post_type ) ) {
        if ( 'nav_menu_item' == $menu_item->post_type ) {
            $menu_item->description = apply_filters( 'nav_menu_description', $menu_item->post_content );
        }
    }

    return $menu_item;
}

add_filter( 'wp_setup_nav_menu_item', 'olympus_wp_setup_nav_menu_item' );

function olympus_filter_mega_menu_icon_customizations( $option ) {
    $option[ 'type' ] = 'icon-v2';
    return $option;
}

add_filter( 'fw:ext:megamenu:icon-option', 'olympus_filter_mega_menu_icon_customizations' );

function olympus_megamenu_admin_enqueue_scripts() {
    $megamenu = Olympus_Core::get_extension( 'megamenu' );

    if ( !$megamenu ) {
        return false;
    }
    
    wp_enqueue_script( "fw-ext-{$megamenu->get_name()}-admin", get_template_directory_uri() . "/framework-customizations/extensions/megamenu/static/js/admin.js", array( 'fw' ), $megamenu->manifest->get_version() );
}

add_action( 'admin_enqueue_scripts', 'olympus_megamenu_admin_enqueue_scripts', 9 );
