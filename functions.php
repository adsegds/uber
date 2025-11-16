<?php
/**
 * Uber Pickup Theme functions
 */

// テーマの基本設定
function uber_pickup_setup() {
  // タイトルタグ自動
  add_theme_support( 'title-tag' );

  // アイキャッチ画像
  add_theme_support( 'post-thumbnails' );

  // HTML5 サポート
  add_theme_support( 'html5', array( 'search-form', 'gallery', 'caption' ) );
}
add_action( 'after_setup_theme', 'uber_pickup_setup' );

// CSS 読み込み
function uber_pickup_enqueue_assets() {
  wp_enqueue_style(
    'uber-pickup-style',
    get_stylesheet_uri(),
    array(),
    '1.0.0'
  );
}
add_action( 'wp_enqueue_scripts', 'uber_pickup_enqueue_assets' );

// 商品用カスタム投稿タイプ「item」とタクソノミー「item_category」
function uber_pickup_register_post_type() {

  // 投稿タイプ item
  $labels = array(
    'name'          => '商品',
    'singular_name' => '商品',
    'add_new'       => '新規商品を追加',
    'add_new_item'  => '新規商品を追加',
    'edit_item'     => '商品を編集',
    'new_item'      => '新しい商品',
    'view_item'     => '商品を表示',
    'search_items'  => '商品を検索',
    'not_found'     => '商品が見つかりませんでした',
    'menu_name'     => '商品',
  );

  register_post_type(
    'item',
    array(
      'labels'       => $labels,
      'public'       => true,
      'has_archive'  => true,
      'menu_icon'    => 'dashicons-cart',
      'supports'     => array( 'title', 'editor', 'thumbnail' ),
      'rewrite'      => array( 'slug' => 'item' ),
      'show_in_rest' => true,
    )
  );

  // タクソノミー item_category
  $tax_labels = array(
    'name'          => '商品カテゴリ',
    'singular_name' => '商品カテゴリ',
    'search_items'  => 'カテゴリを検索',
    'all_items'     => 'すべてのカテゴリ',
    'edit_item'     => 'カテゴリを編集',
    'update_item'   => 'カテゴリを更新',
    'add_new_item'  => '新規カテゴリを追加',
    'new_item_name' => '新規カテゴリ名',
    'menu_name'     => '商品カテゴリ',
  );

  register_taxonomy(
    'item_category',
    'item',
    array(
      'labels'       => $tax_labels,
      'hierarchical' => true,
      'public'       => true,
      'rewrite'      => array( 'slug' => 'item-category' ),
      'show_in_rest' => true,
    )
  );
}
add_action( 'init', 'uber_pickup_register_post_type' );
