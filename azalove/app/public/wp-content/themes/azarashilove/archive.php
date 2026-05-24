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

<div class="entry-header">
	<div class="wrap wrap-post_archive">
	<h1 class="entry-title"><span><?php
  $cat = get_the_category();
  $cat = $cat[0];
  echo $cat->slug;
?>
</span><?php the_archive_title(); ?></h1>
<div class="page-header">
	<?php
	the_archive_description();
	?>
</div><!-- .page-header -->	
				
</div>
</div>			

<div class="flexbox wrap site-main-wrap">
	<main id="primary" class="site-main site-left" role="main">
<ul class="list_post">
<?php if(have_posts()):?>
<?php while(have_posts()):the_post();?>
<li><a class="flexbox" href="<?php the_permalink() ?>">
<figure><?php
$thumb_html = get_the_post_thumbnail( get_the_ID(), 'full', [
	$alt = get_the_title() . 'のサムネイル',
	'loading' => 'lazy',
] );
$thumb_html = preg_replace(
	'/\s+alt=("|\')[^"\']*\1/',
	' alt=""',
	$thumb_html
);
echo $thumb_html;
?></figure>
<figcaption>
<h2><?php the_title(); ?></h2>
<time><?php the_time('Y/m/d') ?></time>
<div class="excerpt"><?php echo mb_substr( get_the_excerpt(), 0, 250 ) . ''; ?></div>
</figcaption>
</a>
</li>
	<?php endwhile;?>
</ul>
		<div id="pager_navigation">
<?php posts_nav_link( '　', '<i class="fa fa-angle-left icon-left"></i>PREV', 'NEXT<i class="fa fa-angle-right icon-right"></i>' ); ?>
</div>
		<?php endif;?>
	</main><!-- #main -->
	<?php get_sidebar(); ?>
</div>

<?php
get_footer();
