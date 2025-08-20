import axios from "axios";
import qs from 'qs';

document.addEventListener('alpine:init', () => {
    Alpine.data('articleListing', ({
        page = 1,
        featured = null
   }) => ({
        loading: true,
        currentPage: page,
        lastPage: null,
        items: [],
        showFocusButton: false,
        lastLoadedItems: [],
        pagination: null,
        featuredArticle: null,
        announceText: null,
        error: false,

        init() {
            setTimeout(() => this.fetchItems(page), 0);
        },

        async fetchItems(page = 1, isPageChange = false) {
            this.loading = true;
            this.error = false;

            if (!isPageChange) {
                this.announce("Loading articles...");
            }

            try {
                const res = await axios.get('/api/articles/', {
                    params: {
                        page: page,
                        featured: featured
                    }
                });

                const newItems = res.data.articles.data;
                this.items = newItems;
                this.currentPage = res.data.articles.current_page;
                this.lastPage = res.data.articles.last_page;
                this.featuredArticle = res.data.featured;

                this.pagination = {
                    currentPage: res.data.articles.current_page,
                    lastPage: res.data.articles.last_page,
                    prev: res.data.articles.prev_page_url,
                    next: res.data.articles.next_page_url
                };

                this.updateBrowserState();

                this.loading = false;

                return newItems;

            } catch (error) {
                this.loading = false;
                this.error = true;
                console.error('Error fetching articles:', error);
                this.announce("Error loading articles. Please try again");

                throw error;
            }
        },

        focusFirstNewItem(id) {
            this.$focus.focus(document.getElementById(`result-${id}`));
        },

        async changePage(page = 0) {
            const root = this.$root;

            try {
                const newItems = await this.fetchItems(page, true);

                if (newItems.length > 0) {
                    this.announcePaginationChange();

                    this.lastLoadedItems = newItems;
                    this.showFocusButton = true;
                    root.scrollIntoView({ behavior: 'smooth', block: 'start' });

                    setTimeout(() => {
                        const firstArticle = root.querySelector('[id^="result-"]');
                        if (firstArticle) {
                            firstArticle.setAttribute('tabindex', '-1');
                            firstArticle.focus();
                            // Remove tabindex after focus to maintain natural tab order
                            setTimeout(() => firstArticle.removeAttribute('tabindex'), 100);
                        }
                    }, 300);

                }
            } catch (error) {

            }

        },

        pageRange() {
            const pages = [];
            const current = this.pagination.currentPage;
            const last = this.pagination.lastPage;

            // Always include page 1
            pages.push({ number: 1, type: 'page' });

            // Add ellipsis if there's a gap after page 1
            if (current - 2 > 2) {
                pages.push({ number: '...', type: 'ellipsis' });
            }

            // Add pages around current (but not if they're 1 or last)
            for (let i = Math.max(2, current - 2); i <= Math.min(last - 1, current + 2); i++) {
                pages.push({ number: i, type: 'page' });
            }

            // Add ellipsis if there's a gap before last page
            if (current + 2 < last - 1) {
                pages.push({ number: '...', type: 'ellipsis' });
            }

            // Always include last page (if it's not page 1)
            if (last > 1) {
                pages.push({ number: last, type: 'page' });
            }

            return pages;
        },

        announcePaginationChange() {
            this.announceText = '';

            const totalItems = this.items.length;
            const announcement = `Page ${this.currentPage} of ${this.lastPage} loaded. Showing ${totalItems} articles.`;

            setTimeout(() => {
                this.announce(announcement);
            }, 500);
        },

        announce(text) {
            this.announceText = '';

            setTimeout(() => {
                this.announceText = text;
            }, 100)
        },

        updateBrowserState() {
            const params = qs.stringify({
                page: this.currentPage
            })

            const currentUrl = new URL(window.location.href);

            currentUrl.search = params;

            const url = currentUrl.toString();

            const originalTitle = document.title;

            const beforePipe = originalTitle.split('|')[0].trim();
            const baseTitle = beforePipe.replace(/\s*\(Page \d+\)\s*$/, '').trim();
            const afterPipe = originalTitle.includes('|') ? originalTitle.split('|').slice(1).join('|').trim() : '';

            if (this.currentPage > 1) {
                document.title = `${baseTitle} (Page ${this.currentPage}) | ${afterPipe}`;
            } else {
                document.title = `${baseTitle} | ${afterPipe}`;
            }


            history.replaceState({
                page: this.currentPage,
                lastPage: this.lastPage
            }, '', url)
        }
    }));
});
