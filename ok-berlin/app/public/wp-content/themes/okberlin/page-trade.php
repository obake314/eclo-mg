<?php
/**
* Template Name: 取引テンプレート
* Template Post Type: page
*/
get_header();
?>
	<main id="primary" class="site-main">
<div class="wrap">
<header class="entry-header">
	<h1 class="entry-title"><span>WORKS</span>制作実績</h1>
</header>
<section class="sec_works">
<ul class="flexbox list_works">
	<?php
  $args = array(
	 'post_type' => 'work',
    'posts_per_page' => -1 // 表示件数の指定
  );
  $posts = okberlin_get_posts( $args );
  foreach ( $posts as $post ): // ループの開始
  setup_postdata( $post ); // 記事データの取得
?>
  <li class="<?php
  $terms = wp_get_object_terms($post->ID,'works_type');
  foreach($terms as $term){
    echo 'cat_' . $term->slug . ' ';
  }
?>">
    <a href="<?php the_permalink(); ?>">
		<figure>
			<img src="<?php the_field('works_img'); ?>" alt="<?php the_title(); ?>">
		</figure>
		<figcaption>
			<p class="category"><?php
  $terms = wp_get_object_terms($post->ID,'works_type');
  foreach($terms as $term){
    echo $term->name . ' ';
  }
?></p>
		<h3><?php the_title(); ?></h3>
		<time><?php the_field('works_month'); ?></time>
		</figcaption>
		</a>
  </li>
<?php
  endforeach; // ループの終了
  wp_reset_postdata(); // 直前のクエリを復元する
?>
	</ul>
</section>
</div>
</main>
<?php get_footer(); ?>