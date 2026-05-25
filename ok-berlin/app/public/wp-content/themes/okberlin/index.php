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
 * @package ok!Berlin
 */

get_header();
?>

<section class="sec_vis">
<div class="wrap flexbox">
<div class="sec_vis_left">
<h1 class="prun"><img src="<?php echo esc_url( home_url( '/' ) ); ?>wp-content/uploads/ob_logo.svg" alt="OK!BERLIN｜ドイツ・ベルリンの生活・観光情報ポータルサイト"></h1>
<p class="description">OK！BERLINはベルリンで生活している日本人在住者、日本からベルリンへの渡航を検討中の方へのお役立ち情報を掲載するサイトです。
ベルリン生活をちょっと便利にできたら、あるいは、ドイツへの渡航をちょっとでも楽しみになってもらえたらうれしいです。</p>
<div class="area_today flexbox">
	<div class="left">
	<script><!--
	var currency_rate_list=new Array("EUR","JPY");
	var currency_template="<p>現在の1 $from_abbrev</p><div><b>$rate</b>$to_abbrev</div>";
	var currency_round=true;
	//--></script>
	<script src="https://ja.coinmill.com/frame.js"></script>
	</div>
	<div class="right">
	<?php echo do_shortcode('[shortcode-weather-atlas city_selector=50 background_color="rgba(0,0,0,0)" unit_c_f="c" style="border:0;text-shadow:none;" text_color="#222222" layout="horizontal" daily=0 sunrise_sunset=0 hourly=0 current=0]'); ?>
	</div>
</div>

<div class="box_time">
<div class="box_time_left">
<h2>BERLIN TIME</h2>
<?php
date_default_timezone_set('Europe/Berlin');
$germany_time = date('Y.m.d H:i');
echo "<time>{$germany_time}</time>"; ?>
</div>
<div class="box_time_right">
<h2>TOKYO TIME</h2>
<?php
date_default_timezone_set('Asia/Tokyo');
$japan_time = date('Y.m.d H:i'); 
echo "<time>{$japan_time}</time>"; ?>
</div>
</div>

</div>
<ul class="slider sec_vis_right">
  <li class="image"><img src="<?php echo esc_url( home_url( '/' ) ); ?>wp-content/uploads/berlin_01.jpg" alt="博物館島"><small>博物館島</small></li>
  <li class="image"><img src="<?php echo esc_url( home_url( '/' ) ); ?>wp-content/uploads/berlin_02.jpg" alt="シュプレー川"><small>シュプレー川</small></li>
</ul>


</div>
</section>
<section class="sec_news_pickup">
<h2 class="title-section">Themen<span>ベルリン生活コラムおすすめ記事</span></h2>
<ul class="list_post_pickup flexbox">
<?php
$cat_posts = okberlin_get_posts(array(
    'post_type'      => 'post',
    'posts_per_page' => 4,
    'tag'            => 'pickup',
    'orderby'        => 'date',
    'order'          => 'DESC',
));
global $post;
if($cat_posts): foreach($cat_posts as $post): setup_postdata($post); ?>
<li class="image"><a href="<?php the_permalink(); ?>">
<figure><?php
  $post_title = get_the_title();
  the_post_thumbnail('full',array('alt' => $post_title,));
?></figure>
<figcaption>
<h3><?php the_title(); ?></h3>
<time><?php echo get_the_date(); ?></time>
</figcaption>
</a></li>
<?php endforeach; endif; wp_reset_postdata(); ?>
</ul>
</section>
<section class="sec_news_pickup area_interview">
<h2 class="title-section">Interview<span>ベルリン在住者インタビュー</span></h2>
<ul class="list_post_pickup flexbox">
<?php
$cat_posts = okberlin_get_posts(array(
    'post_type'      => 'interview',
    'posts_per_page' => 8,
    'orderby'        => 'date',
    'order'          => 'DESC',
));
global $post;
if($cat_posts): foreach($cat_posts as $post): setup_postdata($post); ?>
<li class="image"><a href="<?php the_permalink(); ?>">
<figure><?php
  $post_title = get_the_title();
  the_post_thumbnail('full',array('alt' => $post_title,));
?></figure>
<figcaption>
<h3><?php the_title(); ?></h3>
<time class="date"><?php the_time('d.m.Y') ?></time><br>
<time><?php the_field("interview_name"); ?></time>
</figcaption>
</a></li>
<?php endforeach; endif; wp_reset_postdata(); ?>
</ul>
</section>

