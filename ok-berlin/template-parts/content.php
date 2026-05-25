<?php
/**
 * Template part for displaying posts
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/
 *
 * @package okberlin
 */

?>

<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
	<header class="entry-header">
		<?php
		$en = function_exists( 'get_field' ) ? get_field( 'headline_label' ) : '';
		if ( ! $en ) {
			$cats = get_the_category();
			$en   = $cats ? esc_html( $cats[0]->name ) : '';
		}
		if ( is_singular() ) :
			echo '<div class="entry-title"><p>' . esc_html( $en ) . '</p><h1>' . get_the_title() . '</h1></div>';
		else :
			echo '<div class="entry-title"><p>' . esc_html( $en ) . '</p><h2><a href="' . esc_url( get_permalink() ) . '" rel="bookmark">' . get_the_title() . '</a></h2></div>';
		endif;

		if ( 'post' === get_post_type() ) :
			?>
			<div class="entry-meta">
				<time>公開日:<?php the_time('m.d.Y');?> / 最終更新日:<?php the_modified_date('m.d.Y') ?></time>
			</div><!-- .entry-meta -->
		<?php endif; ?>
	</header><!-- .entry-header -->
	<div class="entry-content">
		<?php
		the_content(
			sprintf(
				wp_kses(
					/* translators: %s: Name of current post. Only visible to screen readers */
					__( 'Continue reading<span class="screen-reader-text"> "%s"</span>', 'okberlin' ),
					array(
						'span' => array(
							'class' => array(),
						),
					)
				),
				wp_kses_post( get_the_title() )
			)
		);

		wp_link_pages(
			array(
				'before' => '<div class="page-links">' . esc_html__( 'Pages:', 'okberlin' ),
				'after'  => '</div>',
			)
		);
		?>
	</div><!-- .entry-content -->

	<div class="entry-footer">
		<?php okberlin_entry_footer(); ?>
	</div><!-- .entry-footer -->
</article><!-- #post-<?php the_ID(); ?> -->
