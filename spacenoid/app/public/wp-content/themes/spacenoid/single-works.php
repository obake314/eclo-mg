<?php
/**
 * Single template for product works.
 *
 * @package Spacenoid
 */

get_header();

if (!function_exists('spacenoid_works_get_field')) {
    function spacenoid_works_get_field($key) {
        if (function_exists('get_field')) {
            $value = get_field($key);
            if (!empty($value)) {
                return $value;
            }
        }

        return get_post_meta(get_the_ID(), $key, true);
    }
}

if (!function_exists('spacenoid_works_get_first_field')) {
    function spacenoid_works_get_first_field($keys) {
        foreach ($keys as $key) {
            $value = spacenoid_works_get_field($key);
            if (!empty($value)) {
                return $value;
            }
        }

        return '';
    }
}

if (!function_exists('spacenoid_works_get_image_url')) {
    function spacenoid_works_get_image_url($image) {
        if (is_array($image)) {
            if (!empty($image['sizes']['large'])) {
                return $image['sizes']['large'];
            }

            return isset($image['url']) ? $image['url'] : '';
        }

        if (is_numeric($image)) {
            $url = wp_get_attachment_image_url((int) $image, 'large');
            return $url ? $url : '';
        }

        return is_string($image) ? $image : '';
    }
}

if (!function_exists('spacenoid_works_prepare_content')) {
    function spacenoid_works_prepare_content($content) {
        $toc = array();
        $used_ids = array();
        $index = 0;

        $content = preg_replace('/^\s*(<figure\b[^>]*>\s*<img\b[^>]*>\s*<\/figure>|<p\b[^>]*>\s*<img\b[^>]*>\s*<\/p>)\s*/is', '', $content, 1);

        $content = preg_replace_callback(
            '/<h([2-3])([^>]*)>(.*?)<\/h\1>/is',
            function ($matches) use (&$toc, &$used_ids, &$index) {
                $level = (int) $matches[1];
                $attributes = $matches[2];
                $inner_html = $matches[3];
                $label = trim(wp_strip_all_tags($inner_html));

                if ('' === $label) {
                    return $matches[0];
                }

                $id = '';
                if (preg_match('/\sid=(["\'])(.*?)\1/i', $attributes, $id_match)) {
                    $id = $id_match[2];
                }

                if ('' === $id) {
                    $id = strtolower(trim(preg_replace('/[^a-z0-9]+/i', '-', remove_accents($label)), '-'));
                    if ('' === $id) {
                        $id = 'product-section-' . ($index + 1);
                    }
                }

                $base_id = $id;
                $suffix = 2;
                while (isset($used_ids[$id])) {
                    $id = $base_id . '-' . $suffix;
                    $suffix++;
                }
                $used_ids[$id] = true;

                if (!preg_match('/\sid=(["\'])(.*?)\1/i', $attributes)) {
                    $attributes .= ' id="' . esc_attr($id) . '"';
                }

                if (2 === $level) {
                    $toc[] = array(
                        'level' => $level,
                        'id'    => $id,
                        'label' => $label,
                    );
                }
                $index++;

                return '<h' . $level . $attributes . '>' . $inner_html . '</h' . $level . '>';
            },
            $content
        );

        return array(
            'content' => $content,
            'toc'     => $toc,
        );
    }
}
?>

