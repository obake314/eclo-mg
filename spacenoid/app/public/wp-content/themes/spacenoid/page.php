<?php get_header(); ?>
<div class="section_content">
<section class="page-header" data-page-title="<?php echo esc_attr(function_exists('spacenoid_get_page_header_label') ? spacenoid_get_page_header_label() : get_the_title()); ?>">
	<h1 class="page-title" data-display-title="<?php echo esc_attr(get_the_title()); ?>"><?php the_title(); ?></h1>
</section>
<article id="post-<?php the_ID(); ?>" <?php post_class('page-content'); ?>>
	<div class="entry-content">
		<?php
		the_content();
		?>
	</div>
</article>
<?php if (function_exists('spacenoid_member_fanmail_notice') && is_page('members')) : ?>
	<?php spacenoid_member_fanmail_notice(); ?>
<?php endif; ?>
</div>

<?php get_footer(); ?>
