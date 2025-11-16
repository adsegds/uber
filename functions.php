<?php
/**
 * Uber Pickup Theme functions
 */

// テーマの基本セットアップ
add_action('after_setup_theme', function () {
    add_theme_support('post-thumbnails'); // アイキャッチ
    add_theme_support('title-tag');       // <title> 自動
});

// 商品投稿タイプ item
function up_register_item_post_type() {
    $labels = array(
        'name'          => '商品',
        'singular_name' => '商品',
    );

    $args = array(
        'labels'        => $labels,
        'public'        => true,
        'has_archive'   => false,
        'menu_position' => 5,
        'menu_icon'     => 'dashicons-cart',
        'supports'      => array('title', 'editor', 'thumbnail'),
        'rewrite'       => array('slug' => 'item'),
        'show_in_rest'  => true,
    );

    register_post_type('item', $args);
}
add_action('init', 'up_register_item_post_type');

// 商品カテゴリ tax：item_category
function up_register_item_category_taxonomy() {
    $labels = array(
        'name'          => '商品カテゴリ',
        'singular_name' => '商品カテゴリ',
    );

    $args = array(
        'labels'       => $labels,
        'hierarchical' => true,
        'public'       => true,
        'rewrite'      => array('slug' => 'item-category'),
        'show_in_rest' => true,
    );

    register_taxonomy('item_category', 'item', $args);
}
add_action('init', 'up_register_item_category_taxonomy');

// CSS 読み込み（style.css を直指定）
function uber_pickup_assets() {
    wp_enqueue_style(
        'uber-style',
        get_template_directory_uri() . '/style.css',
        array(),
        '1.0.0'
    );
}
add_action('wp_enqueue_scripts', 'uber_pickup_assets');
