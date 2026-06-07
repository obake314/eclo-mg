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
	<p>INFORMATION</p>
	<h1>お知らせ</h1>
</div>
</div><!-- .page-header -->
<div class="flexbox container main_container">
<main class="main_left">
<ul class="list_news">
<?php
$paged     = get_query_var( 'paged' ) ? get_query_var( 'paged' ) : 1;
$cat_posts = get_posts( array(
	'post_type'      => 'post',
	'posts_per_page' => 20,
	'orderby'        => 'date',
	'order'          => 'DESC',
	'paged'          => $paged,
) );
global $post;
if ( $cat_posts ) : foreach ( $cat_posts as $post ) : setup_postdata( $post ); ?>
<li>
<a class="flexbox" href="<?php the_permalink(); ?>"></a>
<figure>
<?php if ( has_post_thumbnail() ) : ?>
	<?php the_post_thumbnail( 'full' ); ?>
<?php endif; ?>
</figure>
<figcaption>
<h2 class="post-title"><?php the_title(); ?></h2>
<div class="meta">
<?php
$categories = get_the_category();
if ( ! empty( $categories ) ) : ?>
<ul class="meta_cat">
<?php foreach ( $categories as $cat ) : ?>
<li><?php echo esc_html( $cat->name ); ?></li>
<?php endforeach; ?>
</ul>
<?php endif; ?>
<time class="meta_date"><?php the_time( 'Y/m/d' ); ?></time>
</div>
<p><?php echo get_the_excerpt(); ?></p>
</figcaption>
</li>
<?php endforeach; endif; ?>
</ul>
<div class="pagenation">
<?php
global $wp_query;
echo paginate_links( array(
	'total'     => $wp_query->max_num_pages,
	'current'   => $paged,
	'type'      => 'list',
	'prev_text' => '«',
	'next_text' => '»',
) );
?>
</div>
<?php wp_reset_postdata(); ?>
</main>

<?php get_sidebar(); ?>
</div>
<?php get_footer(); ?>
