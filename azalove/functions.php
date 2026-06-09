<?php
/**
 * azarashilove functions and definitions
 *
 * @link https://developer.wordpress.org/themes/basics/theme-functions/
 *
 * @package azarashilove
 */

if ( ! defined( '_S_VERSION' ) ) {
	define( '_S_VERSION', '1.0.0' );
}

add_theme_support( 'wp-block-styles' );
add_theme_support( 'enable-layout-styles' );
add_theme_support( 'block-template-parts' );

/**
 * Theme Setup
 */

/**
 * フロントエンドからjQueryを除去（管理画面では維持）
 */
function azarashilove_dequeue_jquery() {
    if ( ! is_admin() ) {
        wp_deregister_script( 'jquery' );
    }
}

add_action( 'wp_enqueue_scripts', 'azarashilove_dequeue_jquery' );

if ( ! function_exists( 'azarashilove_setup' ) ) :
	function azarashilove_setup() {
		load_theme_textdomain( 'azarashilove', get_template_directory() . '/languages' );
		add_theme_support( 'automatic-feed-links' );
		add_theme_support( 'title-tag' );
		add_theme_support( 'post-thumbnails' );
		register_nav_menus(
			array(
				'menu-1' => esc_html__( 'Primary', 'azarashilove' ),
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
				'azarashilove_custom_background_args',
				array(
					'default-color' => 'ffffff',
					'default-image' => '',
				)
			)
		);
		
		add_theme_support( 'customize-selective-refresh-widgets' );
		
		add_theme_support(
			'custom-logo',
			array(
				'height'      => 250,
				'width'       => 250,
				'flex-width'  => true,
				'flex-height' => true,
			)
		);
		
		// Add excerpt support to pages
		add_post_type_support( 'page', 'excerpt' );
	}
endif;
add_action( 'after_setup_theme', 'azarashilove_setup' );

/**
 * Set content width
 */
function azarashilove_content_width() {
	$GLOBALS['content_width'] = apply_filters( 'azarashilove_content_width', 640 );
}
add_action( 'after_setup_theme', 'azarashilove_content_width', 0 );

/**
 * Enqueue scripts and styles
 */
function azarashilove_scripts() {
	wp_enqueue_style( 'azarashilove-style', get_stylesheet_uri(), array(), _S_VERSION );
    wp_enqueue_style( 'yakuhanjp', 'https://cdn.jsdelivr.net/npm/yakuhanjp@4.0.0/dist/css/yakuhanjp.min.css', array(), null );
}
add_action( 'wp_enqueue_scripts', 'azarashilove_scripts' );

// yakuhanjpを非同期化
add_filter( 'style_loader_tag', 'azarashilove_async_yakuhanjp', 10, 2 );
function azarashilove_async_yakuhanjp( $html, $handle ) {
    if ( $handle === 'yakuhanjp' ) {
        return str_replace(
            "media='all'",
            "media='print' onload=\"this.media='all'\"",
            $html
        );
    }
    return $html;
}

/**
 * Load theme files
 */
require get_template_directory() . '/inc/custom-header.php';
require get_template_directory() . '/inc/template-tags.php';
require get_template_directory() . '/inc/template-functions.php';
require get_template_directory() . '/inc/block-patterns.php';
require get_template_directory() . '/inc/customizer.php';

if ( defined( 'JETPACK__VERSION' ) ) {
	require get_template_directory() . '/inc/jetpack.php';
}

/**
 * =============================================================================
 * WordPress Head Cleanup
 * =============================================================================
 */

// Remove version info from head and assets
remove_action( 'wp_head', 'wp_generator' );

function azarashilove_remove_version_strings( $src ) {
	if ( strpos( $src, 'ver=' . get_bloginfo( 'version' ) ) ) {
		$src = remove_query_arg( 'ver', $src );
	}
	return $src;
}
add_filter( 'style_loader_src', 'azarashilove_remove_version_strings', 9999 );
add_filter( 'script_loader_src', 'azarashilove_remove_version_strings', 9999 );

