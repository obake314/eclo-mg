<!DOCTYPE html>
<html <?php language_attributes(); ?>>
<head>
    <meta charset="<?php bloginfo('charset'); ?>">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <?php if (is_front_page() || is_home()) : ?>
        <meta name="description" content="株式会社スペースノイドカンパニー">
    <?php endif; ?>
    <?php wp_head(); ?>
    <?php
    $spacenoid_conditional_styles = array();

    if (is_front_page() || is_home()) {
        $spacenoid_conditional_styles['spacenoid-home'] = '/css/home.css';
    } else {
        $spacenoid_conditional_styles['spacenoid-lower-pages'] = '/css/lower-pages.css';
    }

    $spacenoid_is_project_page = is_page(1598) || is_page('project');
    if (!$spacenoid_is_project_page && is_page()) {
        $spacenoid_current_page = get_post();
        if ($spacenoid_current_page instanceof WP_Post) {
            $spacenoid_is_project_page = in_array(1598, get_post_ancestors($spacenoid_current_page), true);
        }
    }

    if ($spacenoid_is_project_page) {
        $spacenoid_conditional_styles['spacenoid-project-page'] = '/css/project-page.css';
    }

    foreach ($spacenoid_conditional_styles as $spacenoid_style_id => $spacenoid_style_path) :
        $spacenoid_style_file = get_template_directory() . $spacenoid_style_path;
        $spacenoid_style_url = get_template_directory_uri() . $spacenoid_style_path;
        $spacenoid_style_version = file_exists($spacenoid_style_file) ? filemtime($spacenoid_style_file) : SPACENOID_VERSION;
        ?>
        <link rel="stylesheet" id="<?php echo esc_attr($spacenoid_style_id); ?>-css" href="<?php echo esc_url(add_query_arg('ver', $spacenoid_style_version, $spacenoid_style_url)); ?>" media="all">
    <?php endforeach; ?>
    <!-- Google Analytics -->
    <?php if (!is_user_logged_in()) : // Don't track logged-in users ?>
    <script async src="https://www.googletagmanager.com/gtag/js?id=UA-161252115-1"></script>
    <script>
        window.dataLayer = window.dataLayer || [];
        function gtag(){dataLayer.push(arguments);}
        gtag('js', new Date());
        gtag('config', 'UA-161252115-1', {
            'anonymize_ip': true
        });
    </script>
    <?php endif; ?>
</head>
<body <?php body_class(); ?>>
<main id="main" class="site-main">
    <div id="content-wrapper" class="home-content">
		<header>
            <?php
            $spacenoid_logo_id = get_theme_mod('custom_logo');
            $spacenoid_logo_url = $spacenoid_logo_id ? wp_get_attachment_image_url($spacenoid_logo_id, 'full') : content_url('/uploads/logo.png');
            $spacenoid_company_name = '株式会社スペースノイドカンパニー';
            $spacenoid_company_name_en = 'Spacenoid Company Inc';
            ?>
            <?php if ( ! is_front_page() && ! is_home() ) : ?>
                <p class="site-title">
                    <a class="site-brand" href="<?php echo esc_url( home_url('/') ); ?>">
                        <?php if ( $spacenoid_logo_url ) : ?>
                            <img class="site-logo" src="<?php echo esc_url( $spacenoid_logo_url ); ?>" alt="" aria-hidden="true">
                        <?php endif; ?>
                        <span class="site-brand__text">
                            <span class="site-title-ja"><?php echo esc_html( $spacenoid_company_name ); ?></span>
                            <span class="site-title-en"><?php echo esc_html( $spacenoid_company_name_en ); ?></span>
                        </span>
                    </a>
                </p>
                <button class="site-nav-toggle" type="button" aria-controls="site-navigation" aria-expanded="false" aria-label="メニューを開閉">
                    <span class="site-nav-toggle__line"></span>
                    <span class="site-nav-toggle__text">Menu</span>
                </button>
				<?php
                wp_nav_menu(
                    array(
                        'theme_location'  => 'header-menu',
                        'container'       => 'div',
                        'container_id'    => 'site-navigation',
                        'container_class' => 'site-navigation',
                        'menu_class'      => 'site-navigation__menu',
                    )
                );
                ?>
            <?php else : ?>
                <h1 class="site-title">
                    <a class="site-brand" href="<?php echo esc_url( home_url('/') ); ?>">
                        <?php if ( $spacenoid_logo_url ) : ?>
                            <img class="site-logo" src="<?php echo esc_url( $spacenoid_logo_url ); ?>" alt="" aria-hidden="true">
                        <?php endif; ?>
                        <span class="site-brand__text">
                            <span class="site-title-ja"><?php echo esc_html( $spacenoid_company_name ); ?></span>
                            <span class="site-title-en"><?php echo esc_html( $spacenoid_company_name_en ); ?></span>
                        </span>
                    </a>
                </h1>
			<?php endif; ?>
		</header>
        <script>
        (function () {
            var toggle = document.querySelector('.site-nav-toggle');
            var navigation = document.getElementById('site-navigation');

            if (!toggle || !navigation) {
                return;
            }

            function setNavigation(open) {
                document.body.classList.toggle('is-nav-open', open);
                toggle.setAttribute('aria-expanded', open ? 'true' : 'false');
            }

            toggle.addEventListener('click', function () {
                setNavigation(!document.body.classList.contains('is-nav-open'));
            });

            navigation.addEventListener('click', function (event) {
                if (event.target.closest('a')) {
                    setNavigation(false);
                }
            });

            document.addEventListener('keydown', function (event) {
                if (event.key === 'Escape') {
                    setNavigation(false);
                }
            });
        })();
        </script>
