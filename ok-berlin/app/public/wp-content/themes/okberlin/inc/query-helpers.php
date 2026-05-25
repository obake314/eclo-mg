<?php
/**
 * Query helpers with per-request memoisation.
 *
 * @package okberlin
 */

/**
 * Wrapper around get_posts() that caches results within the current request.
 * Identical $args produce only one DB query per page load.
 *
 * @param array $args  Same arguments accepted by get_posts().
 * @return WP_Post[]
 */
function okberlin_get_posts( array $args ): array {
	static $cache = array();

	$key = md5( serialize( $args ) );

	if ( ! isset( $cache[ $key ] ) ) {
		$cache[ $key ] = get_posts( $args ) ?: array();
	}

	return $cache[ $key ];
}
