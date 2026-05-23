<?php
/**
 * Single template for events.
 *
 * @package Spacenoid
 */

get_header();

if (!function_exists('spacenoid_event_get_field')) {
    function spacenoid_event_get_field($key) {
        if (function_exists('get_field')) {
            $value = get_field($key);
            if (!empty($value)) {
                return $value;
            }
        }

        return get_post_meta(get_the_ID(), $key, true);
    }
}

if (!function_exists('spacenoid_event_get_image_url')) {
    function spacenoid_event_get_image_url($image) {
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

if (!function_exists('spacenoid_event_prepare_content')) {
    function spacenoid_event_prepare_content($content) {
        $toc = array();
        $used_ids = array();
        $index = 0;

        $content = preg_replace_callback(
            '/(<section\b(?=[^>]*\bsec_([a-z0-9_-]+)\b)[^>]*>)(.*?)(<\/section>)/is',
            function ($matches) {
                $anchor = 'intro' === $matches[2] ? 'introduction' : $matches[2];
                $section_body = preg_replace_callback(
                    '/<h([2-3])([^>]*)>/i',
                    function ($heading_matches) use ($anchor) {
                        if (preg_match('/\sid=(["\'])(.*?)\1/i', $heading_matches[2])) {
                            return $heading_matches[0];
                        }

                        return '<h' . $heading_matches[1] . $heading_matches[2] . ' id="' . esc_attr($anchor) . '">';
                    },
                    $matches[3],
                    1
                );

                return $matches[1] . $section_body . $matches[4];
            },
            $content
        );

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
                        $id = 'event-section-' . ($index + 1);
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

<div class="section_content stage-single event-single">
    <?php if (have_posts()) : ?>
        <?php while (have_posts()) : the_post(); ?>
            <?php
            $event_name = spacenoid_event_get_field('event_name');
            $event_date = spacenoid_event_get_field('event_date');
            $event_place = spacenoid_event_get_field('event_place');
            $event_digital_flyer_url = spacenoid_event_get_field('digital_flyer_url');
            $event_image = spacenoid_event_get_image_url(spacenoid_event_get_field('event_img'));
            if (!$event_image && has_post_thumbnail()) {
                $event_image = get_the_post_thumbnail_url(get_the_ID(), 'large');
            }
            $prepared = spacenoid_event_prepare_content(apply_filters('the_content', get_the_content()));
            $prepared['content'] = preg_replace('/<p\b[^>]*>\s*<a\b[^>]*>\s*電子チラシはこちら\s*<\/a>\s*<\/p>\s*/u', '', $prepared['content']);
            ?>

            <section class="page-header stage-single__header" data-page-title="<?php echo esc_attr($event_name ? $event_name : get_the_title()); ?>">
                <p class="page-title" data-display-title="<?php echo esc_attr($event_name ? $event_name : get_the_title()); ?>">イベント記録</p>
            </section>

            <div class="stage-single__layout">
                <?php if (!empty($prepared['toc'])) : ?>
                    <button class="stage-toc-toggle" type="button" aria-controls="event-toc-panel" aria-expanded="false">Index</button>
                    <aside id="event-toc-panel" class="stage-single__toc" aria-labelledby="event-toc-title">
                        <p id="event-toc-title" class="stage-single__toc-title">Index</p>
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

                <article id="post-<?php the_ID(); ?>" <?php post_class('page-content stage-single__content'); ?>>
                    <section class="stage-single__hero" aria-labelledby="event-single-title">
                        <div class="stage-single__hero-copy">
                            <p class="stage-single__hero-label">Event</p>
                            <h1 id="event-single-title"><?php echo esc_html($event_name ? $event_name : get_the_title()); ?></h1>
                            <?php if ($event_date || $event_place) : ?>
                                <dl class="stage-single__meta">
                                    <?php if ($event_date) : ?>
                                        <div>
                                            <dt>Date</dt>
                                            <dd><?php echo esc_html($event_date); ?></dd>
                                        </div>
                                    <?php endif; ?>
                                    <?php if ($event_place) : ?>
                                        <div>
                                            <dt>Venue</dt>
                                            <dd><?php echo esc_html($event_place); ?></dd>
                                        </div>
                                    <?php endif; ?>
                                </dl>
                            <?php endif; ?>
                            <?php if ($event_digital_flyer_url) : ?>
                                <p class="stage-single__flyer">
                                    <a href="<?php echo esc_url($event_digital_flyer_url); ?>" target="_blank" rel="noopener">電子チラシはこちら</a>
                                </p>
                            <?php endif; ?>
                        </div>
                        <?php if ($event_image) : ?>
                            <figure class="stage-single__visual">
                                <img src="<?php echo esc_url($event_image); ?>" alt="<?php echo esc_attr($event_name ? $event_name : get_the_title()); ?>">
                            </figure>
                        <?php endif; ?>
                    </section>
                    <div class="entry-content">
                        <?php echo $prepared['content']; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?>
                    </div>
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
