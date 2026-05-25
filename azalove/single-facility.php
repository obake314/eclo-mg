<?php
/**
 * The template for displaying all single posts
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/#single-post
 *
 * @package azarashilove
 */

get_header();
?>
<div class="entry-header">
	<h1 class="entry-title"><?php the_title(); ?></h1>
</div>	
<main id="primary" class="site-main" role="main">
<div class="wrap">
<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
<div class="entry-content">
	
<div class="image-modal" id="imageModal" aria-hidden="true">
  <div class="image-modal__backdrop" data-modal-close></div>
  <div class="image-modal__dialog" role="dialog" aria-modal="true">
		<button class="image-modal__close" type="button" data-modal-close>
			<span aria-hidden="true">×</span>
			<span>閉じる</span>
		</button>
	  <img class="image-modal__img" id="imageModalImg" src="" alt="">
  </div>
	
</div>
<script>
document.addEventListener('DOMContentLoaded', () => {
  const modal = document.getElementById('imageModal');
  const modalImg = document.getElementById('imageModalImg');
  let lastFocusedElement = null;

  if (!modal || !modalImg) return;

  const openModal = (img) => {
    const src = img.getAttribute('data-full') || img.getAttribute('src');
    const alt = img.getAttribute('alt') || '';

    if (!src) return;

    lastFocusedElement = document.activeElement;
    modalImg.src = src;
    modalImg.alt = alt;

    modal.classList.add('is-open');
    modal.setAttribute('aria-hidden', 'false');
    document.body.style.overflow = 'hidden';

    const closeBtn = modal.querySelector('.image-modal__close');
    if (closeBtn) closeBtn.focus();
  };

  const closeModal = () => {
    modal.classList.remove('is-open');
    modal.setAttribute('aria-hidden', 'true');
    document.body.style.overflow = '';

    // 閉じアニメーション後にsrcを消す
    setTimeout(() => {
      if (!modal.classList.contains('is-open')) {
        modalImg.src = '';
        modalImg.alt = '';
      }
    }, 300);

    if (lastFocusedElement) {
      lastFocusedElement.focus();
    }
  };

  document.addEventListener('click', (e) => {
    const target = e.target.closest('.grid_view figure img');
    if (target) {
      openModal(target);
      return;
    }

    if (e.target.closest('[data-modal-close]')) {
      closeModal();
    }
  });

  document.addEventListener('keydown', (e) => {
    if (!modal.classList.contains('is-open')) return;

    if (e.key === 'Escape') {
      closeModal();
    }
  });
});
</script>
<style>
.image-modal {
  position: fixed;
  inset: 0;
  z-index: 9999;

  opacity: 0;
  visibility: hidden;
  pointer-events: none;
  transition:
    opacity 0.3s ease,
    visibility 0.3s ease;
}

.image-modal.is-open {
  opacity: 1;
  visibility: visible;
  pointer-events: auto;
}

.image-modal__backdrop {
  position: absolute;
  inset: 0;
  background: rgba(0, 0, 0, 0);
  transition: background 0.3s ease;
}

.image-modal.is-open .image-modal__backdrop {
  background: rgba(0, 0, 0, 0.8);
}

.image-modal__dialog {
  position: relative;
  z-index: 1;
  width: min(90vw, 1200px);
  height: 90vh;
  margin: 5vh auto;
  display: flex;
  align-items: center;
  justify-content: center;
}
.image-modal.is-open .image-modal__dialog {
  transform: translateY(0) scale(1);
  opacity: 1;
}

.image-modal__img {
  display: block;
  max-width: 100%;
  max-height: 90vh;
  width: auto;
  height: auto;
  object-fit: contain;
  background: #fff;
}

.image-modal__close {
  position: absolute;
  top: 60px;
  right: 60px;
  border: 0;
  background: transparent;
  color: #fff;
  font-size: 50px;
  line-height: 1;
  cursor: pointer;
}

.grid_view figure img {
  cursor: pointer;
}
	.image-modal__close span{
		font-size:13px;
		display:block;
	}
	</style>
	
<?php
		the_content(
			sprintf(
				wp_kses(
					/* translators: %s: Name of current post. Only visible to screen readers */
					__( 'Continue reading<span class="screen-reader-text"> "%s"</span>', 'azarashilove' ),
					array(
						'span' => array(
							'class' => array(),
						),
					)
				),
				wp_kses_post( get_the_title() )
			)
		);

		wp_link_pages(
			array(
				'before' => '<div class="page-links">' . esc_html__( 'Pages:', 'azarashilove' ),
				'after'  => '</div>',
			)
		);
		?>
	</div><!-- .entry-content -->

	<div class="entry-footer">
		<?php azarashilove_entry_footer(); ?>
	</div><!-- .entry-footer -->
</article><!-- #post-<?php the_ID(); ?> -->
</div>
	</main><!-- #main -->
<?php
get_footer();