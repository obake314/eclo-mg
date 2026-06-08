<?php

if ( ! defined( '_S_VERSION' ) ) {
	define( '_S_VERSION', '1.0.9' );
}

if ( ! function_exists( 'baba_farm_setup' ) ) {
	function baba_farm_setup() {
		add_theme_support( 'title-tag' );
		add_theme_support( 'post-thumbnails' );

		register_nav_menus(
			array(
				'menu-1' => esc_html__( 'Primary', 'baba_farm' ),
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
	}
}
add_action( 'after_setup_theme', 'baba_farm_setup' );

function baba_farm_content_width() {
	$GLOBALS['content_width'] = apply_filters( 'baba_farm_content_width', 640 );
}
add_action( 'after_setup_theme', 'baba_farm_content_width', 0 );

function baba_farm_widgets_init() {
	register_sidebar(
		array(
			'name'          => esc_html__( 'Sidebar', 'baba_farm' ),
			'id'            => 'sidebar-1',
			'description'   => esc_html__( 'Add widgets here.', 'baba_farm' ),
			'before_widget' => '<section id="%1$s" class="widget %2$s">',
			'after_widget'  => '</section>',
			'before_title'  => '<h2 class="widget-title">',
			'after_title'   => '</h2>',
		)
	);
}
add_action( 'widgets_init', 'baba_farm_widgets_init' );

function baba_farm_scripts() {
	wp_enqueue_style( 'baba_farm-style', get_stylesheet_uri(), array(), _S_VERSION );
	wp_style_add_data( 'baba_farm-style', 'rtl', 'replace' );

	wp_enqueue_style(
		'font-awesome',
		'https://use.fontawesome.com/releases/v5.13.0/css/all.css',
		array(),
		'5.13.0'
	);

	wp_enqueue_style(
		'swiper',
		'https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.css',
		array(),
		'11'
	);

	wp_enqueue_style(
		'drawer',
		'https://cdnjs.cloudflare.com/ajax/libs/drawer/3.2.2/css/drawer.min.css',
		array(),
		'3.2.2'
	);

	wp_enqueue_script(
		'swiper-js',
		'https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.js',
		array(),
		'11',
		true
	);

	wp_enqueue_script( 'baba_farm-navigation', get_template_directory_uri() . '/js/navigation.js', array(), _S_VERSION, true );
	wp_enqueue_script( 'baba_farm-theme', get_template_directory_uri() . '/js/theme.js', array( 'swiper-js' ), _S_VERSION, true );

	if ( is_singular() && comments_open() && get_option( 'thread_comments' ) ) {
		wp_enqueue_script( 'comment-reply' );
	}
}
add_action( 'wp_enqueue_scripts', 'baba_farm_scripts' );

function baba_farm_add_column_media_card_urls( $block_content, $block ) {
	if ( 'core/post-template' !== ( $block['blockName'] ?? '' ) || false === strpos( $block_content, 'list_column_media' ) ) {
		return $block_content;
	}

	return preg_replace_callback(
		'/<li\b([^>]*)class="([^"]*\bwp-block-post\b[^"]*\bpost-(\d+)\b[^"]*)"([^>]*)>/',
		function ( $matches ) {
			if ( false !== strpos( $matches[0], 'data-card-url=' ) ) {
				return $matches[0];
			}

			$permalink = get_permalink( (int) $matches[3] );
			if ( ! $permalink ) {
				return $matches[0];
			}

			return sprintf(
				'<li%1$sclass="%2$s"%3$s data-card-url="%4$s">',
				$matches[1],
				$matches[2],
				$matches[4],
				esc_url( $permalink )
			);
		},
		$block_content
	);
}
add_filter( 'render_block', 'baba_farm_add_column_media_card_urls', 10, 2 );

function baba_farm_posted_on() {
	$time_string = '<time class="entry-date published updated" datetime="%1$s">%2$s</time>';
	if ( get_the_time( 'U' ) !== get_the_modified_time( 'U' ) ) {
		$time_string = '<time class="entry-date published" datetime="%1$s">%2$s</time><time class="updated" datetime="%3$s">%4$s</time>';
	}
	$time_string = sprintf(
		$time_string,
		esc_attr( get_the_date( DATE_W3C ) ),
		esc_html( get_the_date() ),
		esc_attr( get_the_modified_date( DATE_W3C ) ),
		esc_html( get_the_modified_date() )
	);
	$posted_on = sprintf(
		esc_html_x( 'Posted on %s', 'post date', 'baba_farm' ),
		'<a href="' . esc_url( get_permalink() ) . '" rel="bookmark">' . $time_string . '</a>'
	);
	echo '<span class="posted-on">' . $posted_on . '</span>'; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped
}

function baba_farm_posted_by() {
	$byline = sprintf(
		esc_html_x( 'by %s', 'post author', 'baba_farm' ),
		'<span class="author vcard"><a class="url fn n" href="' . esc_url( get_author_posts_url( get_the_author_meta( 'ID' ) ) ) . '">' . esc_html( get_the_author() ) . '</a></span>'
	);
	echo '<span class="byline"> ' . $byline . '</span>'; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped
}

function baba_farm_entry_footer() {
	if ( 'post' === get_post_type() ) {
		$categories_list = get_the_category_list( esc_html__( ', ', 'baba_farm' ) );
		if ( $categories_list ) {
			printf( '<span class="cat-links">' . esc_html__( '%1$s', 'baba_farm' ) . '</span>', $categories_list ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped
		}
		$tags_list = get_the_tag_list( '', esc_html_x( ', ', 'list item separator', 'baba_farm' ) );
		if ( $tags_list ) {
			printf( '<span class="tags-links">' . esc_html__( '%1$s', 'baba_farm' ) . '</span>', $tags_list ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped
		}
	}
	if ( ! is_single() && ! post_password_required() && ( comments_open() || get_comments_number() ) ) {
		echo '<span class="comments-link">';
		comments_popup_link(
			sprintf(
				wp_kses(
					__( 'Leave a Comment<span class="screen-reader-text"> on %s</span>', 'baba_farm' ),
					array( 'span' => array( 'class' => array() ) )
				),
				wp_kses_post( get_the_title() )
			)
		);
		echo '</span>';
	}
}

function baba_farm_post_thumbnail() {
	if ( post_password_required() || is_attachment() || ! has_post_thumbnail() ) {
		return;
	}
	if ( is_singular() ) : ?>
		<div class="post-thumbnail">
			<?php the_post_thumbnail(); ?>
		</div>
	<?php else : ?>
		<a class="post-thumbnail" href="<?php the_permalink(); ?>" aria-hidden="true" tabindex="-1">
			<?php the_post_thumbnail( 'post-thumbnail', array( 'alt' => the_title_attribute( array( 'echo' => false ) ) ) ); ?>
		</a>
	<?php endif;
}

function baba_farm_is_product_lp_page() {
	return is_page(
		array(
			'shiroi-kajitsu',
			'kuri-kabocha',
			'kiraho-genmai',
			7263,
			7389,
			7480,
		)
	);
}

function baba_farm_product_lp_template( $template ) {
	if ( baba_farm_is_product_lp_page() ) {
		$product_template = locate_template( 'page-product.php' );

		if ( $product_template ) {
			return $product_template;
		}
	}

	return $template;
}
add_filter( 'template_include', 'baba_farm_product_lp_template', 20 );

function baba_farm_body_classes( $classes ) {
	if ( ! is_singular() ) {
		$classes[] = 'hfeed';
	}
	if ( ! is_active_sidebar( 'sidebar-1' ) ) {
		$classes[] = 'no-sidebar';
	}
	if ( baba_farm_is_product_lp_page() ) {
		$classes[] = 'page-template-page-product';
		$classes[] = 'page-template-page-product-php';
	}
	return $classes;
}
add_filter( 'body_class', 'baba_farm_body_classes' );

function baba_farm_pingback_header() {
	if ( is_singular() && pings_open() ) {
		printf( '<link rel="pingback" href="%s">', esc_url( get_bloginfo( 'pingback_url' ) ) );
	}
}
add_action( 'wp_head', 'baba_farm_pingback_header' );

add_filter( 'auto_plugin_update_send_email', '__return_false' );
add_filter( 'auto_theme_update_send_email', '__return_false' );

// 不要な wp_head 出力を削除
remove_action( 'wp_head', 'wp_generator' );
remove_action( 'wp_head', 'feed_links', 2 );
remove_action( 'wp_head', 'feed_links_extra', 3 );
remove_action( 'wp_head', 'print_emoji_detection_script', 7 );
remove_action( 'admin_print_scripts', 'print_emoji_detection_script' );
remove_action( 'wp_print_styles', 'print_emoji_styles' );
remove_action( 'admin_print_styles', 'print_emoji_styles' );
remove_action( 'wp_head', 'wp_resource_hints', 2 );
remove_action( 'wp_head', 'rest_output_link_wp_head' );
remove_action( 'wp_head', 'wp_oembed_add_discovery_links' );
remove_action( 'wp_head', 'wp_oembed_add_host_js' );
remove_action( 'wp_head', 'rsd_link' );
remove_action( 'wp_head', 'wlwmanifest_link' );
remove_action( 'wp_head', 'adjacent_posts_rel_link_wp_head', 10, 0 );
remove_action( 'wp_head', 'wp_shortlink_wp_head' );

// WordPress バージョン文字列を CSS/JS URL の ver クエリから除去
function baba_farm_remove_wp_version_from_asset_url( $src ) {
	if ( false !== strpos( $src, 'ver=' . get_bloginfo( 'version' ) ) ) {
		$src = remove_query_arg( 'ver', $src );
	}

	return $src;
}
add_filter( 'style_loader_src', 'baba_farm_remove_wp_version_from_asset_url', 9999 );
add_filter( 'script_loader_src', 'baba_farm_remove_wp_version_from_asset_url', 9999 );

// 埋め込み表示用カスタム CSS
if ( file_exists( get_stylesheet_directory() . '/wp-embed-template-custom.css' ) ) {
	function baba_farm_enqueue_embed_styles() {
		wp_enqueue_style( 'wp-embed-template-custom', get_stylesheet_directory_uri() . '/wp-embed-template-custom.css', array(), _S_VERSION );
	}
	remove_action( 'embed_head', 'print_embed_styles' );
	add_filter( 'embed_head', 'baba_farm_enqueue_embed_styles' );
}

// 注文ページの URL パラメータに応じてチェックボックスを自動選択
function baba_farm_set_order_item_checkboxes() {
	if ( ! is_page( 'order' ) || empty( $_GET['item'] ) || is_array( $_GET['item'] ) ) {
		return;
	}

	$item_param = sanitize_text_field( wp_unslash( (string) $_GET['item'] ) );

	$items = array_filter(
		array_map(
			'sanitize_text_field',
			array_map( 'trim', explode( ',', $item_param ) )
		)
	);

	if ( ! $items ) {
		return;
	}
	?>
	<script>
	document.addEventListener('DOMContentLoaded', function () {
		const targetValues = <?php echo wp_json_encode( array_values( $items ), JSON_HEX_TAG | JSON_HEX_AMP | JSON_HEX_APOS | JSON_HEX_QUOT ); ?>;
		document.querySelectorAll('.smf-checkbox-control__control').forEach(function (checkbox) {
			if (targetValues.includes(checkbox.value)) {
				checkbox.checked = true;
			}
		});
	});
	</script>
	<?php
}
add_action( 'wp_footer', 'baba_farm_set_order_item_checkboxes' );
