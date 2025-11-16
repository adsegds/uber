<?php
/**
 * index.php
 * メインテンプレート（最低限バージョン）
 * テーマ必須ファイル：style.css とセットで使う
 */
?>
<!DOCTYPE html>
<html <?php language_attributes(); ?>>
<head>
    <meta charset="<?php bloginfo( 'charset' ); ?>">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title><?php bloginfo( 'name' ); ?></title>
    <?php wp_head(); ?>
</head>
<body <?php body_class(); ?>>

<header class="site-header">
    <h1 class="site-title">
        <a href="<?php echo esc_url( home_url( '/' ) ); ?>">
            <?php bloginfo( 'name' ); ?>
        </a>
    </h1>
    <p class="site-description"><?php bloginfo( 'description' ); ?></p>
</header>

<main class="site-main">

    <?php if ( have_posts() ) : ?>

        <?php while ( have_posts() ) : the_post(); ?>
            <article id="post-<?php the_ID(); ?>" <?php post_class( 'post-card' ); ?>>
                <h2 class="post-title">
                    <a href="<?php the_permalink(); ?>">
                        <?php the_title(); ?>
                    </a>
                </h2>

                <div class="post-meta">
                    <span class="post-date"><?php echo get_the_date(); ?></span>
                </div>

                <div class="post-content">
                    <?php the_excerpt(); ?>
                </div>

            </article>
        <?php endwhile; ?>

        <div class="pagination">
            <?php
            the_posts_pagination( array(
                'prev_text' => '&laquo; 前へ',
                'next_text' => '次へ &raquo;',
            ) );
            ?>
        </div>

    <?php else : ?>

        <article class="no-posts">
            <h2>まだ投稿がありません</h2>
            <p>管理画面から投稿を作成してみてね。</p>
        </article>

    <?php endif; ?>

</main>

<footer class="site-footer">
    <p>&copy; <?php echo date( 'Y' ); ?> <?php bloginfo( 'name' ); ?></p>
</footer>

<?php wp_footer(); ?>
</body>
</html>
