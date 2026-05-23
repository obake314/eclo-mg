<?php get_header(); ?>
<article id="post-<?php the_ID(); ?>" <?php post_class('page-content'); ?>>
	<div class="entry-content">
		<?php
		the_content();
		?>
	</div>
</div>
</article>
<?php get_footer(); ?>