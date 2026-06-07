<?php
/**
 * The main template file (fallback)
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/
 *
 * @package baba_farm
 */

get_header();
?>

<div id="primary" class="site-main">
	<div class="main_container container">
		<?php if ( have_posts() ) : ?>
			<ul class="list_news">
				<?php while ( have_posts() ) : the_post(); ?>
					<li class="flexbox">
						<?php if ( has_post_thumbnail() ) : ?>
							<figure><a href="<?php the_permalink(); ?>"><?php the_post_thumbnail( 'medium' ); ?></a></figure>
						<?php endif; ?>
						<figcaption>
							<span class="date"><?php the_time( 'Y.m.d' ); ?></span>
							<span class="cat"><?php the_category( ' ' ); ?></span>
							<h2><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h2>
						</figcaption>
					</li>
				<?php endwhile; ?>
			</ul>
			<?php the_posts_pagination(); ?>
		<?php else : ?>
			<p>記事が見つかりませんでした。</p>
		<?php endif; ?>
	</div>
</div>

<?php get_footer(); ?>
