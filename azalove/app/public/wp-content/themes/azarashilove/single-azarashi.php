<?php
/**
 * The template for displaying all single posts
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/#single-post
 *
 * @package azarashilove
 */

get_header();
?>

<main id="primary" class="site-main" role="main">
	<div class="wrap">
	<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
<div class="flexbox facility-post-header">
<figcaption>
		<?php
		if ( is_singular() ) :
			the_title( '<h1 class="entry-title">', '</h1>' );
		else :
			the_title( '<h2 class="entry-title"><a href="' . esc_url( get_permalink() ) . '" rel="bookmark">', '</a></h2>' );
		endif;
		if ( 'post' === get_post_type() ) :
			?>	
		<?php endif; ?>
<dl class="facility-data flexbox">
<?php if(get_field('az_birthday')): ?><dt>生年月日</dt><dd><?php the_field('az_birthday'); ?></dd><?php endif; ?>
<?php if(get_field('az_sex')): ?><dt>性別</dt><dd><?php the_field('az_sex'); ?></dd><?php endif; ?>
<?php if(get_field('prefectures')): ?><dt>都道府県</dt><dd><?php the_field('prefectures'); ?></dd><?php endif; ?>
</dl>
<ul class="url_facility flexbox">
<?php if(get_field('url')): ?><li><a target="_blank" href="<?php the_field('url'); ?>">紹介ページ</a></li><?php endif; ?>
</ul>
	</figcaption>
<figure>
	<?php azarashilove_post_thumbnail(); ?>
	<p class="inyo">画像引用元:<a href="<?php the_field('references_url'); ?>"><?php the_field('references_name'); ?></a></p>
</figure>
</div>
<div class="entry-content">
		<?php
		the_content(
			sprintf(
				wp_kses(
					/* translators: %s: Name of current post. Only visible to screen readers */
					__( 'Continue reading<span class="screen-reader-text"> "%s"</span>', 'azarashilove' ),
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
				'before' => '<div class="page-links">' . esc_html__( 'Pages:', 'azarashilove' ),
				'after'  => '</div>',
			)
		);
		?>
	</div><!-- .entry-content -->

	<div class="entry-footer">
		<?php azarashilove_entry_footer(); ?>
	</div><!-- .entry-footer -->
</article>
</div>
	</main><!-- #main -->

<?php
get_footer();
