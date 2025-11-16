<?php get_header(); ?>

<div class="up-app">

  <!-- ヘッダー（一覧と同じバー） -->
  <header class="up-header">
    <div class="up-header-left">
      <div class="up-logo-circle">L</div>
      <div>
        <div class="up-store-name"><?php bloginfo( 'name' ); ?></div>
        <div class="up-store-sub">店頭受け取り専用・決済はレジで</div>
      </div>
    </div>
    <div class="up-header-right">
      PICKUP
    </div>
  </header>

  <main class="up-main">
    <?php if ( have_posts() ) : ?>
      <?php while ( have_posts() ) : the_post(); ?>
        <article class="up-card">
          <div class="up-card-image-wrap">
            <?php if ( has_post_thumbnail() ) : ?>
              <?php the_post_thumbnail( 'large', array( 'class' => 'up-card-image' ) ); ?>
            <?php else : ?>
              <div class="up-card-image up-card-image--placeholder">
                画像なし
              </div>
            <?php endif; ?>
            <div class="up-badge">店頭受取</div>
          </div>

          <div class="up-card-body">
            <h1 class="up-card-title"><?php the_title(); ?></h1>

            <div class="up-card-meta">
              <?php
              $terms = get_the_terms( get_the_ID(), 'item_category' );
              if ( $terms && ! is_wp_error( $terms ) ) {
                $names = wp_list_pluck( $terms, 'name' );
                echo esc_html( implode( ' / ', $names ) );
              } else {
                echo 'カテゴリ未設定';
              }
              ?>
            </div>

            <div class="up-card-desc">
              <?php the_content(); ?>
            </div>

            <div class="up-card-footer">
              <div class="up-price">￥---</div>
              <button class="up-order-btn">この商品を取り置きする（デザインだけ）</button>
            </div>
          </div>
        </article>
      <?php endwhile; ?>
    <?php endif; ?>

    <p style="margin-top: 16px;">
      <a href="<?php echo esc_url( home_url( '/' ) ); ?>">← 商品一覧に戻る</a>
    </p>
  </main>

</div>

<?php get_footer(); ?>
