<?php
/**
 * okberlin functions and definitions
 *
 * @link https://developer.wordpress.org/themes/basics/theme-functions/
 *
 * @package okberlin
 */

if ( ! defined( '_S_VERSION' ) ) {
	define( '_S_VERSION', '1.0.0' );
}

if ( ! function_exists( 'okberlin_setup' ) ) :
	function okberlin_setup() {
		load_theme_textdomain( 'okberlin', get_template_directory() . '/languages' );
		add_theme_support( 'automatic-feed-links' );
		add_theme_support( 'title-tag' );
		add_theme_support( 'post-thumbnails' );
		register_nav_menus(
			array(
				'menu-1' => esc_html__( 'Primary', 'okberlin' ),
			)
		);
		add_theme_support(
			'html5',
			array(
				'search-form',
				'comment-form',
				'comment-list',
				'gallery',
				'caption',
				'style',
				'script',
			)
		);

		add_theme_support(
			'custom-background',
			apply_filters(
				'okberlin_custom_background_args',
				array(
					'default-color' => 'ffffff',
					'default-image' => '',
				)
			)
		);

		// Add theme support for selective refresh for widgets.
		add_theme_support( 'customize-selective-refresh-widgets' );
		add_theme_support( 'block-template-parts' );
		add_theme_support(
			'custom-logo',
			array(
				'height'      => 250,
				'width'       => 250,
				'flex-width'  => true,
				'flex-height' => true,
			)
		);
	}
endif;
add_action( 'after_setup_theme', 'okberlin_setup' );


function okberlin_content_width() {
	$GLOBALS['content_width'] = apply_filters( 'okberlin_content_width', 640 );
}
add_action( 'after_setup_theme', 'okberlin_content_width', 0 );

function okberlin_widgets_init() {
	register_sidebar(
		array(
			'name'          => esc_html__( 'Sidebar', 'okberlin' ),
			'id'            => 'sidebar-1',
			'description'   => esc_html__( 'Add widgets here.', 'okberlin' ),
			'before_widget' => '<section id="%1$s" class="widget %2$s">',
			'after_widget'  => '</section>',
			'before_title'  => '<h2 class="widget-title">',
			'after_title'   => '</h2>',
		)
	);
}
add_action( 'widgets_init', 'okberlin_widgets_init' );

/**
 * Enqueue scripts and styles.
 */
function okberlin_scripts() {
	wp_enqueue_style( 'okberlin-fonts-bad-script', 'https://fonts.googleapis.com/css2?family=Bad+Script&display=swap', array(), null );
	wp_enqueue_style( 'okberlin-fonts-vt323', 'https://fonts.googleapis.com/css2?family=VT323&display=swap', array(), null );
	wp_enqueue_style( 'okberlin-style', get_stylesheet_uri(), array( 'okberlin-fonts-bad-script', 'okberlin-fonts-vt323' ), _S_VERSION );
	wp_enqueue_script( 'okberlin-navigation', get_template_directory_uri() . '/js/navigation.js', array(), _S_VERSION, true );
	wp_enqueue_script( 'okberlin-slider', get_template_directory_uri() . '/js/slider.js', array(), _S_VERSION, true );

	if ( is_singular() && comments_open() && get_option( 'thread_comments' ) ) {
		wp_enqueue_script( 'comment-reply' );
	}
}
add_action( 'wp_enqueue_scripts', 'okberlin_scripts' );

/**
 * Custom template tags for this theme.
 */
require get_template_directory() . '/inc/template-tags.php';

/**
 * Functions which enhance the theme by hooking into WordPress.
 */
require get_template_directory() . '/inc/template-functions.php';

/**
 * Security, performance, and head cleanup.
 */
require get_template_directory() . '/inc/security.php';

/**
 * Admin UI enhancements (columns, author meta box).
 */
require get_template_directory() . '/inc/admin.php';

/**
 * Shortcode definitions.
 */
require get_template_directory() . '/inc/shortcodes.php';

/**
 * Query helpers with per-request memoisation.
 */
require get_template_directory() . '/inc/query-helpers.php';

function okberlin_custom_excerpt_length() {
	return 100;
}
add_filter( 'excerpt_length', 'okberlin_custom_excerpt_length', 999 );

add_filter( 'excerpt_more', function () {
	return '…';
} );

add_filter( 'get_the_archive_title', function ( $title ) {
	if ( is_category() ) {
		$title = single_cat_title( '', false );
	} elseif ( is_tag() ) {
		$title = single_tag_title( '', false );
	} elseif ( is_tax() ) {
		$title = single_term_title( '', false );
	} elseif ( is_post_type_archive() ) {
		$title = post_type_archive_title( '', false );
	} elseif ( is_date() ) {
		$title = get_the_time( 'Y年n月' );
	} elseif ( is_search() ) {
		$title = '検索結果：' . esc_html( get_search_query( false ) );
	} elseif ( is_404() ) {
		$title = '「404」ページが見つかりません';
	}
	return $title;
} );


