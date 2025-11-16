<?php get_header(); ?>

<div class="up-app">

  <!-- ヘッダー（店舗バー） -->
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

    <!-- 検索ボックス（デザインメイン） -->
    <section class="up-search-section">
      <form method="get" action="<?php echo esc_url( home_url( '/' ) ); ?>">
        <div class="up-search-box">
          <span class="up-search-icon">🔍</span>
          <input
            type="search"
            name="s"
            class="up-search-input"
            placeholder="商品名・キーワードで検索"
            value="<?php echo esc_attr( get_search_query() ); ?>"
          >
          <input type="hidden" name="post_type" value="item">
        </div>
      </form>
    </section>

    <!-- カテゴリ横スクロール -->
    <section class="up-category-section">
      <div class="up-category-scroll">
        <?php
        $current_term = get_queried_object();
        $is_tax       = isset( $current_term->taxonomy ) && 'item_category' === $current_term->taxonomy;
        ?>
        <a
          class="up-cat-pill<?php echo $is_tax ? '' : ' up-cat-pill--active'; ?>"
          href="<?php echo esc_url( get_post_type_archive_link( 'item' ) ); ?>"
        >
          すべて
        </a>
        <?php
        $terms = get_terms(
          array(
            'taxonomy'   => 'item_category',
            'hide_empty' => false,
          )
        );
        if ( ! is_wp_error( $terms ) ) :
          foreach ( $terms as $term ) :
            $active = ( $is_tax && $current_term->term_id === $term->term_id ) ? ' up-cat-pill--active' : '';
            ?>
            <a
              class="up-cat-pill<?php echo esc_attr( $active ); ?>"
              href="<?php echo esc_url( get_term_link( $term ) ); ?>"
            >
              <?php echo esc_html( $term->name ); ?>
            </a>
            <?php
          endforeach;
        endif;
        ?>
      </div>
    </section>

    <!-- 商品グリッド -->
    <?php
    // item 投稿を一覧表示
    $paged = get_query_var( 'paged' ) ? get_query_var( 'paged' ) : 1;
    $args  = array(
      'post_type'      => 'item',
      'posts_per_page' => 12,
      'paged'          => $paged,
    );

    $item_query = new WP_Query( $args );

    if ( $item_query->have_posts() ) :
      ?>
      <div class="up-grid">
        <?php
        while ( $item_query->have_posts() ) :
          $item_query->the_post();
          ?>
          <a href="<?php the_permalink(); ?>" class="up-card-link">
            <article class="up-card">
              <div class="up-card-image-wrap">
                <?php if ( has_post_thumbnail() ) : ?>
                  <?php the_post_thumbnail( 'medium_large', array( 'class' => 'up-card-image' ) ); ?>
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
                  <?php echo wp_kses_post( wp_trim_words( get_the_content(), 30, '…' ) ); ?>
                </div>

                <div class="up-card-footer">
                  <div class="up-price">￥---</div>
                  <button class="up-order-btn">取り置きカゴに入れる（ダミー）</button>
                </div>
              </div>
            </article>
          </a>
          <?php
        endwhile;
        ?>
      </div>

      <!-- ページネーション -->
      <div style="margin-top: 16px; text-align: center;">
        <?php
        echo paginate_links(
          array(
            'total'   => $item_query->max_num_pages,
            'current' => $paged,
          )
        );
        ?>
      </div>

      <?php
      wp_reset_postdata();
    else :
      ?>
      <p class="up-empty">現在、取り置きできる商品がありません。</p>
    <?php endif; ?>

  </main>
</div>

<?php get_footer(); ?>
