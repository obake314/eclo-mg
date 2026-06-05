<?php
/**
 * Shortcode definitions
 *
 * @package okberlin
 */

/**
 * Includes a theme template file and returns its output as a string.
 * Registered for shortcodes: myphp, myphp02–myphp06.
 *
 * Map: shortcode tag → template filename (without .php)
 */
function okberlin_include_template( $atts, $content, $tag ) {
	$map = array(
		'myphp'   => 'tradecategory',
		'myphp02' => 'tradearea',
		'myphp03' => 'facilitycategory',
		'myphp04' => 'facilityarea',
		'myphp05' => 'logo',
		'myphp06' => 'trade_register',
	);

	if ( ! isset( $map[ $tag ] ) ) {
		return '';
	}

	$file = get_template_directory() . '/' . $map[ $tag ] . '.php';

	if ( ! file_exists( $file ) ) {
		return '';
	}

	ob_start();
	include $file;
	return ob_get_clean();
}

foreach ( array( 'myphp', 'myphp02', 'myphp03', 'myphp04', 'myphp05', 'myphp06' ) as $_okberlin_tag ) {
	add_shortcode( $_okberlin_tag, 'okberlin_include_template' );
}
unset( $_okberlin_tag );

// ---------------------------------------------------------------------------
// Writer introduction boxes
// [kanako] [nanae] [mili] [shusei] [hunayu]
//
// Usage in post content: place the shortcode at the end of the article.
// Renders a .box_writer block with profile photo, name, and bio.
//
// To update a writer's bio or archive link, edit the $writers array below.
// ---------------------------------------------------------------------------

/**
 * Writer data map.
 * Keys must match the shortcode tag.
 *
 * 'image_id' : WordPress attachment ID of the profile photo.
 * 'name'     : Display name shown in the h3 heading.
 * 'bio'      : Short self-introduction text.
 * 'archive'  : URL of the writer's article archive (empty = no link rendered).
 */
function okberlin_writer_data(): array {
	return array(
		'kanako' => array(
			'image_id' => 8150,
			'name'     => 'Kanako',
			'bio'      => 'ワーホリ生活1年を経て、そのまま本腰をいれてベルリンに居住。最近のブームはバインミーで、マーケットやお散歩に行くのが好き。趣味はキッチンドランカー。',
			'links'    => array(
				array( 'url' => 'https://twitter.com/Inu_person',          'label' => 'Twitter',   'target' => '_blank' ),
				array( 'url' => 'https://www.instagram.com/kanakohaga/', 'label' => 'Instagram', 'target' => '_blank' ),
			),
		),
		'mili'   => array(
			'image_id' => 6131,
			'name'     => 'Mili',
			'bio'      => '２匹の猫とベルリンで暮らし。たまに舞台作品を作ってます。',
			'links'    => array(
				array( 'url' => 'https://www.instagram.com/mikakokura/',      'label' => 'Instagram1', 'target' => '_blank' ),
				array( 'url' => 'https://www.instagram.com/mikako.kura.art/', 'label' => 'Instagram2', 'target' => '_blank' ),
			),
		),
		'shusei' => array(
			'image_id' => 6182,
			'name'     => 'Schusei',
			'bio'      => '写真を用いたFine-Artとパーソナルジャーナリズムを展開しています。ドイツと日本をベースに、電子音楽家とデザイナーとしても活動中。',
			'links'    => array(
				array( 'url' => 'https://www.instagram.com/captured_ambience_sch', 'label' => 'Instagram', 'target' => '_blank' ),
			),
		),
		'hunayu' => array(
			'image_id' => 5921,
			'name'     => 'hinayu',
			'bio'      => "アーティストとしてベルリンで活動中。\n好きなドイツ語はPurpur(紫)",
			'links'    => array(
				array( 'url' => 'https://www.ayuohinata.com/', 'label' => 'WEBサイト', 'target' => '_blank' ),
			),
		),
		'mia'    => array(
			'image_id' => 6130,
			'name'     => 'Mia',
			'bio'      => "2019年にベルリンに結婚を機に移住。\n趣味はパン作りとガーデニング。お酒も大好き。",
			'links'    => array(),
		),
		'fuko'   => array(
			'image_id' => 6907,
			'name'     => 'Fuko Chiba',
			'bio'      => '2021年秋に、ベルリンに移住。読書、旅行とお煎餅が大好きです！',
			'links'    => array(
				array( 'url' => 'https://www.instagram.com/fukochiba/', 'label' => 'Instagram', 'target' => '_blank' ),
			),
		),
		'oshima' => array(
			'image_id' => 6279,
			'name'     => 'Takuma Oshima',
			'bio'      => '神戸市出身。広告代理店を脱サラ後、ベルリンで映像を学びながらビデオグラファーとして活動中。',
			'links'    => array(
				array( 'url' => 'https://www.instagram.com/takuma_oshima.jp/', 'label' => 'Instagram', 'target' => '_blank' ),
			),
		),
		'tanaka' => array(
			'image_id' => 6280,
			'name'     => 'Hikari',
			'bio'      => 'ベルリン在住。自然現象と身体を用いたインスタレーションアーティストとして活動中。',
			'links'    => array(
				array( 'url' => 'https://www.instagram.com/iam_hikari/', 'label' => 'Instagram', 'target' => '_blank' ),
			),
		),
		'okappa' => array(
			'image_id' => 5797,
			'name'     => 'おカッパさんとおヒゲさん',
			'bio'      => '散歩とアイスクリームが趣味の日本人おカッパさんと、日本語ペラペラなバイエルン地方出身のドイツ人おヒゲさん。ベルリン暮らしサービスセンター運営中です。',
			'links'    => array(
				array( 'url' => 'https://berlin-support.stores.jp/', 'label' => 'ベルリン暮らしサービスセンター', 'target' => '_blank' ),
			),
		),
	);
}

