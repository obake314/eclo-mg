<?php
/**
 * The template for displaying search results pages
 *
 * @package baba_farm
 */

get_header();
?>
<main id="primary" class="site-main">

	<?php if ( have_posts() ) : ?>

		<header class="page-header">
			<h1 class="page-title">
				<?php printf( esc_html__( 'Search Results for: %s', 'baba_farm' ), '<span>' . get_search_query() . '</span>' ); ?>
			</h1>
		</header>

		<?php while ( have_posts() ) : the_post(); ?>
		<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
			<header class="entry-header">
				<?php the_title( sprintf( '<h2 class="entry-title"><a href="%s" rel="bookmark">', esc_url( get_permalink() ) ), '</a></h2>' ); ?>
				<?php if ( 'post' === get_post_type() ) : ?>
				<div class="entry-meta">
					<?php
					baba_farm_posted_on();
					baba_farm_posted_by();
					?>
				</div>
				<?php endif; ?>
			</header>

			<?php baba_farm_post_thumbnail(); ?>

			<div class="entry-summary">
				<?php the_excerpt(); ?>
			</div>

			<footer class="entry-footer">
				<?php baba_farm_entry_footer(); ?>
			</footer>
		</article>
		<?php endwhile; ?>

		<?php the_posts_navigation(); ?>

	<?php else : ?>

		<section class="no-results not-found">
			<header class="page-header">
				<h1 class="page-title"><?php esc_html_e( 'Nothing Found', 'baba_farm' ); ?></h1>
			</header>
			<div class="page-content">
				<?php if ( is_home() && current_user_can( 'publish_posts' ) ) : ?>
				<p><?php printf( wp_kses( __( 'Ready to publish your first post? <a href="%1$s">Get started here</a>.', 'baba_farm' ), array( 'a' => array( 'href' => array() ) ) ), esc_url( admin_url( 'post-new.php' ) ) ); ?></p>
				<?php else : ?>
				<p><?php esc_html_e( 'Sorry, but nothing matched your search terms. Please try again with some different keywords.', 'baba_farm' ); ?></p>
				<?php get_search_form(); ?>
				<?php endif; ?>
			</div>
		</section>

	<?php endif; ?>

</main>

<?php
get_sidebar();
get_footer();