// Remove feed links
remove_action( 'wp_head', 'feed_links', 2 );
remove_action( 'wp_head', 'feed_links_extra', 3 );

// Remove emoji scripts and styles
remove_action( 'wp_head', 'print_emoji_detection_script', 7 );
remove_action( 'admin_print_scripts', 'print_emoji_detection_script' );
remove_action( 'wp_print_styles', 'print_emoji_styles' );
remove_action( 'admin_print_styles', 'print_emoji_styles' );

// Remove DNS prefetch
remove_action( 'wp_head', 'wp_resource_hints', 2 );

// Remove embed functionality
remove_action( 'wp_head', 'rest_output_link_wp_head' );
remove_action( 'wp_head', 'wp_oembed_add_discovery_links' );
remove_action( 'wp_head', 'wp_oembed_add_host_js' );

// Remove EditURI
remove_action( 'wp_head', 'rsd_link' );

// Remove wlwmanifest
remove_action( 'wp_head', 'wlwmanifest_link' );

// Remove adjacent posts rel links
remove_action( 'wp_head', 'adjacent_posts_rel_link_wp_head', 10, 0 );

// Remove shortlink
remove_action( 'wp_head', 'wp_shortlink_wp_head' );


/**
 * Disable auto-update emails
 */
add_filter( 'auto_core_update_send_email', '__return_false' );
add_filter( 'auto_theme_update_send_email', '__return_false' );
add_filter( 'auto_plugin_update_send_email', '__return_false' );


/**
 * Disable auto-formatting on front-end
 */
add_action( 'wp_head', 'azarashilove_disable_autoformat_content' );

function azarashilove_disable_autoformat_content() {
	if ( is_singular() && get_post_meta( get_the_ID(), 'dont_autoformat_radio', true ) === 'dont' ) {
		remove_filter( 'the_content', 'wpautop' );
		remove_filter( 'the_excerpt', 'wpautop' );
	}
}

/**
 * =============================================================================
 * Archive Title Filter
 * =============================================================================
 */
add_filter( 'get_the_archive_title', 'azarashilove_archive_title' );

function azarashilove_archive_title( $title ) {
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
}

/**
 * =============================================================================
 * Shortcode: Display Facilities by Genus and Region
 * =============================================================================
 */
add_shortcode( 'facilities_by_genus_region', 'azarashilove_facilities_by_genus_region' );

function azarashilove_facilities_by_genus_region( $atts ) {
	$atts = shortcode_atts(
		array(
			'slugs' => '',
		),
		$atts,
		'facilities_by_genus_region'
	);

	$target_slugs = array_map( 'trim', explode( ',', $atts['slugs'] ) );
	
	if ( empty( $target_slugs[0] ) ) {
		return '<p>表示する分類（genus）が指定されていません。</p>';
	}

	$regions = array(
		'hokkaido'        => '北海道',
		'tohoku'          => '東北',
		'kanto'           => '関東',
		'chubu'           => '中部',
		'kinki'           => '近畿',
		'chugoku-shikoku' => '中国・四国',
		'kyushu-okinawa'  => '九州・沖縄',
	);

	$output = '<div class="facility-grouped-list">';
	$output .= '<h2>' . get_the_title() . 'に会える施設</h2>';

	foreach ( $regions as $region_slug => $region_label ) {
		$args = array(
			'post_type'      => 'facility',
			'posts_per_page' => -1,
			'tax_query'      => array(
				'relation' => 'AND',
				array(
					'taxonomy' => 'genus',
					'field'    => 'slug',
					'terms'    => $target_slugs,
				),
				array(
					'taxonomy' => 'prefectures',
					'field'    => 'slug',
					'terms'    => $region_slug,
				),
			),
		);

		$query = new WP_Query( $args );

		if ( $query->have_posts() ) {
			$output .= '<section class="region-block">';
			$output .= '<h3 class="region-title">' . esc_html( $region_label ) . '</h3>';
			$output .= '<ul class="facility-list">';

			while ( $query->have_posts() ) {
				$query->the_post();
				
				$thumbnail_id = get_post_thumbnail_id( get_the_ID() );
				$image_html   = '';
				
				if ( $thumbnail_id ) {
					$image_data = wp_get_attachment_image_src( $thumbnail_id, 'full' );
					if ( $image_data && isset( $image_data[0] ) ) {
						$image_url  = $image_data[0];
						$alt        = get_post_meta( $thumbnail_id, '_wp_attachment_image_alt', true );
						$title_attr = get_the_title( $thumbnail_id );
						$image_html = '<img src="' . esc_url( $image_url ) . '" alt="' . esc_attr( $alt ) . '" title="' . esc_attr( $title_attr ) . '">';
					}
				}

				$terms       = get_the_terms( get_the_ID(), 'prefectures' );
				$region_name = ( $terms && ! is_wp_error( $terms ) ) ? $terms[0]->name : '';

				$output .= '<li class="facility-item">';
				$output .= '<a href="' . esc_url( get_permalink() ) . '"></a>';
				$output .= '<figure>' . $image_html . '</figure>';
				$output .= '<div class="facility-item_text">';
				$output .= '<h4 class="facility-title">' . esc_html( get_the_title() ) . '</h4>';
				$output .= '<address>' . esc_html( $region_name ) . '</address>';
				$output .= '</div>';
				$output .= '</li>';
			}

			$output .= '</ul>';
			$output .= '</section>';
		}

		wp_reset_postdata();
	}

	$output .= '</div>';
	
	return $output;
}

