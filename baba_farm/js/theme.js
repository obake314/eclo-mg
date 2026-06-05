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

	// Drawer hamburger menu
	const toggle = document.querySelector('.drawer-toggle');
	if (toggle) {
		const overlay = document.createElement('div');
		overlay.className = 'drawer-overlay';
		document.body.appendChild(overlay);

		const closeDrawer = () => document.body.classList.remove('drawer-open');
		const openDrawer  = () => document.body.classList.add('drawer-open');

		toggle.addEventListener('click', function () {
			document.body.classList.contains('drawer-open') ? closeDrawer() : openDrawer();
		});
		overlay.addEventListener('click', closeDrawer);
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
