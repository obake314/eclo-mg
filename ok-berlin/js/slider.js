(function () {
	'use strict';

	// --- Fade slider (.slider) -----------------------------------------------
	// index.php: 2-image fade slideshow, auto-advances every 4 seconds.

	var fadeEl = document.querySelector('.slider');
	if (fadeEl) {
		var slides = Array.from(fadeEl.querySelectorAll('.image'));

		if (slides.length > 1) {
			fadeEl.style.position = 'relative';

			slides.forEach(function (slide, i) {
				slide.style.cssText += [
					'position:absolute',
					'inset:0',
					'width:100%',
					'height:100%',
					'opacity:' + (i === 0 ? '1' : '0'),
					'transition:opacity 1.2s ease',
				].join(';');
			});

			var current = 0;
			setInterval(function () {
				slides[current].style.opacity = '0';
				current = (current + 1) % slides.length;
				slides[current].style.opacity = '1';
			}, 4000);
		}
	}

	// --- Marquee carousel (.slider02) ----------------------------------------
	// page-support.php: continuous infinite-scroll carousel.

	var marqueeEl = document.querySelector('.slider02');
	if (marqueeEl) {
		var items = Array.from(marqueeEl.querySelectorAll('li'));

		// Clone items once to create seamless loop
		items.forEach(function (item) {
			marqueeEl.appendChild(item.cloneNode(true));
		});

		marqueeEl.style.cssText += [
			'display:flex',
			'flex-wrap:nowrap',
			'overflow:hidden',
			'will-change:transform',
		].join(';');

		var offset = 0;
		var speed  = 0.6; // px per animation frame

		function tick() {
			offset -= speed;
			// Reset when the original set of items has fully scrolled out
			if (Math.abs(offset) >= marqueeEl.scrollWidth / 2) {
				offset = 0;
			}
			marqueeEl.style.transform = 'translateX(' + offset + 'px)';
			requestAnimationFrame(tick);
		}

		requestAnimationFrame(tick);
	}
}());
