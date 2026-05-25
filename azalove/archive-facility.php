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
	<h1 class="entry-title"><span>Facility</span>あざらしに会える施設情報</h1>
</div>			
<div class="page-header wrap">
全国の動物園や水族館で会えるアザラシ情報を地域別に紹介。<br>
北海道から九州・沖縄まで、各施設で飼育されているアザラシの網羅を目指しています。
</div><!-- .page-header -->	
	<main id="primary" class="site-main main_facility">
	<div class="wrap">
	
	<h3 class="section-title">あざらしに会える施設情報｜北海道</h3>
<ul class="list_facility">
<?php
$custom_posts = get_posts(array(
    'post_type' => 'facility', // 投稿タイプ
    'posts_per_page' => -1, // 表示件数
    'orderby' => 'date', // 表示順の基準
    'order' => 'DESC', // 昇順・降順
    'tax_query' => array(
        array(
            'taxonomy' => 'prefectures', //タクソノミーを指定
            'field' => 'slug', //ターム名をスラッグで指定する
            'terms' => 'hokkaido', //表示したいタームをスラッグで指定
            'operator' => 'IN'
        ),
    )
));
global $post;
if($custom_posts): foreach($custom_posts as $post): setup_postdata($post); ?>
<li>
<a href="<?php the_permalink(); ?>">
	<figure>
		<?php if (has_post_thumbnail()) : ?>
		<?php the_post_thumbnail('full'); ?>
		<?php else : ?>
		<img src="https://azarashi.love/wp-content/uploads/azarashi_noimg.jpg">
		<?php endif ; ?>
	</figure>
	<figcaption>
		<h3><?php the_title(); ?></h3>
		<address><?php $terms = get_the_terms($post->ID, 'prefectures'); if ( $terms ) { echo $terms[0]->name;} ?></address>
		<ul class="list_facility_azarashi"><?php
$terms = get_the_terms($post->ID, 'genus');
if ($terms) :
    foreach ($terms as $term) {
        echo '<li>' . $term->name . '</li>';
    }
endif;
?></ul>
	</figcaption>
</a>
</li>
<?php endforeach; wp_reset_postdata(); endif; ?>
</ul>
<ul class="list_facility">
<?php
$custom_posts = get_posts(array(
    'post_type' => 'facility', // 投稿タイプ
    'posts_per_page' => -1, // 表示件数
    'orderby' => 'date', // 表示順の基準
    'order' => 'DESC', // 昇順・降順
    'tax_query' => array(
        array(
            'taxonomy' => 'prefectures', //タクソノミーを指定
            'field' => 'slug', //ターム名をスラッグで指定する
            'terms' => 'tohoku', //表示したいタームをスラッグで指定
            'operator' => 'IN'
        ),
    )
));
global $post;
if($custom_posts): foreach($custom_posts as $post): setup_postdata($post); ?>
<li>
<a href="<?php the_permalink(); ?>">
	<figure>
		<?php if (has_post_thumbnail()) : ?>
		<?php the_post_thumbnail('full'); ?>
		<?php else : ?>
		<img src="https://azarashi.love/wp-content/uploads/azarashi_noimg.jpg">
		<?php endif ; ?>
	</figure>
	<figcaption>
		<h3><?php the_title(); ?></h3>
		<address>
			<?php $terms = get_the_terms($post->ID, 'prefectures'); if ( $terms ) { echo $terms[0]->name;} ?>
		</address>
		<ul class="list_facility_azarashi"><?php
$terms = get_the_terms($post->ID, 'genus');
if ($terms) :
    foreach ($terms as $term) {
        echo '<li>' . $term->name . '</li>';
    }
endif;
?></ul>
	</figcaption>
</a>
</li>
<?php endforeach; wp_reset_postdata(); endif; ?>
</ul>
	<h3 class="section-title">あざらしに会える施設｜関東地方</h3>
