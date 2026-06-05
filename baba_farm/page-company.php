<?php
/*
Template Name: 企業案内
 */

get_header();
?>
<main id="primary" class="site-main">
<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
	<div class="entry-header">
	<div class="entry-title">
		<p><?php the_field('page_headline'); ?></p>
		<h1><?php the_title(); ?></h1>
	</div>
	</div><!-- .entry-header -->
	<div class="entry-content">
		<?php
		the_content();
		?>
	</div><!-- .entry-content -->
</article>
</main><!-- #main -->
<?php
get_footer();