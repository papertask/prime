<?php

if ( !defined( 'FW' ) ) {
    die( 'Forbidden' );
}

$manifest = array();

$manifest[ 'name' ]         = esc_html__( 'Stunning header', 'crumina' );
$manifest[ 'description' ]  = esc_html__( 'Stunning header.', 'crumina' );
$manifest[ 'remote' ]       = 'https://up.crumina.net/extensions/versions/';
$manifest[ 'thumbnail' ]    = plugins_url( 'unyson/framework/extensions/stunning-header/static/img/thumbnail.png' );
$manifest[ 'version' ]      = '1.0.31';
$manifest[ 'display' ]      = true;
$manifest[ 'standalone' ]   = false;
$manifest[ 'requirements' ] = array(
    'extensions' => array(
        'breadcrumbs' => array(),
    )
);