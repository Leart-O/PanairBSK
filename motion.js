// GSAP motion for the whole site. Everything here is optional polish:
// - Pages are complete without it. Only [data-intro] waits for this file (see header.php).
// - Each block runs inside gsap.matchMedia(), so it is reverted automatically when
//   reduced motion is switched on or the screen crosses a breakpoint.
// - Reveals use opacity, never visibility, so hidden cards stay reachable by keyboard.
(function () {
    var root = document.documentElement;

    function release() {
        root.classList.remove('motion-pending');
    }

    if (!window.gsap) {
        release();
        root.classList.remove('lang-turn-in');
        return;
    }

    var gsap = window.gsap;
    var ST = window.ScrollTrigger;
    var MP = window.MotionPathPlugin;

    if (ST) {
        gsap.registerPlugin(ST);
    }
    if (MP) {
        gsap.registerPlugin(MP);
    }

    gsap.defaults({ ease: 'power2.out' });
    // Run on real time, so slow frames can't leave content faded for longer than the set duration.
    gsap.ticker.lagSmoothing(0);

    var CLEAR = 'opacity,visibility,transform,clipPath';
    var SVG_NS = 'http://www.w3.org/2000/svg';
    var motionOk = '(prefers-reduced-motion: no-preference)';
    // The page intro waits until the title page has started to lift.
    var introDelay = root.classList.contains('lang-turn-in') ? 0.4 : 0;

    // Reveal a group once it scrolls into view. If setup fails, the group is shown at once.
    function reveal(selector, from, to, stagger) {
        var items = gsap.utils.toArray(selector);
        if (!items.length) {
            return;
        }
        try {
            gsap.set(items, from);
            ST.batch(items, {
                once: true,
                start: 'top 90%',
                onEnter: function (batch) {
                    gsap.to(batch, Object.assign({ duration: 0.6, stagger: stagger || 0.07, clearProps: CLEAR }, to));
                }
            });
        } catch (error) {
            gsap.set(items, { clearProps: CLEAR });
        }
    }

    // Layout-dependent animation: rebuilt when the width changes or fonts finish loading.
    function rebuildable(build) {
        var context;
        var timer;
        var width = window.innerWidth;

        function run() {
            if (context) {
                context.revert();
            }
            context = gsap.context(build);
            ST.refresh();
        }

        function onResize() {
            // Mobile browser bars change only the height, which needs no rebuild.
            if (window.innerWidth === width) {
                return;
            }
            width = window.innerWidth;
            clearTimeout(timer);
            timer = setTimeout(run, 200);
        }

        run();
        window.addEventListener('resize', onResize);
        window.addEventListener('load', run);
        if (document.fonts && document.fonts.status !== 'loaded') {
            document.fonts.ready.then(run);
        }

        return function () {
            clearTimeout(timer);
            window.removeEventListener('resize', onResize);
            window.removeEventListener('load', run);
            if (context) {
                context.revert();
            }
            run = function () {};
        };
    }

    // ----- Page intro, feedback and menu -----

    function intro() {
        var hero = document.querySelector('.hero');
        var heroItems = hero ? gsap.utils.toArray('[data-intro]', hero) : [];

        if (heroItems.length) {
            var title = hero.querySelector('h1');
            var rest = heroItems.filter(function (item) { return item !== title; });
            gsap.timeline({ delay: introDelay })
                .from(rest[0], { opacity: 0, y: 10, duration: 0.4, clearProps: CLEAR })
                .fromTo(title, { clipPath: 'inset(0 0 100% 0)', y: 24 }, { clipPath: 'inset(0 0 -20% 0)', y: 0, duration: 0.7, ease: 'power3.out', clearProps: CLEAR }, 0.05)
                .from(rest.slice(1), { opacity: 0, y: 14, duration: 0.45, stagger: 0.07, clearProps: CLEAR }, 0.3);
        }

        var others = gsap.utils.toArray('[data-intro]').filter(function (item) {
            return heroItems.indexOf(item) === -1;
        });
        if (others.length) {
            gsap.from(others, { opacity: 0, y: 14, duration: 0.5, stagger: 0.07, delay: introDelay, clearProps: CLEAR });
        }

        var alerts = gsap.utils.toArray('.alert');
        if (alerts.length) {
            gsap.from(alerts, { opacity: 0, y: -8, duration: 0.35, clearProps: CLEAR });
        }

        function onNavOpen(event) {
            gsap.from(event.detail.querySelectorAll('li'), { opacity: 0, x: -8, duration: 0.25, stagger: 0.04, clearProps: CLEAR });
        }
        document.addEventListener('nav:open', onNavOpen);
        return function () {
            document.removeEventListener('nav:open', onNavOpen);
        };
    }

    // ----- Language switch and page turn -----

    function pagePerspective() {
        // Keeps the lifting edge from passing the viewer on wide screens.
        return Math.max(window.innerWidth * 2.2, 1800);
    }

    // Arriving: the title page covering the new page turns away.
    function turnIn() {
        var turn = document.getElementById('pageTurn');
        if (!turn || !root.classList.contains('lang-turn-in')) {
            return;
        }
        var sheet = turn.querySelector('.page-turn-sheet');
        var shade = turn.querySelector('.page-turn-shade');
        var sheen = turn.querySelector('.page-turn-sheen');

        gsap.set(sheet, { transformPerspective: pagePerspective(), transformOrigin: '0% 50%' });
        gsap.timeline({
            delay: 0.15,
            onComplete: function () {
                root.classList.remove('lang-turn-in');
                gsap.set([sheet, shade, sheen], { clearProps: 'all' });
            }
        })
            .to(sheet, { rotationY: -100, duration: 0.7, ease: 'power2.inOut' }, 0)
            .to(sheen, { opacity: 1, duration: 0.45, ease: 'power1.in' }, 0)
            .to(shade, { opacity: 0, duration: 0.7, ease: 'power1.in' }, 0);
    }

    function languageSwitch() {
        var control = document.getElementById('languageSwitch');
        var thumb = control && control.querySelector('.lang-thumb');
        if (!thumb) {
            return function () {};
        }

        var links = gsap.utils.toArray('a', control);
        var body = document.body;
        var turn = document.getElementById('pageTurn');
        var turnHome = turn ? turn.nextElementSibling : null;
        var currentLang = root.lang === 'en' ? 'en' : 'sq';
        var hoverCapable = window.matchMedia('(hover: hover) and (pointer: fine)').matches;
        var leaving = null;
        var removers = [];

        function listen(target, type, handler) {
            target.addEventListener(type, handler);
            removers.push(function () {
                target.removeEventListener(type, handler);
            });
        }

        function positionOf(lang) {
            return lang === 'en' ? 100 : 0;
        }

        gsap.set(thumb, { x: 0, xPercent: positionOf(currentLang) });

        // After a turn, the pill finishes its slide into the language that just arrived.
        if (introDelay) {
            gsap.fromTo(thumb, { xPercent: positionOf(currentLang === 'en' ? 'sq' : 'en') }, {
                xPercent: positionOf(currentLang),
                duration: 0.55,
                delay: 0.5,
                ease: 'back.out(1.8)'
            });
        }

        // ----- Hover and keyboard focus: the pill leans towards the other language -----

        function lean(link) {
            var isCurrent = link.dataset.lang === currentLang;
            gsap.to(link, { scale: 1.1, duration: 0.25, overwrite: 'auto' });
            if (!isCurrent) {
                gsap.to(link, { y: -1, duration: 0.25 });
                gsap.to(thumb, { x: link.dataset.lang === 'en' ? 6 : -6, scaleX: 1.16, duration: 0.3, overwrite: 'auto' });
            }
        }

        function settle(link) {
            if (leaving) {
                return;
            }
            gsap.to(link, { scale: 1, y: 0, duration: 0.35, overwrite: 'auto' });
            gsap.to(thumb, { x: 0, scaleX: 1, scaleY: 1, duration: 0.6, ease: 'elastic.out(1, 0.5)', overwrite: 'auto' });
        }

        links.forEach(function (link) {
            if (hoverCapable) {
                listen(link, 'pointerenter', function () { lean(link); });
                listen(link, 'pointerleave', function () { settle(link); });
            }
            listen(link, 'focus', function () {
                if (link.matches(':focus-visible')) {
                    lean(link);
                }
            });
            listen(link, 'blur', function () { settle(link); });
        });

        // The whole control drifts a little towards the pointer.
        if (hoverCapable) {
            var driftX = gsap.quickTo(control, 'x', { duration: 0.4 });
            var driftY = gsap.quickTo(control, 'y', { duration: 0.4 });
            listen(control, 'pointermove', function (event) {
                var rect = control.getBoundingClientRect();
                driftX(gsap.utils.clamp(-4, 4, (event.clientX - rect.left - rect.width / 2) * 0.1));
                driftY(gsap.utils.clamp(-3, 3, (event.clientY - rect.top - rect.height / 2) * 0.15));
            });
            listen(control, 'pointerleave', function () {
                driftX(0);
                driftY(0);
            });
        }

        // ----- Press: the control squashes, then springs back -----

        function press() {
            gsap.to(control, { scale: 0.92, duration: 0.1, overwrite: 'auto' });
            gsap.to(thumb, { scaleY: 0.82, scaleX: 1.14, duration: 0.1, overwrite: 'auto' });
        }

        function unpress() {
            gsap.to(control, { scale: 1, duration: 0.55, ease: 'elastic.out(1, 0.45)', overwrite: 'auto' });
            if (!leaving) {
                gsap.to(thumb, { scaleY: 1, scaleX: 1, duration: 0.5, ease: 'elastic.out(1, 0.5)', overwrite: 'auto' });
            }
        }

        listen(control, 'pointerdown', press);
        listen(window, 'pointerup', unpress);
        listen(window, 'pointercancel', unpress);

        // ----- Click: the pill slides across, then the real page turns away -----

        function restore() {
            if (!leaving) {
                return;
            }
            clearTimeout(leaving.fallback);
            leaving.timeline.kill();
            leaving.sheen.remove();
            leaving = null;

            gsap.set(body, { clearProps: 'all' });
            root.classList.remove('lang-turn-out');
            turn.classList.remove('is-active');
            turn.dataset.show = currentLang;
            gsap.set(turn.querySelector('.page-turn-shade'), { clearProps: 'all' });
            body.insertBefore(turn, turnHome);

            links.forEach(function (link) {
                link.classList.toggle('active', link.dataset.lang === currentLang);
                gsap.set(link, { clearProps: 'transform' });
            });
            gsap.set(thumb, { x: 0, scaleX: 1, scaleY: 1, xPercent: positionOf(currentLang) });
            try {
                sessionStorage.removeItem('langTurn');
            } catch (error) {}
        }

        function leaveTo(link) {
            var targetLang = link.dataset.lang;
            var href = link.href;
            var gone = false;

            function go() {
                if (!gone) {
                    gone = true;
                    window.location.href = href;
                }
            }

            try {
                sessionStorage.setItem('langTurn', targetLang);
            } catch (error) {
                go();
                return;
            }

            links.forEach(function (item) {
                item.classList.toggle('active', item === link);
            });
            gsap.to(thumb, { xPercent: positionOf(targetLang), x: 0, scaleX: 1, scaleY: 1, duration: 0.32, ease: 'back.out(1.4)', overwrite: 'auto' });

            // The title page moves outside body, because body itself is what turns.
            turn.dataset.show = targetLang;
            root.classList.add('lang-turn-out');
            turn.classList.add('is-active');
            root.appendChild(turn);

            var viewportTop = window.pageYOffset;
            var viewportHeight = window.innerHeight;
            var pageSheen = document.createElement('div');
            pageSheen.className = 'page-turn-page-sheen';
            pageSheen.style.top = viewportTop + 'px';
            pageSheen.style.height = viewportHeight + 'px';
            body.appendChild(pageSheen);

            gsap.set(body, {
                transformPerspective: pagePerspective(),
                transformOrigin: '0px ' + (viewportTop + viewportHeight / 2) + 'px'
            });

            leaving = {
                sheen: pageSheen,
                // Reaches the next page even if the animation is interrupted.
                fallback: setTimeout(go, 1300),
                timeline: gsap.timeline({ delay: 0.14, onComplete: go })
                    .to(body, { rotationY: -100, duration: 0.62, ease: 'power2.in' }, 0)
                    .to(pageSheen, { opacity: 1, duration: 0.5, ease: 'power1.in' }, 0)
                    .fromTo(turn.querySelector('.page-turn-shade'), { opacity: 0.6 }, { opacity: 0, duration: 0.62, ease: 'power1.in' }, 0)
            };
        }

        links.forEach(function (link) {
            listen(link, 'click', function (event) {
                // New-tab clicks, the current language and a turn in progress keep normal behaviour.
                if (event.ctrlKey || event.metaKey || event.shiftKey || event.altKey || event.button !== 0) {
                    return;
                }
                if (leaving) {
                    event.preventDefault();
                    return;
                }
                if (link.dataset.lang === currentLang || !turn) {
                    return;
                }
                event.preventDefault();
                leaveTo(link);
            });
        });

        // The Back button can restore this page as it was left, mid-turn.
        listen(window, 'pageshow', function (event) {
            if (event.persisted) {
                restore();
            }
        });

        turnIn();

        return function () {
            restore();
            removers.forEach(function (remove) { remove(); });
        };
    }

    // ----- Scroll reveals: each kind of content moves in its own way -----

    function scrollReveals() {
        reveal('.section-title h2', { clipPath: 'inset(0 0 100% 0)', y: 18 }, { clipPath: 'inset(0 0 -20% 0)', y: 0, ease: 'power3.out' });
        reveal('.section-title p', { opacity: 0 }, { opacity: 1, delay: 0.15 });
        reveal('.section-header .view-all', { opacity: 0, x: 14 }, { opacity: 1, x: 0, delay: 0.2 });
        reveal('.book-card', { opacity: 0, y: 28, scale: 0.97 }, { opacity: 1, y: 0, scale: 1 });
        reveal('.category-card', { opacity: 0, scale: 0.9 }, { opacity: 1, scale: 1, ease: 'back.out(1.6)', duration: 0.5 }, 0.05);
        reveal('.feature-strip', { opacity: 0, x: -24 }, { opacity: 1, x: 0 });
        reveal('.testimonial-card', { opacity: 0, x: gsap.utils.wrap([-22, 22]) }, { opacity: 1, x: 0 }, 0.09);
        reveal('.blog-card', { clipPath: 'inset(0 0 100% 0)' }, { clipPath: 'inset(0 0 0% 0)', duration: 0.8, ease: 'power3.inOut' }, 0.12);
        reveal('.newsletter-inner', { opacity: 0, y: 20 }, { opacity: 1, y: 0 });
        // Steps fade without moving, because the process path measures their position.
        reveal('.process-step', { opacity: 0 }, { opacity: 1 }, 0.12);

        var header = document.getElementById('siteHeader');
        if (header) {
            ST.create({
                start: 12,
                end: 99999999, // Past any real scroll position, so the state holds at the page bottom.
                onToggle: function (self) {
                    header.classList.toggle('is-scrolled', self.isActive);
                }
            });
        }

        var progress = document.querySelector('.scroll-progress');
        if (progress) {
            gsap.fromTo(progress, { scaleX: 0 }, {
                scaleX: 1,
                ease: 'none',
                scrollTrigger: { start: 0, end: 'max', scrub: 0.2 }
            });
        }
    }

    function heroParallax() {
        var background = document.querySelector('.hero-bg');
        if (background) {
            gsap.to(background, {
                yPercent: 8,
                ease: 'none',
                scrollTrigger: { trigger: '.hero', start: 'top top', end: 'bottom top', scrub: true }
            });
        }
    }

    // ----- How it works: a path joins the steps and a small book rides along it -----

    function buildProcessPath() {
        var grid = document.querySelector('.process-steps');
        if (!grid) {
            return;
        }
        var svg = grid.querySelector('.process-line');
        var path = svg && svg.querySelector('path');
        var rider = grid.querySelector('.process-rider');
        var icons = gsap.utils.toArray('.process-icon', grid);
        if (!path || icons.length < 2) {
            return;
        }

        var box = grid.getBoundingClientRect();
        var points = icons.map(function (icon) {
            var rect = icon.getBoundingClientRect();
            return { x: rect.left - box.left + rect.width / 2, y: rect.top - box.top + rect.height / 2 };
        });
        var horizontal = Math.abs(points[1].y - points[0].y) < 10;
        var d = 'M' + points[0].x + ' ' + points[0].y;

        points.slice(1).forEach(function (point, index) {
            var previous = points[index];
            var wave = index % 2 ? 34 : -34;
            if (horizontal) {
                var midX = (previous.x + point.x) / 2;
                d += ' C' + (previous.x + 60) + ' ' + (previous.y + wave) + ' ' + (midX - 40) + ' ' + (previous.y + wave) + ' ' + midX + ' ' + previous.y;
                d += ' S' + (point.x - 60) + ' ' + (point.y - wave) + ' ' + point.x + ' ' + point.y;
            } else {
                var midY = (previous.y + point.y) / 2;
                d += ' C' + (previous.x + 22) + ' ' + (previous.y + 30) + ' ' + (point.x + 22) + ' ' + (midY - 10) + ' ' + point.x + ' ' + point.y;
            }
        });

        svg.setAttribute('viewBox', '0 0 ' + box.width + ' ' + box.height);
        path.setAttribute('d', d);
        var length = path.getTotalLength();

        grid.classList.add('is-ready');
        gsap.set(path, { strokeDasharray: length, strokeDashoffset: length });

        var timeline = gsap.timeline({
            defaults: { ease: 'none' },
            scrollTrigger: { trigger: grid, start: 'top 72%', end: 'bottom 48%', scrub: 0.5 }
        });
        timeline.to(path, { strokeDashoffset: 0, duration: 1 }, 0);

        if (rider && MP) {
            gsap.set(rider, { xPercent: -50, yPercent: -50, x: points[0].x, y: points[0].y, opacity: 1 });
            timeline.to(rider, { motionPath: { path: d }, duration: 1 }, 0);
        }

        icons.forEach(function (icon, index) {
            var at = index / (icons.length - 1);
            timeline.to(icon, { backgroundColor: '#14305c', color: '#f2cf85', duration: 0.05 }, Math.max(0, at - 0.03));
            timeline.fromTo(icon, { scale: 1 }, { scale: 1.12, duration: 0.05, yoyo: true, repeat: 1 }, Math.max(0, at - 0.03));
        });

        return function () {
            grid.classList.remove('is-ready');
        };
    }

    // ----- Floating books: three books fly down the page and land on a shelf -----
    // The route is measured from the real sections. Books follow the side margins and cross
    // only in the empty padding between sections, and the layer sits behind all content.

    function buildBookJourney() {
        var layer = document.getElementById('bookJourney');
        if (!layer || !MP) {
            return;
        }
        var mainEl = layer.parentElement;
        var sections = gsap.utils.toArray(mainEl.children).filter(function (el) { return el.tagName === 'SECTION'; });
        var sample = mainEl.querySelector('.page-section > .container');
        var inner = mainEl.querySelector('.newsletter-inner');
        var trail = layer.querySelector('.journey-trail path');
        var trailSvg = layer.querySelector('.journey-trail');
        var shelf = layer.querySelector('.journey-shelf');
        var books = gsap.utils.toArray('.journey-book', layer);
        if (sections.length < 3 || !sample || !inner || !trail || !shelf || !books.length) {
            return;
        }

        layer.classList.add('is-ready');

        var mainRect = mainEl.getBoundingClientRect();
        var pageTop = mainRect.top + window.pageYOffset;
        var width = mainEl.clientWidth;
        var height = mainEl.offsetHeight;
        var viewport = window.innerHeight;
        var maxScroll = document.documentElement.scrollHeight - viewport;
        var sampleRect = sample.getBoundingClientRect();
        var sidePad = parseFloat(getComputedStyle(sample).paddingLeft);
        var contentLeft = sampleRect.left - mainRect.left + sidePad;
        // Centred in a wide margin. In a narrow one the book peeks in from the screen edge,
        // keeping a tilted book (up to 32px either side of its centre) clear of the text.
        var leftX = Math.min(contentLeft / 2, contentLeft - 40);
        var rightX = width - leftX;

        trailSvg.setAttribute('viewBox', '0 0 ' + width + ' ' + height);

        function topOf(el) {
            return el.getBoundingClientRect().top - mainRect.top;
        }

        function bottomOf(el) {
            return el.getBoundingClientRect().bottom - mainRect.top;
        }

        // Crossings happen at section boundaries, ending on the right side beside the shelf.
        var crossings = sections.length - 1;
        function sideAfter(index) {
            return (crossings - 1 - index) % 2 === 0 ? rightX : leftX;
        }

        var trunk = [];
        var previous = null;
        for (var i = 0; i < crossings; i++) {
            var boundary = bottomOf(sections[i]);
            var padBelow = parseFloat(getComputedStyle(sections[i]).paddingBottom);
            var padAbove = parseFloat(getComputedStyle(sections[i + 1]).paddingTop);
            var rise = Math.max(10, Math.min(padBelow, padAbove) - 50);
            var fromX = i === 0 ? (sideAfter(0) === rightX ? leftX : rightX) : sideAfter(i - 1);
            var toX = sideAfter(i);

            if (previous) {
                var columnStart = previous.y;
                var columnEnd = boundary - rise;
                var third = (columnEnd - columnStart) / 3;
                trunk.push({
                    x0: fromX, y0: columnStart, x1: fromX, y1: columnEnd,
                    d: 'C' + (fromX + 7) + ' ' + (columnStart + third) + ' ' + (fromX - 7) + ' ' + (columnEnd - third) + ' ' + fromX + ' ' + columnEnd,
                    pageY: columnEnd, widen: -110, rotation: fromX === leftX ? -4 : 4
                });
            }

            trunk.push({
                x0: fromX, y0: boundary - rise, x1: toX, y1: boundary + rise,
                d: 'C' + fromX + ' ' + boundary + ' ' + toX + ' ' + boundary + ' ' + toX + ' ' + (boundary + rise),
                pageY: boundary + rise, widen: 110, rotation: toX > fromX ? 14 : -14
            });
            previous = { y: boundary + rise };
        }

        // The shelf sits to the right of the newsletter form.
        var last = sections[sections.length - 1];
        // The shelf is an SVG, which has no offsetWidth or offsetHeight.
        var shelfRect = shelf.getBoundingClientRect();
        var shelfWidth = shelfRect.width;
        var shelfHeight = shelfRect.height;
        var innerRight = inner.getBoundingClientRect().right - mainRect.left;
        var shelfX = (innerRight + (width - contentLeft)) / 2 - shelfWidth / 2;
        var shelfY = topOf(last) + last.offsetHeight / 2 - shelfHeight / 2;
        var plankY = shelfY + shelfHeight - 10;
        gsap.set(shelf, { x: shelfX, y: shelfY });

        function toD(seg) {
            return 'M' + seg.x0 + ' ' + seg.y0 + ' ' + seg.d;
        }

        var trailEnd = { x: shelfX + shelfWidth / 2, y: plankY - 40 };
        var trailLast = trunk[trunk.length - 1];
        var trailFinal = 'C' + trailLast.x1 + ' ' + (trailLast.y1 + 50) + ' ' + trailEnd.x + ' ' + (trailEnd.y - 50) + ' ' + trailEnd.x + ' ' + trailEnd.y;
        var trailD = 'M' + trunk[0].x0 + ' ' + trunk[0].y0 + ' ' + trunk.map(function (seg) { return seg.d; }).join(' ') + ' ' + trailFinal;

        trail.setAttribute('d', trailD);
        var trailLength = trail.getTotalLength();

        // Length of each trunk piece, for keeping the line in step with the lead book.
        var measure = document.createElementNS(SVG_NS, 'path');
        var pieces = trunk.map(function (seg) {
            measure.setAttribute('d', toD(seg));
            return measure.getTotalLength();
        });

        gsap.set(trail, { strokeDasharray: trailLength, strokeDashoffset: trailLength });
        gsap.fromTo(shelf, { opacity: 0, y: shelfY + 14 }, {
            opacity: 1,
            y: shelfY,
            scrollTrigger: { trigger: last, start: 'top 80%', toggleActions: 'play none none reverse' }
        });

        // Resting spots in the free space beside the hero text.
        var heroHeight = sections[0].offsetHeight;
        var heroMargin = Math.max((width - 780) / 2, 70);
        var spots = [
            { x: width - heroMargin * 0.5, y: heroHeight * 0.3 },
            { x: heroMargin * 0.5, y: heroHeight * 0.62 },
            { x: width - heroMargin * 0.34, y: heroHeight * 0.72 }
        ];
        var settings = [
            { anchor: 0.62, scrub: 0.5, heroScale: 1.35, slot: 26 },
            { anchor: 0.46, scrub: 0.8, heroScale: 1.3, slot: 62 },
            { anchor: 0.32, scrub: 1.1, heroScale: 1.25, slot: 94 }
        ];

        books.forEach(function (book, index) {
            var setting = settings[index % settings.length];
            var spot = spots[index % spots.length];
            var bookInner = book.querySelector('.journey-book-inner');
            var landedScale = 0.8;
            var slotX = shelfX + setting.slot;
            var slotY = plankY - (book.offsetHeight * landedScale) / 2;
            var first = trunk[0];
            var end = trunk[trunk.length - 1];

            // A book resting on the far side of the hero joins after the first crossing,
            // so it never travels behind the hero text.
            var sameSide = Math.abs(spot.x - first.x0) < width / 2;
            var joinX = sameSide ? first.x0 : first.x1;
            var joinY = sameSide ? first.y0 : first.y1;
            var shared = sameSide ? trunk : trunk.slice(1);

            var route = [{
                d: 'M' + spot.x + ' ' + spot.y + ' C' + spot.x + ' ' + (spot.y + 90) + ' ' + joinX + ' ' + (joinY - 90) + ' ' + joinX + ' ' + joinY,
                pageY: joinY, widen: sameSide ? -110 : 110, rotation: 6, scale: 1
            }].concat(shared.map(function (seg) {
                return { d: toD(seg), pageY: seg.pageY, widen: seg.widen, rotation: seg.rotation };
            })).concat([{
                d: 'M' + end.x1 + ' ' + end.y1 + ' C' + end.x1 + ' ' + (end.y1 + 50) + ' ' + slotX + ' ' + (slotY - 60) + ' ' + slotX + ' ' + slotY,
                pageY: slotY, widen: 0, rotation: 0, scale: landedScale
            }]);

            // Scroll position at which the book reaches the end of each piece.
            var scrollAt = 0;
            var stops = route.map(function (seg) {
                var target = pageTop + seg.pageY + seg.widen - setting.anchor * viewport;
                scrollAt = Math.max(target, scrollAt + 60);
                return scrollAt;
            });
            var fit = Math.min(1, maxScroll / scrollAt);

            gsap.set(book, {
                xPercent: -50, yPercent: -50,
                x: spot.x, y: spot.y,
                scale: setting.heroScale,
                rotation: index % 2 ? 8 : -8
            });

            var float = gsap.to(bookInner, {
                y: index % 2 ? 7 : -7,
                rotation: index % 2 ? -3 : 3,
                duration: 2.2 + index * 0.4,
                ease: 'sine.inOut',
                repeat: -1,
                yoyo: true
            });

            var landed = false;
            var timeline = gsap.timeline({
                defaults: { ease: 'none' },
                scrollTrigger: {
                    start: 0,
                    end: stops[stops.length - 1] * fit,
                    scrub: setting.scrub,
                    onUpdate: function (self) {
                        var isLanded = self.progress > 0.985;
                        if (isLanded === landed) {
                            return;
                        }
                        landed = isLanded;
                        if (landed) {
                            float.pause();
                            gsap.to(bookInner, { y: 0, rotation: 0, duration: 0.3, overwrite: 'auto' });
                        } else {
                            float.play();
                        }
                    }
                }
            });

            var cursor = 0;
            route.forEach(function (seg, segIndex) {
                var stop = stops[segIndex] * fit;
                var duration = stop - cursor;
                timeline.to(book, { motionPath: { path: seg.d }, duration: duration }, cursor);
                var vars = { rotation: seg.rotation, duration: duration };
                if (seg.scale !== undefined) {
                    vars.scale = seg.scale;
                }
                timeline.to(book, vars, cursor);

                // The first book draws the line behind it.
                if (index === 0) {
                    // Pieces of the shared line this book has finished once this segment ends.
                    var finished = segIndex + (trunk.length - shared.length);
                    var drawn = finished <= pieces.length
                        ? pieces.slice(0, finished).reduce(function (sum, piece) { return sum + piece; }, 0)
                        : trailLength;
                    timeline.to(trail, { strokeDashoffset: trailLength - drawn, duration: duration }, cursor);
                }
                cursor = stop;
            });
        });

        return function () {
            layer.classList.remove('is-ready');
        };
    }

    // ----- Book covers tilt slightly towards the pointer -----

    function coverTilt() {
        var cleanups = gsap.utils.toArray('.book-card').map(function (card) {
            var cover = card.querySelector('.book-img img');
            if (!cover) {
                return function () {};
            }
            gsap.set(cover, { transformPerspective: 700 });
            var toY = gsap.quickTo(cover, 'rotationY', { duration: 0.4 });
            var toX = gsap.quickTo(cover, 'rotationX', { duration: 0.4 });

            function onMove(event) {
                var rect = card.getBoundingClientRect();
                toY(((event.clientX - rect.left) / rect.width - 0.5) * 10);
                toX(((event.clientY - rect.top) / rect.height - 0.5) * -8);
            }

            function onLeave() {
                toY(0);
                toX(0);
            }

            card.addEventListener('pointermove', onMove);
            card.addEventListener('pointerleave', onLeave);
            return function () {
                card.removeEventListener('pointermove', onMove);
                card.removeEventListener('pointerleave', onLeave);
            };
        });

        return function () {
            cleanups.forEach(function (cleanup) { cleanup(); });
        };
    }

    // ----- Start everything for the current screen and motion preference -----

    var media = gsap.matchMedia();

    media.add(motionOk, function () {
        var cleanups = [languageSwitch(), intro()];
        if (ST) {
            scrollReveals();
            cleanups.push(rebuildable(buildProcessPath));
        }
        return function () {
            cleanups.forEach(function (cleanup) { cleanup(); });
        };
    });

    if (ST) {
        media.add(motionOk + ' and (min-width: 768px)', heroParallax);
        media.add(motionOk + ' and (min-width: 1024px)', function () {
            return rebuildable(buildBookJourney);
        });
    }

    media.add(motionOk + ' and (hover: hover) and (pointer: fine)', coverTilt);

    release();
})();
