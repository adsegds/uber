<?php
/* Template Name: Order Page */
$item_title = '';
if (isset($_GET['item_id'])) {
    $post_obj = get_post(intval($_GET['item_id']));
    if ($post_obj && $post_obj->post_type === 'item') {
        $item_title = $post_obj->post_title;
    }
}

// 簡易送信処理（超シンプル版）
$sent = false;
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['up_order_nonce']) && wp_verify_nonce($_POST['up_order_nonce'], 'up_order')) {
    $name   = sanitize_text_field($_POST['name'] ?? '');
    $tel    = sanitize_text_field($_POST['tel'] ?? '');
    $time   = sanitize_text_field($_POST['time'] ?? '');
    $item   = sanitize_text_field($_POST['item'] ?? '');
    $qty    = intval($_POST['qty'] ?? 1);

    $to      = get_option('admin_email'); // 店のメールアドレスにあとで変更
    $subject = '取り置き注文: ' . $item;
    $message = "お名前: {$name}\n電話番号: {$tel}\n受取時間: {$time}\n商品: {$item}\n数量: {$qty}\n";
    wp_mail($to, $subject, $message);

    $sent = true;
}
?>
<!DOCTYPE html>
<html <?php language_attributes(); ?>>
<head>
  <meta charset="<?php bloginfo('charset'); ?>">
  <?php up_title('取り置き注文'); ?>
  <meta name="viewport" content="width=device-width,initial-scale=1">
  <link rel="stylesheet" href="<?php echo esc_url(get_stylesheet_uri()); ?>">
  <?php wp_head(); ?>
</head>
<body <?php body_class(); ?>>

<header class="header">
  <div>取り置き注文</div>
</header>

<div class="container">
  <?php if ($sent): ?>
    <p>ご注文ありがとうございました！<br>10分後を目安にレジまでお越しください。</p>
  <?php else: ?>
    <form method="post">
      <?php wp_nonce_field('up_order', 'up_order_nonce'); ?>
      <p>
        <label>商品</label><br>
        <input type="text" name="item" value="<?php echo esc_attr($item_title); ?>" readonly style="width:100%;padding:8px;">
      </p>
      <p>
        <label>数量</label><br>
        <input type="number" name="qty" value="1" min="1" style="width:100%;padding:8px;">
      </p>
      <p>
        <label>お名前</label><br>
        <input type="text" name="name" required style="width:100%;padding:8px;">
      </p>
      <p>
        <label>電話番号</label><br>
        <input type="tel" name="tel" required style="width:100%;padding:8px;">
      </p>
      <p>
        <label>受取希望時間</label><br>
        <input type="time" name="time" required style="width:100%;padding:8px;">
      </p>
      <p>
        <button type="submit" class="item-card-button">取り置きを確定する</button>
      </p>
    </form>
  <?php endif; ?>
</div>

<?php wp_footer(); ?>
</body>
</html>
