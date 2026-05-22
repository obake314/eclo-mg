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
            <nav class="main-navigation">
                <ul class="nav-menu">
                    <li><a href="https://avant-p.co.jp#about">About</a></li>
                    <li><a href="https://avant-p.co.jp#services">Services</a></li>
                    <li><a href="https://avant-p.co.jp#contact">Contact</a></li>
                </ul>
            </nav>
        </div>
    </div>
</header>