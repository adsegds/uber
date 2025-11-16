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
        placeholder="商品名・キーワードで検索（見た目だけ）"
      >
    </div>
  </section>

  <!-- カテゴリ（UberEats風 横スクロール） -->
  <section class="up-category-section">
    <div class="up-category-scroll">
      <span class="up-cat-pill up-cat-pill--active">すべて</span>
      <span class="up-cat-pill">ペットボトル飲料</span>
      <span class="up-cat-pill">お菓子</span>
      <span class="up-cat-pill">冷凍食品</span>
      <span class="up-cat-pill">カップ麺</span>
      <span class="up-cat-pill">ホットスナック</span>
      <span class="up-cat-pill">デザート</span>
    </div>
  </section>

  <!-- メイン商品グリッド -->
  <main class="up-main">
    <div class="up-grid">

      <?php
      // item 投稿タイプを全部取得
      $item_query = new WP_Query(array(
        'post_type'      => 'item',
        'posts_per_page' => -1,
        'orderby'        => 'date',
        'order'          => 'DESC',
      ));

      if ( $item_query->have_posts() ) :
        while ( $item_query->have_posts() ) :
          $item_query->the_post();

          // 価格がカスタムフィールドにあれば取得（なければ空）
          $price = get_post_meta(get_the_ID(), 'price', true);
          $terms = get_the_terms(get_the_ID(), 'item_category');
          $term_names = array();

          if ( ! is_wp_error($terms) && $terms ) {
            foreach ( $terms as $t ) {
              $term_names[] = $t->name;
            }
          }
          $term_text = $term_names ? implode(' / ', $term_names) : 'カテゴリ未設定';
      ?>
        <article class="up-card">
          <a href="<?php the_permalink(); ?>" class="up-card-link">

            <div class="up-card-image-wrap">
              <?php if ( has_post_thumbnail() ) : ?>
                <?php the_post_thumbnail('medium', array('class' => 'up-card-image')); ?>
              <?php else : ?>
                <div class="up-card-image up-card-image--placeholder">
                  画像なし
                </div>
              <?php endif; ?>

              <div class="up-badge">店頭受け取り</div>
            </div>

            <div class="up-card-body">
              <div class="up-card-title"><?php the_title(); ?></div>
              <div class="up-card-meta"><?php echo esc_html($term_text); ?></div>

              <div class="up-card-desc">
                <?php echo wp_trim_words(get_the_excerpt(), 16, '…'); ?>
              </div>

              <div class="up-card-footer">
                <div class="up-price">
                  <?php if ( $price ) : ?>
                    ¥<?php echo esc_html(number_format($price)); ?>
                  <?php else : ?>
                    ¥ — 
                  <?php endif; ?>
                </div>
                <button type="button" class="up-order-btn">
                  取り置きカゴに入れる
                </button>
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
          まだ商品が登録されていません。<br>
          管理画面から「商品」投稿タイプで商品を追加してください。
        </div>
      <?php endif; ?>

    </div><!-- /.up-grid -->
  </main>

</div><!-- /.up-app -->

<?php get_footer(); ?>
