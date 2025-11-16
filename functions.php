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
