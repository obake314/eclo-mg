<?php
/**
 * Main Index Template
 * 
 * @package Spacenoid
 */

get_header();
?>

 <?php
    $slider_items = array(
        array(
            'type' => 'link',
            'url' => home_url('/project#event'),
            'title_ja' => 'イベント',
            'title_en' => 'EVENT',
        ),
        array(
            'type' => 'link',
            'url' => home_url('/project#stage'),
            'title_ja' => '舞台制作',
            'title_en' => 'STAGE',
        ),
        array(
            'type' => 'link',
            'url' => home_url('/contact'),
            'title_ja' => 'お問い合わせ',
            'title_en' => 'CONTACT US',
        ),
        array(
            'type' => 'link',
            'url' => home_url('/members'),
            'title_ja' => '所属',
            'title_en' => 'MEMBERS',
        ),
        array(
            'type' => 'company',
            'title' => 'Spacenoid Company Inc.',
        ),
        array(
            'type' => 'shop',
            'url' => 'https://spacenoid.thebase.in/',
            'title' => 'ONLINESHOP',
            'external' => true,
        ),
        array(
            'type' => 'link',
            'url' => home_url('/writers'),
            'title_ja' => '脚本家',
            'title_en' => 'Spacenoid Writers Room',
        ),
        array(
            'type' => 'about',
            'logo' => 'https://spacenoid.jp/test/wp-content/uploads/logo.jpg',
            'title_ja' => '会社概要',
            'title_en' => 'About Us',
            'info' => array(
                '会社名' => '株式会社スペースノイドカンパニー',
                '所在地' => '〒111-0042<br>東京都台東区寿1-6-7<br>ユーハイツ伸光901',
                '設立' => '2018年5月16日',
                'お問い合わせ' => '<a href="' . esc_url(home_url('/contact')) . '">お問い合わせはこちら</a>',
            ),
        ),
        /* array(
            'type' => 'kakashido',
            'url' => home_url('/kakashido'),
            'image' => 'https://spacenoid.jp/test/wp-content/uploads/member_ito.png',
            'title' => '案山子堂',
        ),　*/
    );
    ?>

    <ul class="slider" role="list" aria-label="<?php esc_attr_e('Company Information Slider', 'spacenoid'); ?>">
        <?php foreach ($slider_items as $item): ?>
            <li>
                <?php
                switch ($item['type']) {
                    case 'link':
                        spacenoid_render_link_slide($item);
                        break;
                    case 'company':
                        spacenoid_render_company_slide($item);
                        break;
                    case 'shop':
                    case 'writers':
                        spacenoid_render_text_slide($item);
                        break;
                    case 'about':
                        spacenoid_render_about_slide($item);
                        break;
                    case 'kakashido':
                        spacenoid_render_image_slide($item);
                        break;
                }
                ?>
            </li>
        <?php endforeach; ?>
    </ul>

<?php get_footer(); ?>
<script>
    (function () {
        'use strict';

        // Wait for DOM to be ready
        if (document.readyState === 'loading') {
            document.addEventListener('DOMContentLoaded', initSlider);
        } else {
            initSlider();
        }

        function initSlider() {
            const slider = document.querySelector('.slider');
            if (!slider) return;

            const slides = Array.from(slider.querySelectorAll('li'));
            if (slides.length === 0) return;

            // Randomize slides using Fisher-Yates shuffle
            const slideContents = slides.map(slide => slide.innerHTML);
            for (let i = slideContents.length - 1; i > 0; i--) {
                const j = Math.floor(Math.random() * (i + 1));
                [slideContents[i], slideContents[j]] = [slideContents[j], slideContents[i]];
            }

            // Repopulate slides with shuffled content
            slides.forEach((slide, index) => {
                slide.innerHTML = slideContents[index];
            });

            // Initialize slider
            let currentIndex = 0;
            slides[currentIndex].classList.add('active');

            // Auto-advance slides
            setInterval(() => {
                const currentSlide = slides[currentIndex];
                const nextIndex = (currentIndex + 1) % slides.length;
                const nextSlide = slides[nextIndex];
                currentSlide.classList.add('fade-out');
                currentSlide.classList.remove('active');
                nextSlide.classList.add('active');
                nextSlide.classList.remove('fade-out');
                currentIndex = nextIndex;
            }, 3000); // Change slide every 3 seconds
        }
    })();
</script>


<?php
/**
 * Helper functions for rendering slide content
 */

function spacenoid_render_link_slide($item)
{
    ?>
    <div class="box_outline">
        <div class="intro">
            <p class="name">
                <a href="<?php echo esc_url($item['url']); ?>">
                    <span><?php echo esc_html($item['title_ja']); ?></span>
                    <strong><?php echo esc_html($item['title_en']); ?></strong>
                </a>
            </p>
        </div>
    </div>
    <?php
}

function spacenoid_render_company_slide($item)
{
    ?>
    <div class="box_outline">
        <div class="leftbox">
            <p class="name">
                <span>株式会社スペースノイドカンパニー</span>
                <strong><?php echo esc_html($item['title']); ?></strong>
            </p>
        </div>
    </div>
    <?php
}


function spacenoid_render_text_slide($item)
{
    ?>
    <div class="box_outline">
        <div class="intro fd_colmun">
            <p class="name">
                <a href="<?php echo esc_url($item['url']); ?>">
                    <strong><?php echo esc_html($item['title']); ?></strong>
                    <?php if (!empty($item['external'])): ?>
                        <em class="store-link-icon"><span><?php esc_html_e('Online Store', 'spacenoid'); ?></span></em>
                    <?php endif; ?>
                    <span><?php echo esc_html($item['url']); ?></span>
                </a>
            </p>
        </div>
    </div>
    <?php
}

function spacenoid_render_about_slide($item)
{
    ?>
    <div class="box_outline flexbox">
        <div class="leftbox">
            <img src="<?php echo esc_url($item['logo']); ?>"
                alt="<?php esc_attr_e('Spacenoid Company Logo', 'spacenoid'); ?>">
        </div>
        <div class="rightbox">
            <div class="outline_info">
                <p class="name">
                    <span>会社概要</span>
                    <strong>Outline</strong>
                </p>
                <table class="table_outline">
                    <?php foreach ($item['info'] as $label => $value): ?>
                        <tr>
                            <th><?php echo esc_html($label); ?></th>
                            <td><?php echo wp_kses_post($value); ?></td>
                        </tr>
                    <?php endforeach; ?>
                    </table>
            </div>
        </div>
    </div>
    <?php
}

function spacenoid_render_image_slide($item)
{
    ?>
    <div class="box_outline flexbox">
        <div class="leftbox">
            <img src="<?php echo esc_url($item['image']); ?>" alt="<?php echo esc_attr($item['title']); ?>">
        </div>
        <div class="rightbox">
            <div class="intro">
                <p class="name">
					<a href="<?php echo esc_url($item['url']); ?>">
                    	<strong>
                       		<?php echo esc_html($item['title']); ?>
                        </strong>
                    </a>
                </p>
            </div>
        </div>
    </div>

    <?php
}
