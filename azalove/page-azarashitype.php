<?php
/*
Template Name: アザラシ種類ページ
*/
get_header();
?>
<main id="primary" class="site-main" role="main">
<div class="wrap">
<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
<?php
$current_id = get_the_ID();
$parent     = get_page_by_path('species'); 
$parent_id  = $parent ? $parent->ID : 0;
if ( wp_get_post_parent_id($current_id) === $parent_id ) : ?>
<div class="flexbox facility-post-header">
<div class="figcaption">
<h1><?php the_title(); ?></h1>
   <div class="azarashi-meta">
    英名：<?php the_field("azarashi_english"); ?><br>
    学名：<?php the_field("azarashi_scientific"); ?><br>
    生息地域：<?php the_field("azarashi_location_text"); ?><br>
  </div>
<figure><img src="<?php echo esc_url( azarashilove_illust_url( get_post_meta( get_the_ID(), 'azarashi_illust', true ) ) ); ?>"></figure>
 </div>
<figure>
	<?php azarashilove_post_thumbnail(); ?>
	<?php if(has_post_thumbnail()) : ?><p class="inyo">画像引用元:<a href="<?php the_field('references_url'); ?>"><?php the_field('references_name'); ?></a></p><?php endif; ?>
</figure>
</div>
<?php endif; ?>
		<?php
		while ( have_posts() ) :
			the_post();

			?>
			<div class="entry-content">
				<?php
				the_content();
				wp_link_pages(
					array(
						'before' => '<div class="page-links">' . esc_html__( 'Pages:', 'azarashilove' ),
						'after'  => '</div>',
					)
				);
				?>
			</div>
			<?php


		endwhile; // End of the loop.
		?>
		<p class="btn">
		<a href="https://azarashi.love/species">アザラシ一覧へ戻る
		</a>
		</p>


</article>
</div>
</main><!-- #main -->

<?php
get_footer();
