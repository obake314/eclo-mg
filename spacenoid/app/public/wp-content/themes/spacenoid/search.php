<?php get_header(); ?>

		<div id="content-wrapper" class="wrapper clearfix">



						<div class="post-title text-center search-title">
							<h2>
							  <?php esc_html_e( 'You searched for "', 'spacenoid' ); ?>
							  <?php echo esc_html( get_search_query( false ) ); ?>
							  <?php esc_html_e( '" Here are the results:', 'spacenoid' ); ?>
							</h2>
						</div>  


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