/**
 * Shared handler for all writer shortcodes.
 * $tag is the shortcode name (= writer key in okberlin_writer_data()).
 */
function okberlin_writer_box( $atts, $content, $tag ) {
	$writers = okberlin_writer_data();

	if ( ! isset( $writers[ $tag ] ) ) {
		return '';
	}

	$w   = $writers[ $tag ];
	$img = wp_get_attachment_image(
		$w['image_id'],
		array( 180, 180 ),
		false,
		array( 'alt' => esc_attr( $w['name'] ) )
	);

	ob_start();
	?>
<div class="box_writer flexbox">
<figure><?php echo $img; ?></figure>
<figcaption>
<h3><?php echo esc_html( $w['name'] ); ?></h3>
<?php if ( $w['bio'] ) : ?>
<p><?php echo nl2br( esc_html( $w['bio'] ) ); ?></p>
<?php endif; ?>
<?php if ( ! empty( $w['links'] ) ) : ?>
<p class="link">
<?php foreach ( $w['links'] as $i => $link ) : ?>
<?php if ( $i > 0 ) echo '<br>'; ?>
<a href="<?php echo esc_url( $link['url'] ); ?>"
   target="<?php echo esc_attr( $link['target'] ?? '_self' ); ?>"
   <?php echo ( ( $link['target'] ?? '' ) === '_blank' ) ? 'rel="noopener noreferrer"' : ''; ?>
><?php echo esc_html( $link['label'] ); ?></a>
<?php endforeach; ?>
</p>
<?php endif; ?>
</figcaption>
</div>
	<?php
	return ob_get_clean();
}

foreach ( array_keys( okberlin_writer_data() ) as $_okberlin_writer ) {
	add_shortcode( $_okberlin_writer, 'okberlin_writer_box' );
}
unset( $_okberlin_writer );

// ---------------------------------------------------------------------------
// Front-page sections — used in the "HOME" page via Shortcode blocks
// ---------------------------------------------------------------------------

/**
 * [okberlin_sec_vis]
 * Hero section: site logo, description, currency widget, weather, time, slider.
 */
