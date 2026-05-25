<?php
/**
 * The sidebar containing the main widget area
 *
 * @link https://developer.wordpress.org/themes/basics/template-files/#template-partials
 *
 * @package okberlin
 */

?>

<aside id="secondary" class="widget-area">
<div class="trade_search flexbox">
<h3 class="title-section">Suche<span>OK!ベルリン サイト内検索</span></h3><?php get_search_form() ?>
</div>
<div class="area_widget group_facility">
	<h2 class="title-section title-section-center">Kategorie<span>ベルリン施設 カテゴリ別検索</span></h2>
		<?php echo do_shortcode('[myphp03 file="facilitycategory"]'); ?>
	</div>
<div class="area_widget group_facility">
<h2 class="title-section title-section-center">Bereich<span>ベルリン施設 エリア別検索</span></h2>
<?php echo do_shortcode('[myphp04 file="facilityarea"]'); ?>
</div>

<div class="area_widget">
<h2 class="title-section">Transaktion<span>ベルリン生活掲示板</span></h2>
<?php
include_once( ABSPATH . WPINC . '/feed.php' );
$rss = fetch_feed( 'https://ok-berlin.life/tradeboard/index.php?a=8' ); // ここにURLを入力する
if ( !is_wp_error( $rss ) ) {
$maxitems = $rss->get_item_quantity( 5 );
$rss_items = $rss->get_items( 0, $maxitems );
}
?>
<?php if ( !empty( $maxitems ) ) : ?>
<ul>
<?php if ($maxitems == 0) echo '<li>RSSデータがありませんでした.</li>';
else
foreach ( $rss_items as $item ) : ?>
<li>
<a href="<?php echo $item->get_permalink(); ?>">
<?php echo $item->get_title();// タイトル ?>
</a>
</li>
<li>
<span class="date">
<?php echo $item->get_date('d.m.Y');// 日付 ?>
</span>
</li>
<?php endforeach; ?>
</ul>
<?php endif; ?>
</div>



<div class="area_widget">
<h2 class="title-section">Artikel<span>ベルリン生活コラム</span></h2>
<ul class="list_news_recent">
<?php
$cat_posts = okberlin_get_posts(array(
    'post_type'      => 'post',
    'posts_per_page' => 5,
    'orderby'        => 'date',
    'order'          => 'DESC',
));
global $post;
if($cat_posts): foreach($cat_posts as $post): setup_postdata($post); ?>
  <li>
    <a href="<?php the_permalink(); ?>"><time><?php echo get_the_date(); ?></time><h3><?php the_title(); ?></h3></a>
  </li>
<?php endforeach; endif; wp_reset_postdata(); ?>
</ul>
<p class="btn"><a href="<?php echo esc_url( home_url( '/' ) ); ?>archives/category/column">コラムバックナンバー</a></p>
</div>
	<?php dynamic_sidebar( 'sidebar-1' ); ?>
</aside><!-- #secondary -->
