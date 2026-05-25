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
<div class="main_left main_full">
<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
	<header class="entry-header">
		<?php
			echo '<div class="entry-title"><p>Interview</p><h1>' . get_the_title() . '</h1></div>';
			?>
			<div class="entry-meta interview-meta">
				INTERVIEW<?php the_field('interview_number'); ?> - <span><?php the_field('interview_name'); ?></span>
			</div><!-- .entry-meta -->
	</header><!-- .entry-header -->
	
	<div class="entry-content">
		<?php
		the_content(
		);
		?>
	</div><!-- .entry-content -->
<section class="sec_news_pickup area_interview">
<div class="title-section"><p>Interview</p><h2>ベルリン在住者インタビュー</h2></div>
<ul class="list_post_pickup">
<?php
$cat_posts = okberlin_get_posts(array(
    'post_type'      => 'interview',
    'posts_per_page' => 4,
    'orderby'        => 'date',
    'order'          => 'DESC',
));
global $post;
if($cat_posts): foreach($cat_posts as $post): setup_postdata($post); ?>
<li class="image"><a href="<?php the_permalink(); ?>">
<figure><?php
  $post_title = get_the_title();
  the_post_thumbnail('full',array('alt' => $post_title,));
?></figure>
<figcaption>
<h3><?php the_title(); ?></h3>
<time><?php the_field("interview_name"); ?></time>
</figcaption>
</a></li>
<?php endforeach; endif; wp_reset_postdata(); ?>
</ul>
</section>
	<div class="entry-footer">
		<?php okberlin_entry_footer(); ?>
	</div><!-- .entry-footer -->
</article><!-- #post-<?php the_ID(); ?> -->
</div>
<div class="interview_footer">
<?php get_sidebar(); ?>
</div>
</div>
	</main><!-- #main -->
<?php
get_footer();
