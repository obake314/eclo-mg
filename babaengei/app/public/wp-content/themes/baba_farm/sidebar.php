<?php
/**
 * The sidebar containing the main widget area
 *
 * @link https://developer.wordpress.org/themes/basics/template-files/#template-partials
 *
 * @package baba_farm
 */

if ( ! is_active_sidebar( 'sidebar-1' ) ) {
	return;
}
?>

<aside id="secondary" class="widget-area">
<div class="sidebar_about">
  <p class="sidebar_about__logo"><img src="<?php echo esc_url( home_url( '/' ) ); ?>wp-content/uploads/footer_logo.svg" alt="三右エ門"></p>
  <p class="sidebar_about__text">岩手県二戸市の農業生産法人・株式会社馬場園芸が運営する直販サイトです。ホワイトアスパラガス「白い果実」、三右エ門栗かぼちゃ、お米「きらほ」をお届けしています。</p>
</div>
<ul class="banner">
	<?php
		$custom_posts = get_posts(array(
			'post_type' => 'banner',
			'posts_per_page' => 3,
			'tax_query' => array(
			array(
				'taxonomy' => 'area_banner',
				'field' => 'slug',
				'terms' => 'vis_banner'
				)
			)
		));
	global $post;
	if($custom_posts): foreach($custom_posts as $post): setup_postdata($post); ?>
<li class="sec_post_img"><a href="<?php the_field('banner_link'); ?>"><img src="<?php the_field('banner_img'); ?>" alt="<?php the_title(); ?>"></a></li>
<?php endforeach; wp_reset_postdata(); endif; ?>
</ul>
	<?php dynamic_sidebar( 'sidebar-1' ); ?>
</aside><!-- #secondary -->
