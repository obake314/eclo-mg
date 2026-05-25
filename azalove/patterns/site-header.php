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
