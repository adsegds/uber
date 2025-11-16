<?php get_header(); ?>


<button id="mode-toggle" class="mode-btn">🌙</button>


<style>
/* Uber Eats 風の黒背景 */
body {
    background-color: #000;
    color: #fff;
}

/* コンテナ */
.uber-container {
    max-width: 1200px;
    margin: 0 auto;
    padding: 20px;
}

/* 検索バー */
.uber-search {
    width: 100%;
    padding: 15px;
    border-radius: 25px;
    border: none;
    margin-bottom: 20px;
}

/* カテゴリボタン */
.uber-cat-btn {
    background: #1DB954;
    color: #fff;
    padding: 8px 20px;
    margin-right: 10px;
    border-radius: 20px;
    display: inline-block;
    font-size: 14px;
}

/* 商品カード */
.uber-card {
    background: #111;
    border-radius: 15px;
    padding: 15px;
    margin-bottom: 20px;
    display: flex;
    align-items: flex-start;
}

.uber-card img {
    width: 120px;
    height: 120px;
    border-radius: 10px;
    object-fit: cover;
    margin-right: 15px;
}

.uber-card h3 {
    margin: 0;
    font-size: 18px;
}

.uber-tag {
    display: inline-block;
    background: #1DB954;
    padding: 4px 10px;
    color: #fff;
    border-radius: 12px;
    font-size: 12px;
    margin-top: 5px;
}
</style>

<div class="uber-container">

    <!-- 検索バー -->
    <input type="text" class="uber-search" placeholder="商品名で検索">

    <!-- カテゴリボタン -->
    <a class="uber-cat-btn">すべて</a>
    <a class="uber-cat-btn">お弁当</a>
    <a class="uber-cat-btn">飲料</a>
    <a class="uber-cat-btn">スイーツ</a>

    <br><br>

    <!-- 商品一覧（ループ） -->
    <?php
    if ( have_posts() ) :
        while ( have_posts() ) : the_post();
    ?>

    <div class="uber-card">
        <!-- アイキャッチ画像 -->
        <?php if ( has_post_thumbnail() ) : ?>
            <a href="<?php the_permalink(); ?>">
                <?php the_post_thumbnail( 'medium' ); ?>
            </a>
        <?php else: ?>
            <div style="width:120px;height:120px;background:#333;border-radius:10px;margin-right:15px;"></div>
        <?php endif; ?>

        <div class="uber-info">
            <h3><a href="<?php the_permalink(); ?>" style="color:#fff;"><?php the_title(); ?></a></h3>
            <span class="uber-tag">詳細・取り置き</span>
        </div>
    </div>

    <?php
        endwhile;
    endif;
    ?>

</div>

<?php get_footer(); ?>
