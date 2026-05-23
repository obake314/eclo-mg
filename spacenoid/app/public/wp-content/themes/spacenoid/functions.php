<?php
/**
 * Spacenoid Theme Functions
 * 
 * @package Spacenoid
 * @version 2.1.19
 */

// Exit if accessed directly
if (!defined('ABSPATH')) {
    exit;
}

// Theme constants
define('SPACENOID_VERSION', '2.1.19');
define('SPACENOID_DIR', get_template_directory_uri());
define('SPACENOID_TEMPLATE_DIR', get_template_directory());

/*-----------------------------------------------------------------------------------*/
/*  DISABLE AUTOMATIC THEME UPDATES                                                   */
/*-----------------------------------------------------------------------------------*/

add_filter('auto_update_theme', '__return_false');
add_filter('auto_theme_update_send_email', '__return_false');
add_filter('auto_plugin_update_send_email', '__return_false');
remove_action('load-update-core.php', 'wp_update_themes');


/*-----------------------------------------------------------------------------------*/
/*  ENQUEUE SCRIPTS & STYLES                                                          */
/*-----------------------------------------------------------------------------------*/

function spacenoid_enqueue_assets() {
    // CSS - style.css only
    wp_enqueue_style(
        'spacenoid-style',
        get_stylesheet_uri(),
        array(),
        SPACENOID_VERSION
    );

    // Gutenberg blocks / layout styles
    wp_enqueue_style('wp-block-library');
    wp_enqueue_style('wp-block-library-theme');
}
add_action('wp_enqueue_scripts', 'spacenoid_enqueue_assets');

function spacenoid_add_page_slug_body_class($classes) {
    if (is_page()) {
        $page = get_queried_object();

        if ($page instanceof WP_Post && !empty($page->post_name)) {
            $classes[] = 'page-' . sanitize_html_class($page->post_name);
        }
    }

    return $classes;
}
add_filter('body_class', 'spacenoid_add_page_slug_body_class');

function spacenoid_enqueue_editor_assets() {
    wp_enqueue_style(
        'spacenoid-editor-style',
        get_template_directory_uri() . '/editor-style.css',
        array(),
        SPACENOID_VERSION
    );
}
add_action('enqueue_block_editor_assets', 'spacenoid_enqueue_editor_assets');

function spacenoid_filter_header_menu_items($items, $args) {
    if (empty($args->theme_location) || 'header-menu' !== $args->theme_location) {
        return $items;
    }

    return array_values(array_filter($items, function ($item) {
        $title = isset($item->title) ? wp_strip_all_tags($item->title) : '';
        $url = isset($item->url) ? $item->url : '';

        return 'FANMAIL' !== strtoupper($title) && false === strpos($url, '/contactus');
    }));
}
add_filter('wp_nav_menu_objects', 'spacenoid_filter_header_menu_items', 10, 2);

function spacenoid_sort_member_query_by_furigana($query) {
    if (!is_page('members')) {
        return $query;
    }

    $post_type = isset($query['post_type']) ? $query['post_type'] : '';
    if ('member' !== $post_type) {
        return $query;
    }

    $query['meta_key'] = 'furigana';
    $query['orderby'] = 'meta_value';
    $query['order'] = 'ASC';

    return $query;
}
add_filter('query_loop_block_query_vars', 'spacenoid_sort_member_query_by_furigana');

function spacenoid_member_fanmail_notice() {
    ?>
    <section class="member-fanmail" aria-labelledby="member-fanmail-title">
        <div class="member-fanmail__inner">
            <div class="member-fanmail__header">
                <p class="member-fanmail__label">Fan Letter</p>
                <h2 id="member-fanmail-title">ファンレター・プレゼントなどの送付先</h2>
            </div>
            <div class="member-fanmail__body">
                <p>弊社所属俳優・クリエイター、あるいは当サイトについてのご質問、お問い合せがございましたら、こちらまでメールをお寄せください。<br>
                また、弊社所属俳優・クリエイターへのファンレター等の宛先は、こちらです。</p>
                <address>
                    〒111-0042<br>
                    東京都台東区寿1-6-7 ユーハイツ伸光901<br>
                    （株）スペースノイドカンパニー （俳優・クリエイター名）宛
                </address>
                <p>いただきましたファンレター・プレゼントは弊社を通し本人にお渡し致します。本人の手に渡るまでのタイミングは調整できかねますので、ご了承ください。<br>何卒、よろしくお願い申し上げます。</p>
            </div>
        </div>
    </section>
    <?php
}

/*-----------------------------------------------------------------------------------*/
/*  CUSTOM META BOX - DISABLE AUTO FORMATTING                                         */
/*-----------------------------------------------------------------------------------*/

/**
 * Add meta box for formatting control
 */
