# Project Improvement Suggestions

## Highest-priority improvements

### 1. Make reservations and returns consistent and reliable

- Treat each copy as inventory, rather than using the book-wide `is_held` flag to decide whether a title can be reserved. A title can have several copies, so its availability should be driven by copy count and active reservations. The current details page both checks `available_books` and `is_held`, but the reservation flow decrements inventory without clearing or consistently updating that flag. See [details.php](details.php#L19-L42), [details.php](details.php#L70-L89), and the [librat schema](bibloteka.sql#L45-L56).
- Make reservation creation an atomic database operation: confirm a copy is available, create the hold, and decrement availability as one transaction. Reject invalid or past pickup dates and prevent duplicate or over-capacity holds. This avoids two simultaneous requests reserving the last copy.
- Unify return handling. The admin page posts to `mark_returned.php`, which changes the hold status but does not restore the book count; a separate `return_book.php` does restore it, but is not the handler shown in the admin table. Route all returns through one verified workflow, and make repeat submissions harmless. See [admin.php](admin.php#L61-L76), [mark_returned.php](mark_returned.php#L12-L24), and [return_book.php](return_book.php#L11-L21).
- Show clear reservation outcomes and history to students, including pickup date, current status, and cancellation rules. At present, the user-facing flow is centered on placing a hold, while the admin page is the main view of hold records ([details.php](details.php#L75-L105), [admin.php](admin.php#L11-L76)).

### 2. Repair and simplify the shared JavaScript

- Make scripts initialize only when the elements they use exist. `main.js` is shared across pages but expects a mobile-menu button, modal, cart, and other elements; several of those controls are not present in the shared header. A missing element can stop the rest of the script from running. See [main.js](main.js#L4-L85) and [header.php](header.php#L90-L120).
- Fix the category-filter code, which currently has a split `dataset.category` expression at [main.js](main.js#L90-L110), and either connect it to the actual catalog card data or remove the unused client-side filter in favor of the existing category links.
- Remove or implement unused cart, modal, and multi-step-form interactions. These controls are not part of the current borrowing experience and can confuse users or create errors when their expected HTML is absent ([main.js](main.js#L27-L88), [main.js](main.js#L114-L184)).
- Load shared scripts once, from one common layout. Several pages include shared layout files and also contain their own footer/script markup, which risks duplicate footers or duplicate script execution (for example, [details.php](details.php#L108-L178)).

### 3. Correct catalog categories, labels, and counts

- Align category names shown to users with the values stored in the database. For example, the catalog maps stored values such as `Fantazi`, `Dramë`, and `Aventurë` to labels like “Thriller,” “Romancë,” and “Poezia”; those labels may not describe the same categories. Check the same mappings wherever categories are displayed ([books.php](books.php#L20-L28), [upload.php](upload.php#L30-L40), [index.php](index.php#L111-L158)).
- Replace manually written category totals on the home page with counts calculated from the catalog. Fixed values such as “450+ libra” can become misleading as the collection changes ([index.php](index.php#L111-L158)).
- Add result counts, an explicit empty state, and a visible indication of the active category. Keep category filtering consistent between the home page and full catalog.
- Add pagination and sorting (title, author, newest additions, and availability) as the collection grows. The current catalog fetches every matching record in one query ([books.php](books.php#L5-L10)).

## Usability and feature suggestions

### Catalog discovery

- Extend search beyond title and author to include category, grade range, and—if the data is collected—ISBN or subject. The home-page placeholder mentions ISBN, but the current search implementation is limited to title and author ([index.php](index.php#L24-L31), [search.php](search.php#L5-L12)).
- Preserve the search term and selected filters in the results page, and offer helpful suggestions when there are no matches.
- Show an explicit availability label on every book card, and let users filter to available books. Current cards show numeric totals, while the detailed status uses `is_held`, which may not accurately represent a multi-copy title ([books.php](books.php#L35-L44), [details.php](details.php#L70-L74)).
- Improve book details with consistent metadata such as ISBN, publisher, publication year, language, subject, and age/grade suitability where available. These fields would need corresponding schema and admin-form changes.
- Add clear fallback cover images and meaningful image descriptions. Current catalog images use the generic alt text “Book Image” ([books.php](books.php#L30-L32)).

### Student and librarian workflows

- Add a student account page for active holds, past loans, pickup dates, and contact or profile details. Consider adding self-service cancellation before pickup, subject to library policy.
- Add optional due dates, overdue indicators, renewal requests, and notifications (email or in-app) after the school defines the relevant borrowing rules.
- Improve the admin panel with search and filters for student, title, hold date, pickup date, and status; add pagination and a summary of pending, overdue, and returned items. The current table is an unfiltered list ([admin.php](admin.php#L11-L76)).
- Add catalog management actions for editing and archiving books, correcting metadata, and adjusting copy counts. The current admin navigation exposes adding a book, while the panel primarily lists holds ([header.php](header.php#L101-L106), [upload.php](upload.php#L1-L78)).
- Confirm whether the “delete” action should remove only a returned hold record or archive it for history. Retaining circulation history is generally more useful for reporting than deleting it permanently ([admin.php](admin.php#L71-L76), [return_book.php](return_book.php#L11-L21)).
- Replace the home page’s nonfunctional newsletter form with a real, consent-based subscription flow, or remove it until it can be supported ([index.php](index.php#L288-L298)).

## Design, accessibility, and localization

- Establish a consistent visual system for buttons, forms, alerts, tables, spacing, and typography. The project already defines CSS variables and responsive rules, but shared elements should use one predictable set of patterns ([style.css](style.css#L10-L46), [style.css](style.css#L90-L135)).
- Simplify the home page by removing duplicated search-section markup, reducing repeated promotional content, and making the primary actions—searching, browsing, and signing in—prominent ([index.php](index.php#L20-L46)).
- Replace the fixed inline margin on the news link with responsive layout rules so it does not depend on a desktop-sized offset ([index.php](index.php#L232-L238)).
- Review repeated or placeholder content, dead links, and inconsistent footer text across pages. For example, the admin footer links to `.html` pages that are not part of the listed PHP site, and other pages have differing descriptions and contact information ([admin.php](admin.php#L90-L145), [details.php](details.php#L108-L178)).
- Complete Albanian and English localization across the entire workflow. The language switch links between home pages, but the catalog and search pages are not consistently switched, and the English search page still contains Albanian result-card labels ([header.php](header.php#L116-L120), [searchAnglisht.php](searchAnglisht.php#L16-L31)).
- Improve accessibility with semantic page landmarks, a clear heading hierarchy, visible keyboard focus, descriptive link and icon labels, form error associations, and accessible status messages. Ensure icon-only social links and controls have accessible names.
- Test responsive layouts at common phone and tablet widths. Some CSS supports mobile navigation, but the header markup should expose a working, keyboard-accessible toggle and the news link should not rely on a fixed pixel margin ([style.css](style.css#L1305-L1458), [header.php](header.php#L90-L120), [index.php](index.php#L236)).
- Avoid forcing a one-second loading screen on every page if the page is already ready; it delays access without communicating meaningful progress ([header.php](header.php#L33-L40), [header.php](header.php#L123-L137)).

### GSAP motion and interaction design

The added `gsap-public` folder contains GSAP 3.15.0 in minified, UMD, and ESM formats, including ScrollTrigger and Flip. Treat animation as optional polish that supports navigation and feedback, not as a prerequisite for using the library.

- Use a short, subtle entrance for the home-page hero content and staggered reveals for book cards or category tiles as they enter the viewport. Keep movement and delays restrained so the catalog remains quick to scan ([index.php](index.php#L10-L18), [index.php](index.php#L80-L166), [books.php](books.php#L29-L47)).
- Consider ScrollTrigger for one-time, viewport-based reveals on long home-page sections. Do not hijack scrolling, pin large sections, or make users wait for an animation before they can search, browse, or reserve ([index.php](index.php#L20-L46), [index.php](index.php#L220-L298), [gsap-public/gsap-public/minified/ScrollTrigger.min.js](gsap-public/gsap-public/minified/ScrollTrigger.min.js)).
- Consider a small Flip transition only if client-side catalog filtering or sorting is introduced, so cards can move between positions without abrupt jumps. Keep server-rendered category links and results fully usable without JavaScript ([books.php](books.php#L5-L47), [gsap-public/gsap-public/minified/Flip.min.js](gsap-public/gsap-public/minified/Flip.min.js)).
- Use brief, non-blocking feedback for meaningful actions such as a successful reservation or an admin status change. Keep the actual confirmation text visible and accessible; motion should not be the only indication of success or failure ([details.php](details.php#L35-L48), [admin.php](admin.php#L61-L76)).
- Respect `prefers-reduced-motion`: disable or greatly reduce nonessential movement for users who request it. Avoid text-scrambling, large parallax effects, flashing, and animation that obscures content or controls.
- Keep all content visible by default and add animation only after the relevant script has initialized successfully. If JavaScript or GSAP fails to load, the page should still render and work normally.
- If GSAP is adopted, use only the needed core and plugins. The local minified files are a straightforward option for this PHP project, which currently has no Node/package manifest; ESM files are better suited if a bundling workflow is introduced. Load scripts once, locally, and only on pages that use them. Check distribution terms before shipping the bundled files.
- Initialize animations only for elements present on the current page, and clean up ScrollTrigger instances when applicable. This is especially important before expanding the shared [main.js](main.js), which currently assumes several page elements exist and has unrelated initialization errors ([main.js](main.js#L4-L85), [main.js](main.js#L90-L184)).

## Reliability, security, and maintainability

- Use prepared statements for all database queries that include user input, including category filtering and book uploads. Search and login already use different approaches, so standardizing database access would make behavior safer and easier to maintain ([books.php](books.php#L5-L10), [search.php](search.php#L5-L12), [upload.php](upload.php#L57-L74), [login.php](login.php#L8-L13)).
- Validate all submitted values on the server, including numeric copy counts, category membership, pickup dates, and uploaded image type, size, and content. Do not rely only on browser-side `required` attributes or a file’s reported image dimensions ([upload.php](upload.php#L16-L74), [details.php](details.php#L27-L37)).
- Add CSRF protection to state-changing forms such as reservations, returns, and deletions. Require a confirmation for destructive admin actions.
- Escape all user- or database-controlled output consistently, particularly student names, email addresses, status text, and messages in admin views ([admin.php](admin.php#L61-L76)).
- Move database credentials out of the web-accessible source file, configure production error handling and logging, and use a least-privilege database account. The current configuration hardcodes connection settings and terminates with the raw connection error ([config.php](config.php#L1-L14)).
- Set secure session-cookie options and regenerate the session ID after successful login or registration. Add basic login throttling and a password policy appropriate for student accounts ([login.php](login.php#L1-L30), [signup.php](signup.php#L1-L48)).
- Store uploaded images in a controlled file/object-storage location or otherwise enforce strict size/type limits and serve the correct MIME type. The current image endpoint always declares JPEG while returning a database blob ([upload.php](upload.php#L50-L74), [view.php](view.php#L1-L14)).
- Add indexes for common catalog searches and circulation filters as data volume grows. Consider normalized category data and explicit constraints for nonnegative availability and valid inventory counts; the current schema has basic keys and email uniqueness but no inventory checks ([bibloteka.sql](bibloteka.sql#L30-L56), [bibloteka.sql](bibloteka.sql#L103-L154)).
- Separate shared layout, request handling, and database operations from page templates. The header currently also processes registration submissions, and several PHP files mix request logic with markup; a small shared helper layer would reduce duplication and make behavior easier to test ([header.php](header.php#L1-L39), [details.php](details.php#L1-L50), [upload.php](upload.php#L1-L78)).
- Add a repeatable local setup guide, documented database import steps, and a small set of checks for registration, login, search, reservation, return, and admin permissions. The current README contains only a short project description ([README.md](README.md)).

## Suggested implementation order

1. Fix reservation/return inventory consistency and the shared JavaScript runtime issues.
2. Correct category labels and counts; improve search, empty states, and availability display.
3. Add student circulation history and strengthen the admin workflow.
4. Standardize responsive design, accessibility, and Albanian/English content.
5. Improve validation, database configuration, session protections, and project documentation.
6. Once shared JavaScript is stable, consider restrained GSAP motion with reduced-motion and no-JavaScript fallbacks.
7. Add optional enhancements such as reminders, overdue handling, reporting, and richer book metadata after school policies are agreed.

Before introducing loan periods, renewal rules, or cancellation behavior, confirm the school’s circulation policy so the interface and data model reflect real procedures.
