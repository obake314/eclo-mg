<?php
/**
 * azarashilove functions and definitions
 *
 * @link https://developer.wordpress.org/themes/basics/theme-functions/
 *
 * @package azarashilove
 */

if ( ! defined( '_S_VERSION' ) ) {
	// Replace the version number of the theme on each release.
	define( '_S_VERSION', '1.0.0' );
}

if ( ! function_exists( 'azarashilove_setup' ) ) :
	function azarashilove_setup() {
		load_theme_textdomain( 'azarashilove', get_template_directory() . '/languages' );
		add_theme_support( 'automatic-feed-links' );
		add_theme_support( 'title-tag' );
		add_theme_support( 'post-thumbnails' );
		add_theme_support( 'wp-block-styles' );
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
	}
endif;
add_action( 'after_setup_theme', 'azarashilove_setup' );
function azarashilove_content_width() {
	$GLOBALS['content_width'] = apply_filters( 'azarashilove_content_width', 640 );
}
add_action( 'after_setup_theme', 'azarashilove_content_width', 0 );
function azarashilove_widgets_init() {
	register_sidebar(
		array(
			'name'          => esc_html__( 'Sidebar', 'azarashilove' ),
			'id'            => 'sidebar-1',
			'description'   => esc_html__( 'Add widgets here.', 'azarashilove' ),
			'before_widget' => '<section id="%1$s" class="widget %2$s">',
			'after_widget'  => '</section>',
			'before_title'  => '<h2 class="widget-title">',
			'after_title'   => '</h2>',
		)
	);
}
add_action( 'widgets_init', 'azarashilove_widgets_init' );
function azarashilove_scripts() {
	wp_enqueue_style( 'azarashilove-style', get_stylesheet_uri(), array(), _S_VERSION );
	wp_enqueue_style( 'azarashilove-responsive', get_template_directory_uri() . '/responsive.css', array( 'azarashilove-style' ), _S_VERSION);
	wp_style_add_data( 'azarashilove-style', 'rtl', 'replace' );
	wp_enqueue_script( 'azarashilove-navigation', get_template_directory_uri() . '/js/navigation.js', array(), _S_VERSION, true );

	if ( is_singular() && comments_open() && get_option( 'thread_comments' ) ) {
		wp_enqueue_script( 'comment-reply' );
	}
}
add_action( 'wp_enqueue_scripts', 'azarashilove_scripts' );

require get_template_directory() . '/inc/custom-header.php';
require get_template_directory() . '/inc/template-tags.php';
require get_template_directory() . '/inc/template-functions.php';
require get_template_directory() . '/inc/customizer.php';

if ( defined( 'JETPACK__VERSION' ) ) {
	require get_template_directory() . '/inc/jetpack.php';
}

remove_action('wp_head','wp_generator');

//wpのバージョン情報削除
function vc_remove_wp_ver_css_js( $src ) {
if ( strpos( $src, 'ver=' . get_bloginfo( 'version' ) ) )
$src = remove_query_arg( 'ver', $src );
return $src;
}
add_filter( 'style_loader_src', 'vc_remove_wp_ver_css_js', 9999 );
add_filter( 'script_loader_src', 'vc_remove_wp_ver_css_js', 9999 );

//フィードリンク削除
remove_action('wp_head', 'feed_links', 2);
remove_action('wp_head', 'feed_links_extra', 3);

//絵文字削除
remove_action( 'wp_head', 'print_emoji_detection_script', 7 );
remove_action( 'admin_print_scripts', 'print_emoji_detection_script' );
remove_action( 'wp_print_styles', 'print_emoji_styles' );
remove_action( 'admin_print_styles', 'print_emoji_styles' );

//DNS Prefetch削除
remove_action('wp_head', 'wp_resource_hints', 2);

//Embed削除
remove_action('wp_head', 'rest_output_link_wp_head');
remove_action('wp_head', 'wp_oembed_add_discovery_links');
remove_action('wp_head', 'wp_oembed_add_host_js');

//EditURI
remove_action('wp_head', 'rsd_link');

//wlwmanifest削除
remove_action('wp_head', 'wlwmanifest_link');

