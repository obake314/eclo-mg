<?php
/**
 * The template for displaying archive pages
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/
 *
 * @package azarashilove
 */

get_header();
?>
<main id="primary" class="site-main main_facility" role="main">
<div class="wrap">
<h3 class="title-section-azarashi">全国の水族館にいるあざらし一覧</h3>
<ul class="list_facility">
<?php
$custom_posts = get_posts(array(
    'post_type' => 'azarashi', // 投稿タイプ
    'posts_per_page' => -1, // 表示件数
    'orderby' => 'date', // 表示順の基準
    'order' => 'DESC', // 昇順・降順

));
global $post;
if($custom_posts): foreach($custom_posts as $post): setup_postdata($post); ?>
<li>
<figure>
<a href="<?php the_permalink(); ?>">
   <?php if (has_post_thumbnail()) : ?>
<?php the_post_thumbnail('full'); ?>
    <?php else : ?>
<img src="https://azarashi.love/wp-content/uploads/azarashi_noimg.jpg">
    <?php endif ; ?>
</a>
</figure>
<figcaption>
<h3><?php the_title(); ?></h3>
<p class="list_facility_azarashi azarashi_genus"><?php echo get_the_term_list($post->ID, 'genus'); ?></p>
<p class="azarashi_place"><?php $terms = get_the_terms($post->ID, 'fc_facility'); if ( $terms ) { echo $terms[0]->name;} ?></p>
</figcaption>
</li>
<?php endforeach; wp_reset_postdata(); endif; ?>
</ul>
</div>
	</main><!-- #main -->
<?php
get_footer();