add_filter('post_thumbnail_html', 'facility_default_thumbnail', 10, 5);

function facility_default_thumbnail($html, $post_id, $post_thumbnail_id, $size, $attr) {
	if (empty($post_id)) {
		return $html;
	}
	$post_type = get_post_type($post_id);
	if ($post_type !== 'facility') {
		return $html;
	}
	if (!empty($html) && has_post_thumbnail($post_id)) {
		return $html;
	}
	$dummy_image_url = get_theme_file_uri('../../uploads/azarashi_noimg-1.jpg');
	$alt = get_the_title($post_id);
	$class = 'wp-post-image';
	if (is_array($attr) && !empty($attr['class'])) {
		$class .= ' ' . esc_attr($attr['class']);
	}
	$fallback = sprintf(
		'<img src="%1$s" alt="%2$s" class="%3$s" loading="lazy" decoding="async">',
		esc_url($dummy_image_url),
		esc_attr($alt),
		esc_attr($class)
	);

	return $fallback;
}

/**
 * =============================================================================
 * AJAX: Get ACF Image from Post
 * =============================================================================
 */
add_action( 'wp_ajax_nopriv_az_fig', 'azarashilove_ajax_get_figure' );
add_action( 'wp_ajax_az_fig', 'azarashilove_ajax_get_figure' );

function azarashilove_ajax_get_figure() {
	$href = isset( $_POST['href'] ) ? esc_url_raw( $_POST['href'] ) : '';
	
	if ( ! $href ) {
		wp_send_json_error( array( 'msg' => 'no href' ), 400 );
	}

	$post_id = url_to_postid( $href );
	
	if ( ! $post_id ) {
		wp_send_json_error( array( 'msg' => 'not found' ), 404 );
	}

	$field_value = get_field( 'azarashi_illust', $post_id );
	
	if ( is_array( $field_value ) ) {
		$url = isset( $field_value['url'] ) ? $field_value['url'] : '';
		$alt = isset( $field_value['alt'] ) ? $field_value['alt'] : '';
	} elseif ( is_numeric( $field_value ) ) {
		$url = wp_get_attachment_url( $field_value );
		$alt = get_post_meta( $field_value, '_wp_attachment_image_alt', true );
	} else {
		$url = $field_value;
		$alt = '';
	}

	if ( ! $url ) {
		wp_send_json_error( array( 'msg' => 'no url' ), 404 );
	}

	$img = sprintf( '<img src="%s" alt="%s">', esc_url( $url ), esc_attr( $alt ) );
	wp_send_json_success( array( 'html' => $img ) );
}

/**
 * Frontend script to load images via AJAX
 */

add_action( 'wp_footer', 'azarashilove_ajax_figure_script' );

