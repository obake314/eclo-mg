<?php
/**
 * The header for our theme
 *
 * This is the template that displays all of the <head> section and everything up until <div id="content">
 *
 * @link https://developer.wordpress.org/themes/basics/template-files/#template-partials
 *
 * @package baba_farm
 */

?>
<!doctype html>
<html <?php language_attributes(); ?>>
<head>
	<meta charset="<?php bloginfo( 'charset' ); ?>">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<meta name="facebook-domain-verification" content="ip9xzogy58vm9hhcozgrmu1p5e57w8" />

	<link rel="profile" href="https://gmpg.org/xfn/11">

	<!-- Google Analytics -->
	<script async src="https://www.googletagmanager.com/gtag/js?id=G-CX3WMRG1RC"></script>
	<script>
	  window.dataLayer = window.dataLayer || [];
	  function gtag(){dataLayer.push(arguments);}
	  gtag('js', new Date());
	  gtag('config', 'G-CX3WMRG1RC');
	</script>

	<?php wp_head(); ?>
</head>

<body <?php body_class( 'drawer drawer--right' ); ?>>

<div id="fb-root"></div>
<script async defer crossorigin="anonymous" src="https://connect.facebook.net/ja_JP/sdk.js#xfbml=1&version=v11.0&appId=751474652207415&autoLogAppEvents=1"></script>
	
<?php
$logo_url = esc_url( content_url( 'uploads/logo-1.svg' ) );
$home_url = esc_url( home_url( '/' ) );
$logo_alt = esc_attr( '三右エ門｜ホワイトアスパラ「白い果実」｜株式会社馬場園芸' );
$shop_url = 'https://poke-m.com/products?words=%E4%B8%89%E5%8F%B3%E3%82%A8%E9%96%80&sort_order=recommended&type=all';
?>
<header role="banner" class="sp_only">
	<p class="site-branding">
		<a href="<?php echo $home_url; ?>" rel="home">
			<img src="<?php echo $logo_url; ?>" width="200" height="56" alt="<?php echo $logo_alt; ?>" fetchpriority="high">
		</a>
	</p>
	<button type="button" class="drawer-toggle drawer-hamburger">
		<span class="sr-only">toggle navigation</span>
		<span class="drawer-hamburger-icon"></span>
	</button>
	<nav class="drawer-nav" role="navigation">
		<?php wp_nav_menu( array( 'theme_location' => 'menu-1', 'menu_id' => 'primary-menu' ) ); ?>
		<ul class="flexbox header02">
			<li><a onclick="gtag('event','ボタンクリック',{'click_category':'btn','btn_position':'drawer'});" href="<?php echo esc_url( $shop_url ); ?>"><i class="fas fa-shopping-cart"></i>　オンラインストア</a></li>
		</ul>
	</nav><!-- #site-navigation -->
</header>

<div id="page" class="site">
	<header id="masthead" class="site-header pc_only">
	<div class="container flexbox">
		<?php if ( is_front_page() || is_home() ) : ?>
			<h1 class="site-branding">
				<a href="<?php echo $home_url; ?>"><img src="<?php echo $logo_url; ?>" alt="<?php echo $logo_alt; ?>"></a>
			</h1>
		<?php else : ?>
			<p class="site-branding">
				<a href="<?php echo $home_url; ?>"><img src="<?php echo $logo_url; ?>" alt="<?php echo $logo_alt; ?>"></a>
			</p>
		<?php endif; ?>
		
		<nav id="site-navigation" class="main-navigation flexbox">
			<?php
			wp_nav_menu(
				array(
					'theme_location' => 'menu-1',
					'menu_id'        => 'primary-menu',
				)
			);
			?>
			<ul class="flexbox header02">
				<li><a onclick="gtag('event','ボタンクリック',{'click_category':'banner','btn_position':'header'});" href="<?php echo esc_url( $shop_url ); ?>"><i class="fas fa-shopping-cart"></i>　オンラインストア</a></li>
			</ul>
		</nav><!-- #site-navigation -->
		</div>
	</header><!-- #masthead -->