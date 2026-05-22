<?php
/**
 * Avant Planning Theme Functions
 */

// テーマのセットアップ
function avantplanning_setup() {
    // タイトルタグのサポート
    add_theme_support('title-tag');
    
    // HTML5のサポート
    add_theme_support('html5', array(
        'search-form',
        'comment-form',
        'comment-list',
        'gallery',
        'caption',
    ));
    
    // 投稿サムネイルのサポート
    add_theme_support('post-thumbnails');
}
add_action('after_setup_theme', 'avantplanning_setup');

// スタイルとスクリプトの読み込み
function avantplanning_scripts() {
    // メインスタイルシート
    wp_enqueue_style('avantplanning-style', get_stylesheet_uri(), array(), '1.0.0');
    
    // スムーススクロール用のスクリプト
    wp_enqueue_script('avantplanning-script', get_template_directory_uri() . '/js/main.js', array(), '1.0.0', true);
}
add_action('wp_enqueue_scripts', 'avantplanning_scripts');

// SCSSコンパイルの注意
// style.scssをstyle.cssにコンパイルする必要があります
// ローカル環境では以下のようなツールを使用してください：
// - node-sass
// - dart-sass
// - VSCode拡張機能 "Live Sass Compiler"
?>