function azarashilove_ajax_figure_script() {
	?>
	<script>
	(function() {
		document.querySelectorAll('.list_azarashi li').forEach(function(li) {
			var a = li.querySelector('a[href]');
			var fig = li.querySelector('figure.az-auto');
			if (!a || !fig) return;
			
			var fd = new FormData();
			fd.append('action', 'az_fig');
			fd.append('href', a.getAttribute('href'));
			
			fetch('<?php echo esc_url( admin_url( 'admin-ajax.php' ) ); ?>', {
				method: 'POST',
				body: fd,
				credentials: 'same-origin'
			})
			.then(function(r) { return r.json(); })
			.then(function(res) {
				if (res && res.success && res.data && res.data.html) {
					fig.innerHTML = res.data.html;
				}
			});
		});
	})();
	</script>
	<?php
}

/**
 * =============================================================================
 * Shortcode: Include PHP file from theme
 * =============================================================================
 */
add_shortcode( 'myphp', 'azarashilove_include_php' );

function azarashilove_include_php( $params = array() ) {
	$params = shortcode_atts(
		array(
			'file' => 'default',
		),
		$params
	);

	$file_path = get_template_directory() . '/inc/' . sanitize_file_name( $params['file'] ) . '.php';
	
	if ( ! file_exists( $file_path ) ) {
		return '<!-- File not found -->';
	}

	ob_start();
	include $file_path;
	return ob_get_clean();
}


add_action('widgets_init', function () {
  register_sidebar([
    'name'          => 'サイドバー',
    'id'            => 'sidebar-latest-cpt',
    'description'   => '最新のカスタム投稿リスト用',
    'before_widget' => '<section class="widget %2$s">',
    'after_widget'  => '</section>',
    'before_title'  => '<h2 class="widget-title">',
    'after_title'   => '</h2>',
  ]);
  register_sidebar([
    'name'          => 'フッター',
    'id'            => 'footer-widgets',
    'description'   => 'フッター用ウィジェットエリア',
    'before_widget' => '<section class="widget %2$s">',
    'after_widget'  => '</section>',
    'before_title'  => '<h2 class="widget-title">',
    'after_title'   => '</h2>',
  ]);
});

add_filter( 'snow_monkey_blocks_enqueue_fontawesome', '__return_false' );

add_filter('post_class', function ($classes, $class, $post_id) {
	if (has_term('has_report', 'reported', $post_id)) {
		$classes[] = 'is-has-report';
	}

	$location = function_exists( 'get_field' ) ? get_field( 'azarashi_location', $post_id ) : array();
	foreach ( (array) $location as $item ) {
		$value = is_array( $item ) ? ( $item['value'] ?? $item['label'] ?? '' ) : $item;
		if ( $value ) {
			$classes[] = sanitize_html_class( $value );
		}
	}

	return $classes;
}, 10, 3);


/**
 * 管理画面の記事一覧に「抜粋」カラムを追加
 */
add_filter('manage_post_posts_columns', function ($columns) {
    $new_columns = [];

    foreach ($columns as $key => $label) {
        $new_columns[$key] = $label;

        // タイトルの後ろに差し込む
        if ('title' === $key) {
            $new_columns['admin_excerpt'] = '抜粋';
        }
    }

    // 念のため title が無いケースでも追加
    if (!isset($new_columns['admin_excerpt'])) {
        $new_columns['admin_excerpt'] = '抜粋';
    }

    return $new_columns;
});


/**
 * 抜粋カラムの内容を表示
 * ついでにクイック編集用の生データも hidden で埋める
 */
add_action('manage_post_posts_custom_column', function ($column, $post_id) {
    if ('admin_excerpt' !== $column) {
        return;
    }

    $excerpt = get_post_field('post_excerpt', $post_id, 'raw');

    echo '<div class="admin-excerpt-view">' . esc_html(wp_trim_words($excerpt, 24, '…')) . '</div>';
    echo '<div class="admin-excerpt-source" hidden>' . esc_textarea($excerpt) . '</div>';
}, 10, 2);


