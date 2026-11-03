// Shared page behaviour. Every page loads this file once, from footer.php.

// Show progress on forms that save something, and ignore an accidental second submit.
// The button is deliberately not disabled: a disabled button would drop its name from
// the request, and details.php and upload.php check for that name.
(function () {
    var forms = document.querySelectorAll('form[method="post" i]');

    forms.forEach(function (form) {
        form.addEventListener('submit', function (event) {
            if (form.dataset.busy) {
                event.preventDefault();
                return;
            }
            form.dataset.busy = 'true';
            var button = event.submitter || form.querySelector('[type="submit"]');
            if (button) {
                button.classList.add('is-busy');
                button.setAttribute('aria-busy', 'true');
            }
        });
    });

    // The Back button can restore a page exactly as it was left, so reset that state.
    window.addEventListener('pageshow', function () {
        forms.forEach(function (form) {
            delete form.dataset.busy;
            form.querySelectorAll('.is-busy').forEach(function (button) {
                button.classList.remove('is-busy');
                button.removeAttribute('aria-busy');
            });
        });
    });
})();

// Mobile navigation toggle.
(function () {
    var button = document.getElementById('mobileMenuBtn');
    var nav = document.getElementById('navLinks');
    if (!button || !nav) {
        return;
    }

    var icon = button.querySelector('i');

    function setOpen(open) {
        nav.classList.toggle('is-open', open);
        button.setAttribute('aria-expanded', String(open));
        button.setAttribute('aria-label', open ? button.dataset.labelClose : button.dataset.labelOpen);
        if (icon) {
            icon.className = open ? 'fas fa-times' : 'fas fa-bars';
        }
        if (open) {
            document.dispatchEvent(new CustomEvent('nav:open', { detail: nav }));
        }
    }

    button.addEventListener('click', function () {
        setOpen(!nav.classList.contains('is-open'));
    });

    // Following a link closes the menu, which matters for the on-page #kontakt link.
    nav.addEventListener('click', function (event) {
        if (event.target.closest('a')) {
            setOpen(false);
        }
    });

    document.addEventListener('keydown', function (event) {
        if (event.key === 'Escape' && nav.classList.contains('is-open')) {
            setOpen(false);
            button.focus();
        }
    });

    document.addEventListener('click', function (event) {
        if (nav.classList.contains('is-open') && !nav.contains(event.target) && !button.contains(event.target)) {
            setOpen(false);
        }
    });
})();
