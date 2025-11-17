<div class="up-related-area">

  <h2 class="up-related-title">類似商品</h2>

  <div class="up-related-list-fanza">
    <?php
    $terms = get_the_terms($post->ID, 'item_category');
    if ($terms) {
        $term_ids = wp_list_pluck($terms, 'term_id');

        $args = array(
            'post_type' => 'item',
            'posts_per_page' => 30,
            'post__not_in' => array($post->ID),
            'tax_query' => array(
                array(
                    'taxonomy' => 'item_category',
                    'field' => 'term_id',
                    'terms' => $term_ids,
                )
            )
        );

        $related_query = new WP_Query($args);

        if ($related_query->have_posts()): 
            while ($related_query->have_posts()): $related_query->the_post(); ?>
                
                <a class="up-related-card-fanza" href="<?php the_permalink(); ?>">
                    <?php if (has_post_thumbnail()): ?>
                        <?php the_post_thumbnail('medium'); ?>
                    <?php else: ?>
                        <img src="https://placehold.jp/aaaaaa/ffffff/300x400.png?text=No+Image">
                    <?php endif; ?>

                    <div class="title"><?php the_title(); ?></div>
                    <div class="price">¥<?php echo get_post_meta(get_the_ID(), 'price', true); ?></div>
                </a>

            <?php endwhile;
            wp_reset_postdata();
        endif;
    }
    ?>
  </div>

</div>
