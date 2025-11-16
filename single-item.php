<?php
/* 商品詳細 */
?>
<!DOCTYPE html>
<html <?php language_attributes(); ?>>
<head>
  <meta charset="<?php bloginfo('charset'); ?>">
  <?php up_title(get_the_title()); ?>
  <meta name="viewport" content="width=device-width,initial-scale=1">
  <link rel="stylesheet" href="<?php echo esc_url(get_stylesheet_uri()); ?>">
  <?php wp_head(); ?>
</head>
<body <?php body_class(); ?>>

<header class="header">
  <div>商品詳細</div>
</header>

<div class="container">
  <?php if (have_posts()): while (have_posts()): the_post(); ?>
    <div>
      <?php if (has_post_thumbnail()): the_post_thumbnail('large'); endif; ?>
      <h1><?php the_title(); ?></h1>
      <?php
      $price = get_post_meta(get_the_ID(), 'up_price', true);
      if ($price) {
        echo '<p>' . esc_html(number_format($price)) . ' 円</p>';
      }
      ?>
      <div><?php the_content(); ?></div>

      <?php
      // 注文ページへのリンク（商品IDをクエリに付ける）
      $order_url = add_query_arg('item_id', get_the_ID(), home_url('/order'));
      ?>
      <p style="margin-top:20px;">
        <a href="<?php echo esc_url($order_url); ?>" class="item-card-button">この商品を取り置きする</a>
      </p>
    </div>
  <?php endwhile; endif; ?>
</div>

<?php wp_footer(); ?>
</body>
</html>
