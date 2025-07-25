document.addEventListener('alpine:init', () => {
    Alpine.data('header', () => ({
        /**
         * tracks whether the mobile navigation is open -
         * this file only manipulates this variable when the screen size is changed
         * in most cases this is manipulated via the DOM.
         * @see handleResize
         */
        mobileNavOpen: false,
        isTouch: false,
        headerHidden: false,
        lastScrollY: 0,
        scrollThreshold: 5,

        init() {
            this.isTouch = 'ontouchstart' in window || navigator.maxTouchPoints > 0;
            this.lastScrollY = window.scrollY;

            this.setupScrollListener();

            if (this.isTouch) {
                this.setupTouchListeners();
            }
        },

        setupScrollListener() {
            let ticking = false;

            window.addEventListener('scroll', () => {
                if (!ticking) {
                    requestAnimationFrame(() => {
                        this.handleScroll();
                        ticking = false;
                    });
                    ticking = true;
                }
            });
        },

        setupTouchListeners() {
            let touchStartY = 0;

            const handleTouchStart = (e) => {
                touchStartY = e.touches[0].clientY;
            };

            const handleTouchEnd = (e) => {
                const touchEndY = e.changedTouches[0].clientY;
                const touchDiff = touchStartY - touchEndY;

                // If significant upward swipe, show header immediately
                if (touchDiff < -30 && this.headerHidden) {
                    this.headerHidden = false;
                }
            };

            window.addEventListener('touchstart', handleTouchStart, { passive: true });
            window.addEventListener('touchend', handleTouchEnd, { passive: true });
        },

        handleScroll() {
            const currentScrollY = window.scrollY;
            const isMobile = window.innerWidth < 1024;

            // Use different thresholds for mobile vs desktop
            const threshold = isMobile ? 3 : this.scrollThreshold;
            const hideThreshold = isMobile ? 50 : 500;

            // Only act if we've scrolled more than the threshold
            if (Math.abs(currentScrollY - this.lastScrollY) < threshold) {
                return;
            }

            // Hide header when scrolling down, show when scrolling up
            if (currentScrollY > this.lastScrollY && currentScrollY > hideThreshold) {
                // Scrolling down & past initial area
                this.headerHidden = true;
            } else if (currentScrollY < this.lastScrollY) {
                // Scrolling up - show immediately on mobile, with small threshold on desktop
                if (isMobile || Math.abs(currentScrollY - this.lastScrollY) > 5) {
                    this.headerHidden = false;
                }
            }

            this.lastScrollY = currentScrollY;
        },

        // Method to handle window resize for mobile nav
        handleResize() {
            if (window.innerWidth >= 1024) {
                this.mobileNavOpen = false;
            }
        }
    }));
});
