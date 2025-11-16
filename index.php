<?php get_header(); ?>

<div class="up-app">
  <header class="up-header">
    <div class="up-header-left">
      <div class="up-logo-circle">L</div>
      <div>
        <div class="up-store-name"><?php bloginfo( 'name' ); ?></div>
        <div class="up-store-sub">通常のブログ一覧</div>
      </div>
    </div>
    <div class="up-header-right">
      BLOG
    </div>
  </header>

  <main class="up-main">
    <?php if ( have_posts() ) : ?>
      <?php while ( have_posts() ) : the_post(); ?>
        <article class="up-card" style="margin-bottom: 12px;">
          <div class="up-card-body">
            <h2 class="up-card-title">
              <a href="<?php the_permalink(); ?>"><?php the_title(); ?></a>
            </h2>
            <div class="up-card-meta">
              <?php echo get_the_date(); ?>
            </div>
            <div class="up-card-desc">
              <?php the_excerpt(); ?>
            </div>
          </div>
        </article>
      <?php endwhile; ?>

      <div style="margin-top: 16px; text-align: center;">
        <?php the_posts_pagination(); ?>
      </div>

    <?php else : ?>
      <p class="up-empty">投稿はありません。</p>
    <?php endif; ?>
  </main>
</div>

<?php get_footer(); ?>
