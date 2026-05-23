<?php
/*
Template Name: 舞台テンプレート
*/
?>

<?php get_header(); ?>

<div id="content-wrapper" class="wrapper page_wrapper">
<h2 class="pc_only"><?php the_title(); ?>
<?php if( get_field('english') ) { ?>
<span><?php the_field('english'); ?></span>
<?php } ?></h2>
<h2 class="sp_only"><?php the_title(); ?>
<?php if( get_field('english') ) { ?>
<span><?php the_field('english'); ?></span>
<?php } ?></h2>
<div class="flexbox eventbox">
	<div class="leftbox">
		<h3 class="headline">これから開催</h3>
		<ul class="info_list">
<?php
$custom_posts = get_posts(array(
    'post_type' => 'stage', // 投稿タイプ
    'posts_per_page' => -1, // 表示件数
    'orderby' => 'date', // 表示順の基準
    'order' => 'DESC', // 昇順・降順
    'tax_query' => array(
       array(
            'taxonomy' => 'stage_status', //タクソノミーを指定
            'field' => 'slug', //ターム名をスラッグで指定する
            'terms' => 'stage_ready', //表示したいタームをスラッグで指定
            'operator' => 'IN'
        ),
    )
));
global $post;
if($custom_posts): foreach($custom_posts as $post): setup_postdata($post); ?>
<li><a href="<?php if(get_field('stage_url')): ?>
<?php the_field( 'stage_url' ); ?><?php else: ?><?php the_permalink(); ?><?php endif; ?>" class="flexbox">
	<figure><img src="<?php the_field( 'stage_img' ); ?>"></figure>
	<figcaption>
	<time>投稿日：<?php the_time( 'Y/m/d' ); ?></time>
	<h3><?php the_field( 'stage_name' ); ?></h3>
	<p class="stage_time">開催日：<?php the_field( 'stage_date' ); ?></p>
	<p class="stage_place">会場：<?php the_field( 'stage_place' ); ?></p>
	</figcaption></a></li>
<?php endforeach; wp_reset_postdata(); endif; ?>
		</ul>
			</div>
		<div class="rightbox">
					<h3 class="headline">開催終了</h3>
<ul class="info_list">
	<?php
$custom_posts = get_posts(array(
    'post_type' => 'stage', // 投稿タイプ
    'posts_per_page' => 5, // 表示件数
    'orderby' => 'date', // 表示順の基準
    'order' => 'DESC', // 昇順・降順
    'tax_query' => array(
        array(
            'taxonomy' => 'stage_status', //タクソノミーを指定
            'field' => 'slug', //ターム名をスラッグで指定する
            'terms' => 'stage_end', //表示したいタームをスラッグで指定
            'operator' => 'IN'
        ),
    )
));
global $post;
if($custom_posts): foreach($custom_posts as $post): setup_postdata($post); ?>
<li><a href="<?php if(get_field('stage_url')): ?>
<?php the_field( 'stage_url' ); ?><?php else: ?><?php the_permalink(); ?><?php endif; ?>" class="flexbox">
	<figure><img src="<?php the_field( 'stage_img' ); ?>"></figure>
	<figcaption>
	<time>投稿日：<?php the_time( 'Y/m/d' ); ?></time>
	<h3><?php the_field( 'stage_name' ); ?></h3>
	<p class="stage_time">開催日：<?php the_field( 'stage_date' ); ?></p>
	<p class="stage_place">会場：<?php the_field( 'stage_place' ); ?></p>
	</figcaption></a></li>
<?php endforeach; wp_reset_postdata(); endif; ?>
		</ul>
		</div>

		</div>
</div>

<?php get_footer(); ?>