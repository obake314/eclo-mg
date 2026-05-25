<?php
/**
 * The main template file
 *
 * This is the most generic template file in a WordPress theme
 * and one of the two required files for a theme (the other being style.css).
 * It is used to display a page when nothing more specific matches a query.
 * E.g., it puts together the home page when no home.php file exists.
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/
 *
 * @package azarashilove
 */

get_header();
?>
<main id="primary" role="main">
<section class="sec_vis">
<div class="wrap flexbox">
<div class="sec_vis_left">
<h1><img src="<?php echo esc_url( home_url('/') ); ?>wp-content/uploads/2021/11/logo.svg" alt="アザラシ総合情報サイト｜アザラブ_ロゴ"></h1>
<p>アザラシのことをもっと知りたい。<br>
そんな気持ちでアザラシの画像や動画を収集したり、知見をまとめていくためのWEBサイトを作りました。グッズの購入や寄付などを促進してアザラシを取り巻く環境の向上に協力できたらうれしいです。</p>
<p class="btn btn_donation"><a class="prun" href="<?php echo esc_url( home_url('/') ); ?>donation">アザラシを支援する<img src="<?php echo esc_url( home_url('/') ); ?>wp-content/uploads/btn_azarashi01.svg" alt="ファーストビューアザラシを支援する"></a></p>
</div>
<ul class="slider sec_vis_right">
<li class="image"><img src="<?php echo esc_url( home_url('/') ); ?>wp-content/uploads/azarashi_img01.jpg" alt="アザラブキービジュアル1" width="750" height="500"></li>
<li class="image"><img src="<?php echo esc_url( home_url('/') ); ?>wp-content/uploads/azarashi_img02.jpg" alt="アザラブキービジュアル2" width="750" height="500"></li>
<li class="image"><img src="<?php echo esc_url( home_url('/') ); ?>wp-content/uploads/azarashi_img03.jpg" alt="アザラブキービジュアル3" width="750" height="500"></li>
</ul>
</div>
</section>
<ul class="list_pickup flexbox">
<li><a href="<?php echo esc_url( home_url('/') ); ?>archives/category/news">
<figure><img src="<?php echo esc_url( home_url('/') ); ?>wp-content/uploads/icon_azarashi02.svg" alt=""></figure>
<figcaption><h2>アザラシニュース</h2><p>アザラシに関する新着情報を掲載していきます。</p></figcaption></a></li>
<li><a href="<?php echo esc_url( home_url('/') ); ?>archives/facility">
<figure><img src="<?php echo esc_url( home_url('/') ); ?>wp-content/uploads/icon_azarashi01.svg" alt=""></figure>
<figcaption><h2>アザラシと会える施設情報</h2><p>水族館や動物園など、全国のアザラシ関連施設をまとめています。</p></figcaption></a></li>
<li><a href="<?php echo esc_url( home_url('/') ); ?>archives/azarashi">
<figure><img src="<?php echo esc_url( home_url('/') ); ?>wp-content/uploads/icon_azarashi03.svg" alt=""></figure>
<figcaption><h2>アザラシグッズ紹介</h2><p>編集部おすすめのアザラシアイテムをご紹介します。</p></figcaption></a></li>
</ul>
<section class="sec_news" id="js-trigger">
<div class="wrap flexbox">
<div class="rightbox">
<img src="<?php echo esc_url( home_url('/') ); ?>wp-content/uploads/seal03.jpg" alt="" loading="lazy">
</div>
<div class="leftbox">
<h2 class="title-section">News<span>新着アザラシニュース</span></h2>
<ul class="list_news_recent">
<?php
$q = new WP_Query([
  'posts_per_page'      => 5,
  'cat'                 => 6,
  'no_found_rows'       => true,
  'ignore_sticky_posts' => true,
]);

if ( $q->have_posts() ):
  while ( $q->have_posts() ) : $q->the_post();

    // 記事に付いている「カテゴリ」全部を取得
    $cats = get_the_terms( get_the_ID(), 'category' );

    // 親がニュース(ID=6)のものだけ残す
    $child_cats = [];
    if ( $cats && ! is_wp_error( $cats ) ) {
      foreach ( $cats as $cat ) {
        if ( (int) $cat->parent === 6 ) {
          $child_cats[] = $cat;
        }
      }
    }
?>
  <li>
    <a class="cover" href="<?php the_permalink(); ?>"></a>
    <div class="meta">
      <time datetime="<?php echo esc_attr( get_the_date( DATE_W3C ) ); ?>">
        <?php echo esc_html( get_the_date() ); ?>
      </time>
      <p class="cats">
        <?php if ( $child_cats ) :
          foreach ( $child_cats as $i => $cat ) :
            if ( $i ) echo ' / ';
            echo esc_html( $cat->name );
          endforeach;
        endif; ?>
      </p>
    </div>
    <h3><?php the_title(); ?></h3>
  </li>
<?php
  endwhile;
  wp_reset_postdata();
endif;
?>
</ul>
<p class="btn">
	<a href="<?php echo esc_url( home_url('/') ); ?>archives/category/news">
		アザラシニュース一覧へ
	</a></p>
</div>
</div>
</section><!-- #main -->
<section class="sec_azarashi">
<div class="wrap">
<h2 class="title-section">Type<span>アザラシの種類</span></h2>

<?php echo do_shortcode('[myphp file="azarashi_type"]'); ?>
</div>
</section>
<section class="sec_contents">
<div class="sec_contents_left">
<h2 class="title-section">Column<span>アザラシコラム</span></h2>
<ul class="list_news_recent">
<?php
  $args = array(
    'posts_per_page' => 5,
    'cat'            => 551,
  );
  $posts = get_posts( $args );
  if ( $posts ) :
    global $post;
    foreach ( $posts as $post ) :
      setup_postdata( $post );
?>
<li>
    <a href="<?php the_permalink(); ?>"></a>
	<time><?php echo get_the_date(); ?></time><h3><?php the_title(); ?></h3>
  </li>
<?php
    endforeach;
    wp_reset_postdata();
  endif;
?>
</ul>
<p class="btn" style="margin-top:var(--space-m);text-align:center;"><a href="<?php echo esc_url( get_category_link( 551 ) ); ?>">アザラシコラム一覧へ</a></p>
</div>
</section>
</main>
<?php
get_footer();