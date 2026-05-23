<?php get_header(); ?>

<section class="page-header" data-page-title="<?php echo esc_attr(get_the_archive_title()); ?>">
	<h2 class="page-title" data-display-title="<?php echo esc_attr(get_the_archive_title()); ?>"><?php the_archive_name(); ?></h2>
	<?php if( get_field('english') ) { ?>
	<span><?php the_field('english'); ?></span>
	<?php } ?>
</section>

			<?php if ( have_posts() ) : ?>
				<?php while ( have_posts() ) : the_post(); 
					wp_dequeue_script( 'spacenoid-photostack' );

					get_template_part( 'inc/format/content', get_post_format() );

				endwhile; ?>
			<?php else : ?>

			<?php 
			wp_dequeue_script( 'spacenoid-photostack' );
			get_template_part( 'inc/format/content', 'no-result' ); ?>

			<?php endif; ?>

		</div><!-- wrapper -->

<?php weh_lite_content_nav( 'nav-loop' );?>
<?php get_footer(); ?>