//前の記事､次の記事のリンク削除
remove_action('wp_head', 'adjacent_posts_rel_link_wp_head', 10, 0);

// ショートリンクURLの削除
remove_action('wp_head', 'wp_shortlink_wp_head');

function delete_jquery() {
  if (!is_admin()) {
    wp_deregister_script('jquery');
  }
}
add_action('init', 'delete_jquery');

// jQuery migrationの削除
add_filter( 'wp_default_scripts', 'dequeue_jquery_migrate' );
function dequeue_jquery_migrate( $scripts){
if(!is_admin()){
$scripts->remove( 'jquery');
$scripts->add( 'jquery', false, array( 'jquery-core' ) );
}
}

//wpのバージョン情報削除
remove_action('wp_head','wp_generator');


add_filter( 'style_loader_src', 'vc_remove_wp_ver_css_js', 9999 );
add_filter( 'script_loader_src', 'vc_remove_wp_ver_css_js', 9999 );

//フィードリンク削除
remove_action('wp_head', 'feed_links', 2);
remove_action('wp_head', 'feed_links_extra', 3);

//絵文字削除
remove_action( 'wp_head', 'print_emoji_detection_script', 7 );
remove_action( 'admin_print_scripts', 'print_emoji_detection_script' );
remove_action( 'wp_print_styles', 'print_emoji_styles' );
remove_action( 'admin_print_styles', 'print_emoji_styles' );

//DNS Prefetch削除
remove_action('wp_head', 'wp_resource_hints', 2);

//Embed削除
remove_action('wp_head', 'rest_output_link_wp_head');
remove_action('wp_head', 'wp_oembed_add_discovery_links');
remove_action('wp_head', 'wp_oembed_add_host_js');

//EditURI
remove_action('wp_head', 'rsd_link');

//wlwmanifest削除
remove_action('wp_head', 'wlwmanifest_link');

//前の記事､次の記事のリンク削除
remove_action('wp_head', 'adjacent_posts_rel_link_wp_head', 10, 0);

// ショートリンクURLの削除
remove_action('wp_head', 'wp_shortlink_wp_head');

//---WP本体：更新通知メールの停止
add_filter('auto_core_update_send_email' , '__return_false');

//---テーマ：更新通知メールの停止
add_filter('auto_theme_update_send_email' , '__return_false');

//---プラグイン：更新通知メールの停止
add_filter('auto_plugin_update_send_email' , '__return_false');

//==============================================================================
//
//	自動整形を無効にするカスタムフィールドを作成
//
//==============================================================================

//	アクションフックに登録：管理画面にカスタムボックスをエントリー
add_action(
'add_meta_boxes',
function(){
$screens = array('post', 'page');
foreach($screens as $scrn){
add_meta_box(
'peralab-custombox-dont-autoformatting', 	//編集画面セクションのHTML ID
'自動整形を無効化', 	//メタボックスのタイトル
'PeralabDontAutoFormatting_CustomBoxCreate', 	//入力フォーム作成で呼び出されるコールバック
$scrn, 								//表示するページ
'side', 							//メタボックス表示箇所(advanced, normal, side)
'default', 							//表示優先度(high, core, default, low)
null);								//コールバック時に渡す引数があれば指定
}
}
);

//	メタボックスを作成
function PeralabDontAutoFormatting_CustomBoxCreate($post){	//$postには現在の投稿記事データが入っています
//入力済みのデータを取得
$data_str = get_post_meta($post->ID, "dont_autoformat_radio", true);
if($data_str != 'dont'){
$data_str = 'format';
}

//nonce作成
wp_nonce_field('action-noncekey-dontautoformat', 'noncename-dontautoformat');

?>
<div>

<!-- 出力する文字列 -->
<p><label><input name="name-metabox_autoformat_radio" type="radio" value="format" <?php echo (($data_str == 'format') ? 'checked' : '') ?>>整形する（初期値）</label></p>
<p><label><input name="name-metabox_autoformat_radio" type="radio" value="dont" <?php echo (($data_str == 'dont') ? 'checked' : '') ?>>整形しない</label></p>
<p><label>ビジュアルエディタの整形無効の切り替えは[下書き保存] [更新]などで記事の保存後から反映されます。</label></p>

</div>
<?php
}

