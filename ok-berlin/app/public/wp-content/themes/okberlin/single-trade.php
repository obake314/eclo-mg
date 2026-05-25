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
<div class="flexbox trade-post-header">
<figcaption>
<?php the_title( '<h2 class="entry-title">', '</h2>' );?>	
<time><small><svg xmlns="http://www.w3.org/2000/svg" width="1em" height="1em" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" aria-hidden="true"><rect x="3" y="4" width="18" height="18" rx="2"/><line x1="16" y1="2" x2="16" y2="6"/><line x1="8" y1="2" x2="8" y2="6"/><line x1="3" y1="10" x2="21" y2="10"/></svg></small><?php echo get_the_date('j.n.Y'); ?></time>
<div><svg xmlns="http://www.w3.org/2000/svg" width="1em" height="1em" viewBox="0 0 24 24" fill="currentColor" aria-hidden="true"><path d="M20 7H4a2 2 0 0 0-2 2v10a2 2 0 0 0 2 2h16a2 2 0 0 0 2-2V9a2 2 0 0 0-2-2z"/><path d="M16 7V5a2 2 0 0 0-2-2h-4a2 2 0 0 0-2 2v2"/></svg><?php echo get_the_term_list($post->ID, 'trade_genre'); ?></div>
<p><small><svg xmlns="http://www.w3.org/2000/svg" width="1em" height="1em" viewBox="0 0 24 24" fill="currentColor" aria-hidden="true"><path d="M12 2C8.13 2 5 5.13 5 9c0 5.25 7 13 7 13s7-7.75 7-13c0-3.87-3.13-7-7-7zm0 9.5c-1.38 0-2.5-1.12-2.5-2.5s1.12-2.5 2.5-2.5 2.5 1.12 2.5 2.5-1.12 2.5-2.5 2.5z"/></svg></small><?php echo get_the_term_list($post->ID, 'trade_area'); ?></p>
<p><small>€</small><?php the_field('price'); ?></p>
</figcaption>
<figure>
<?php
  $post_title = get_the_title();
  the_post_thumbnail('full',array('alt' => $post_title,));
?>
</figure>
</div>
<div class="entry-content">
<?php the_content(); ?>

<div class="trade_info flexbox">
<div class="product_info flexbox">
<figure>
<?php
  $post_title = get_the_title();
  the_post_thumbnail('full',array('alt' => $post_title,));
?>
</figure>
<figcaption>
<small>投稿ID:<?php the_ID(); ?></small>
<?php the_title( '<h2 class="entry-title">', '</h2>' );?>	
<p class="trade_spot"><svg xmlns="http://www.w3.org/2000/svg" width="1em" height="1em" viewBox="0 0 24 24" fill="currentColor" aria-hidden="true"><path d="M12 2C8.13 2 5 5.13 5 9c0 5.25 7 13 7 13s7-7.75 7-13c0-3.87-3.13-7-7-7zm0 9.5c-1.38 0-2.5-1.12-2.5-2.5s1.12-2.5 2.5-2.5 2.5 1.12 2.5 2.5-1.12 2.5-2.5 2.5z"/></svg><?php echo get_the_term_list($post->ID, 'trade_area'); ?></p>
<p class="">€<?php the_field('price'); ?></p>
</figcaption>
</div>

<div class="user_info">
<figcaption>
<?php 
$ID = $post->post_author;
?>
<h3><?php
echo get_the_author_meta('user_login',$ID);//　ユーザー名
?></h3>
</figcaption>
<p class="btn"><a href="mailto:<?php echo get_the_author_meta( 'user_email',$ID); ?>">このユーザーに連絡する</a></p>
</div>
</div>
	</div><!-- .entry-content -->
	<?php echo do_shortcode('[myphp06 file="trade_register"]'); ?>

	<div class="entry-footer">
	<h2 class="title-section title-section-center">Kategorie<span>取引カテゴリー</span></h2>
		<?php echo do_shortcode('[myphp file="tradecategory"]'); ?>
	</div><!-- .entry-footer -->
		<div class="entry-footer">
	<h2 class="title-section title-section-center">Bereich<span>取引エリア</span></h2>
		<?php echo do_shortcode('[myphp02 file="tradearea"]'); ?>
	</div><!-- .entry-footer -->
</article>
</div>
<?php get_sidebar(); ?>
</div>
	</main><!-- #main -->
<?php get_footer(); ?>