/**
 * クイック編集欄に textarea を追加
 * ※ name は excerpt にしない（core に上書きされるため）
 */
add_action('quick_edit_custom_box', function ($column_name, $post_type) {
    if ('admin_excerpt' !== $column_name || 'post' !== $post_type) {
        return;
    }
    ?>
    <fieldset class="inline-edit-col-right">
        <div class="inline-edit-col">
            <label class="alignleft" style="width:100%;">
                <span class="title">抜粋</span>
                <span class="input-text-wrap">
                    <textarea
                        name="quickedit_excerpt"
                        rows="4"
                        style="width:100%;"
                    ></textarea>
                </span>
            </label>
        </div>
    </fieldset>
    <?php
}, 10, 2);


/**
 * クイック編集を開いた時に、既存の抜粋を textarea に流し込む
 */
add_action('admin_print_footer_scripts-edit.php', function () {
    $screen = get_current_screen();

    if (!$screen || 'edit-post' !== $screen->id) {
        return;
    }
    ?>
    <script>
    jQuery(function ($) {
        const originalEdit = inlineEditPost.edit;

        inlineEditPost.edit = function (id) {
            originalEdit.apply(this, arguments);

            let postId = 0;

            if (typeof id === 'object') {
                postId = parseInt(this.getId(id), 10);
            } else {
                postId = parseInt(id, 10);
            }

            if (!postId) return;

            const $postRow = $('#post-' + postId);
            const rawExcerpt = $postRow
                .find('.column-admin_excerpt .admin-excerpt-source')
                .text();

            $('#edit-' + postId)
                .find('textarea[name="quickedit_excerpt"]')
                .val(rawExcerpt);
        };
    });
    </script>
    <?php
});


/**
 * クイック編集で送られた抜粋を、保存直前に post_excerpt へ差し込む
 */
add_filter('wp_insert_post_data', function ($data, $postarr) {
    if (!is_admin()) {
        return $data;
    }

    if (($postarr['post_type'] ?? '') !== 'post') {
        return $data;
    }

    if (
        wp_doing_ajax() &&
        isset($_POST['action']) &&
        'inline-save' === $_POST['action'] &&
        isset($_POST['quickedit_excerpt'])
    ) {
        $data['post_excerpt'] = sanitize_textarea_field(
            wp_unslash($_POST['quickedit_excerpt'])
        );
    }

    return $data;
}, 10, 2);

// WordPressのレスポンシブ画像(srcset / sizes)を無効化
add_filter( 'wp_calculate_image_srcset', '__return_false' );
add_filter( 'wp_calculate_image_sizes', '__return_false', 99 );
add_filter( 'wp_img_tag_add_srcset_and_sizes_attr', '__return_false' );
add_filter( 'wp_calculate_image_srcset_meta', '__return_null' );
add_filter('wp_is_application_passwords_available', '__return_true');



/**
 * クエリループ内の「続きを読む」リンクにスクリーンリーダー用テキストを追加
 */
add_filter( 'render_block_core/post-excerpt', function( $block_content, $block ) {
	if ( is_admin() ) {
		return $block_content;
	}

	if ( false === strpos( $block_content, 'wp-block-post-excerpt__more-link' ) ) {
		return $block_content;
	}

	$post_id = get_the_ID();
	$title   = get_the_title( $post_id );

	if ( ! $title ) {
		$title = '記事';
	}

	$sr_text = sprintf(
		'%sを続きを読む',
		$title
	);

	// 空の続きを読むリンク、または中身が空白だけのリンクにテキストを追加
	$block_content = preg_replace_callback(
		'/<a\b([^>]*class=(["\'])(?=[^"\']*wp-block-post-excerpt__more-link)[^"\']*\2[^>]*)>\s*<\/a>/i',
		function( $matches ) use ( $sr_text ) {
			return '<a' . $matches[1] . '><span class="screen-reader-text">'
				. esc_html( $sr_text )
				. '</span></a>';
		},
		$block_content
	);
	return $block_content;
}, 20, 2 );


/**
 * ブロックエディタのスペーサーブロックをサイト上では出力しない。
 */