<ul class="list_facility">
<?php
$custom_posts = get_posts(array(
    'post_type' => 'facility', // 投稿タイプ
    'posts_per_page' => -1, // 表示件数
    'orderby' => 'date', // 表示順の基準
    'order' => 'DESC', // 昇順・降順
    'tax_query' => array(
        array(
            'taxonomy' => 'prefectures', //タクソノミーを指定
            'field' => 'slug', //ターム名をスラッグで指定する
            'terms' => 'kanto', //表示したいタームをスラッグで指定
            'operator' => 'IN'
        ),
    )
));
global $post;
if($custom_posts): foreach($custom_posts as $post): setup_postdata($post); ?>
<li>
<a href="<?php the_permalink(); ?>">
	<figure>
		<?php if (has_post_thumbnail()) : ?>
		<?php the_post_thumbnail('full'); ?>
		<?php else : ?>
		<img src="https://azarashi.love/wp-content/uploads/azarashi_noimg.jpg">
		<?php endif ; ?>
	</figure>
<figcaption>
	<h3><?php the_title(); ?></h3>
		<address>
		<?php $terms = get_the_terms($post->ID, 'prefectures'); if ( $terms ) { echo $terms[0]->name;} ?>
		</address>
		<ul class="list_facility_azarashi"><?php
$terms = get_the_terms($post->ID, 'genus');
if ($terms) :
    foreach ($terms as $term) {
        echo '<li>' . $term->name . '</li>';
    }
endif;
?></ul>
	</figcaption>
</a>
</li>
<?php endforeach; wp_reset_postdata(); endif; ?>
</ul>
	<h3 class="section-title">あざらしに会える施設｜中部地方</h3>
<ul class="list_facility">
<?php
$custom_posts = get_posts(array(
    'post_type' => 'facility', // 投稿タイプ
    'posts_per_page' => -1, // 表示件数
    'orderby' => 'date', // 表示順の基準
    'order' => 'DESC', // 昇順・降順
    'tax_query' => array(
        array(
            'taxonomy' => 'prefectures', //タクソノミーを指定
            'field' => 'slug', //ターム名をスラッグで指定する
            'terms' => 'chubu', //表示したいタームをスラッグで指定
            'operator' => 'IN'
        ),
    )
));
global $post;
if($custom_posts): foreach($custom_posts as $post): setup_postdata($post); ?>
<li>
<a href="<?php the_permalink(); ?>">
<figure>
   <?php if (has_post_thumbnail()) : ?>
<?php the_post_thumbnail('full'); ?>
    <?php else : ?>
<img src="https://azarashi.love/wp-content/uploads/azarashi_noimg.jpg">
    <?php endif ; ?>
</figure>
<figcaption>
<h3><?php the_title(); ?></h3>
<address><?php $terms = get_the_terms($post->ID, 'prefectures'); if ( $terms ) { echo $terms[0]->name;} ?></address>
<ul class="list_facility_azarashi"><?php
$terms = get_the_terms($post->ID, 'genus');
if ($terms) :
    foreach ($terms as $term) {
        echo '<li>' . $term->name . '</li>';
    }
endif;
?></ul>
</figcaption>
</a>
</li>
<?php endforeach; wp_reset_postdata(); endif; ?>
</ul>
	<h3 class="section-title">あざらしに会える施設｜近畿地方</h3>
<ul class="list_facility">
<?php
$custom_posts = get_posts(array(
    'post_type' => 'facility', // 投稿タイプ
    'posts_per_page' => -1, // 表示件数
    'orderby' => 'date', // 表示順の基準
    'order' => 'DESC', // 昇順・降順
    'tax_query' => array(
        array(
            'taxonomy' => 'prefectures', //タクソノミーを指定
            'field' => 'slug', //ターム名をスラッグで指定する
            'terms' => 'kinki', //表示したいタームをスラッグで指定
            'operator' => 'IN'
        ),
    )
));
global $post;
if($custom_posts): foreach($custom_posts as $post): setup_postdata($post); ?>
<li>
<a href="<?php the_permalink(); ?>">
<figure>
   <?php if (has_post_thumbnail()) : ?>
<?php the_post_thumbnail('full'); ?>
    <?php else : ?>
