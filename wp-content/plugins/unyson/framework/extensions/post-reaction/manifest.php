<?php

if ( !defined( 'FW' ) ) {
    die( 'Forbidden' );
}

$manifest = array();

$manifest[ 'name' ]        = __( 'Post reaction', 'crumina' );
$manifest[ 'description' ] = __( 'Post reaction.', 'crumina' );
$manifest[ 'version' ]     = '1.0.20';
$manifest[ 'display' ]     = true;
$manifest[ 'standalone' ]  = true;
$manifest[ 'remote' ]       = 'https://up.crumina.net/extensions/versions/';
$manifest[ 'thumbnail' ]   = plugins_url( 'unyson/framework/extensions/post-reaction/static/img/thumbnail.png' );
