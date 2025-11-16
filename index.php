<?php get_header(); ?>

<div class="up-app">

  <!-- ヘッダー（店舗バー） -->
  <header class="up-header">
    <div class="up-header-left">
      <div class="up-logo-circle">L</div>
      <div>
        <div class="up-store-name"><?php bloginfo('name'); ?></div>
        <div class="up-store-sub">店頭受け取り専用・決済はレジで</div>
      </div>
    </div>
    <div class="up-header-right">
      PICKUP
    </div>
  </header>

  <!-- 検索バー -->
  <section class="up-search-section">
    <div class="up-search-box">
      <span class="up-search-icon">🔍</span>
      <input
        type="text"
        class="up-search-input"
        placeholder="商品名・キーワードで検索（見た目だけ）">
    </div>
  </section>

  <!-- カテゴリ横スクロール（見た目だけのダミー） -->
  <section class="up-category-section">
    <div class="up-category-scroll">
      <div class="up-cat-pill up-cat-pill--active">すべて</div>
      <div class="up-cat-pill">ペットボトル飲料</div>
      <div class="up-cat-pill">お菓子</div>
      <div class="up-cat-pill">冷凍食品</div>
      <div class="up-cat-pill">カップ麺</div>
      <div class="up-cat-pill">ホットスナック</div>
      <div class="up-cat-pill">お酒</div>
    </div>
  </section>

  <!-- 商品グリッド -->
  <main class="up-main">
    <div class="up-grid">
      <?php
      // 商品投稿(item) を全部取得
      $query = new WP_Query(array(
        'post_type'      => 'item',
        'posts_per_page' => -1,
        'orderby'        => 'date',
        'order'          => 'DESC',
      ));

      if ( $query->have_posts() ) :
        while ( $query->have_posts() ) : $query->the_post();
      ?>
        <article class="up-card">
          <a class="up-card-link" href="<?php the_permalink(); ?>">
            <div class="up-card-image-wrap">
              <?php if ( has_post_thumbnail() ) : ?>
                <?php the_post_thumbnail( 'medium', array( 'class' => 'up-card-image' ) ); ?>
              <?php else : ?>
                <div class="up-card-image up-card-image--placeholder">
                  画像なし
                </div>
              <?php endif; ?>

              <div class="up-badge">店頭受取</div>
            </div>

            <div class="up-card-body">
              <h2 class="up-card-title"><?php the_title(); ?></h2>

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
                <?php echo esc_html( wp_trim_words( get_the_content(), 18, '…' ) ); ?>
              </div>

              <div class="up-card-footer">
                <div class="up-price">￥---</div>
                <button class="up-order-btn">取り置きカゴに入れる</button>
              </div>
            </div>
          </a>
        </article>
      <?php
        endwhile;
        wp_reset_postdata();
      else :
      ?>
        <div class="up-empty">
          商品がまだ登録されていません。
        </div>
      <?php endif; ?>
    </div>
  </main>

</div>

<?php get_footer(); ?>
