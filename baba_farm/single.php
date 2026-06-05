<?php
/**
 * The template for displaying all single posts
 *
 * @package baba_farm
 */

get_header();
?>
<div id="primary" class="site-main">
<div class="entry-header">
<div class="entry-title">
	<?php if ( get_queried_object()->post_type === 'column' ) : ?>
	<p>COLUMN</p>
	<h1> 馬場園芸コラム</h1>
	<?php else : ?>
	<p>INFORMATION</p>
	<h1> お知らせ</h1>
	<?php endif; ?>
</div>
</div>
<div class="flexbox container main_container">
<main class="main_left">
	<?php
	while ( have_posts() ) :
		the_post();
		?>
		<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
			<header class="entry-header">
				<?php the_title( '<h1 class="entry-title">', '</h1>' ); ?>
				<?php if ( 'post' === get_post_type() ) : ?>
				<div class="entry-meta">
					<?php
					$category = get_the_category();
					echo esc_html( $category[0]->cat_name );
					?>
					<time class="meta_date"><?php the_time( 'Y/m/d' ); ?></time>
				</div>
				<?php endif; ?>
			</header>
			<div class="entry-content">
				<?php
				the_content(
					sprintf(
						wp_kses(
							__( 'Continue reading<span class="screen-reader-text"> "%s"</span>', 'baba_farm' ),
							array( 'span' => array( 'class' => array() ) )
						),
						wp_kses_post( get_the_title() )
					)
				);
				wp_link_pages( array(
					'before' => '<div class="page-links">' . esc_html__( 'Pages:', 'baba_farm' ),
					'after'  => '</div>',
				) );
				?>
			</div>
			<footer class="entry-footer">
				<?php baba_farm_entry_footer(); ?>
			</footer>
		</article>
		<?php
		the_post_navigation( array(
			'prev_text' => '<span class="nav-subtitle">' . esc_html__( '前', 'baba_farm' ) . '</span> <span class="nav-title">%title</span>',
			'next_text' => '<span class="nav-subtitle">' . esc_html__( '次', 'baba_farm' ) . '</span> <span class="nav-title">%title</span>',
		) );
	endwhile;
	?>
</main>
<?php get_sidebar(); ?>
</div>
</div>

<?php get_footer();
