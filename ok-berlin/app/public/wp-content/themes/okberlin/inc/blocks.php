<?php
/**
 * Register server-side rendered Gutenberg blocks.
 * JavaScript editor component: js/blocks.js
 *
 * @package okberlin
 */

// エディタ用スクリプトのエンキュー
add_action( 'enqueue_block_editor_assets', function () {
	wp_enqueue_script(
		'okberlin-blocks-editor',
		get_template_directory_uri() . '/js/blocks.js',
		array( 'wp-blocks', 'wp-element', 'wp-block-editor', 'wp-components' ),
		filemtime( get_template_directory() . '/js/blocks.js' ),
		true
	);
} );

// ブロックの PHP 側登録（init タイミング）
add_action( 'init', function () {

	register_block_type( 'okberlin/sec-vis', array(
		'editor_script'   => 'okberlin-blocks-editor',
		'render_callback' => 'okberlin_sec_vis',
	) );

	register_block_type( 'okberlin/sec-news', array(
		'editor_script'   => 'okberlin-blocks-editor',
		'render_callback' => 'okberlin_sec_news',
	) );

	register_block_type( 'okberlin/sec-contents', array(
		'editor_script'   => 'okberlin-blocks-editor',
		'render_callback' => 'okberlin_sec_contents',
	) );

	register_block_type( 'okberlin/sec-interview', array(
		'editor_script'   => 'okberlin-blocks-editor',
		'render_callback' => 'okberlin_sec_interview',
	) );

} );
