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

// Date picker for input[data-datepicker], replacing the browser's unstyleable calendar.
// The input stays in the form, invisible, so it still submits the value and the browser
// still checks required and min. Without JavaScript the native control simply remains.
(function () {
    var MONTHS = ['janar', 'shkurt', 'mars', 'prill', 'maj', 'qershor', 'korrik', 'gusht', 'shtator', 'tetor', 'nëntor', 'dhjetor'];
    var DAYS = ['e diel', 'e hënë', 'e martë', 'e mërkurë', 'e enjte', 'e premte', 'e shtunë'];
    var WEEK_HEAD = [['Hën', 'e hënë'], ['Mar', 'e martë'], ['Mër', 'e mërkurë'], ['Enj', 'e enjte'], ['Pre', 'e premte'], ['Sht', 'e shtunë'], ['Die', 'e diel']];

    function capitalize(text) {
        return text.charAt(0).toUpperCase() + text.slice(1);
    }

    function pad(number) {
        return (number < 10 ? '0' : '') + number;
    }

    // Built from local parts: toISOString() would shift the date across time zones.
    function toIso(date) {
        return date.getFullYear() + '-' + pad(date.getMonth() + 1) + '-' + pad(date.getDate());
    }

    function fromIso(text) {
        var parts = /^(\d{4})-(\d{2})-(\d{2})$/.exec(text || '');
        return parts ? new Date(+parts[1], +parts[2] - 1, +parts[3]) : null;
    }

    function longDate(date) {
        return DAYS[date.getDay()] + ', ' + date.getDate() + ' ' + MONTHS[date.getMonth()] + ' ' + date.getFullYear();
    }

    function setup(input) {
        var now = new Date();
        var today = new Date(now.getFullYear(), now.getMonth(), now.getDate());
        var minIso = input.min || '';
        var viewYear, viewMonth, cursor;

        var field = document.createElement('div');
        field.className = 'date-field';

        var trigger = document.createElement('button');
        trigger.type = 'button';
        trigger.id = input.id + '_trigger';
        trigger.className = 'form-control date-trigger';
        trigger.setAttribute('aria-haspopup', 'dialog');
        trigger.setAttribute('aria-expanded', 'false');
        trigger.innerHTML = '<span class="date-trigger-text"></span><i class="far fa-calendar-alt" aria-hidden="true"></i>';
        var triggerText = trigger.firstChild;

        var pop = document.createElement('div');
        pop.className = 'date-pop';
        pop.hidden = true;
        pop.setAttribute('role', 'dialog');
        pop.setAttribute('aria-label', 'Zgjidhni datën');
        pop.innerHTML =
            '<div class="date-head">' +
                '<button type="button" class="date-nav" data-step="-1" aria-label="Muaji i kaluar"><i class="fas fa-chevron-left" aria-hidden="true"></i></button>' +
                '<div class="date-title" aria-live="polite"></div>' +
                '<button type="button" class="date-nav" data-step="1" aria-label="Muaji tjetër"><i class="fas fa-chevron-right" aria-hidden="true"></i></button>' +
            '</div>' +
            '<table class="date-grid"><thead><tr>' +
                WEEK_HEAD.map(function (day) {
                    return '<th scope="col" abbr="' + day[1] + '">' + day[0] + '</th>';
                }).join('') +
            '</tr></thead><tbody></tbody></table>' +
            '<div class="date-foot">' +
                '<button type="button" class="date-link" data-action="today">Sot</button>' +
                '<button type="button" class="date-link" data-action="clear">Pastro</button>' +
            '</div>';

        var title = pop.querySelector('.date-title');
        var body = pop.querySelector('tbody');
        var prev = pop.querySelector('[data-step="-1"]');
        var todayButton = pop.querySelector('[data-action="today"]');
        var clearButton = pop.querySelector('[data-action="clear"]');

        var error = document.createElement('div');
        error.className = 'date-error';
        error.setAttribute('role', 'alert');
        error.hidden = true;

        input.parentNode.insertBefore(field, input);
        field.appendChild(input);
        field.appendChild(trigger);
        field.appendChild(pop);
        field.parentNode.insertBefore(error, field.nextSibling);

        input.classList.add('date-native');
        input.classList.remove('form-control');
        input.tabIndex = -1;
        input.setAttribute('aria-hidden', 'true');

        // The label now names the button that people actually use.
        var label = document.querySelector('label[for="' + input.id + '"]');
        if (label) {
            label.id = input.id + '_label';
            label.htmlFor = trigger.id;
            trigger.setAttribute('aria-labelledby', label.id + ' ' + trigger.id);
        }

        function isBlocked(date) {
            return minIso !== '' && toIso(date) < minIso;
        }

        function syncTrigger() {
            var selected = fromIso(input.value);
            triggerText.textContent = selected ? capitalize(longDate(selected)) : 'Zgjidhni një datë';
            trigger.classList.toggle('is-empty', !selected);
        }

        function clearError() {
            error.hidden = true;
            error.textContent = '';
            trigger.classList.remove('has-error');
        }

        function render() {
            var selectedIso = input.value;
            var todayIso = toIso(today);
            var firstOfMonth = new Date(viewYear, viewMonth, 1);
            var offset = (firstOfMonth.getDay() + 6) % 7; // Weeks start on Monday.

            title.textContent = capitalize(MONTHS[viewMonth]) + ' ' + viewYear;
            body.textContent = '';

            for (var week = 0; week < 6; week++) {
                var row = body.insertRow();
                for (var weekday = 0; weekday < 7; weekday++) {
                    var date = new Date(viewYear, viewMonth, 1 - offset + week * 7 + weekday);
                    var iso = toIso(date);
                    var button = document.createElement('button');
                    button.type = 'button';
                    button.className = 'date-day';
                    button.textContent = date.getDate();
                    button.dataset.date = iso;
                    button.setAttribute('aria-label', capitalize(longDate(date)));
                    button.tabIndex = iso === toIso(cursor) ? 0 : -1;
                    button.disabled = isBlocked(date);
                    button.classList.toggle('is-outside', date.getMonth() !== viewMonth);
                    if (iso === todayIso) {
                        button.classList.add('is-today');
                        button.setAttribute('aria-current', 'date');
                    }
                    if (iso === selectedIso) {
                        button.classList.add('is-selected');
                        button.setAttribute('aria-pressed', 'true');
                    }
                    row.insertCell().appendChild(button);
                }
            }

            // Nothing before the earliest allowed month can be chosen.
            var lastOfPrev = new Date(viewYear, viewMonth, 0);
            var prevBlocked = isBlocked(lastOfPrev);
            if (prevBlocked && document.activeElement === prev) {
                pop.querySelector('[data-step="1"]').focus();
            }
            prev.disabled = prevBlocked;
            todayButton.disabled = isBlocked(today);
            clearButton.hidden = !selectedIso;
        }

        function focusCursor(options) {
            var day = body.querySelector('[data-date="' + toIso(cursor) + '"]');
            if (day) {
                day.focus(options);
            }
        }

        function earliest(date) {
            var minDate = fromIso(minIso);
            return minDate && date < minDate ? minDate : date;
        }

        // Moves the view by whole months, keeping the day number where the month allows it.
        function showMonth(step) {
            var lastDay = new Date(viewYear, viewMonth + step + 1, 0).getDate();
            cursor = earliest(new Date(viewYear, viewMonth + step, Math.min(cursor.getDate(), lastDay)));
            viewYear = cursor.getFullYear();
            viewMonth = cursor.getMonth();
            render();
        }

        function moveCursor(date) {
            cursor = earliest(date);
            viewYear = cursor.getFullYear();
            viewMonth = cursor.getMonth();
            render();
            focusCursor();
        }

        function open() {
            cursor = earliest(fromIso(input.value) || today);
            viewYear = cursor.getFullYear();
            viewMonth = cursor.getMonth();
            render();

            pop.hidden = false;
            pop.classList.remove('is-above');
            trigger.classList.add('is-open');
            trigger.setAttribute('aria-expanded', 'true');
            clearError();

            // Focus first without scrolling: a focus scroll would cancel the smooth one below.
            focusCursor({ preventScroll: true });

            // Open upward only when it fits there and does not fit below.
            var rect = pop.getBoundingClientRect();
            var headerHeight = (document.getElementById('siteHeader') || { offsetHeight: 0 }).offsetHeight;
            var triggerTop = trigger.getBoundingClientRect().top;
            if (rect.bottom > window.innerHeight && triggerTop - rect.height - 8 > headerHeight) {
                pop.classList.add('is-above');
            } else if (rect.bottom > window.innerHeight) {
                pop.scrollIntoView({ block: 'nearest' });
            }
        }

        function close(returnFocus) {
            if (pop.hidden) {
                return;
            }
            pop.hidden = true;
            trigger.classList.remove('is-open');
            trigger.setAttribute('aria-expanded', 'false');
            if (returnFocus) {
                trigger.focus();
            }
        }

        function choose(iso) {
            input.value = iso;
            input.dispatchEvent(new Event('change', { bubbles: true }));
            syncTrigger();
            clearError();
            close(true);
        }

        trigger.addEventListener('click', function () {
            if (pop.hidden) {
                open();
            } else {
                close(false);
            }
        });

        pop.addEventListener('click', function (event) {
            var button = event.target.closest('button');
            if (!button || button.disabled) {
                return;
            }
            if (button.dataset.date) {
                choose(button.dataset.date);
            } else if (button.dataset.step) {
                showMonth(+button.dataset.step);
            } else if (button.dataset.action === 'today') {
                choose(toIso(today));
            } else if (button.dataset.action === 'clear') {
                choose('');
            }
        });

        pop.addEventListener('keydown', function (event) {
            if (event.key === 'Escape') {
                event.preventDefault();
                event.stopPropagation();
                close(true);
                return;
            }
            if (!event.target.dataset.date) {
                return;
            }

            var y = cursor.getFullYear();
            var m = cursor.getMonth();
            var d = cursor.getDate();
            var next = null;
            switch (event.key) {
                case 'ArrowLeft': next = new Date(y, m, d - 1); break;
                case 'ArrowRight': next = new Date(y, m, d + 1); break;
                case 'ArrowUp': next = new Date(y, m, d - 7); break;
                case 'ArrowDown': next = new Date(y, m, d + 7); break;
                case 'Home': next = new Date(y, m, d - (cursor.getDay() + 6) % 7); break;
                case 'End': next = new Date(y, m, d + 6 - (cursor.getDay() + 6) % 7); break;
                case 'PageUp':
                case 'PageDown':
                    event.preventDefault();
                    showMonth(event.key === 'PageUp' ? -1 : 1);
                    focusCursor();
                    return;
            }
            if (next) {
                event.preventDefault();
                moveCursor(next);
            }
        });

        document.addEventListener('click', function (event) {
            if (!field.contains(event.target)) {
                close(false);
            }
        });

        // Tabbing out closes it. relatedTarget is null when a re-render removes the focused day.
        pop.addEventListener('focusout', function (event) {
            if (event.relatedTarget && !field.contains(event.relatedTarget)) {
                close(false);
            }
        });

        // Submitting with no date: show our message instead of the browser's bubble.
        input.addEventListener('invalid', function (event) {
            event.preventDefault();
            error.textContent = input.validity.rangeUnderflow
                ? 'Data e marrjes nuk mund të jetë në të kaluarën.'
                : 'Ju lutem zgjidhni datën e marrjes.';
            error.hidden = false;
            trigger.classList.add('has-error');
            close(false);
            trigger.focus();
        });

        // The Back button can restore a value into the input.
        window.addEventListener('pageshow', syncTrigger);
        syncTrigger();
    }

    document.querySelectorAll('input[data-datepicker]').forEach(setup);
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
