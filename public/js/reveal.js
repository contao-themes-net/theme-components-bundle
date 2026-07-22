(function () {
    function initReveal() {
        const els = document.querySelectorAll('[class^="reveal"], [class*=" reveal"]');
        if (!els.length) return;

        if (!("IntersectionObserver" in window)) {
            els.forEach((el) => el.classList.add("is-visible"));
            return;
        }

        const io = new IntersectionObserver(
            (entries) => {
                entries.forEach((e) => {
                    if (e.isIntersecting) {
                        e.target.classList.add("is-visible");
                    } else {
                        // Nur Elemente mit reveal-repeat wieder zurücksetzen
                        if (e.target.classList.contains("reveal-repeat")) {
                            e.target.classList.remove("is-visible");
                        }
                    }
                });
            },
            { threshold: 0.15, rootMargin: "0px 0px -10% 0px" }
        );

        els.forEach((el) => io.observe(el));
    }

    if (document.readyState === "loading") {
        document.addEventListener("DOMContentLoaded", initReveal);
    } else {
        initReveal();
    }

    window.addEventListener("load", initReveal);
})();
