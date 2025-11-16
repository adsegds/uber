<?php
/**
 * メイン一覧ページ（Uber Eats 風）
 */
get_header();
?>

<div class="ue-app">

  <!-- 上部ヘッダー -->
  <header class="ue-header">
    <div class="ue-header-left">
      <div class="ue-logo-circle">L</div>
      <div>
        <div class="ue-store-name">南部店 PICKUP</div>
        <div class="ue-store-sub">ローソン・テイクアウト専門</div>
      </div>
    </div>
    <div class="ue-header-right">
      <span class="ue-chip ue-chip-outline">開店中</span>
    </div>
  </header>

  <!-- 検索 -->
  <section class="ue-search-section">
    <form method="get" action="<?php echo esc_url( home_url( '/' ) ); ?>">
      <div class="ue-search-box">
        <span class="ue-search-icon">🔍</span>
        <input
          type="text"
          name="s"
          class="ue-search-input"
          placeholder="商品名・カテゴリで検索"
          value="<?php echo esc_attr( get_search_query() ); ?>"
        />
      </div>
    </form>
  </section>

  <!-- カテゴリ（横スクロール） -->
  <section class="ue-category-section">
    <h2 class="ue-section-title">カテゴリ</h2>
    <div class="ue-category-scroll">
      <button class="ue-chip ue-chip-filled">すべて</button>
      <button class="ue-chip">揚げ物</button>
      <button class="ue-chip">ドリンク</button>
      <button class="ue-chip">スイーツ</button>
      <button class="ue-chip">おにぎり</button>
      <button class="ue-chip">弁当</button>
      <button class="ue-chip">アイス</button>
    </div>
  </section>

  <!-- 商品一覧 -->
  <main class="ue-main">
    <h2 class="ue-section-title">おすすめメニュー</h2>

    <?php if ( have_posts() ) : ?>
      <div class="ue-grid">
        <?php while ( have_posts() ) : the_post(); ?>

          <article class="ue-card">
            <a href="<?php the_permalink(); ?>" class="ue-card-inner">
              <div class="ue-card-image-wrap">
                <?php if ( has_post_thumbnail() ) : ?>
                  <?php the_post_thumbnail( 'medium', [ 'class' => 'ue-card-image' ] ); ?>
                <?php else : ?>
                  <div class="ue-card-image ue-card-image--placeholder">
                    <span>No Image</span>
                  </div>
                <?php endif; ?>

                <div class="ue-badge ue-badge-pickup">店頭受け取り</div>
              </div>

              <div class="ue-card-body">
                <h3 class="ue-card-title"><?php the_title(); ?></h3>

                <p class="ue-card-meta">
                  <?php
                  // カテゴリ名
                  $cats = get_the_category();
                  if ( $cats ) {
                    echo esc_html( $cats[0]->name );
                  } else {
                    echo 'カテゴリなし';
                  }
                  ?>
                </p>

                <p class="ue-card-desc">
                  <?php echo esc_html( wp_trim_words( get_the_excerpt(), 16 ) ); ?>
                </p>

                <div class="ue-card-footer">
                  <?php
                  // カスタムフィールド 'price' があれば表示
                  $price = get_post_meta( get_the_ID(), 'price', true );
                  if ( $price ) :
                  ?>
                    <span class="ue-price"><?php echo esc_html( $price ); ?>円</span>
                  <?php else : ?>
                    <span class="ue-price">価格は店頭表示</span>
                  <?php endif; ?>

                  <button type="button" class="ue-order-button">
                    取り置きリストに追加
                  </button>
                </div>
              </div>
            </a>
          </article>

        <?php endwhile; ?>
      </div>

      <!-- ページネーション -->
      <div class="ue-pagination">
        <?php
        the_posts_pagination( [
          'mid_size'  => 1,
          'prev_text' => '← 前へ',
          'next_text' => '次へ →',
        ] );
        ?>
      </div>

    <?php else : ?>

      <p class="ue-empty-text">まだ商品が登録されていません。</p>

    <?php endif; ?>
  </main>

</div>

<?php get_footer(); ?>
