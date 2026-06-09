<?php
/**
 * Title: Site Header
 * Slug: azarashilove/site-header
 * Categories: azarashilove-site, header
 * Block Types: core/template-part/header
 * Inserter: true
 *
 * @package azarashilove
 */
?>
<!-- wp:html -->
<header id="masthead" class="site-header">
	<div class="wrap flexbox">
		<div class="site-branding">
			<p class="site-title">
				<a href="<?php echo esc_url( home_url( '/' ) ); ?>" rel="home">
					<img src="<?php echo esc_url( home_url( '/' ) ); ?>wp-content/uploads/header_logo-1.svg" alt="アザラブ アザラーのためのアザラシ総合情報サイト">
				</a>
			</p>
		</div>
		<button class="drawer-toggle" aria-expanded="false" aria-controls="site-drawer" aria-label="メニューを開く">
			<span></span>
			<span></span>
			<span></span>
		</button>
		<nav id="site-drawer" class="drawer-nav" aria-label="ヘッダーグローバルナビゲーション">
			<?php
			wp_nav_menu(
				array(
					'theme_location' => 'menu-1',
					'menu_id'        => 'primary-menu',
					'menu_class'     => 'flexbox',
					'fallback_cb'    => function() {
						$items = array(
							array( 'url' => '/species',                    'label' => 'アザラシの種類' ),
							array( 'url' => '/archives/category/news',     'label' => 'アザラシニュース' ),
							array( 'url' => '/facility',                   'label' => 'アザラシ施設' ),
							array( 'url' => '/archives/category/column',   'label' => 'アザラシコラム' ),
							array( 'url' => '/items',                      'label' => 'アザラシアイテム' ),
						);
						echo '<div class="menu-main-container"><ul id="primary-menu" class="flexbox">';
						foreach ( $items as $item ) {
							printf(
								'<li class="menu-item"><a href="%s">%s</a></li>',
								esc_url( home_url( $item['url'] ) ),
								esc_html( $item['label'] )
							);
						}
						echo '</ul></div>';
					},
				)
			);
			?>
			<p class="btn btn_donation">
				<a class="prun" href="<?php echo esc_url( home_url( '/' ) ); ?>donation">
					あざらしを支援する
					<img src="<?php echo esc_url( home_url( '/' ) ); ?>wp-content/uploads/btn_azarashi01.svg" alt="あざらしへの寄付リンク">
				</a>
			</p>
		</nav>
		<div class="drawer-overlay"></div>
	</div>
	<a class="skip-link" href="#primary">メインコンテンツへスキップ</a>
</header>
<!-- /wp:html -->
