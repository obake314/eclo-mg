<?php
/**
 * The sidebar containing the main widget area
 *
 * @link https://developer.wordpress.org/themes/basics/template-files/#template-partials
 *
 * @package baba_farm
 */

?>

<aside id="secondary" class="widget-area">
<section class="sidebar_archive sidebar_about">
	<div class="headline sidebar_headline">
		<p>ABOUT</p>
		<h2>このサイトについて</h2>
	</div>
  <p class="sidebar_about__logo"><img src="<?php echo esc_url( home_url( '/' ) ); ?>wp-content/uploads/logo-1.svg" alt="三右エ門ロゴ"></p>
  <p class="sidebar_about__text">岩手県二戸市の農業生産法人・株式会社馬場園芸が運営する直販サイトです。ホワイトアスパラガス「白い果実」、三右エ門栗かぼちゃ、お米「きらほ」をお届けしています。</p>
</section>
<section class="sidebar_archive">
	<div class="headline sidebar_headline">
		<p>PRODUCTS</p>
		<h2>商品情報</h2>
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
</section>
<section class="sidebar_archive">
	<div class="headline sidebar_headline">
		<p>NEWS</p>
		<h2>お知らせ記事</h2>
	</div>
	<ul class="list_infomation sidebar_archive__list">
		<?php
		$recent_posts = get_posts(
			array(
				'post_type'      => 'post',
				'posts_per_page' => 5,
				'post_status'    => 'publish',
			)
		);

		if ( $recent_posts ) :
			foreach ( $recent_posts as $recent_post ) :
				?>
				<li>
					<time class="meta_date" datetime="<?php echo esc_attr( get_the_date( 'c', $recent_post ) ); ?>"><?php echo esc_html( get_the_date( 'Y/m/d', $recent_post ) ); ?></time>
					<a href="<?php echo esc_url( get_permalink( $recent_post ) ); ?>"><?php echo esc_html( get_the_title( $recent_post ) ); ?></a>
				</li>
				<?php
			endforeach;
		endif;
		?>
	</ul>
	<p class="btn sidebar_archive__more"><a href="<?php echo esc_url( home_url( '/archives/category/information' ) ); ?>">お知らせ一覧へ</a></p>
</section>
<section class="sidebar_archive">
	<div class="headline sidebar_headline">
		<p>COLUMN</p>
		<h2>コラム記事</h2>
	</div>
	<ul class="list_infomation sidebar_archive__list">
		<?php
		$recent_posts = get_posts(
			array(
				'post_type'      => 'column',
				'posts_per_page' => 5,
				'post_status'    => 'publish',
			)
		);

		if ( $recent_posts ) :
			foreach ( $recent_posts as $recent_post ) :
				?>
				<li>
					<time class="meta_date" datetime="<?php echo esc_attr( get_the_date( 'c', $recent_post ) ); ?>"><?php echo esc_html( get_the_date( 'Y/m/d', $recent_post ) ); ?></time>
					<a href="<?php echo esc_url( get_permalink( $recent_post ) ); ?>"><?php echo esc_html( get_the_title( $recent_post ) ); ?></a>
				</li>
				<?php
			endforeach;
		endif;
		?>
	</ul>
	<p class="btn sidebar_archive__more"><a href="<?php echo esc_url( home_url( '/archives/column' ) ); ?>">コラム一覧へ</a></p>
</section>
</aside><!-- #secondary -->
