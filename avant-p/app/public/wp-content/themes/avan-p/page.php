<?php get_header(); ?>

<main class="site-main">
	<div class="entry-header">
	<div class="container">
	<h1 class="page-title"><?php wp_title(''); ?></h1>
	</div>
	</div>
<div class="container entry-container">
<?php the_content();?>
	</div>
</main>
<?php get_footer(); ?>