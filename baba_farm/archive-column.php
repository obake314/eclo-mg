<?php
/**
 * The template for displaying archive pages
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/
 *
 * @package baba_farm
 */

get_header();
?>
<div class="page-header">
<div class="entry-title">
	<p>COLUMN</p>
	<h1>馬場園芸コラム</h1>
</div>
</div><!-- .page-header -->
<div class="flexbox container main_container">			
<main class="main_left">
<ul class="list_news list_news_column ">
<?php
$paged = get_query_var('paged') ? get_query_var('paged') : 1; //pagedの設定
$cat_posts = get_posts(array(
	'post_type' => 'column',// 投稿タイプを指定
    'posts_per_page' => 20, // 表示件数
    'orderby' => 'date', // 表示順の基準
    'order' => 'DESC', // 昇順・降順
	'paged' => $paged

));
global $post;
if($cat_posts): foreach($cat_posts as $post): setup_postdata($post); ?>
<li>
<a class="flexbox" href="<?php the_permalink() ?>"></a>
<figure>
<?php if ( has_post_thumbnail() ) : ?>
    <?php the_post_thumbnail('full'); ?>
<?php else : ?>
<?php endif; ?>
</figure>
<!-- ループはじめ -->
<figcaption>
<h2 class="post-title"><?php the_title(); ?></h2>
<div class="meta">
<?php
$terms = get_the_terms( get_the_ID(), 'column_cat' );
if ( !empty($terms) ) : if ( !is_wp_error($terms) ) :
?>

<ul class="meta_cat">
<?php foreach( $terms as $term ) : ?>
<li><?php echo $term->name; ?></li>
<?php endforeach; ?>
</ul>
<?php endif; endif; ?>

<time class="meta_date"><?php the_time('Y/m/d') ?></time>
</div>
<p><?php echo get_the_excerpt(); ?></p>
</figcaption>

</li>
<?php endforeach; endif; ?>
</ul>
<div class="pagenation">
<?php echo paginate_links( array ( 'type' => 'list',
	'prev_text' => '«',
	'next_text' => '»'
)); ?>
</div>
<?php wp_reset_postdata(); ?>
	</main>

<?php get_sidebar(); ?>
</div>
<?php get_footer(); ?>