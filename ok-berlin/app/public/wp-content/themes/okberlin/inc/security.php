<?php
/**
 * Security & performance: remove unnecessary WordPress head output,
 * suppress update emails, disable image variants, remove jQuery from frontend.
 *
 * @package okberlin
 */

// --- WP head cleanup ----------------------------------------------------------

remove_action( 'wp_head', 'wp_generator' );
remove_action( 'wp_head', 'wp_resource_hints', 2 );     // DNS Prefetch
remove_action( 'wp_head', 'rest_output_link_wp_head' ); // Embed
remove_action( 'wp_head', 'wp_oembed_add_discovery_links' );
remove_action( 'wp_head', 'wp_oembed_add_host_js' );
remove_action( 'wp_head', 'rsd_link' );                 // EditURI
remove_action( 'wp_head', 'wlwmanifest_link' );
remove_action( 'wp_head', 'wp_shortlink_wp_head' );

remove_action( 'wp_head',            'print_emoji_detection_script', 7 );
remove_action( 'admin_print_scripts', 'print_emoji_detection_script' );
remove_action( 'wp_print_styles',    'print_emoji_styles' );
remove_action( 'admin_print_styles', 'print_emoji_styles' );

function okberlin_remove_version_from_assets( $src ) {
	if ( strpos( $src, 'ver=' . get_bloginfo( 'version' ) ) ) {
		$src = remove_query_arg( 'ver', $src );
	}
	return $src;
}
add_filter( 'style_loader_src',  'okberlin_remove_version_from_assets', 9999 );
add_filter( 'script_loader_src', 'okberlin_remove_version_from_assets', 9999 );

// --- jQuery: フロントエンドでは使用しない（admin のみ WP 標準 jQuery を使用）----

add_filter( 'wp_default_scripts', function ( $scripts ) {
	if ( ! is_admin() ) {
		$scripts->remove( 'jquery' );
		$scripts->remove( 'jquery-core' );
		$scripts->remove( 'jquery-migrate' );
	}
} );

// --- Suppress automated update emails ----------------------------------------

add_filter( 'auto_core_update_send_email',   '__return_false' );
add_filter( 'auto_theme_update_send_email',  '__return_false' );
add_filter( 'auto_plugin_update_send_email', '__return_false' );

// --- Disable intermediate image size generation ------------------------------

function okberlin_disable_image_sizes( $sizes ) {
	unset(
		$sizes['thumbnail'],
		$sizes['medium'],
		$sizes['large'],
		$sizes['medium_large'],
		$sizes['1536x1536'],
		$sizes['2048x2048']
	);
	return $sizes;
}
add_filter( 'intermediate_image_sizes_advanced', 'okberlin_disable_image_sizes' );
add_filter( 'wp_big_image_size_threshold',       '__return_false' );
add_filter( 'big_image_size_threshold',          '__return_false' );

// --- Exclude feed from search engine indexing --------------------------------

add_action( 'template_redirect', function () {
	if ( is_feed() && headers_sent() === false ) {
		header( 'X-Robots-Tag: noindex, follow', true );
	}
} );
