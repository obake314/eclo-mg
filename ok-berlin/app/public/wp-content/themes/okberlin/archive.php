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
	<div class="wrap flexbox">
<div class="main_left">
		<?php if ( have_posts() ) : ?>
		<div class="page-title">
		<?php
		  $category = get_the_category();
		  $cat_id   = $category[0]->cat_ID;
		  $cat_name = $category[0]->cat_name;
		  $cat_slug = $category[0]->category_nicename;
		?>
		<div class="title-section"><p><?php echo $cat_slug; ?></p><h2>ベルリン<?php the_archive_title(); ?></h2></div>
		</div>
<ul class="list_post">
			
				<?php
$paged = get_query_var('paged') ? get_query_var('paged') : 1 ;
$cat_posts = okberlin_get_posts(array(
    'post_type'      => 'post',
    'posts_per_page' => 20,
    'orderby'        => 'date',
    'order'          => 'DESC',
    'paged'          => $paged,
));
global $post;
if($cat_posts): foreach($cat_posts as $post): setup_postdata($post); ?>

						<li>
							<a class="flexbox" href="<?php the_permalink() ?>">
							<figure>
								<?php if(has_post_thumbnail()) : ?>
								<?php
  $post_title = get_the_title();
  the_post_thumbnail('full',array('alt' => $post_title,));
?>
								<?php else: ?>
								<img src="<?php echo esc_url( home_url('/') ); ?>wp-content/uploads/cropped-ogp.jpg" alt="<?php the_title(); ?>">
								<?php endif; ?>
							</figure>
							<figcaption>
								<h3><?php the_title(); ?></h3>
								<p class="post_meta"><time><?php the_time('d.m.Y') ?></time></p>
							</figcaption>
								</a>					
						</li>

<?php endforeach; endif; wp_reset_postdata(); ?>

<?php the_posts_pagination(
    array(
        'mid_size'      => 2, // 現在ページの左右に表示するページ番号の数
        'prev_next'     => true, // 「前へ」「次へ」のリンクを表示する場合はtrue
        'prev_text'     => __( '前へ'), // 「前へ」リンクのテキスト
        'next_text'     => __( '次へ'), // 「次へ」リンクのテキスト
        'type'          => 'list', // 戻り値の指定 (plain/list)
    )
); ?>

		<?php 

		else :

			get_template_part( 'template-parts/content', 'none' );

		endif;
		?>
</ul>
</div>
<?php get_sidebar(); ?>
	</div>
	</main><!-- #main -->

<?php get_footer(); ?>
