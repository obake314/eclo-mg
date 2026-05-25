<?php
/**
 * Admin UI enhancements: thumbnail column, character-count column, author meta box.
 *
 * @package okberlin
 */

// --- Thumbnail column in post list -------------------------------------------

function okberlin_add_thumbnail_column( $columns ) {
	$columns['thumbnail'] = __( 'Thumbnail' );
	return $columns;
}
add_filter( 'manage_posts_columns', 'okberlin_add_thumbnail_column' );

function okberlin_render_thumbnail_column( $col, $post_id ) {
	if ( $col !== 'thumbnail' ) {
		return;
	}
	$img = get_the_post_thumbnail( $post_id, 'small', array( 'style' => 'width:150px;height:auto;' ) );
	echo $img ? $img : __( 'None' );
}
add_action( 'manage_posts_custom_column', 'okberlin_render_thumbnail_column', 10, 2 );

// --- Character-count column in post list -------------------------------------

function okberlin_add_charcount_column( $columns ) {
	$columns['char_count'] = '文字数';
	return $columns;
}
add_filter( 'manage_posts_columns', 'okberlin_add_charcount_column' );

function okberlin_render_charcount_column( $col, $post_id ) {
	if ( $col !== 'char_count' ) {
		return;
	}
	echo mb_strlen( strip_tags( get_post_field( 'post_content', $post_id ) ) );
}
add_action( 'manage_posts_custom_column', 'okberlin_render_charcount_column', 11, 2 );

// --- Author meta box for "trade" post type -----------------------------------

add_action( 'admin_menu', function () {
	if ( function_exists( 'add_meta_box' ) ) {
		add_meta_box(
			'okberlin_trade_author',
			__( '作成者', 'myplugin_textdomain' ),
			'post_author_meta_box',
			'trade',
			'advanced'
		);
	}
} );
