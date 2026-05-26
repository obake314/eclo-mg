<?php
/**
 * The template for displaying all single posts
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/#single-post
 *
 * @package okberlin
 */

get_header();
?>
<main id="primary" class="site-main">
<div class="flexbox wrap">
<div class="main_left">
<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
<div class="flexbox facility-post-header">
<figcaption>
<h2><?php the_field('post_title_deutsu'); ?><span><?php the_title(); ?></span></h2>
<dl class="facility-data flexbox">
<?php if(get_field('address')): ?><dt>住所</dt><dd><?php the_field('address'); ?></dd><?php endif; ?>
<?php if(get_field('tel')): ?><dt>電話番号</dt><dd><?php the_field('tel'); ?></dd><?php endif; ?>
<?php if(get_field('access')): ?><dt>アクセス</dt><dd><?php the_field('access'); ?></dd><?php endif; ?>
</dl>
<ul class="url_facility flexbox">
<?php if(get_field('url')): ?><li><a target="_blank" href="<?php the_field('url'); ?>">公式サイト</a></li><?php endif; ?>
<?php if(get_field('address')): ?><li><a target="_blank" href="https://www.google.com/maps/place/<?php the_field('address'); ?>">Google Map</a></li><?php endif; ?>
</ul>
</figcaption>
<figure>
	<?php
	  $post_title = get_the_title();
	  the_post_thumbnail('full',array('alt' => $post_title,));
	?>
	<?php if(get_field('references_name')): ?><p class="inyo">画像引用元:<a href="<?php the_field('references_url'); ?>"><?php the_field('references_name'); ?></a></p><?php endif; ?>
</figure>
</div>
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
<?php if(get_field('instagramfeed')): ?>
<div class="area_instagram">
<div class="title-section"><p>Intagram</p><h2>最新のハッシュタグフィード</h2></div>
<?php the_field('instagramfeed'); ?>
</div>
<?php endif; ?>
	<div class="entry-footer">
		<?php okberlin_entry_footer(); ?>
	</div><!-- .entry-footer -->
</article><!-- #post-<?php the_ID(); ?> -->
</div>
<?php get_sidebar(); ?>
</div>
	</main><!-- #main -->
<?php get_footer(); ?>
