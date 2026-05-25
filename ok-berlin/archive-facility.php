<?php
/**
 * The template for displaying archive pages
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/
 *
 * @package okberlin
 */

get_header();
?>

<main id="primary" class="site-main">
<div class="flexbox wrap">
<div class="main_left">


<div class="page-title">
	<h1 class="title-section">Einrichtungen<span>スポット情報</span></h1>
</div>
<div class="facility-top">
<?php echo do_shortcode('[myphp04 file="facilityarea"]'); ?>
<?php echo do_shortcode('[myphp03 file="facilitycategory"]'); ?>
</div>
<ul class="flexbox list_facility">
<?php
$custom_posts = okberlin_get_posts(array(
    'post_type'      => 'facility',
    'posts_per_page' => -1,
    'orderby'        => 'date',
    'order'          => 'DESC',
));
global $post;
if($custom_posts): foreach($custom_posts as $post): setup_postdata($post); ?>
<li>
<figure>
<a href="<?php the_permalink(); ?>">
   <?php if (has_post_thumbnail()) : ?>
<?php
  $post_title = get_the_title();
  the_post_thumbnail('full',array('alt' => $post_title,));
?>
    <?php else : ?>
<img src="https://ok-berlin.life/wp-content/uploads/berlin_noimg.jpg" alt="ベルリン施設画像">
    <?php endif ; ?>
</a>
</figure>
<figcaption>
<h3><?php the_field('post_title_deutsu'); ?><span><?php the_title(); ?></span></h3>
<address><?php echo get_the_term_list($post->ID, 'prefectures'); ?></address>
<ul class="list_facility_genre">
<?php echo get_the_term_list($post->ID,'genre'); ?>
</ul>
<p><?php echo mb_substr(get_the_excerpt(), 0, 200); ?></p>
</figcaption>
</li>
<?php endforeach; wp_reset_postdata(); endif; ?>
</ul>
</div>
<?php
get_sidebar(); ?>
</div>
</main><!-- #main -->



<?php
get_footer();
