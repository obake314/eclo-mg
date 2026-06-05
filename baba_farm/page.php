<?php
/**
 * The template for displaying all pages
 *
 * @package baba_farm
 */

get_header();
?>
<main id="primary" class="site-main">
	<?php while ( have_posts() ) : the_post(); ?>
	<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
		<div class="entry-header">
		<div class="entry-title">
			<p><?php the_field( 'page_headline' ); ?></p>
			<h1><?php the_title(); ?></h1>
		</div>
		</div>

		<?php baba_farm_post_thumbnail(); ?>

		<div class="entry-content">
			<?php
			the_content();
			wp_link_pages( array(
				'before' => '<div class="page-links">' . esc_html__( 'Pages:', 'baba_farm' ),
				'after'  => '</div>',
			) );
			?>
		</div>
	</article>
	<?php endwhile; ?>
</main>

<?php get_footer();