function spacenoid_add_formatting_metabox() {
    $post_types = array('post', 'page', 'event', 'stage', 'works');
    
    foreach ($post_types as $post_type) {
        add_meta_box(
            'spacenoid-autoformat-control',
            __('Auto Formatting Control', 'spacenoid'),
            'spacenoid_render_formatting_metabox',
            $post_type,
            'side',
            'default'
        );
    }
}
add_action('add_meta_boxes', 'spacenoid_add_formatting_metabox');

/**
 * Render meta box content
 */
function spacenoid_render_formatting_metabox($post) {
    // Add nonce for security
    wp_nonce_field('spacenoid_formatting_nonce_action', 'spacenoid_formatting_nonce');
    
    // Get current value
    $current_value = get_post_meta($post->ID, '_spacenoid_autoformat', true);
    $current_value = empty($current_value) ? 'format' : $current_value;
    ?>
    <div class="spacenoid-formatting-options">
        <p>
            <label>
                <input 
                    type="radio" 
                    name="spacenoid_autoformat" 
                    value="format" 
                    <?php checked($current_value, 'format'); ?>
                >
                <?php esc_html_e('Enable Formatting (Default)', 'spacenoid'); ?>
            </label>
        </p>
        <p>
            <label>
                <input 
                    type="radio" 
                    name="spacenoid_autoformat" 
                    value="dont" 
                    <?php checked($current_value, 'dont'); ?>
                >
                <?php esc_html_e('Disable Formatting', 'spacenoid'); ?>
            </label>
        </p>
        <p class="description">
            <?php esc_html_e('Changes take effect after saving the post.', 'spacenoid'); ?>
        </p>
    </div>
    <?php
}

/**
 * Save meta box data
 */
function spacenoid_save_formatting_metabox($post_id) {
    // Security checks
    if (!isset($_POST['spacenoid_formatting_nonce'])) {
        return;
    }

    $nonce = sanitize_text_field(wp_unslash($_POST['spacenoid_formatting_nonce']));
    if (!wp_verify_nonce($nonce, 'spacenoid_formatting_nonce_action')) {
        return;
    }
    
    if (defined('DOING_AUTOSAVE') && DOING_AUTOSAVE) {
        return;
    }
    
    if (!current_user_can('edit_post', $post_id)) {
        return;
    }
    
    // Save the data
    if (isset($_POST['spacenoid_autoformat'])) {
        $value = sanitize_text_field(wp_unslash($_POST['spacenoid_autoformat']));
        update_post_meta($post_id, '_spacenoid_autoformat', $value);
    }
}
add_action('save_post', 'spacenoid_save_formatting_metabox');



/*-----------------------------------------------------------------------------------*/
/*  THEME SUPPORT                                                                     */
/*-----------------------------------------------------------------------------------*/

function spacenoid_theme_setup() {
    add_theme_support('title-tag');
    add_theme_support('post-thumbnails');
    add_theme_support('html5', array(
        'search-form',
        'comment-form',
        'comment-list',
        'gallery',
        'caption',
    ));
    add_theme_support('custom-logo');
    register_nav_menus(array(
        'header-menu' => __('Header Menu', 'spacenoid'),
        'footer-menu' => __('Footer Menu', 'spacenoid'),
    ));
    add_theme_support('wp-block-styles');
    add_theme_support('editor-styles');      // ← ここに移動
    add_theme_support('responsive-embeds');  // ← ここに移動
}
add_action('after_setup_theme', 'spacenoid_theme_setup');

function spacenoid_enable_excerpts_for_post_items() {
    $post_types = array('post', 'page', 'event', 'stage', 'works', 'member');

    foreach ($post_types as $post_type) {
        add_post_type_support($post_type, 'excerpt');
    }
}
add_action('init', 'spacenoid_enable_excerpts_for_post_items', 100);

function spacenoid_register_block_patterns() {
    if (!function_exists('register_block_pattern')) {
        return;
    }

    register_block_pattern(
        'spacenoid/headline',
        array(
            'title'       => __('Important Headline', 'spacenoid'),
            'description' => __('Japanese heading with English label for important content sections.', 'spacenoid'),
            'categories'  => array('text'),
            'content'     => '<!-- wp:group {"className":"headline","layout":{"type":"default"}} --><div class="wp-block-group headline"><!-- wp:heading --><h2 class="wp-block-heading">記録</h2><!-- /wp:heading --><!-- wp:paragraph --><p>RECORD</p><!-- /wp:paragraph --></div><!-- /wp:group -->',
        )
    );
}
add_action('init', 'spacenoid_register_block_patterns');

/*-----------------------------------------------------------------------------------*/
/*  SECURITY ENHANCEMENTS                                                             */
/*-----------------------------------------------------------------------------------*/

// Remove WordPress version from head
remove_action('wp_head', 'wp_generator');

// Disable XML-RPC if not needed
add_filter('xmlrpc_enabled', '__return_false');

// Remove RSD link
remove_action('wp_head', 'rsd_link');

remove_action('wp_head', 'wlwmanifest_link');