function okberlin_sec_vis() {
	wp_enqueue_script( 'okberlin-home', get_template_directory_uri() . '/js/home.js', array(), _S_VERSION, true );

	$home = esc_url( home_url( '/' ) );

	ob_start();
	?>
<section class="sec_vis">
<div class="wrap flexbox">
<div class="sec_vis_left">
<h1 class="prun"><img src="<?php echo $home; ?>wp-content/uploads/ob_logo.svg" alt="OK!BERLIN｜ドイツ・ベルリンの生活・観光情報ポータルサイト"></h1>
<p class="description">OK！BERLINはベルリンで生活している日本人在住者、日本からベルリンへの渡航を検討中の方へのお役立ち情報を掲載するサイトです。
ベルリン生活をちょっと便利にできたら、あるいは、ドイツへの渡航をちょっとでも楽しみになってもらえたらうれしいです。</p>
<div class="area_today flexbox">
	<div class="left">
	<div class="currency-wrap">
	<p>現在の1 EUR</p>
	<div><b id="js-eur-jpy">--</b> JPY</div>
	</div>
	</div>
	<div class="right">
	<div class="berlin-weather">
	<div class="berlin-temp-wrap"><span id="js-berlin-temp">--</span><span class="unit">°C</span></div>
	<p class="berlin-weather-desc"><span id="js-berlin-weather-icon"></span><span id="js-berlin-weather-label"></span></p>
	</div>
	</div>
</div>
<div class="box_time">
<div class="box_time_left">
<p>BERLIN</p>
<time id="js-berlin-time">----.--.-- --:--</time>
</div>
<div class="box_time_right">
<p>TOKYO</p>
<time id="js-tokyo-time">----.--.-- --:--</time>
</div>
</div>
</div>
<ul class="slider sec_vis_right">
  <li class="image"><img src="<?php echo $home; ?>wp-content/uploads/berlin_01.jpg" alt="博物館島"><small>博物館島</small></li>
  <li class="image"><img src="<?php echo $home; ?>wp-content/uploads/berlin_02.jpg" alt="シュプレー川"><small>シュプレー川</small></li>
</ul>
</div>
</section>
	<?php
	return ob_get_clean();
}
add_shortcode( 'okberlin_sec_vis', 'okberlin_sec_vis' );

/**
 * [okberlin_sec_news_pickup title="" subtitle="" post_type="post" tag="" count="4" class="" show_name="0"]
 * Pickup / interview post list.
 *
 * show_name="1" → display interview_name ACF field instead of date.
 */
function okberlin_sec_news_pickup( $atts ) {
	$a = shortcode_atts( array(
		'title'     => '',
		'subtitle'  => '',
		'post_type' => 'post',
		'tag'       => '',
		'count'     => 4,
		'class'     => '',
		'show_name' => '0',
	), $atts );

	$args = array(
		'post_type'      => sanitize_key( $a['post_type'] ),
		'posts_per_page' => absint( $a['count'] ),
		'orderby'        => 'date',
		'order'          => 'DESC',
	);
	if ( $a['tag'] ) {
		$args['tag'] = sanitize_key( $a['tag'] );
	}

	$posts = okberlin_get_posts( $args );
	if ( ! $posts ) {
		return '';
	}

	$show_name = ( '1' === $a['show_name'] );

	ob_start();
	?>
<section class="sec_news_pickup <?php echo esc_attr( $a['class'] ); ?>">
<div class="title-section"><p><?php echo esc_html( $a['title'] ); ?></p><h2><?php echo esc_html( $a['subtitle'] ); ?></h2></div>
<ul class="list_post_pickup flexbox">
<?php global $post; foreach ( $posts as $post ) : setup_postdata( $post ); ?>
<li class="image"><a href="<?php the_permalink(); ?>">
<figure><?php the_post_thumbnail( 'full', array( 'alt' => get_the_title() ) ); ?></figure>
<figcaption>
<h3><?php the_title(); ?></h3>
<?php if ( $show_name ) : ?>
<time class="date"><?php the_time( 'd.m.Y' ); ?></time><br>
<time><?php echo esc_html( function_exists( 'get_field' ) ? get_field( 'interview_name' ) : '' ); ?></time>
<?php else : ?>
<time><?php echo esc_html( get_the_date() ); ?></time>
<?php endif; ?>
</figcaption>
</a></li>
<?php endforeach; wp_reset_postdata(); ?>
</ul>
</section>
	<?php
	return ob_get_clean();
}
add_shortcode( 'okberlin_sec_news_pickup', 'okberlin_sec_news_pickup' );