//--------------------------------------------------------------
//	カスタムボックス内のフィールド値更新処理
//--------------------------------------------------------------
add_action(
'save_post',
function($post_id){
//nonceを確認
if(isset($_POST['noncename-dontautoformat']) == false
|| wp_verify_nonce($_POST['noncename-dontautoformat'], 'action-noncekey-dontautoformat') == false) {
return;	//nonceを認証できなかった
}

//自動保存ルーチンかどうかチェック。そうだった場合はフォームを送信しない(何もしない)
	if(defined('DOING_AUTOSAVE') && DOING_AUTOSAVE){
		return;
	}

	//パーミッション確認
	if(isset($_POST['post_type'])){
		if($_POST['post_type'] == 'page'){
			if(!current_user_can('edit_page', $post_id)){
				return;	//固定ページを編集する権限がない
			}
		}
		else{
			if(!current_user_can('edit_post', $post_id)){
				return;	//記事を編集する権限がない
			}
		}
	}

	//== 確認ここまで ==


	//予約投稿時は、データが有るにも関わらず$_POSTからデータ取得ができないので、
	//issetでデータ確認が出来るときのみ値の更新処理を行います。
	if(isset($_POST['name-metabox_autoformat_radio'])){
		update_post_meta($post_id, "dont_autoformat_radio", $_POST['name-metabox_autoformat_radio']);
	}
}
);

//=========================
//	自動整形無効の実処理
//=========================

//記事表示時の整形無効
add_action(
'wp_head',
function(){
if(get_post_meta(get_the_ID(), 'dont_autoformat_radio', true) == 'dont'){
remove_filter('the_content', 'wpautop');
remove_filter('the_excerpt', 'wpautop');
}
}
);

//ビジュアルエディタ(TinyMCE)の整形無効
add_filter(
'tiny_mce_before_init',
function($init_array){
if(get_post_meta(get_the_ID(), 'dont_autoformat_radio', true) == 'dont'){
global $allowedposttags;
$init_array['valid_elements']          = '[]';
$init_array['extended_valid_elements'] = '[]';
$init_array['valid_children']          = '+a[' . implode( '|', array_keys( $allowedposttags ) ) . ']';
$init_array['indent']                  = true;
$init_array['wpautop']                 = false;
$init_array['force_p_newlines']        = false;
}
return $init_array;
}
);

/* the_archive_title 余計な文字を削除 */
add_filter( 'get_the_archive_title', function ($title) {
    if (is_category()) {
        $title = single_cat_title('',false);
    } elseif (is_tag()) {
        $title = single_tag_title('',false);
	} elseif (is_tax()) {
	    $title = single_term_title('',false);
	} elseif (is_post_type_archive() ){
		$title = post_type_archive_title('',false);
	} elseif (is_date()) {
	    $title = get_the_time('Y年n月');
	} elseif (is_search()) {
	    $title = '検索結果：'.esc_html( get_search_query(false) );
	} elseif (is_404()) {
	    $title = '「404」ページが見つかりません';
	} else {

	}
    return $title;
});


