<?php
/**
 * Block pattern helpers.
 *
 * @package azarashilove
 */

/**
 * Register theme pattern categories.
 */
function azarashilove_register_pattern_categories() {
	register_block_pattern_category(
		'azarashilove-site',
		array( 'label' => __( 'Azarashilove site parts', 'azarashilove' ) )
	);
}
add_action( 'init', 'azarashilove_register_pattern_categories' );

/**
 * Render a PHP-backed block pattern file from the theme patterns directory.
 *
 * @param string $slug Pattern file name without extension.
 */
function azarashilove_render_theme_pattern( $slug ) {
	$slug = sanitize_file_name( $slug );
	$file = get_theme_file_path( "patterns/{$slug}.php" );

	if ( ! is_readable( $file ) ) {
		return;
	}

	ob_start();
	include $file;
	$content = ob_get_clean();

	echo do_blocks( $content ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped
}