<section class="sec_news">
<div class="wrap flexbox">
<div class="rightbox">
<h2 class="title-section">Transaktion<span>ベルリン生活掲示板 最新投稿</span></h2>
<?php
include_once( ABSPATH . WPINC . '/feed.php' );
$rss = fetch_feed( 'https://ok-berlin.life/tradeboard/index.php?a=8' ); // ここにURLを入力する
if ( !is_wp_error( $rss ) ) {
$maxitems = $rss->get_item_quantity( 5 );
$rss_items = $rss->get_items( 0, $maxitems );
}
?>
<?php if ( !empty( $maxitems ) ) : ?>
<ul class="list_borad">
<?php if ($maxitems == 0) echo '<li>RSSデータがありませんでした.</li>';
else
foreach ( $rss_items as $item ) : ?>
<li>
<time class="date">
<?php echo $item->get_date('d.m.Y');// 日付 ?>
</time>
<a href="<?php echo $item->get_permalink(); ?>">
<?php echo $item->get_title();// タイトル ?>
</a>
</li>
<?php endforeach; ?>
</ul>
<?php endif; ?>
<p class="btn"><a href="https://ok-berlin.life/tradeboard/">ベルリン生活掲示板</a></p>
</div>
<div class="leftbox">
<h2 class="title-section">Neue Artikel<span>ベルリン生活コラム 最新記事</span></h2>
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
    <a href="<?php the_permalink(); ?>">
	<figure><?php the_post_thumbnail('full'); ?></figure>
	<figcaption><time><?php echo get_the_date(); ?></time><h3><?php the_title(); ?></h3>
	<p><?php echo mb_substr(get_the_excerpt(), 0, 90); ?></p>
	</figcaption>
	</a>
  </li>
<?php endforeach; endif; wp_reset_postdata(); ?>
</ul>
<p class="btn"><a href="<?php echo esc_url( home_url( '/' ) ); ?>archives/category/column">コラム一覧へ</a></p>
</div>
</div>
</section>
<section class="sec_contents">
<div class="flexbox wrap">
<ul class="list_contents flexbox">
<li><a href="https://ok-berlin.life/archives/5580"><figure><img src="https://ok-berlin.life/wp-content/uploads/icon_spot.svg" alt="ベルリンの基本情報"></figure>
<figcaption><h2>ベルリンの基本情報</h2><p>ベルリンってどんな街？ベルリンの基本情報をまとめています。</p></figcaption></a></li>
<li><a href="<?php echo esc_url( home_url( '/' ) ); ?>archives/facility">
<figure><img src="<?php echo esc_url( home_url( '/' ) ); ?>wp-content/uploads/icon_spot.svg" alt="ベルリン街歩き施設情報"></figure>
<figcaption><h2>ベルリン街歩き施設情報</h2><p>ベルリンのお出かけスポット・行政関連の施設情報をまとめています。</p></figcaption></a></li>
<li><a href="https://ok-berlin.life/tradeboard/" alt="ベルリン生活掲示板">
<figure><img src="<?php echo esc_url( home_url( '/' ) ); ?>wp-content/uploads/icon_home.svg" alt="ベルリン生活掲示板"></figure>
<figcaption><h2>ベルリン生活掲示板</h2><p>物件情報、不用品シェア、告知などの取引のための掲示板です。</p></figcaption></a></li>
</ul>
</div>
<div class="spot_box flexbox">
<div class="leftbox">
<h3>ドイツ基本情報</h3>
<ul>
<li><a href="https://ok-berlin.life/emergency-contact">ドイツの緊急時連絡先一覧</a></li>
<li><a href="https://ok-berlin.life/deutschland/company">ドイツの有名企業一覧</a></li>
<li><a href="https://ok-berlin.life/deutschland/airport">ドイツの主要空港</a></li>
<li><a href="https://ok-berlin.life/deutschland/land">ドイツ16州</a></li>
</ul>
</div>
<div class="rightbox">
<h3>ベルリン基本情報</h3>
<ul>
<li><a href="https://ok-berlin.life/berlin">ベルリンの基本情報</a></li>
<li><a href="https://ok-berlin.life/berlin/public">ベルリンの公的機関・交通機関</a></li>
</ul>
</div>
<div class="box01">
<h3>ベルリン物件関連TIPS</h3>
<ul>
<li><a href="https://ok-berlin.life/archives/5601">ベルリン物件探しWEBサイト</a></li>
<li><a href="https://ok-berlin.life/archives/5791">ベルリン生活ルール</a></li>
<li><a href="https://ok-berlin.life/archives/5903">ベルリンでのゴミの捨て方</a></li>
<li>ベルリンでのペットの飼い方(<a href="https://ok-berlin.life/archives/5961">犬</a>/<a href="https://ok-berlin.life/archives/6097">猫</a>)</li>
<li>賃貸物件探しレポート（<a href="https://ok-berlin.life/archives/6410">前半</a>/<a href="https://ok-berlin.life/archives/6665">後半</a>）</li>
</ul>

