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
	<h1> お知らせ</h1>
</div>
</div><!-- .page-header -->
<div class="container archive_container">
<main class="archive_main">
<ul class="list_news">
<?php
$paged     = get_query_var( 'paged' ) ? get_query_var( 'paged' ) : 1;
$the_query = new WP_Query(
	array(
		'posts_per_page' => 20,
		'orderby'        => 'date',
		'order'          => 'DESC',
		'paged'          => $paged,
	)
);
if ( $the_query->have_posts() ) :
	while ( $the_query->have_posts() ) :
		$the_query->the_post();
		$categories = get_the_category();
		$cat_names  = ! empty( $categories ) ? wp_list_pluck( $categories, 'name' ) : array();
		?>
<li>
	<a href="<?php the_permalink(); ?>"></a>
	<div class="meta">
		<time class="meta_date"><?php the_time( 'Y/m/d' ); ?></time>
		<p class="meta_cat"><?php echo esc_html( implode( ', ', $cat_names ) ); ?></p>
	</div>
	<h2 class="post-title"><?php the_title(); ?></h2>
</li>
		<?php
	endwhile;
endif;
wp_reset_postdata();
?>
</ul>
<div class="pagenation">
<?php
echo paginate_links(
	array(
		'total'     => $the_query->max_num_pages,
		'current'   => $paged,
		'type'      => 'list',
		'prev_text' => '«',
		'next_text' => '»',
	)
);
?>
</div>
</main>

<?php get_sidebar(); ?>

</div>
<!-- #main -->

<?php get_footer(); ?>
