<?php
/**
 * Avant Planning Theme Functions
 */

function avantplanning_setup() {
    add_theme_support('title-tag');
    add_theme_support('post-thumbnails');
    add_theme_support('wp-block-styles');
    add_theme_support('align-wide');
    add_theme_support('editor-styles');
    add_editor_style('style.css');

    add_theme_support('html5', array(
        'search-form',
        'comment-form',
        'comment-list',
        'gallery',
        'caption',
        'style',
        'script',
    ));
}
add_action('after_setup_theme', 'avantplanning_setup');

function avantplanning_scripts() {
    $style_path = get_stylesheet_directory() . '/style.css';
    $script_path = get_template_directory() . '/js/main.js';
    $style_version = file_exists($style_path) ? filemtime($style_path) : '1.0.0';
    $script_version = file_exists($script_path) ? filemtime($script_path) : '1.0.0';

    wp_enqueue_style('avantplanning-style', get_stylesheet_uri(), array(), $style_version);
    wp_enqueue_script('avantplanning-script', get_template_directory_uri() . '/js/main.js', array(), $script_version, true);
}
add_action('wp_enqueue_scripts', 'avantplanning_scripts');

function avantplanning_editor_assets() {
    $style_path = get_stylesheet_directory() . '/style.css';
    $style_version = file_exists($style_path) ? filemtime($style_path) : '1.0.0';

    wp_enqueue_style('avantplanning-editor-style', get_stylesheet_uri(), array(), $style_version);
}
add_action('enqueue_block_editor_assets', 'avantplanning_editor_assets');

function avantplanning_use_home_page_as_front_page() {
    $front_page_id = (int) get_option('page_on_front');

    if ($front_page_id > 0) {
        return;
    }

    $home_page = get_page_by_path('home');

    if (! $home_page instanceof WP_Post || 'page' !== $home_page->post_type) {
        return;
    }

    update_option('show_on_front', 'page');
    update_option('page_on_front', $home_page->ID);
}
add_action('after_switch_theme', 'avantplanning_use_home_page_as_front_page');
add_action('init', 'avantplanning_use_home_page_as_front_page');

function avantplanning_seed_home_page_content() {
    $home_page = get_page_by_path('home');

    if (! $home_page instanceof WP_Post || 'page' !== $home_page->post_type) {
        return;
    }

    $seed_version = 'blocks-v1';
    $current_seed_version = get_post_meta($home_page->ID, '_avantplanning_home_seed_version', true);
    $is_empty = '' === trim($home_page->post_content);
    $is_legacy_html_seed = false !== strpos($home_page->post_content, '<!-- wp:html -->')
        && false !== strpos($home_page->post_content, 'hero-section')
        && $seed_version !== $current_seed_version;

    if (! $is_empty && ! $is_legacy_html_seed) {
        return;
    }

    $pattern_file = get_template_directory() . '/patterns/home.php';

    if (! is_readable($pattern_file)) {
        return;
    }

    $content = file_get_contents($pattern_file);

    if (false === $content) {
        return;
    }

    $content = preg_replace('/^<\?php.*?\?>\s*/s', '', $content);
    $content = trim($content);

    if ('' === $content) {
        return;
    }

    wp_update_post(array(
        'ID'           => $home_page->ID,
        'post_content' => $content,
    ));

    update_post_meta($home_page->ID, '_avantplanning_home_seed_version', $seed_version);
}
add_action('after_switch_theme', 'avantplanning_seed_home_page_content');
add_action('init', 'avantplanning_seed_home_page_content');
