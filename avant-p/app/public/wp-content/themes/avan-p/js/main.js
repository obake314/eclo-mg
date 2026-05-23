/**
 * Avant Planning Main JavaScript
 */

document.addEventListener('DOMContentLoaded', function() {
    const drawerToggle = document.querySelector('.drawer-toggle');
    const drawerBackdrop = document.querySelector('.drawer-backdrop');
    const mainNavigation = document.querySelector('.main-navigation');

    const closeDrawer = () => {
        document.body.classList.remove('is-drawer-open');

        if (drawerToggle) {
            drawerToggle.setAttribute('aria-expanded', 'false');
        }
    };

    const openDrawer = () => {
        document.body.classList.add('is-drawer-open');

        if (drawerToggle) {
            drawerToggle.setAttribute('aria-expanded', 'true');
        }
    };

    const initDrawer = () => {
        if (!drawerToggle || !mainNavigation) return;

        drawerToggle.addEventListener('click', () => {
            if (document.body.classList.contains('is-drawer-open')) {
                closeDrawer();
            } else {
                openDrawer();
            }
        });

        if (drawerBackdrop) {
            drawerBackdrop.addEventListener('click', closeDrawer);
        }

        mainNavigation.querySelectorAll('a').forEach(link => {
            link.addEventListener('click', closeDrawer);
        });

        window.addEventListener('keydown', event => {
            if (event.key === 'Escape') {
                closeDrawer();
            }
        });

        window.addEventListener('resize', () => {
            if (window.matchMedia('(min-width: 769px)').matches) {
                closeDrawer();
            }
        });
    };
    
    // スムーススクロール
    const smoothScroll = () => {
        const links = document.querySelectorAll('a[href^="#"], a[href^="/#"]');
        
        links.forEach(link => {
            link.addEventListener('click', function(e) {
                const href = this.getAttribute('href');
                const hash = href.startsWith('/#') ? href.slice(1) : href;
                
                // #のみの場合は処理しない
                if (hash === '#') return;
                
                const target = document.querySelector(hash);
                
                if (target) {
                    e.preventDefault();

                    const header = document.querySelector('.site-header');
                    const headerHeight = header ? header.offsetHeight : 0;
                    const targetPosition = target.offsetTop - headerHeight - 20;
                    
                    window.scrollTo({
                        top: targetPosition,
                        behavior: 'smooth'
                    });
                }
            });
        });
    };
    
    // ヘッダーのスクロール時の挙動
    const handleHeaderScroll = () => {
        const header = document.querySelector('.site-header');

        if (!header) return;
        
        window.addEventListener('scroll', () => {
            const currentScroll = window.pageYOffset;
            
            if (currentScroll > 100) {
                header.style.boxShadow = 'var(--shadow-header-scrolled)';
            } else {
                header.style.boxShadow = 'var(--shadow-header)';
            }
        });
    };
    
    // フェードインアニメーション
    const observeElements = () => {
        const observer = new IntersectionObserver((entries) => {
            entries.forEach(entry => {
                if (entry.isIntersecting) {
                    entry.target.style.opacity = '1';
                    entry.target.style.transform = 'translateY(0)';
                }
            });
        }, {
            threshold: 0.1
        });
        
        const fadeElements = document.querySelectorAll('.service-card, .contact-item');
        fadeElements.forEach(el => {
            el.style.opacity = '0';
            el.style.transform = 'translateY(30px)';
            el.style.transition = 'all 0.6s ease';
            observer.observe(el);
        });
    };
    
    // 初期化
    initDrawer();
    smoothScroll();
    handleHeaderScroll();
    observeElements();
    
});
