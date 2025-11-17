<?php get_header(); ?>

<div class="up-shell">

  <?php get_template_part('parts/global-header'); ?>

  <div class="up-layout">

    <!-- 左サイドバー（常に表示／スマホはCSSで折りたたみ） -->
    <aside class="up-sidebar">
      <div class="up-sidebar-title">カテゴリー</div>
      <nav class="up-sidebar-nav">
        <a class="up-sidebar-link up-sidebar-link--all" href="<?php echo home_url(); ?>">すべての商品</a>

        <?php
        $terms = get_terms('item_category');
        if (!empty($terms) && !is_wp_error($terms)) :
          foreach ($terms as $term) : ?>
            <a class="up-sidebar-link" href="<?php echo get_term_link($term); ?>">
              <?php echo $term->name; ?>
            </a>
        <?php endforeach; endif; ?>
      </nav>
    </aside>

    <!-- メイン -->
    <main class="up-main-area up-main--detail">

      <!-- 商品詳細 横最大レイアウト -->
      <div class="up-detail-wide">

        <!-- 画像 ＋ 本文 横並び -->
        <div class="up-detail-flex">

          <!-- 画像 -->
          <div class="up-detail-image-wrap">
            <?php if (has_post_thumbnail()) : ?>
              <img class="up-detail-image" src="<?php the_post_thumbnail_url('large'); ?>" alt="">
            <?php else : ?>
              <div class="up-card-image--placeholder">画像なし</div>
            <?php endif; ?>
          </div>

          <!-- 本文 -->
          <div class="up-detail-body">
            <div class="up-detail-category">
              <?php echo get_the_term_list(get_the_ID(), 'item_category'); ?>
            </div>

            <h1 class="up-detail-title"><?php the_title(); ?></h1>

            <div class="up-detail-price-row">
              <span class="up-detail-price">¥<?php echo get_post_meta(get_the_ID(), 'price', true); ?></span>
              <span class="up-detail-qty">数量：<?php echo get_post_meta(get_the_ID(), 'qty', true); ?>（デモ）</span>
            </div>

            <div class="up-detail-desc">
              <?php the_content(); ?>
            </div>

            <div class="up-detail-order-wrap">
              <button class="up-detail-order-btn">注文に 1 商品追加する（ダミー）</button>
              <p class="up-detail-note">※ 現在はデモモードです</p>
            </div>
          </div>

        </div>
      </div>

      <!-- ========================= -->
      <!--   FANZA風 類似商品       -->
      <!-- ========================= -->
      <div class="up-related-area">
        <h2 class="up-related-title">類似商品</h2>

        <div class="up-related-scroll">

          <?php
          $terms = get_the_terms($post->ID, 'item_category');

          if ($terms) :
            $term_ids = wp_list_pluck($terms, 'term_id');

            $related_query = new WP_Query([
              'post_type' => 'item',
              'posts_per_page' => 30,
              'post__not_in' => [get_the_ID()],
              'tax_query' => [
                [
                  'taxonomy' => 'item_category',
                  'field' => 'term_id',
                  'terms' => $term_ids,
                ]
              ]
            ]);

            if ($related_query->have_posts()) :
              while ($related_query->have_posts()) :
                $related_query->the_post();
          ?>

                <a class="up-related-card" href="<?php the_permalink(); ?>">

                  <div class="up-related-image-wrap">
                    <?php if (has_post_thumbnail()) : ?>
                      <img class="up-related-image" src="<?php the_post_thumbnail_url('medium'); ?>">
                    <?php else : ?>
                      <img class="up-related-image" src="https://placehold.jp/aaaaaa/ffffff/300x400.png?text=No+Image">
                    <?php endif; ?>
                  </div>

                  <div class="up-related-body">
                    <div class="up-related-name"><?php the_title(); ?></div>
                    <div class="up-related-price">¥<?php echo get_post_meta(get_the_ID(), 'price', true); ?></div>
                  </div>

                </a>

          <?php
              endwhile;
              wp_reset_postdata();
            endif;
          endif;
          ?>

        </div>
      </div>

    </main>
  </div>
</div>

<?php get_footer(); ?>
