<?php
/**
 * The template for displaying all single posts
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/#single-post
 *
 * @package okberlin
 */

get_header();
?>
<main id="primary" class="site-main">
<div class="flexbox wrap">
<div class="main_left">

		<?php
		while ( have_posts() ) :
			the_post();

			get_template_part( 'template-parts/content', get_post_type() );

			the_post_navigation(
				array(
					'prev_text' => '<span class="nav-subtitle">&#10094;</span> <span class="nav-title">%title</span>',
					'next_text' => '<span class="nav-subtitle"></span> <span class="nav-title">%title &#10095;</span>',
				)
			);


		endwhile; // End of the loop.
		?>
</div>
<?php get_sidebar(); ?>
</div>
	</main><!-- #main -->
<?php
get_footer();
