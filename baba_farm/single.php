<?php
/**
 * The template for displaying all single posts
 *
 * @package baba_farm
 */

get_header();
?>
<div class="page-header">
<div class="entry-title">
	<?php if ( get_queried_object()->post_type === 'column' ) : ?>
	<p>COLUMN</p>
	<p class="section-label">馬場園芸コラム</p>
	<?php else : ?>
	<p>INFORMATION</p>
	<p class="section-label">お知らせ</p>
	<?php endif; ?>
</div>
</div><!-- .page-header -->
<div class="flexbox container main_container">
<main class="main_left">
	<?php
	while ( have_posts() ) :
		the_post();
		?>
		<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
			<header class="entry-header">
				<?php the_title( '<h1 class="entry-title">', '</h1>' ); ?>
				<?php
				$meta_category_name = '';

				if ( 'column' === get_post_type() ) {
					$terms = get_the_terms( get_the_ID(), 'column_cat' );

					if ( ! empty( $terms ) && ! is_wp_error( $terms ) ) {
						$meta_category_name = $terms[0]->name;
					}
				} elseif ( 'post' === get_post_type() ) {
					$category = get_the_category();

					if ( ! empty( $category ) ) {
						$meta_category_name = $category[0]->cat_name;
					}
				}
				?>
				<?php if ( 'column' === get_post_type() || 'post' === get_post_type() ) : ?>
				<div class="entry-meta">
					<?php echo esc_html( $meta_category_name ); ?>
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
