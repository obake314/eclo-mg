<?php
/**
 * The template for displaying search results pages
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/#search-result
 *
 * @package okberlin
 */

get_header();
?>
<main id="primary" class="site-main">
<div class="flexbox wrap">
<div class="main_left">
	<div class="page-title">
	<div class="title-section">
	<p>Suchergebnisse</p>
	<h2><?php printf( esc_html__( '検索結果 %s', 'okberlin' ), '' . get_search_query() . '' ); ?></h2>
	</div>
	</div>
	<ul class="list_post">
            <?php 
			if (have_posts()) :
			while ( have_posts() ) :
				the_post();

				/**
				 * Run the loop for the search to output the results.
				 * If you want to overload this in a child theme then include a file
				 * called content-search.php and that will be used instead.
				 */
				get_template_part( 'template-parts/content', 'search' );

			endwhile;

			the_posts_navigation();

		else :

			get_template_part( 'template-parts/content', 'none' );

		endif;
		?>
</ul>
</div>
<?php get_sidebar(); ?>
</div>
	</main><!-- #main -->
<?php
get_footer();
