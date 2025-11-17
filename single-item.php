<?php
/**
 * 商品詳細ページ（Uber Eats 風）
 */
get_header();
?>

<div class="up-shell">
  <div class="up-app">

    <!-- 青いヘッダー（カテゴリ一覧と同じやつ） -->
    <header class="up-global-header">
      <div class="up-global-inner">
        <div class="up-global-left">
          <div class="up-global-logo">L</div>
          <div class="up-global-store">
            <div class="up-global-store-name"><?php bloginfo( 'name' ); ?></div>
            <div class="up-global-store-meta">店頭受け取り専用・決済はレジにて</div>
          </div>
        </div>
        <div class="up-global-right">
          <form method="get" action="<?php echo esc_url( home_url( '/' ) ); ?>" class="up-global-search">
            <span class="up-global-search-icon">🔍</span>
            <input
              type="search"
              name="s"
              class="up-global-search-input"
              placeholder="商品名・キーワードで検索"
              value="<?php echo esc_attr( get_search_query() ); ?>"
            >
            <input type="hidden" name="post_type" value="item">
          </form>
        </div>
      </div>
    </header>

    <main class="up-main up-main--detail">
      <?php if ( have_posts() ) : while ( have_posts() ) : the_post(); ?>

        <?php
        // この商品が属しているカテゴリIDを取得（類似商品用）
        $term_ids = wp_get_post_terms(
          get_the_ID(),
          'item_category',
          array( 'fields' => 'ids' )
        );
        ?>

        <!-- 上段：商品本体 -->
        <section class="up-detail-layout">

          <!-- 左：大きい商品カード -->
          <article class="up-card up-detail-card">
            <div class="up-card-image-wrap up-detail-image-wrap">
              <?php if ( has_post_thumbnail() ) : ?>
                <?php the_post_thumbnail( 'large', array( 'class' => 'up-card-image up-detail-image' ) ); ?>
              <?php else : ?>
                <div class="up-card-image up-card-image--placeholder">
                  画像なし
                </div>
              <?php endif; ?>
            </div>

            <div class="up-detail-body">
              <div class="up-detail-meta-top">
                <?php
                $terms = get_the_terms( get_the_ID(), 'item_category' );
                if ( $terms && ! is_wp_error( $terms ) ) {
                  $names = wp_list_pluck( $terms, 'name' );
                  echo '<div class="up-detail-category">' . esc_html( implode( ' / ', $names ) ) . '</div>';
                }
                ?>
              </div>

              <h1 class="up-detail-title"><?php the_title(); ?></h1>

              <div class="up-detail-price-row">
                <div class="up-detail-price">￥---</div>
                <div class="up-detail-qty">数量：1（ダミー）</div>
              </div>

              <div class="up-detail-desc">
                <?php the_content(); ?>
              </div>

              <div class="up-detail-order-wrap">
                <button class="up-detail-order-btn">
                  注文に 1 個追加する（ダミー）
                </button>
                <p class="up-detail-note">
                  ※ 実際の決済はレジにて行います。これはデザイン用のボタンです。
                </p>
              </div>
            </div>
          </article>

        </section>

        <!-- 下段：類似商品グリッド -->
        <?php
        if ( ! empty( $term_ids ) && ! is_wp_error( $term_ids ) ) :

          $related_query = new WP_Query( array(
            'post_type'      => 'item',
            'posts_per_page' => 24,              // ← ここ増やせば「置きまくり」になる
            'post__not_in'   => array( get_the_ID() ),
            'tax_query'      => array(
              array(
                'taxonomy' => 'item_category',
                'field'    => 'term_id',
                'terms'    => $term_ids,
              ),
            ),
          ) );

          if ( $related_query->have_posts() ) : ?>
            <section class="up-related-section">
              <h2 class="up-related-heading">類似商品</h2>
              <div class="up-related-grid">
                <?php while ( $related_query->have_posts() ) : $related_query->the_post(); ?>
                  <a href="<?php the_permalink(); ?>" class="up-related-card">
                    <div class="up-related-image-wrap">
                      <?php if ( has_post_thumbnail() ) : ?>
                        <?php the_post_thumbnail( 'medium', array( 'class' => 'up-related-image' ) ); ?>
                      <?php else : ?>
                        <div class="up-related-image up-related-image--placeholder">
                          画像なし
                        </div>
                      <?php endif; ?>
                    </div>
                    <div class="up-related-body">
                      <div class="up-related-title"><?php the_title(); ?></div>
                      <div class="up-related-price">￥---</div>
                    </div>
                  </a>
                <?php endwhile; ?>
              </div>
            </section>
          <?php
          endif;
          wp_reset_postdata();
        endif;
        ?>

        <!-- 一覧に戻る -->
        <p class="up-detail-back">
          <a href="<?php echo esc_url( home_url( '/' ) ); ?>">← 商品一覧に戻る</a>
        </p>

      <?php endwhile; endif; ?>
    </main>

  </div><!-- /.up-app -->
</div><!-- /.up-shell -->

<?php get_footer(); ?>
