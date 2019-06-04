<?php

if ( !defined( 'FW' ) ) {
    die( 'Forbidden' );
}

$manifest = array();

$manifest[ 'name' ]         = __( 'Ajax blog', 'crum-ext-ajax-blog' );
$manifest[ 'description' ]  = __( 'Ajax blog.', 'crum-ext-ajax-blog' );
$manifest[ 'remote' ]       = 'https://up.crumina.net/extensions/versions/';
$manifest[ 'thumbnail' ]    = plugins_url( 'unyson/framework/extensions/ajax-blog/static/img/thumbnail.png' );
$manifest[ 'version' ]      = '1.0.22';
$manifest[ 'display' ]      = true;
$manifest[ 'standalone' ]   = false;
$manifest[ 'requirements' ] = array(
    'extensions' => array(
        'post-reaction' => array(),
    )
);