<div class="section_content stage-single works-single">
    <?php if (have_posts()) : ?>
        <?php while (have_posts()) : the_post(); ?>
            <?php
            $product_title = spacenoid_works_get_first_field(array('product_name', 'works_name', 'work_name', 'disc_name'));
            $product_title = $product_title ? $product_title : get_the_title();
            $product_artist = spacenoid_works_get_first_field(array('artist', 'product_artist', 'works_artist', 'work_artist'));
            $product_release = spacenoid_works_get_first_field(array('release_date', 'product_date', 'works_date', 'work_date', 'disc_time', 'date'));
            $product_price = spacenoid_works_get_first_field(array('product_price', 'works_price', 'work_price', 'disc_price', 'price'));
            $product_number = spacenoid_works_get_first_field(array('catalog_number', 'product_number', 'works_number', 'work_number', 'product_code', 'jan'));
            $product_link = spacenoid_works_get_first_field(array('product_url', 'shop_url', 'store_url', 'disc_url', 'buy_url', 'url'));
            $product_image = spacenoid_works_get_image_url(spacenoid_works_get_first_field(array('product_img', 'product_image', 'works_img', 'works_image', 'work_img', 'jacket_img', 'jacket', 'cover', 'disc_img', 'image')));

            if (!$product_image && has_post_thumbnail()) {
                $product_image = get_the_post_thumbnail_url(get_the_ID(), 'large');
            }

            $prepared = spacenoid_works_prepare_content(apply_filters('the_content', get_the_content()));
            $has_content = '' !== trim(wp_strip_all_tags($prepared['content']));
            $product_excerpt = has_excerpt() ? get_the_excerpt() : '';
            ?>

            <section class="page-header stage-single__header works-single__header" data-page-title="<?php echo esc_attr($product_title); ?>">
                <p class="page-title" data-display-title="<?php echo esc_attr($product_title); ?>">製品情報</p>
            </section>

            <div class="stage-single__layout works-single__layout<?php echo empty($prepared['toc']) ? ' works-single__layout--no-toc' : ''; ?>">
                <?php if (!empty($prepared['toc'])) : ?>
                    <button class="stage-toc-toggle" type="button" aria-controls="works-toc-panel" aria-expanded="false">Index</button>
                    <aside id="works-toc-panel" class="stage-single__toc" aria-labelledby="works-toc-title">
                        <p id="works-toc-title" class="stage-single__toc-title">Index</p>
                        <nav aria-label="<?php esc_attr_e('Page sections', 'spacenoid'); ?>">
                            <ol>
                                <?php foreach ($prepared['toc'] as $toc_item) : ?>
                                    <li class="stage-single__toc-item stage-single__toc-item--level-<?php echo esc_attr($toc_item['level']); ?>">
                                        <a href="#<?php echo esc_attr($toc_item['id']); ?>"><?php echo esc_html($toc_item['label']); ?></a>
                                    </li>
                                <?php endforeach; ?>
                            </ol>
                        </nav>
                    </aside>
                <?php endif; ?>

                <article id="post-<?php the_ID(); ?>" <?php post_class('page-content stage-single__content works-single__content'); ?>>
                    <section class="stage-single__hero works-single__hero" aria-labelledby="works-single-title">
                        <div class="stage-single__hero-copy works-single__hero-copy">
                            <p class="stage-single__hero-label">Product</p>
                            <h1 id="works-single-title"><?php echo esc_html($product_title); ?></h1>

                            <?php if ($product_excerpt) : ?>
                                <p class="works-single__lead"><?php echo esc_html($product_excerpt); ?></p>
                            <?php endif; ?>

                            <?php if ($product_artist || $product_release || $product_price || $product_number) : ?>
                                <dl class="stage-single__meta works-single__meta">
                                    <?php if ($product_artist) : ?>
                                        <div>
                                            <dt>Artist</dt>
                                            <dd><?php echo esc_html($product_artist); ?></dd>
                                        </div>
                                    <?php endif; ?>
                                    <?php if ($product_release) : ?>
                                        <div>
                                            <dt>Release</dt>
                                            <dd><?php echo esc_html($product_release); ?></dd>
                                        </div>
                                    <?php endif; ?>
                                    <?php if ($product_price) : ?>
                                        <div>
                                            <dt>Price</dt>
                                            <dd><?php echo esc_html($product_price); ?></dd>
                                        </div>
                                    <?php endif; ?>
                                    <?php if ($product_number) : ?>
                                        <div>
                                            <dt>No.</dt>
                                            <dd><?php echo esc_html($product_number); ?></dd>
                                        </div>
                                    <?php endif; ?>
                                </dl>
                            <?php endif; ?>

                            <?php if ($product_link) : ?>
                                <p class="stage-single__flyer works-single__cta">
                                    <a href="<?php echo esc_url($product_link); ?>" target="_blank" rel="noopener">取扱ページ</a>
                                </p>
                            <?php endif; ?>
                        </div>

                        <?php if ($product_image) : ?>
                            <figure class="stage-single__visual works-single__visual">
                                <img src="<?php echo esc_url($product_image); ?>" alt="<?php echo esc_attr($product_title); ?>">
                            </figure>
                        <?php endif; ?>
                    </section>

                    <?php if ($has_content) : ?>
                        <div class="entry-content">
                            <?php echo $prepared['content']; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?>
                        </div>
                    <?php endif; ?>
                </article>
            </div>
        <?php endwhile; ?>
    <?php endif; ?>
</div>

<script>
document.querySelectorAll('.stage-single__toc a[href^="#"]').forEach(function (anchor) {
    anchor.addEventListener('click', function (event) {
        var rawId = anchor.getAttribute('href').slice(1);
        var id = rawId;

        try {
            id = decodeURIComponent(rawId);
        } catch (error) {}

        var target = document.getElementById(id) || document.getElementById(rawId);
        if (!target) {
            return;
        }

        event.preventDefault();
        target.scrollIntoView({ behavior: 'smooth', block: 'start' });
        window.history.pushState(null, '', '#' + rawId);
        document.body.classList.remove('is-toc-open');
        document.querySelectorAll('.stage-toc-toggle').forEach(function (toggle) {
            toggle.setAttribute('aria-expanded', 'false');
        });
    });
});

document.querySelectorAll('.stage-toc-toggle').forEach(function (toggle) {
    var panel = document.getElementById(toggle.getAttribute('aria-controls'));
    if (!panel) {
        return;
    }

    toggle.addEventListener('click', function () {
        var open = !document.body.classList.contains('is-toc-open');
        document.body.classList.toggle('is-toc-open', open);
        toggle.setAttribute('aria-expanded', open ? 'true' : 'false');
    });
});

document.addEventListener('keydown', function (event) {
    if (event.key !== 'Escape') {
        return;
    }

    document.body.classList.remove('is-toc-open');
    document.querySelectorAll('.stage-toc-toggle').forEach(function (toggle) {
        toggle.setAttribute('aria-expanded', 'false');
    });
});
</script>

<?php get_footer(); ?>
