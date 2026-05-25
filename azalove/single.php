<?php
/**
 * The template for displaying all single posts
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/#single-post
 *
 * @package azarashilove
 */

get_header();
?>

<div class="flexbox wrap site-main-wrap">
<main id="primary" class="site-main site-left" role="main">
<div class="page-header">
	<h1 class="page-title"><?php the_title(); ?></h1>
	<div class="entry-meta">
		<?php azarashilove_posted_on();?>
	</div>
</div>
<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>

	<div class="entry-content">
		<?php
		the_content(
			sprintf(
				wp_kses(
					/* translators: %s: Name of current post. Only visible to screen readers */
					__( 'Continue reading<span class="screen-reader-text"> "%s"</span>', 'azarashilove' ),
					array(
						'span' => array(
							'class' => array(),
						),
					)
				),
				wp_kses_post( get_the_title() )
			)
		);
		wp_link_pages(
			array(
				'before' => '<div class="page-links">' . esc_html__( 'Pages:', 'azarashilove' ),
				'after'  => '</div>',
			)
		);
		?>
	</div><!-- .entry-content -->

	<div class="entry-footer">
		<?php azarashilove_entry_footer(); ?>
	</div><!-- .entry-footer -->
</article><!-- #post-<?php the_ID(); ?> -->

		<?php
		while ( have_posts() ) :
			the_post();
			the_post_navigation(
				array(
					'prev_text' => '<span class="nav-subtitle">' . esc_html__( '前', 'azarashilove' ) . '</span> <span class="nav-title">%title</span>',
					'next_text' => '<span class="nav-title">%title</span><span class="nav-subtitle">' . esc_html__( '次', 'azarashilove' ) . '</span>',
				)
			);

		endwhile; // End of the loop.
		?>

	</main><!-- #main -->
	<?php get_sidebar(); ?>
</div>
<?php
get_footer();
