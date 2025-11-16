<?php
/* フロントページ（トップ） */
?>
<!DOCTYPE html>
<html <?php language_attributes(); ?>>
<head>
    <meta charset="<?php bloginfo('charset'); ?>">
    <?php up_title('取り置きメニュー'); ?>
    <meta name="viewport" content="width=device-width,initial-scale=1">
    <link rel="stylesheet" href="<?php echo esc_url(get_stylesheet_uri()); ?>">
    <?php wp_head(); ?>
</head>
<body <?php body_class(); ?>>

<header class="header">
  <div>南部店 PICKUP</div>
  <div style="font-size:12px;opacity:0.8;">店頭受け取り専用 / 決済はレジで</div>
</header>

<div class="container">

  <!-- 疑似検索バー -->
  <div style="margin:12px 0;">
    <input type="text" placeholder="商品名で検索" style="width:100%;padding:10px 12px;border-radius:999px;border:1px solid #ddd;font-size:14px;">
  </div>

  <!-- カテゴリ横スクロール -->
  <div class="category-scroll">
    <?php
    $current_cat = isset($_GET['cat']) ? intval($_GET['cat']) : 0;
    $terms = get_terms(array(
      'taxonomy' => 'item_category',
      'hide_empty' => true,
    ));
    echo '<a href="' . esc_url(home_url('/')) . '" class="category-pill ' . ($current_cat === 0 ? 'category-pill--active' : '') . '">すべて</a>';
    foreach ($terms as $term) {
        $active = ($current_cat === $term->term_id) ? 'category-pill--active' : '';
        echo '<a href="' . esc_url(add_query_arg('cat', $term->term_id, home_url('/'))) . '" class="category-pill ' . $active . '">' . esc_html($term->name) . '</a>';
    }
    ?>
  </div>

  <!-- 商品一覧 -->
  <div>
    <?php
    $args = array(
      'post_type' => 'item',
      'posts_per_page' => -1,
    );
    if ($current_cat) {
      $args['tax_query'] = array(
        array(
          'taxonomy' => 'item_category',
          'field'    => 'term_id',
          'terms'    => $current_cat,
        )
      );
    }
    $items = new WP_Query($args);

    if ($items->have_posts()):
      while ($items->have_posts()): $items->the_post();
        $price = get_post_meta(get_the_ID(), 'up_price', true); // 後でカスタムフィールドで入れる用
        ?>
        <div class="item-card">
          <div>
            <?php if (has_post_thumbnail()): ?>
              <?php the_post_thumbnail('medium'); ?>
            <?php else: ?>
              <div style="width:96px;height:96px;background:#ddd;border-radius:8px;"></div>
            <?php endif; ?>
          </div>
          <div style="flex:1;">
            <div class="item-card-title"><?php the_title(); ?></div>
            <?php if ($price): ?>
              <div class="item-card-price"><?php echo esc_html(number_format($price)); ?> 円</div>
            <?php endif; ?>
            <a class="item-card-button" href="<?php the_permalink(); ?>">詳細・取り置き</a>
          </div>
        </div>
        <?php
      endwhile;
      wp_reset_postdata();
    else:
      echo '<p>商品がまだ登録されていません。</p>';
    endif;
    ?>
  </div>

</div>

<!-- 下タブナビ（シンプル） -->
<nav class="footer-nav">
  <a href="<?php echo esc_url(home_url('/')); ?>">メニュー</a>
  <a href="<?php echo esc_url(home_url('/order')); ?>">注文履歴(仮)</a>
  <a href="#">マイページ(予定)</a>
</nav>

<?php wp_footer(); ?>
</body>
</html>
