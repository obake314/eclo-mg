document.addEventListener('DOMContentLoaded', function () {

	// Scrolled header
	const siteHeader = document.querySelector('.site-header');
	if (siteHeader) {
		const onScroll = () => {
			siteHeader.classList.toggle('is-scrolled', window.scrollY > 60);
		};
		window.addEventListener('scroll', onScroll, { passive: true });
		onScroll();
	}

	// Fade-up on scroll
	const fadeEls = document.querySelectorAll('.fadeUp');
	if (fadeEls.length) {
		const observer = new IntersectionObserver(
			(entries) => {
				entries.forEach((entry) => {
					if (entry.isIntersecting) {
						entry.target.classList.add('is-visible');
						observer.unobserve(entry.target);
					}
				});
			},
			{ threshold: 0.15 }
		);
		fadeEls.forEach((el) => observer.observe(el));
	}

	// Make column media cards clickable.
	document.querySelectorAll('.list_column_media > li').forEach((card) => {
		const href = card.dataset.cardUrl || card.querySelector('a[href]')?.href;
		if (!href) return;

		card.classList.add('is-clickable-card');
		card.setAttribute('role', 'link');
		card.setAttribute('tabindex', '0');

		const title = card.querySelector('.wp-block-post-title')?.textContent?.trim();
		if (title && !card.hasAttribute('aria-label')) {
			card.setAttribute('aria-label', title);
		}

		const go = () => {
			window.location.href = href;
		};

		card.addEventListener('click', (event) => {
			if (
				event.defaultPrevented ||
				event.button !== 0 ||
				event.metaKey ||
				event.ctrlKey ||
				event.shiftKey ||
				event.altKey ||
				event.target.closest('a, button, input, textarea, select, label')
			) {
				return;
			}

			go();
		});

		card.addEventListener('keydown', (event) => {
			if (event.target !== card || (event.key !== 'Enter' && event.key !== ' ')) return;
			event.preventDefault();
			go();
		});
	});

	// Drawer hamburger menu
	const toggle = document.querySelector('.drawer-toggle');
	if (toggle) {
		const overlay = document.createElement('div');
		overlay.className = 'drawer-overlay';
		document.body.appendChild(overlay);

		const closeDrawer = () => {
			document.body.classList.remove('drawer-open');
			toggle.setAttribute('aria-expanded', 'false');
		};
		const openDrawer  = () => {
			document.body.classList.add('drawer-open');
			toggle.setAttribute('aria-expanded', 'true');
		};

		toggle.setAttribute('aria-expanded', 'false');

		toggle.addEventListener('click', function () {
			document.body.classList.contains('drawer-open') ? closeDrawer() : openDrawer();
		});
		overlay.addEventListener('click', closeDrawer);
		document.querySelectorAll('.drawer-nav a[href]').forEach((link) => {
			link.addEventListener('click', closeDrawer);
		});
		document.addEventListener('keydown', function (e) {
			if (e.key === 'Escape') closeDrawer();
		});
	}

	// Swiper for pickup column slider
	const pickupEl = document.querySelector('.list_pickup');
	if (pickupEl) {
		new Swiper(pickupEl, {
			effect: 'fade',
			loop: true,
			navigation: {
				nextEl: '.list_pickup .swiper-button-next',
				prevEl: '.list_pickup .swiper-button-prev',
			},
		});
	}
});