<img src="https://azarashi.love/wp-content/uploads/azarashi_noimg.jpg">
    <?php endif ; ?>
</figure>
<figcaption>
<h3><?php the_title(); ?></h3>
<address><?php $terms = get_the_terms($post->ID, 'prefectures'); if ( $terms ) { echo $terms[0]->name;} ?></address>
<ul class="list_facility_azarashi"><?php
$terms = get_the_terms($post->ID, 'genus');
if ($terms) :
    foreach ($terms as $term) {
        echo '<li>' . $term->name . '</li>';
    }
endif;
?></ul>
</figcaption>
</a>
</li>
<?php endforeach; wp_reset_postdata(); endif; ?>
</ul>
<h3 class="section-title">あざらしに会える施設｜中国・四国地方</h3>
<ul class="list_facility">
<?php
$custom_posts = get_posts(array(
    'post_type' => 'facility', // 投稿タイプ
    'posts_per_page' => -1, // 表示件数
    'orderby' => 'date', // 表示順の基準
    'order' => 'DESC', // 昇順・降順
    'tax_query' => array(
        array(
            'taxonomy' => 'prefectures', //タクソノミーを指定
            'field' => 'slug', //ターム名をスラッグで指定する
            'terms' => 'chugoku-shikoku', //表示したいタームをスラッグで指定
            'operator' => 'IN'
        ),
    )
));
global $post;
if($custom_posts): foreach($custom_posts as $post): setup_postdata($post); ?>
<li>
<a href="<?php the_permalink(); ?>">
<figure>
   <?php if (has_post_thumbnail()) : ?>
<?php the_post_thumbnail('full'); ?>
    <?php else : ?>
<img src="https://azarashi.love/wp-content/uploads/azarashi_noimg.jpg">
    <?php endif ; ?>
</figure>
<figcaption>
<h3><?php the_title(); ?></h3>
<address><?php $terms = get_the_terms($post->ID, 'prefectures'); if ( $terms ) { echo $terms[0]->name;} ?></address>
<ul class="list_facility_azarashi"><?php
$terms = get_the_terms($post->ID, 'genus');
if ($terms) :
    foreach ($terms as $term) {
        echo '<li>' . $term->name . '</li>';
    }
endif;
?></ul>
</figcaption>
</a>
</li>
<?php endforeach; wp_reset_postdata(); endif; ?>
</ul>
	<h3 class="section-title">あざらしに会える施設｜九州・沖縄地方</h3>
<ul class="list_facility">
<?php
$custom_posts = get_posts(array(
    'post_type' => 'facility', // 投稿タイプ
    'posts_per_page' => -1, // 表示件数
    'orderby' => 'date', // 表示順の基準
    'order' => 'DESC', // 昇順・降順
    'tax_query' => array(
        array(
            'taxonomy' => 'prefectures', //タクソノミーを指定
            'field' => 'slug', //ターム名をスラッグで指定する
            'terms' => 'kyushu-okinawa', //表示したいタームをスラッグで指定
            'operator' => 'IN'
        ),
    )
));
global $post;
if($custom_posts): foreach($custom_posts as $post): setup_postdata($post); ?>
<li>
<a href="<?php the_permalink(); ?>">
<figure>
   <?php if (has_post_thumbnail()) : ?>
<?php the_post_thumbnail('full'); ?>
    <?php else : ?>
<img src="https://azarashi.love/wp-content/uploads/azarashi_noimg.jpg">
    <?php endif ; ?>
</figure>
<figcaption>
<h3><?php the_title(); ?></h3>
<address><?php $terms = get_the_terms($post->ID, 'prefectures'); if ( $terms ) { echo $terms[0]->name;} ?></address>
<ul class="list_facility_azarashi"><?php
$terms = get_the_terms($post->ID, 'genus');
if ($terms) :
    foreach ($terms as $term) {
        echo '<li>' . $term->name . '</li>';
    }
endif;
?></ul>
</figcaption>
</a>
</li>
<?php endforeach; wp_reset_postdata(); endif; ?>
</ul>
</div>
</main><!-- #main -->
<?php
get_footer();
