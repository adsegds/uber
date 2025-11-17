<?php
/**
 * 商品詳細ページ (Uber Eats 風)
 */

get_header();
?>

<div class="up-app">

  <!-- ヘッダー（一覧と同じ） -->
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

  <main class="up-main up-main--detail">

    <?php if ( have_posts() ) : while ( have_posts() ) : the_post(); ?>

      <!-- ▼ 商品メインカード（左：画像 / 右：情報） -->
      <article class="up-card up-detail-card">
        <div class="up-detail-image-wrap">
          <?php if ( has_post_thumbnail() ) : ?>
            <?php the_post_thumbnail( 'large', array( 'class' => 'up-detail-image' ) ); ?>
          <?php else : ?>
            <div class="up-card-image up-card-image--placeholder">
              画像なし
            </div>
          <?php endif; ?>
        </div>

        <div class="up-detail-body">
          <?php
            $terms = get_the_terms( get_the_ID(), 'item_category' );
            if ( $terms && ! is_wp_error( $terms ) ) {
              $names = wp_list_pluck( $terms, 'name' );
              echo '<div class="up-detail-category">' . esc_html( implode( ' / ', $names ) ) . '</div>';
            } else {
              echo '<div class="up-detail-category">カテゴリ未設定</div>';
            }
          ?>

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
              ※ 実際の注文には対応していません。これはデザイン用のダミーボタンです。
            </p>
          </div>
        </div>
      </article>
      <!-- ▲ 商品メインカードここまで -->

      <?php
      // ▼ 類似商品クエリ（同じ item_category の他商品）
      $term_ids = $terms && ! is_wp_error( $terms )
        ? wp_list_pluck( $terms, 'term_id' )
        : array();

      if ( ! empty( $term_ids ) ) :
        $related_args = array(
          'post_type'      => 'item',
          'posts_per_page' => 12, // 類似商品をいっぱい並べる
          'post__not_in'   => array( get_the_ID() ),
          'tax_query'      => array(
            array(
              'taxonomy' => 'item_category',
              'field'    => 'term_id',
              'terms'    => $term_ids,
            ),
          ),
        );

        $related_query = new WP_Query( $related_args );
        if ( $related_query->have_posts() ) :
      ?>

        <!-- ▼ 類似商品セクション（ページ幅いっぱいにグリッド） -->
        <section class="up-related-section">
          <h2 class="up-related-heading">類似商品</h2>

          <div class="up-related-grid">
            <?php while ( $related_query->have_posts() ) : $related_query->the_post(); ?>
              <a class="up-related-card" href="<?php the_permalink(); ?>">
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
        <!-- ▲ 類似商品セクションここまで -->

      <?php
        wp_reset_postdata();
        endif;
      endif;
      // ▲ 類似商品クエリ終わり
      ?>

      <p class="up-detail-back">
        <a href="<?php echo esc_url( home_url( '/' ) ); ?>">← 商品一覧に戻る</a>
      </p>

    <?php endwhile; endif; ?>

  </main>
</div>

<?php get_footer(); ?>
