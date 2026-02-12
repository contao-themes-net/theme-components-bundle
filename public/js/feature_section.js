(() => {
    const run = () => {

        const sections = document.querySelectorAll('.content-feature-section');

        const updateLayout = (section) => {
            /* ----------------------------------
               1) Deine bestehende Höhenlogik
            ---------------------------------- */
            const heroInner = section.querySelector('.feature-section__hero-inner');
            if (heroInner) {
                const h = heroInner.getBoundingClientRect().height;

                const minH = window.innerHeight; // 100vh
                const finalH = Math.max(h, minH);

                section.style.setProperty('--aside-h', `${finalH}px`);
            }

            /* ----------------------------------
               2) Neue Logik: Prüfen ob Galerie voll ist
            ---------------------------------- */
            const gallery = section.querySelector('.feature-section__gallery');
            const content = section.querySelector('.content-gallery');

            if (!gallery || !content) return;

            const galleryWidth = gallery.getBoundingClientRect().width;
            const contentWidth = content.getBoundingClientRect().width;

            const tolerance = 2; // gegen Subpixel-Rundung

            if (contentWidth < galleryWidth - tolerance) {
                gallery.classList.add('is-not-full');
            } else {
                gallery.classList.remove('is-not-full');
            }
        };

        const bind = (section) => {
            updateLayout(section);

            const heroInner = section.querySelector('.feature-section__hero-inner');
            const gallery   = section.querySelector('.feature-section__gallery');

            const ro = new ResizeObserver(() => updateLayout(section));

            if (heroInner) ro.observe(heroInner);
            if (gallery)   ro.observe(gallery);

            // Recompute on viewport resize
            window.addEventListener('resize', () => updateLayout(section));
        };

        sections.forEach(bind);
    };

    if (document.readyState === 'loading') {
        document.addEventListener('DOMContentLoaded', run);
    } else {
        run();
    }
})();
