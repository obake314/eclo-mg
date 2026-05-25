<?php
/*
Template Name: インフォメーションテンプレート
*/
?>

<?php get_header(); ?>
<div class="section_content">
<section class="page-header" data-page-title="<?php echo esc_attr(function_exists('spacenoid_get_page_header_label') ? spacenoid_get_page_header_label() : get_the_title()); ?>">
	<h2 class="page-title" data-display-title="<?php echo esc_attr(get_the_title()); ?>">
		<?php the_title(); ?></h2>
</section>
<article id="post-<?php the_ID(); ?>">
	<div class="entry-content">
		<?php
		the_content();
		?>
	</div>
</article>
<main class="flexbox eventbox" style="display:none">
	<div class="leftbox">
		<h3 class="headline">これから開催</h3>
		<ul class="info_list">
<?php
$custom_posts = get_posts(array(
    'post_type' => 'event', // 投稿タイプ
    'posts_per_page' => -1, // 表示件数
    'orderby' => 'date', // 表示順の基準
    'order' => 'DESC', // 昇順・降順
    'tax_query' => array(
        array(
            'taxonomy' => 'release', //タクソノミーを指定
            'field' => 'slug', //ターム名をスラッグで指定する
            'terms' => 'event_ready', //表示したいタームをスラッグで指定
            'operator' => 'IN'
        ),
    )
));
global $post;
if($custom_posts): foreach($custom_posts as $post): setup_postdata($post); ?>
<li><a href="<?php the_permalink(); ?>" class="flexbox">
	<figure><img src="<?php the_field( 'event_img' ); ?>"></figure>
	<figcaption>
	<time>投稿日：<?php the_time( 'Y/m/d' ); ?></time>
	<h3><?php the_field( 'event_name' ); ?></h3>
	<p class="event_time">イベント開催日：<?php the_field( 'event_date' ); ?></p>
	<p class="event_place">会場：<?php the_field( 'event_place' ); ?></p>
	</figcaption></a></li>
<?php endforeach; wp_reset_postdata(); endif; ?>
		</ul>
			</div>
		<div class="rightbox">
					<h3 class="headline">開催終了</h3>
<ul class="info_list">
	<?php
$custom_posts = get_posts(array(
    'post_type' => 'event', // 投稿タイプ
    'posts_per_page' => 5, // 表示件数
    'orderby' => 'date', // 表示順の基準
    'order' => 'DESC', // 昇順・降順
    'tax_query' => array(
        array(
            'taxonomy' => 'release', //タクソノミーを指定
            'field' => 'slug', //ターム名をスラッグで指定する
            'terms' => 'event_end', //表示したいタームをスラッグで指定
            'operator' => 'IN'
        ),
    )
));
global $post;
if($custom_posts): foreach($custom_posts as $post): setup_postdata($post); ?>
<li><a href="<?php the_permalink(); ?>" class="flexbox">
	<figure><img src="<?php the_field( 'event_img' ); ?>"></figure>
	<figcaption>
	<time>投稿日：<?php the_time( 'Y/m/d' ); ?></time>
	<h3><?php the_field( 'event_name' ); ?></h3>
	<p class="event_time">イベント開催日：<?php the_field( 'event_date' ); ?></p>
	<p class="event_place">会場：<?php the_field( 'event_place' ); ?></p>
	</figcaption></a></li>
<?php endforeach; wp_reset_postdata(); endif; ?>
		</ul>
		</div>
	</main>
</div>
<?php get_footer(); ?>
