<!DOCTYPE html>
<html <?php language_attributes(); ?>>
<head>
    <meta charset="<?php bloginfo('charset'); ?>">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <?php wp_head(); ?>
</head>
<body <?php body_class(); ?>>
<?php wp_body_open(); ?>

<header class="site-header">
    <div class="container">
        <div class="header-inner">
            <div class="site-branding">
                <h1 class="site-title">
                    <a href="<?php echo esc_url(home_url('/')); ?>">
                        <span class="company-name-ja">アバンプランニング株式会社</span>
                        <span class="company-name-en">Avant Planning Inc.</span>
                    </a>
                </h1>
            </div>
            <button class="drawer-toggle" type="button" aria-controls="site-navigation" aria-expanded="false">
                <span class="drawer-toggle-line"></span>
                <span class="drawer-toggle-line"></span>
                <span class="drawer-toggle-line"></span>
                <span class="screen-reader-text">メニューを開閉</span>
            </button>
            <nav id="site-navigation" class="main-navigation" aria-label="Main navigation">
                <ul class="nav-menu">
                    <li><a href="https://avant-p.co.jp#about">About</a></li>
                    <li><a href="https://avant-p.co.jp#services">Services</a></li>
                    <li><a href="https://avant-p.co.jp#contact">Contact</a></li>
                </ul>
            </nav>
            <button class="drawer-backdrop" type="button" aria-label="メニューを閉じる"></button>
        </div>
    </div>
</header>