/**
 * [okberlin_sec_news]
 * News section: RSS feed (tradeboard) + recent posts.
 */
function okberlin_sec_news() {
	$home = esc_url( home_url( '/' ) );

	// RSS feed.
	include_once ABSPATH . WPINC . '/feed.php';
	$rss      = fetch_feed( 'https://ok-berlin.life/tradeboard/index.php?a=8' );
	$rss_items = array();
	if ( ! is_wp_error( $rss ) ) {
		$rss_items = $rss->get_items( 0, $rss->get_item_quantity( 5 ) );
	}

	// Recent posts.
	$recent_posts = okberlin_get_posts( array(
		'post_type'      => 'post',
		'posts_per_page' => 5,
		'orderby'        => 'date',
		'order'          => 'DESC',
	) );

	ob_start();
	?>
<section class="sec_news">
<div class="wrap flexbox">
<div class="rightbox">
<div class="title-section"><p>Transaktion</p><h2>ベルリン生活掲示板 最新投稿</h2></div>
<?php if ( $rss_items ) : ?>
<ul class="list_borad">
<?php foreach ( $rss_items as $item ) : ?>
<li>
<time class="date"><?php echo esc_html( $item->get_date( 'd.m.Y' ) ); ?></time>
<a href="<?php echo esc_url( $item->get_permalink() ); ?>"><?php echo esc_html( $item->get_title() ); ?></a>
</li>
<?php endforeach; ?>
</ul>
<?php endif; ?>
<p class="btn"><a href="https://ok-berlin.life/tradeboard/">ベルリン生活掲示板</a></p>
</div>
<div class="leftbox">
<div class="title-section"><p>Neue Artikel</p><h2>ベルリン生活コラム 最新記事</h2></div>
<ul class="list_news_recent">
<?php global $post; foreach ( $recent_posts as $post ) : setup_postdata( $post ); ?>
<li>
<a href="<?php the_permalink(); ?>">
<figure><?php the_post_thumbnail( 'thumbnail' ); ?></figure>
<figcaption>
<time><?php echo esc_html( get_the_date() ); ?></time>
<h3><?php the_title(); ?></h3>
</figcaption>
</a>
</li>
<?php endforeach; wp_reset_postdata(); ?>
</ul>
<p class="btn"><a href="<?php echo $home; ?>archives/category/column">コラム一覧へ</a></p>
</div>
</div>
</section>
	<?php
	return ob_get_clean();
}
add_shortcode( 'okberlin_sec_news', 'okberlin_sec_news' );

/**
 * okberlin/sec-interview block render callback.
 * Interview post list with ACF interview_name field.
 */
function okberlin_sec_interview() {
	$posts = okberlin_get_posts( array(
		'post_type'      => 'interview',
		'posts_per_page' => 8,
		'orderby'        => 'date',
		'order'          => 'DESC',
	) );
	if ( ! $posts ) {
		return '';
	}

	ob_start();
	?>
<section class="wp-block-group sec_news_pickup area_interview">
<div class="title-section"><p>Interview</p><h2>ベルリン在住者インタビュー</h2></div>
<ul class="list_post_pickup flexbox">
<?php global $post; foreach ( $posts as $post ) : setup_postdata( $post ); ?>
<li class="image"><a href="<?php the_permalink(); ?>">
<figure><?php the_post_thumbnail( 'full', array( 'alt' => get_the_title() ) ); ?></figure>
<figcaption>
<h3><?php the_title(); ?></h3>
<time class="date"><?php the_time( 'd.m.Y' ); ?></time>
<?php
$interview_name = function_exists( 'get_field' ) ? get_field( 'interview_name', $post->ID ) : '';
if ( $interview_name ) :
?>
<span class="interview-name"><?php echo esc_html( $interview_name ); ?></span>
<?php endif; ?>
</figcaption>
</a></li>
<?php endforeach; wp_reset_postdata(); ?>
</ul>
</section>
	<?php
	return ob_get_clean();
}