function show_facilities_by_genus_and_region($atts) {
    $atts = shortcode_atts(array(
        'slugs' => '', // genusのslugをカンマ区切りで指定
    ), $atts, 'facilities_by_genus_region');

    $target_slugs = array_map('trim', explode(',', $atts['slugs']));
    if (empty($target_slugs[0])) {
        return '<p>表示する分類（genus）が指定されていません。</p>';
    }
	
    $regions = array(
        'hokkaido'         => '北海道',
        'tohoku'           => '東北',
        'kanto'            => '関東',
        'chubu'            => '中部',
        'kinki'            => '近畿',
        'chugoku-shikoku'  => '中国・四国',
        'kyushu-okinawa'   => '九州・沖縄',
    );

    $output = '<div class="facility-grouped-list">';
	$output = '<h2>' . get_the_title() . 'に会える施設</h2>';
    foreach ($regions as $region_slug => $region_label) {
        $args = array(
            'post_type' => 'facility',
            'posts_per_page' => -1,
            'tax_query' => array(
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

        $query = new WP_Query($args);

        if ($query->have_posts()) {
            $output .= '<section class="region-block">';
            $output .= '<h3 class="region-title">' . esc_html($region_label) . '</h3>';
            $output .= '<ul class="facility-list">';

            while ($query->have_posts()) {
                $query->the_post();
                $thumbnail_id = get_post_thumbnail_id(get_the_ID());
                $image_html = '';
                if ($thumbnail_id) {
                    $image_data = wp_get_attachment_image_src($thumbnail_id, 'full');
                    if ($image_data && isset($image_data[0])) {
                        $image_url = $image_data[0];
                        $alt = get_post_meta($thumbnail_id, '_wp_attachment_image_alt', true);
                        $title = get_the_title($thumbnail_id);
                        $image_html = '<img src="' . esc_url($image_url) . '" alt="' . esc_attr($alt) . '" title="' . esc_attr($title) . '">';
                    }
                }
	$terms = get_the_terms(get_the_ID(), 'prefectures');
	$region_name = ($terms && !is_wp_error($terms)) ? $terms[0]->name : '';
	
                $output .= '<li class="facility-item">';
                $output .= '<a href="' . get_permalink() . '"></a>';
                $output .= '<figure>' . $image_html . '</figure>';
                $output .= '<div class="facility-item_text">';
                $output .= '<h4 class="facility-title">' . get_the_title() . '</h4>';
				$output .= '<address>' . esc_html($region_name) . '</address>';
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
add_shortcode('facilities_by_genus_region', 'show_facilities_by_genus_and_region');



// Ajax: href -> post_id -> ACF -> <img>
add_action('wp_ajax_nopriv_az_fig', 'az_fig_handler');
add_action('wp_ajax_az_fig', 'az_fig_handler');
function az_fig_handler() {
  $href = isset($_POST['href']) ? esc_url_raw($_POST['href']) : '';
  if (!$href) wp_send_json_error(['msg'=>'no href'], 400);
  $pid = url_to_postid($href);
  if (!$pid) wp_send_json_error(['msg'=>'not found'], 404);

  $v = get_field('azarashi_illust', $pid);               // URL / Array / ID どれでも
  $url = is_array($v) ? ($v['url'] ?? '') : (is_numeric($v) ? wp_get_attachment_url($v) : $v);
  $alt = is_array($v) ? ($v['alt'] ?? '') : '';
  if (!$url) wp_send_json_error(['msg'=>'no url'], 404);

  $img = sprintf('<img src="%s" alt="%s">', esc_url($url), esc_attr($alt));
  wp_send_json_success(['html'=>$img]);
}

// JS：同じ <figure> を差し替え
add_action('wp_footer', function(){
  ?>
  <script>
  (function(){
    document.querySelectorAll('.list_azarashi li').forEach(function(li){
      var a = li.querySelector('a[href]');
      var fig = li.querySelector('figure.az-auto');
      if(!a || !fig) return;
      var fd = new FormData();
      fd.append('action','az_fig');
      fd.append('href', a.getAttribute('href'));
      fetch('<?php echo admin_url('admin-ajax.php'); ?>', {method:'POST', body:fd, credentials:'same-origin'})
        .then(r=>r.json())
        .then(res=>{ if(res && res.success && res.data && res.data.html){ fig.innerHTML = res.data.html; } });
    });
  })();
  </script>
  <?php
});


//テーマディレクトリからショートコードを使ってincludeする [inc_file file='my-file']
function Include_my_php($params = array()) {
    extract(shortcode_atts(array(
        'file' => 'default'
    ), $params));

    ob_start();
    include get_template_directory() . "/inc/$file.php";
    return ob_get_clean();
}
add_shortcode('myphp', 'Include_my_php');

add_post_type_support( 'page', 'excerpt' );

// いったん管理画面で1回だけ実行 → その後コメントアウト
add_action('admin_init', function(){
  flush_rewrite_rules();
});