</div>
<div class="box02">
<h3>ベルリン生活関連TIPS</h3>
<ul>
<li><a href="https://ok-berlin.life/archives/6122">病院に行きたい時</a></li>
<li><a href="https://ok-berlin.life/archives/6905">携帯電話購入方法</a></li>
<li><a href="https://ok-berlin.life/archives/7458">ベルリンで治安の悪いエリア</a></li>
<li><a href="https://ok-berlin.life/archives/7068">ベルリンのネガティヴなポイント</a></li>
<li><a href="https://ok-berlin.life/archives/7515">ベルリンで利用できる日本食通販サイト</a></li>
</ul>
</div>
<div class="box03">
<h3>ベルリンでのレジャー</h3>
<ul>
<li><a href="https://ok-berlin.life/archives/6089">ベルリンのおすすめの美術館</a></li>
<li><a href="https://ok-berlin.life/archives/5752">ベルリンのクラブ</a></li>
<li><a href="https://ok-berlin.life/archives/5626">ベルリンからのドイツ国外旅行</a></li>
<li><a href="https://ok-berlin.life/archives/5648">ベルリンからのドイツ国内旅行</a></li>
</ul>
</div>
</div>
</section>


<section class="sec_news sec_news02" id="js-trigger">
<div class="wrap flexbox">
<div class="rightbox pc_only">
<img src="<?php echo esc_url( home_url( '/' ) ); ?>wp-content/uploads/tram.jpg" alt="ベルリンのトラム">
</div>
<div class="leftbox">
<h2 class="title-section">Uber uns<span>OK!ベルリンとは</span></h2>
<p>OK！BERLINはベルリンの日本人在住者、日本からベルリンへの渡航を検討中の方へのお役立ち情報を掲載するサイトです。ベルリン生活がより便利になっていけたら、あるいは、ドイツの環境の中でさまざまな活動をする日本人のことを紹介できたらと思い運用しています。皆様とベルリンのいい出会いがあったらうれしいです。</p>
<h2 class="title-section">Nachricht<span>OK!ベルリンからのお知らせ</span></h2>
<p>2022年6月　ベルリン在住者のインタビュー記事の公開を開始しました！</p>
<h2 class="title-section">Rekrutierung<span>OK!ベルリン スタッフ募集</span></h2>
<p>OK!BERLINは、ベルリンの街を取材してレポートするスタッフを募集しています。ライター以外にも企画やサイト開発、その他の業務を協力していただける方がいらっしゃいましたら、是非ご連絡ください。面談の機会を設定させていただけたらと思います。学歴不問/未経験者歓迎/報酬は業務内容によって応相談とさせてください。</p>
<p class="btn"><a href="<?php echo esc_url( home_url( '/' ) ); ?>archives/category/column">コラム一覧へ</a>　<a target="_blank" href="https://twitter.com/OKBerlin_"><svg xmlns="http://www.w3.org/2000/svg" width="1em" height="1em" viewBox="0 0 24 24" fill="currentColor" aria-hidden="true" style="vertical-align:middle"><path d="M18.244 2.25h3.308l-7.227 8.26 8.502 11.24H16.17l-4.714-6.231-5.401 6.231H2.747l7.73-8.835L1.254 2.25H8.08l4.262 5.632 5.901-5.632Zm-1.161 17.52h1.833L7.084 4.126H5.117z"/></svg> Twitter</a>　<a href="https://ok-berlin.life/contact">お問い合わせ</a></p>
</div>
</div>
</section><!-- #main -->

<?php
get_footer();