/**
 * [okberlin_sec_contents]
 * Contents/links section with spot_box quick links.
 */
function okberlin_sec_contents() {
	$home = esc_url( home_url( '/' ) );
	ob_start();
	?>
<section class="sec_contents">
<div class="flexbox wrap">
<ul class="list_contents flexbox">
<li><a href="https://ok-berlin.life/archives/5580"><figure><img src="<?php echo $home; ?>wp-content/uploads/icon_spot.svg" alt="ベルリンの基本情報"></figure>
<figcaption><h2>ベルリンの基本情報</h2><p>ベルリンってどんな街？ベルリンの基本情報をまとめています。</p></figcaption></a></li>
<li><a href="<?php echo $home; ?>archives/facility">
<figure><img src="<?php echo $home; ?>wp-content/uploads/icon_spot.svg" alt="ベルリン街歩き施設情報"></figure>
<figcaption><h2>ベルリン街歩き施設情報</h2><p>ベルリンのお出かけスポット・行政関連の施設情報をまとめています。</p></figcaption></a></li>
<li><a href="https://ok-berlin.life/tradeboard/" alt="ベルリン生活掲示板">
<figure><img src="<?php echo $home; ?>wp-content/uploads/icon_home.svg" alt="ベルリン生活掲示板"></figure>
<figcaption><h2>ベルリン生活掲示板</h2><p>物件情報、不用品シェア、告知などの取引のための掲示板です。</p></figcaption></a></li>
</ul>
</div>
<div class="spot_box">
<div class="spot_card">
<h3 class="spot_card_title">
<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><circle cx="12" cy="12" r="10"/><line x1="2" y1="12" x2="22" y2="12"/><path d="M12 2a15.3 15.3 0 0 1 4 10 15.3 15.3 0 0 1-4 10 15.3 15.3 0 0 1-4-10 15.3 15.3 0 0 1 4-10z"/></svg>
ドイツ基本情報
</h3>
<ul class="spot_card_list">
<li><a href="https://ok-berlin.life/emergency-contact">ドイツの緊急時連絡先一覧</a></li>
<li><a href="https://ok-berlin.life/deutschland/company">ドイツの有名企業一覧</a></li>
<li><a href="https://ok-berlin.life/deutschland/airport">ドイツの主要空港</a></li>
<li><a href="https://ok-berlin.life/deutschland/land">ドイツ16州</a></li>
</ul>
</div>
<div class="spot_card">
<h3 class="spot_card_title">
<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><path d="M21 10c0 7-9 13-9 13s-9-6-9-13a9 9 0 0 1 18 0z"/><circle cx="12" cy="10" r="3"/></svg>
ベルリン基本情報
</h3>
<ul class="spot_card_list">
<li><a href="https://ok-berlin.life/berlin">ベルリンの基本情報</a></li>
<li><a href="https://ok-berlin.life/berlin/public">ベルリンの公的機関・交通機関</a></li>
</ul>
</div>
<div class="spot_card">
<h3 class="spot_card_title">
<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><path d="M3 9l9-7 9 7v11a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2z"/><polyline points="9 22 9 12 15 12 15 22"/></svg>
ベルリン物件関連TIPS
</h3>
<ul class="spot_card_list">
<li><a href="https://ok-berlin.life/archives/5601">ベルリン物件探しWEBサイト</a></li>
<li><a href="https://ok-berlin.life/archives/5791">ベルリン生活ルール</a></li>
<li><a href="https://ok-berlin.life/archives/5903">ベルリンでのゴミの捨て方</a></li>
<li><a href="https://ok-berlin.life/archives/5961">犬の飼い方</a> / <a href="https://ok-berlin.life/archives/6097">猫の飼い方</a></li>
<li><a href="https://ok-berlin.life/archives/6410">賃貸物件探しレポート前半</a> / <a href="https://ok-berlin.life/archives/6665">後半</a></li>
</ul>
</div>
<div class="spot_card">
<h3 class="spot_card_title">
<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><polyline points="22 12 18 12 15 21 9 3 6 12 2 12"/></svg>
ベルリン生活関連TIPS
</h3>
<ul class="spot_card_list">
<li><a href="https://ok-berlin.life/archives/6122">病院に行きたい時</a></li>
<li><a href="https://ok-berlin.life/archives/6905">携帯電話購入方法</a></li>
<li><a href="https://ok-berlin.life/archives/7458">治安の悪いエリア</a></li>
<li><a href="https://ok-berlin.life/archives/7068">ベルリンのネガティヴなポイント</a></li>
<li><a href="https://ok-berlin.life/archives/7515">日本食通販サイト</a></li>
</ul>
</div>
<div class="spot_card">
<h3 class="spot_card_title">
<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><circle cx="12" cy="12" r="10"/><polygon points="16.24 7.76 14.12 14.12 7.76 16.24 9.88 9.88 16.24 7.76"/></svg>
ベルリンでのレジャー
</h3>
<ul class="spot_card_list">
<li><a href="https://ok-berlin.life/archives/6089">おすすめの美術館</a></li>
<li><a href="https://ok-berlin.life/archives/5752">ベルリンのクラブ</a></li>
<li><a href="https://ok-berlin.life/archives/5626">ドイツ国外旅行</a></li>
<li><a href="https://ok-berlin.life/archives/5648">ドイツ国内旅行</a></li>
</ul>
</div>
</div>
</section>
	<?php
	return ob_get_clean();
}
add_shortcode( 'okberlin_sec_contents', 'okberlin_sec_contents' );

