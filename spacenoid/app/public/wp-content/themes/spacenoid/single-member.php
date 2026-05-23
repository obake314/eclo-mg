<?php
/*
Template Name: メンバーテンプレート
*/
?>

<?php get_header(); ?>
<div class="section_content">
<?php
$member_english = function_exists('get_field') ? get_field('english') : get_post_meta(get_the_ID(), 'english', true);
$member_english = $member_english ? $member_english : get_the_title();
?>
<section class="page-header" data-page-title="<?php echo esc_attr($member_english); ?>">
	<h1 class="page-title" data-display-title="<?php echo esc_attr(get_the_title()); ?>"><?php the_title(); ?></h1>
</section>
<div class="member-single-layout">
	<div class="member-single-main">
		<article class="article_member" id="post-<?php the_ID(); ?>">
			<div class="entry-content">
				<?php
				the_content();
				?>
			</div>
		</article>
	</div>
	<?php
	$member_query = new WP_Query(array(
		'post_type'      => 'member',
		'posts_per_page' => -1,
		'post__not_in'   => array(get_the_ID()),
		'meta_key'       => 'furigana',
		'orderby'        => 'meta_value',
		'order'          => 'ASC',
		'no_found_rows'  => true,
	));
	?>
	<aside class="member-sidebar" aria-label="<?php esc_attr_e('Other members', 'spacenoid'); ?>">
		<p class="member-sidebar__label"><?php esc_html_e('Other Members', 'spacenoid'); ?></p>
		<?php if ($member_query->have_posts()): ?>
			<ul class="member-sidebar__list">
				<?php while ($member_query->have_posts()): $member_query->the_post(); ?>
					<li>
						<a href="<?php the_permalink(); ?>"><?php the_title(); ?></a>
					</li>
				<?php endwhile; ?>
			</ul>
			<?php wp_reset_postdata(); ?>
		<?php endif; ?>
		<a class="member-sidebar__back" href="<?php echo esc_url(home_url('/members/')); ?>"><?php esc_html_e('MEMBER LIST', 'spacenoid'); ?></a>
	</aside>
</div>
<?php if (function_exists('spacenoid_member_fanmail_notice')): ?>
	<?php spacenoid_member_fanmail_notice(); ?>
<?php endif; ?>
</div>
<?php get_footer(); ?>
