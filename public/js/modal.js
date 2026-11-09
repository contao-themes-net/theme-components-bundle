/*
 * Modal module of the theme components bundle, based on the native <dialog> element.
 *
 *  - [data-ct-modal-open="<id>"] and links to "#<id>" open the dialog
 *  - [data-ct-modal-close], the Escape key and a click on the backdrop close it
 *  - [data-ct-modal-autoopen] opens the dialog when the page is loaded,
 *    [data-ct-modal-remember] skips that once the dialog has been closed
 */
(() => {
    const storageKey = (dialog) => `ct-modal-dismissed-${dialog.id}`;

    const isDismissed = (dialog) => {
        try {
            return !!localStorage.getItem(storageKey(dialog));
        } catch (e) {
            return false;
        }
    };

    const open = (dialog) => {
        if (dialog instanceof HTMLDialogElement && !dialog.open) {
            dialog.showModal();
        }
    };

    document.addEventListener('click', (event) => {
        const opener = event.target.closest('[data-ct-modal-open], a[href*="#ct-modal-"]');

        if (opener) {
            const id = opener.dataset.ctModalOpen ?? new URL(opener.href, location.href).hash.slice(1);
            const dialog = document.getElementById(id);

            if (dialog?.matches('dialog.ct-modal__dialog')) {
                event.preventDefault();
                open(dialog);
            }

            return;
        }

        if (event.target.closest('[data-ct-modal-close]')) {
            event.target.closest('dialog')?.close();
            return;
        }

        // The dialog itself is only the click target on the backdrop
        if (event.target.matches('dialog.ct-modal__dialog')) {
            event.target.close();
        }
    });

    const init = () => {
        document.querySelectorAll('dialog.ct-modal__dialog').forEach((dialog) => {
            if (dialog.hasAttribute('data-ct-modal-remember')) {
                dialog.addEventListener('close', () => {
                    try {
                        localStorage.setItem(storageKey(dialog), '1');
                    } catch (e) {}
                });
            }

            const isTarget = location.hash === `#${dialog.id}`;

            if (isTarget || (dialog.hasAttribute('data-ct-modal-autoopen') && !(dialog.hasAttribute('data-ct-modal-remember') && isDismissed(dialog)))) {
                open(dialog);
            }
        });
    };

    if (document.readyState === 'loading') {
        document.addEventListener('DOMContentLoaded', init);
    } else {
        init();
    }
})();
