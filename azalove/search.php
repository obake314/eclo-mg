<?php
/**
 * The template for displaying search results pages
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/#search-result
 *
 * @package azarashilove
 */

get_header();
?>

<main id="primary" class="site-main" role="main">
		<?php if ( have_posts() ) : ?>

			<header class="page-header">
				<h1 class="page-title">
					<?php
					printf( esc_html__( 'Search Results for: %s', 'azarashilove' ), '<span>' . get_search_query() . '</span>' );
					?>
				</h1>
			</header><!-- .page-header -->

			<?php
			/* Start the Loop */
			while ( have_posts() ) :
				the_post();

				?>
			<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
				<header class="entry-header">
					<?php the_title( sprintf( '<h2 class="entry-title"><a href="%s" rel="bookmark">', esc_url( get_permalink() ) ), '</a></h2>' ); ?>
					<?php if ( 'post' === get_post_type() ) : ?>
					<div class="entry-meta">
						<?php
						azarashilove_posted_on();
						azarashilove_posted_by();
						?>
					</div>
					<?php endif; ?>
				</header>
				<?php azarashilove_post_thumbnail(); ?>
				<div class="entry-summary">
					<?php the_excerpt(); ?>
				</div>
				<footer class="entry-footer">
					<?php azarashilove_entry_footer(); ?>
				</footer>
			</article>
			<?php

			endwhile;

			the_posts_navigation();

		else :
			?>
			<section class="no-results not-found">
				<header class="page-header">
					<h1 class="page-title"><?php esc_html_e( 'Nothing Found', 'azarashilove' ); ?></h1>
				</header>
				<div class="page-content">
					<p><?php esc_html_e( 'Sorry, but nothing matched your search terms. Please try again with some different keywords.', 'azarashilove' ); ?></p>
					<?php get_search_form(); ?>
				</div>
			</section>
			<?php

		endif;
		?>

	</main><!-- #main -->

<?php
get_sidebar();
get_footer();