add_filter( 'render_block_core/spacer', function( $block_content, $block ) {
	return '';
}, 10, 2 );

add_action( 'template_redirect', function() {
	if ( is_admin() || wp_doing_ajax() || wp_doing_cron() ) {
		return;
	}
	ob_start( function( $html ) {
		if ( false === strpos( $html, 'wp-block-spacer' ) ) {
			return $html;
		}
		return preg_replace(
			'/<div\b[^>]*class=(["\'])(?=[^"\']*\bwp-block-spacer\b)[^"\']*\1[^>]*>\s*<\/div>/i',
			'',
			$html
		);
	} );
}, 5 );


/**
 * wp-block-query 内の画像 alt を
 * 「投稿タイトルのサムネイル」に変更する
 * Image Optimizer / picture 変換後にも対応
 */
add_action( 'template_redirect', function() {
	if ( is_admin() || wp_doing_ajax() || wp_doing_cron() ) {
		return;
	}
	ob_start( function( $html ) {
		if ( false === strpos( $html, 'wp-block-query' ) ) {
			return $html;
		}
		libxml_use_internal_errors( true );
		$dom = new DOMDocument();
		$dom->loadHTML(
			'<?xml encoding="UTF-8">' . $html,
			LIBXML_HTML_NOIMPLIED | LIBXML_HTML_NODEFDTD
		);
		$xpath = new DOMXPath( $dom );
		$imgs = $xpath->query(
			'//*[contains(concat(" ", normalize-space(@class), " "), " wp-block-query ")]//img'
		);

		foreach ( $imgs as $img ) {
			$post_container = $img;

			while ( $post_container && $post_container->parentNode ) {
				$post_container = $post_container->parentNode;

				if (
					$post_container instanceof DOMElement &&
					(
						str_contains( ' ' . $post_container->getAttribute( 'class' ) . ' ', ' wp-block-post ' ) ||
						strtolower( $post_container->nodeName ) === 'li' ||
						strtolower( $post_container->nodeName ) === 'article'
					)
				) {
					break;
				}
			}
			if ( ! $post_container instanceof DOMElement ) {
				continue;
			}
			$title_node = $xpath->query(
				'.//*[contains(concat(" ", normalize-space(@class), " "), " wp-block-post-title ")]',
				$post_container
			)->item( 0 );
			if ( ! $title_node ) {
				continue;
			}
			$title = trim( preg_replace( '/\s+/', ' ', $title_node->textContent ) );
			if ( $title !== '' ) {
				$img->setAttribute( 'alt', $title . 'のサムネイル' );
			}
		}
		$output = $dom->saveHTML();
		$output = preg_replace( '/^<\?xml encoding="UTF-8"\?>/', '', $output );
		libxml_clear_errors();
		return $output;
	} );
}, PHP_INT_MAX );

/**
 * SP: TOC (.link_area) を開閉式にする JS
 */
add_action( 'wp_footer', function () {
	?>
	<script>
	(function () {
		if (window.innerWidth > 760) return;
		document.querySelectorAll('.link_area').forEach(function (toc) {
			var h2 = toc.querySelector('h2');
			var ul  = toc.querySelector('ul');
			if (!h2 || !ul) return;

			// ul を toc-body でラップ
			var body = document.createElement('div');
			body.className = 'toc-body';
			ul.parentNode.insertBefore(body, ul);
			body.appendChild(ul);

			// h2 をトグルボタンに差し替え
			var btn = document.createElement('button');
			btn.className = 'toc-toggle-btn';
			btn.type = 'button';
			btn.textContent = h2.textContent;
			btn.setAttribute('aria-expanded', 'false');
			h2.parentNode.replaceChild(btn, h2);

			// 初期状態: 折りたたむ
			toc.classList.add('is-toc-collapsed');

			btn.addEventListener('click', function () {
				var collapsed = toc.classList.toggle('is-toc-collapsed');
				btn.setAttribute('aria-expanded', collapsed ? 'false' : 'true');
			});
		});
	})();
	</script>
	<?php
}, 20 );
