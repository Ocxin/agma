export default class LazyBackgroundLoader {
    constructor() {
        this.elements = document.querySelectorAll('[data-bg="lazy"]');
        this.observer = null;
        this.mutationObserver = null;
        this.init();
    }

    init() {
        const options = {
            root: null,
            rootMargin: '0px',
            threshold: 0.01
        };

        this.observer = new IntersectionObserver((entries, self) => {
            entries.forEach(entry => {
                if (entry.isIntersecting) {
                    this.loadImage(entry.target);
                    self.unobserve(entry.target);
                }
            });
        }, options);

        this.elements.forEach(el => this.observer.observe(el));
        this.observeDOMChanges();
    }

    loadImage(element) {
        const imageUrl = element.getAttribute('data-src');
        element.style.backgroundImage = `url(${imageUrl})`;
        element.style.backgroundSize = 'cover';
        element.style.backgroundRepeat = 'no-repeat';
        element.style.backgroundPosition = 'center';
        element.removeAttribute('data-src');
        element.removeAttribute('data-bg');
    }

    observeDOMChanges() {
        this.mutationObserver = new MutationObserver((mutations) => {
            mutations.forEach(mutation => {
                if (mutation.type === 'childList' && mutation.addedNodes.length) {
                    mutation.addedNodes.forEach(node => {
                        if (node.matches && node.matches('[data-bg="lazy"]')) {
                            this.observer.observe(node);
                        }
                    });
                }
            });
        });

        const config = {
            childList: true,
            subtree: true
        };

        this.mutationObserver.observe(document.body, config);
    }
}
