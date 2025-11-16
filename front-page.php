<?php
/**
 * Uber Eats 風 トップページ
 */
get_header();
?>

<div class="ue-app">

  <!-- ヘッダー -->
  <header class="ue-header">
    <div class="ue-header-left">
      <div class="ue-logo-circle">
        L
      </div>
      <div>
        <div class="ue-store-name">
          <?php bloginfo('name'); ?>
        </div>
        <div class="ue-store-sub">
          店頭受取り専用・決済はレジで
        </div>
      </div>
    </div>
    <div class="ue-header-right">
      <button class="ue-chip ue-chip-filled">PICKUP</button>
    </div>
  </header>

  <!-- 検索 -->
  <section class="ue-search-section">
    <div class="ue-search-box">
      <span class="ue-search-icon">🔍</span>
      <input
        type="text"
        class="ue-search-input"
        placeholder="商品名・キーワードで検索（見た目だけ）">
    </div>
  </section>

  <!-- カテゴリ横スクロール（見た目用ダミー） -->
  <section class="ue-category-section">
    <div class="ue-section-title">カテゴリー</div>
    <div class="ue-category-scroll">
      <div class="ue-category-pill ue-category-pill--active">すべて</div>
      <div class="ue-category-pill">お菓子</div>
      <div class="ue-category-pill">ペットボトル飲料</div>
      <div class="ue-category-pill">カップ麺</div>
      <div class="ue-category-pill">冷凍食品</div>
      <div class="ue-category-pill">ホットスナック</div>
      <div class="ue-category-pill">お酒</div>
    </div>
  </section>

  <!-- メイン商品グリッド -->
  <main class="ue-main">
    <div class="ue-section-title">おすすめ商品</div>

    <div class="ue-grid">
      <?php
      // 商品用のクエリ
      $args = array(
        'post_type'      => array('item', 'pickup_item', 'post'), // ここは使ってる投稿タイプに合わせて調整
        'posts_per_page' => 24,
      );
      $loop = new WP_Query($args);

      if ($loop->have_posts()) :
        while ($loop->have_posts()) :
          $loop->the_post();

          // サムネイル画像
          $thumb = get_the_post_thumbnail_url(get_the_ID(), 'medium');
          $price = get_post_meta(get_the_ID(), 'price', true); // カスタムフィールド price を想定
          ?>
          <article class="ue-card">
            <a class="ue-card-inner" href="<?php the_permalink(); ?>">
              <div class="ue-card-image-wrap">
                <?php if ($thumb) : ?>
                  <img src="<?php echo esc_url($thumb); ?>"
                       alt="<?php the_title_attribute(); ?>"
                       class="ue-card-image">
                <?php else : ?>
                  <div class="ue-card-image ue-card-image--placeholder">
                    画像なし
                  </div>
                <?php endif; ?>

                <div class="ue-badge ue-badge-pickup">店頭受取</div>
              </div>

              <div class="ue-card-body">
                <h2 class="ue-card-title"><?php the_title(); ?></h2>

                <div class="ue-card-meta">
                  <?php
                  $cats = get_the_category();
                  if (!empty($cats)) {
                    echo esc_html($cats[0]->name);
                  } else {
                    echo 'カテゴリー未設定';
                  }
                  ?>
                </div>

                <div class="ue-card-desc">
                  <?php echo esc_html(wp_trim_words(get_the_excerpt(), 18)); ?>
                </div>

                <div class="ue-card-footer">
                  <div class="ue-price">
                    <?php
                    if ($price) {
                      echo '¥' . number_format_i18n($price);
                    } else {
                      echo '¥---';
                    }
                    ?>
                  </div>
                  <button type="button" class="ue-order-button">
                    取り置きカゴに入れる
                  </button>
                </div>
              </div>
            </a>
          </article>
          <?php
        endwhile;

        // ページネーション
        ?>
        <div class="ue-pagination">
          <?php
          echo paginate_links(array(
            'prev_text' => '«',
            'next_text' => '»',
          ));
          ?>
        </div>
        <?php

      else :
        ?>
        <p class="ue-empty-text">まだ商品が登録されていません。</p>
        <?php
      endif;

      wp_reset_postdata();
      ?>
    </div>
  </main>

</div><!-- /.ue-app -->

<?php
get_footer();
