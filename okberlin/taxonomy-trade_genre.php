<?php
/**
 * The template for displaying archive pages
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/
 *
 * @package okberlin
 */

get_header();
?>

<main id="primary" class="site-main">
<div class="flexbox wrap">
<div class="main_left">
<div class="page-title" style="background:url(<?php
$term = get_queried_object();
if( get_field( 'tradegenreimg', $term ) ){
	the_field( 'tradegenreimg', $term );
}
?>);">
<h1 class="title-section">
<?php
$term = get_queried_object();
if( get_field( 'tradegenredeutsu', $term ) ){
	the_field( 'tradegenredeutsu', $term );
}
?>
<span><?php single_term_title(); ?></span>
</h1>
</div>
<ul class="flexbox list_facility">
<?php
            $trade_genre = get_query_var( 'trade_genre' ); //指定したいタクソノミーを指定
            $args = array(
                'post_type' => array('trade'), 
                'tax_query' => array(
                    'relation' => 'OR',
                    array(
                        'taxonomy' => 'trade_genre',
                        'field' => 'slug',
                        'terms' => $trade_genre, /* 上記で指定した変数を指定 */
                    ),
                ),
                'paged' => $paged,
                'posts_per_page' => '20' /* 1ページに表示させたい件数 */
            ); ?>
            <?php query_posts( $args ); ?>
            <?php if (have_posts()) : ?>
            <?php while (have_posts()) : the_post(); /* ループ開始 */ ?>
<li>
<figure>
<a href="<?php the_permalink(); ?>">
   <?php if (has_post_thumbnail()) : ?>
<?php
  $post_title = get_the_title();
  the_post_thumbnail('full',array('alt' => $post_title,));
?>
    <?php else : ?>
<img src="https://ok-berlin.life/wp-content/uploads/berlin_noimg.jpg" alt="ベルリン施設画像">
    <?php endif ; ?>
</a>
</figure>
<figcaption>
<h3><?php the_field('post_title_deutsu'); ?><span><?php the_title(); ?></span></h3>
<address><?php echo get_the_term_list($post->ID, 'trade_area'); ?></address>
<ul class="list_facility_genre"><?php echo get_the_term_list($post->ID,'trade_genre'); ?></ul>
</figcaption>
</li>
<?php endwhile; else: ?>
<p><?php echo "お探しの記事、ページは見つかりませんでした。"; ?></p>
<?php endif; ?>
</ul>
<?php echo do_shortcode('[myphp06 file="trade_register"]'); ?>
</div>
<?php
get_sidebar(); ?>
</div>
</main><!-- #main -->



<?php
get_footer();
