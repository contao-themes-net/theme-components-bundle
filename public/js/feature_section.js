(() => {
    const run = () => {

        const sections = document.querySelectorAll('.content-feature-section');

        const setAsideHeight = (section) => {
            const heroInner = section.querySelector('.feature-section__hero-inner');
            const aside = section.querySelector('.feature-section__aside');

            const h = heroInner.getBoundingClientRect().height;

            const minH = window.innerHeight; // 100vh
            const finalH = Math.max(h, minH);

            section.style.setProperty('--aside-h', `${finalH}px`);
        };

        const bind = (section) => {
            // Initial
            setAsideHeight(section);

            const heroInner = section.querySelector('.feature-section__hero-inner');
            if (!heroInner) return;

            // Observe layout changes
            const ro = new ResizeObserver(() => setAsideHeight(section));
            ro.observe(heroInner);

            // Also recompute on resize
            window.addEventListener('resize', () => setAsideHeight(section));
        };

        sections.forEach(bind);
    };

    // Ensure DOM is ready (Contao often loads scripts in head)
    if (document.readyState === 'loading') {
        document.addEventListener('DOMContentLoaded', run);
    } else {
        run();
    }
})();
