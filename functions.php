<?php
// サムネイルとか有効化
add_theme_support('post-thumbnails');

// 商品用カスタム投稿タイプ
function up_register_item_post_type() {
    $labels = array(
        'name' => '商品',
        'singular_name' => '商品',
    );
    $args = array(
        'labels' => $labels,
        'public' => true,
        'has_archive' => false,
        'menu_position' => 5,
        'menu_icon' => 'dashicons-cart',
        'supports' => array('title', 'editor', 'thumbnail'),
        'rewrite' => array('slug' => 'item'),
    );
    register_post_type('item', $args);
}
add_action('init', 'up_register_item_post_type');

// 商品カテゴリ用タクソノミー
function up_register_item_category_taxonomy() {
    $labels = array(
        'name' => '商品カテゴリ',
        'singular_name' => '商品カテゴリ',
    );
    $args = array(
        'labels' => $labels,
        'hierarchical' => true,
        'public' => true,
        'rewrite' => array('slug' => 'item-category'),
    );
    register_taxonomy('item_category', 'item', $args);
}
add_action('init', 'up_register_item_category_taxonomy');

// シンプルなタイトル出力
function up_title($title = '') {
    if ($title) {
        echo '<title>' . esc_html($title) . '</title>';
    } else {
        echo '<title>' . esc_html(get_bloginfo('name')) . '</title>';
    }
}


// テーマのCSSとJSを読み込む
function uber_theme_assets() {
    // メインのCSS
    wp_enqueue_style(
        'uber-style',
        get_stylesheet_uri(),
        array(),
        '1.0'
    );

    // ダーク／ライト切り替え用 JS
    wp_enqueue_script(
        'uber-theme-toggle',
        get_template_directory_uri() . '/js/theme-toggle.js',
        array(),
        '1.0',
        true  // フッター読み込み
    );
}
add_action('wp_enqueue_scripts', 'uber_theme_assets');