/**
 * [okberlin_sec_about]
 * About / notice / recruitment section.
 */
function okberlin_sec_about() {
	$home = esc_url( home_url( '/' ) );
	ob_start();
	?>
<section class="sec_about-us">
<div class="wrap flexbox">
<div class="rightbox pc_only">
<img src="<?php echo $home; ?>wp-content/uploads/tram.jpg" alt="ベルリンのトラム">
</div>
<div class="leftbox">
<div class="title-section"><p>Uber uns</p><h2>OK!ベルリンとは</h2></div>
<p>OK！BERLINはベルリンの日本人在住者、日本からベルリンへの渡航を検討中の方へのお役立ち情報を掲載するサイトです。ベルリン生活がより便利になっていけたら、あるいは、ドイツの環境の中でさまざまな活動をする日本人のことを紹介できたらと思い運用しています。皆様とベルリンのいい出会いがあったらうれしいです。</p>
<div class="title-section"><p>Nachricht</p><h2>OK!ベルリンからのお知らせ</h2></div>
<p>2022年6月　ベルリン在住者のインタビュー記事の公開を開始しました！</p>
<div class="title-section"><p>Rekrutierung</p><h2>OK!ベルリン スタッフ募集</h2></div>
<p>OK!BERLINは、ベルリンの街を取材してレポートするスタッフを募集しています。ライター以外にも企画やサイト開発、その他の業務を協力していただける方がいらっしゃいましたら、是非ご連絡ください。面談の機会を設定させていただけたらと思います。学歴不問/未経験者歓迎/報酬は業務内容によって応相談とさせてください。</p>
<p class="btn"><a href="<?php echo $home; ?>archives/category/column">コラム一覧へ</a>　<a target="_blank" href="https://twitter.com/OKBerlin_"><svg xmlns="http://www.w3.org/2000/svg" width="1em" height="1em" viewBox="0 0 24 24" fill="currentColor" aria-hidden="true" style="vertical-align:middle"><path d="M18.244 2.25h3.308l-7.227 8.26 8.502 11.24H16.17l-4.714-6.231-5.401 6.231H2.747l7.73-8.835L1.254 2.25H8.08l4.262 5.632 5.901-5.632Zm-1.161 17.52h1.833L7.084 4.126H5.117z"/></svg> Twitter</a>　<a href="<?php echo $home; ?>contact">お問い合わせ</a></p>
</div>
</div>
</section>
	<?php
	return ob_get_clean();
}
add_shortcode( 'okberlin_sec_about', 'okberlin_sec_about' );
