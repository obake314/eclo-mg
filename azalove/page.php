<?php
/**
 * The template for displaying all pages
 *
 * This is the template that displays all pages by default.
 * Please note that this is the WordPress construct of pages
 * and that other 'pages' on your WordPress site may use a
 * different template.
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/
 *
 * @package azarashilove
 */

get_header();
?>
<div class="entry-header">
	<h1 class="entry-title"><span><?php the_field("headline_label"); ?></span><?php the_title(); ?></h1>
</div>	

<main id="main-content primary" class="site-main">
<div class="wrap">
<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
<?php
$current_id = get_the_ID();
$parent     = get_page_by_path('species'); 
$parent_id  = $parent ? $parent->ID : 0;
if ( wp_get_post_parent_id($current_id) === $parent_id ) : ?>
	
<section class="flexbox facility-post-header">
<figcaption>
<h1><?php the_title(); ?></h1>
   <div class="azarashi-meta">
    英名：<?php the_field("azarashi_english"); ?><br>
    学名：<?php the_field("azarashi_scientific"); ?><br>
    生息地域：<?php the_field("azarashi_location_text"); ?><br>
  </div>
 </figcaption>
<figure>
	<?php azarashilove_post_thumbnail(); ?>
	<?php if(has_post_thumbnail()) : ?><p class="inyo">画像引用元:<a href="<?php the_field('references_url'); ?>"><?php the_field('references_name'); ?></a></p><?php endif; ?>
</figure>
	</section>
<?php endif; ?>
		<?php
		while ( have_posts() ) :
			the_post(); ?>

<div id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
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
	</div><!-- .entry-footer -->


		<?php endwhile; // End of the loop.
		?>

</article>
</div>
</main><!-- #main -->

<?php
get_footer();
