<?php
/**
 * @package wpscrub
 * @version 1.0
 */

/*
Plugin Name: wpscrub
Plugin URI: https://github.com/mkaz/wpscrub
Description: A plugin to remove a bit of unnecessary stuff from WordPress load.
Author: Marcus Kazmierczak
Version: 1.1
Author URI: https://mkaz.com/
*/

defined( 'ABSPATH' ) or die( 'No thanks.');

// disable emoji
add_action( 'init', function() {
	remove_action( 'wp_head', 'print_emoji_detection_script', 7 );
	remove_action( 'admin_print_scripts', 'print_emoji_detection_script' );
	remove_action( 'wp_print_styles', 'print_emoji_styles' );
	remove_action( 'admin_print_styles', 'print_emoji_styles' );
	remove_filter( 'the_content_feed', 'wp_staticize_emoji' );
	remove_filter( 'comment_text_rss', 'wp_staticize_emoji' );
	remove_filter( 'wp_mail', 'wp_staticize_emoji_for_email' );


	// disable oembeds
	remove_action( 'rest_api_init', 'wp_oembed_register_route' );
	add_filter( 'embed_oembed_discover', '__return_false' );
	remove_action( 'wp_head', 'wp_oembed_add_host_js' );
	remove_action( 'wp_head', 'wp_oembed_add_discovery_links' );
} );

// remove enqueue scripts devicepx
add_action( 'wp_enqueue_scripts', function() {
    wp_dequeue_script( 'devicepx' );

	// check if single page and dont include blocks
	if ( !is_single() ) {
		wp_dequeue_script('mkaz-code-syntax-prism-settings');
		wp_dequeue_script('mkaz-code-syntax-prism-css');
		wp_dequeue_style('mkaz-code-syntax-prism-css');
		wp_dequeue_style('mkaz-code-syntax-css');
		wp_dequeue_style('wp-block-library');
	}
}, 20 );


// remove jquery-migrate
add_action( 'wp_default_scripts', function( $scripts ) {
    if ( ! empty( $scripts->registered['jquery'] ) ) {
        $scripts->registered['jquery']->deps = array_diff( $scripts->registered['jquery']->deps, array( 'jquery-migrate' ) );
    }
} );

