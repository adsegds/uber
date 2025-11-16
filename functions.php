<?php
/**
 * Uber Pickup Theme functions
 */

// テーマの基本セットアップ
add_action('after_setup_theme', function () {
    // アイキャッチ画像（商品サムネ用）
    add_theme_support('post-thumbnails');

    // タイトルタグ（<title>）をWPに任せる
    add_theme_support('title-tag');
});

// 商品用カスタム投稿タイプ：item
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

// 商品カテゴリ用タクソノミー：item_category
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

// テーマのCSSだけ読み込む（JSはなし）
function uber_pickup_assets() {
    wp_enqueue_style(
        'uber-style',
        get_stylesheet_uri(),
        array(),
        '1.0.0'
    );
}
add_action('wp_enqueue_scripts', 'uber_pickup_assets');
