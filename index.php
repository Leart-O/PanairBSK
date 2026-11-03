<?php
session_start();
include("config.php");

// Fetch the 4 newest books
$result = $db->query("SELECT id, title, author, foto, total_books, available_books FROM librat ORDER BY id DESC LIMIT 4");
$useScrollMotion = true;
$useMotionPath = true;
?>
<?php include("header.php");?>

    <!-- Hero and search -->
    <section class="hero">
        <div class="hero-bg" aria-hidden="true"></div>
        <div class="container">
            <div class="hero-inner">
                <p class="hero-eyebrow" data-intro>Biblioteka e shkollës</p>
                <h1 data-intro>The British School of Kosova</h1>
                <p class="hero-lead" data-intro>Zbuloni koleksionin tonë të pasur të librave arsimorë për të gjitha klasat dhe nivelet</p>
                <form method="GET" action="search.php" class="search-container" role="search" data-intro>
                    <input type="text" name="kerko" class="search-input" placeholder="Kërko sipas titullit ose autorit" aria-label="Kërko librat" required>
                    <button type="submit" class="search-btn"><i class="fas fa-search" aria-hidden="true"></i>Kërko</button>
                </form>
                <div class="hero-btns" data-intro>
                    <a href="books.php" class="btn btn-gold">Shfleto të gjithë librat</a>
                    <?php if (!isset($_SESSION['user_id'])): ?>
                        <a href="login.php" class="btn btn-ghost-light">Hyr në llogari</a>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </section>

    <!-- New Books Section -->
    <section class="page-section">
        <div class="container">
            <div class="section-header">
                <div class="section-title">
                    <h2>Librat</h2>
                    <p>Zbuloni koleksionin tonë të librave</p>
                </div>
                <a href="books.php" class="view-all">Shiko të gjitha <i class="fas fa-arrow-right" aria-hidden="true"></i></a>
            </div>

            <div class="books-grid">
                <?php while ($row = $result->fetch_assoc()): ?>
                    <?php include("book_card.php"); ?>
                <?php endwhile; ?>
            </div>
        </div>
    </section>

    <!-- Categories Section -->
    <section class="page-section section-tint">
        <div class="container">
            <div class="section-title">
                <h2>Kategoritë tona</h2>
                <p>Zgjidhni sipas klasave dhe lëndëve tuaja të preferuara</p>
            </div>

            <div class="categories-grid">
                <a href="books.php?category=Klasa+1-5" class="category-card">
                    <div class="category-icon"><i class="fas fa-child" aria-hidden="true"></i></div>
                    <h3>Klasa 1-5</h3>
                    <p class="category-count">15+ libra</p>
                </a>

                <a href="books.php?category=Klasa+6-9" class="category-card">
                    <div class="category-icon"><i class="fas fa-user-graduate" aria-hidden="true"></i></div>
                    <h3>Klasa 6-9</h3>
                    <p class="category-count">30+ libra</p>
                </a>

                <a href="books.php?category=Klasa+10-12" class="category-card">
                    <div class="category-icon"><i class="fas fa-graduation-cap" aria-hidden="true"></i></div>
                    <h3>Klasa 10-12</h3>
                    <p class="category-count">450+ libra</p>
                </a>

                <a href="books.php?category=Fantazi" class="category-card">
                    <div class="category-icon"><i class="fas fa-atom" aria-hidden="true"></i></div>
                    <h3>Thriller</h3>
                    <p class="category-count">180+ libra</p>
                </a>

                <a href="books.php?category=Dramë" class="category-card">
                    <div class="category-icon"><i class="fas fa-landmark" aria-hidden="true"></i></div>
                    <h3>Romancë</h3>
                    <p class="category-count">120+ libra</p>
                </a>

                <a href="books.php?category=Aventurë" class="category-card">
                    <div class="category-icon"><i class="fas fa-book-reader" aria-hidden="true"></i></div>
                    <h3>Poezia</h3>
                    <p class="category-count">250+ libra</p>
                </a>
            </div>
        </div>
    </section>

    <!-- How it works -->
    <section class="page-section">
        <div class="container">
            <div class="section-title">
                <h2>Si funksionon</h2>
                <p>Nga kërkimi te libri në duart tuaja, në tre hapa.</p>
            </div>

            <ol class="process-steps">
                <li class="process-step">
                    <div class="process-icon"><i class="fas fa-search" aria-hidden="true"></i></div>
                    <div>
                        <h3>Kërko</h3>
                        <p>Gjeni librin me kërkim ose sipas kategorisë.</p>
                    </div>
                </li>
                <li class="process-step">
                    <div class="process-icon"><i class="far fa-calendar-alt" aria-hidden="true"></i></div>
                    <div>
                        <h3>Rezervo</h3>
                        <p>Hyni në llogari, hapni librin dhe zgjidhni datën e marrjes.</p>
                    </div>
                </li>
                <li class="process-step">
                    <div class="process-icon"><i class="fas fa-book-open" aria-hidden="true"></i></div>
                    <div>
                        <h3>Merre</h3>
                        <p>Merreni librin në bibliotekë në datën që keni zgjedhur.</p>
                    </div>
                </li>
                <li class="process-decor" aria-hidden="true">
                    <svg class="process-line" focusable="false"><path fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round"></path></svg>
                    <svg class="process-rider" viewBox="0 0 52 68" focusable="false">
                        <rect x="6" y="3" width="44" height="63" rx="2" fill="#fbf8f1" stroke="#d9d2c0"></rect>
                        <rect x="2" y="1" width="44" height="63" rx="3" fill="#c8952e"></rect>
                        <rect x="15" y="14" width="24" height="4" rx="2" fill="#14305c"></rect>
                    </svg>
                </li>
            </ol>
        </div>
    </section>

    <!-- Feature -->
    <section class="page-section">
        <div class="container">
            <div class="feature-strip">
                <div class="feature-icon"><i class="fas fa-book" aria-hidden="true"></i></div>
                <div>
                    <h2>Biblioteka e The British School of Kosova ka shumëllojshmëri të librave.</h2>
                    <p>Zgjedhjet e shumta nga kategori të ndryshme mundësojnë që nxënësit të kenë akses në njohuri të pakufishme.</p>
                </div>
            </div>
        </div>
    </section>

    <!-- Testimonials Section -->
    <section class="page-section testimonials">
        <div class="container">
            <div class="section-title">
                <h2>Opinione nga nxënësit</h2>
            </div>

            <div class="testimonials-grid">
                <figure class="testimonial-card">
                    <blockquote>Platforma e bibliotekës na ndihmon të zgjerojmë horizontet tona dhe të gjejmë burime që nuk mund t'i gjejmë lehtësisht diku tjetër.</blockquote>
                    <figcaption><strong>Loris Geci</strong><span>Nxënës, Klasa 10</span></figcaption>
                </figure>

                <figure class="testimonial-card">
                    <blockquote>Falë bibliotekës digjitale, mësimet bëhen më interesante dhe mund të qasemi në libra dhe materiale që e bëjnë mësimin më të thjeshtë.</blockquote>
                    <figcaption><strong>Mendim Shoshi</strong><span>Nxënës, Klasa 10</span></figcaption>
                </figure>

                <figure class="testimonial-card">
                    <blockquote>Biblioteka është një mundësi e shkëlqyer për të eksploruar dijen dhe për të zhvilluar aftësitë tona, duke pasur gjithmonë burimet e duhura në duar.</blockquote>
                    <figcaption><strong>Arita Maxhuni</strong><span>Nxënës, Klasa 10</span></figcaption>
                </figure>

                <figure class="testimonial-card">
                    <blockquote>Me platformën e bibliotekës, çdo nxënës ka mundësinë të mësojë në mënyrë të pavarur dhe të thellojë njohuritë në çdo lëndë.</blockquote>
                    <figcaption><strong>Leart Obertinca</strong><span>Nxënës, Klasa 10</span></figcaption>
                </figure>
            </div>
        </div>
    </section>

    <!-- Blog Section -->
    <section class="page-section">
        <div class="container">
            <div class="section-header">
                <div class="section-title">
                    <h2>Lajme dhe Artikuj</h2>
                    <p>Lexoni artikujt tanë më të fundit rreth arsimit dhe librave</p>
                </div>
                <a href="https://britishschoolkosova.com/lajmet/" class="view-all">Shiko më shumë <i class="fas fa-arrow-right" aria-hidden="true"></i></a>
            </div>
            <div class="blog-grid">
                <article class="blog-card">
                    <div class="blog-img">
                        <img src="https://britishschoolkosova.com/wp-content/uploads/2023/03/9.jpg" alt="" loading="lazy">
                    </div>
                    <div class="blog-content">
                        <div class="blog-meta">
                            <span><i class="far fa-calendar-alt" aria-hidden="true"></i>15 Maj 2023</span>
                            <span><i class="far fa-eye" aria-hidden="true"></i>1.2K</span>
                        </div>
                        <h3 class="blog-title">Në BSK shënohet Dita e Poezisë</h3>
                        <p class="blog-excerpt">Poezia është pikturë që dëgjohet” – ishin fjalët e Leonardo da Vinҁit me të cilën filloi “Ora e Poezisë” në BSK. E shenjuar në kuadër Ditës së Poezisë, kjo ngjarje mblodhi nxënës, profesorë, poetë dhe familje të poetëve tashmë të ndjerë.</p>
                        <a href="https://britishschoolkosova.com/ne-bsk-shenohet-dita-e-poezise/" class="read-more" aria-label="Lexo më shumë: Në BSK shënohet Dita e Poezisë">Lexo më shumë <i class="fas fa-arrow-right" aria-hidden="true"></i></a>
                    </div>
                </article>

                <article class="blog-card">
                    <div class="blog-img">
                        <img src="https://britishschoolkosova.com/wp-content/uploads/2023/02/5-2-1-scaled.jpg" alt="" loading="lazy">
                    </div>
                    <div class="blog-content">
                        <div class="blog-meta">
                            <span><i class="far fa-calendar-alt" aria-hidden="true"></i>24 Mars 2023</span>
                            <span><i class="far fa-eye" aria-hidden="true"></i>890</span>
                        </div>
                        <h3 class="blog-title">Punime rreth dizajnit të enterierit dhe eksterierit.</h3>
                        <p class="blog-excerpt">Sot, nxënësit e klasave të 8-ta të The British School of Kosova, punuan punime të dizajnit të enterierit dhe eksterierit. Ata mësuan si të bëjnë matjet, dizajnimin me vija dhe zhvilluan imagjinatën e tyre në një projekt arkitektural.</p>
                        <a href="https://britishschoolkosova.com/punime-rreth-dizajnit-te-interierit-dhe-eksterierit/" class="read-more" aria-label="Lexo më shumë: Punime rreth dizajnit të enterierit dhe eksterierit">Lexo më shumë <i class="fas fa-arrow-right" aria-hidden="true"></i></a>
                    </div>
                </article>

                <article class="blog-card">
                    <div class="blog-img">
                        <img src="https://britishschoolkosova.com/wp-content/uploads/2023/02/Matematika-0.jpg" alt="" loading="lazy">
                    </div>
                    <div class="blog-content">
                        <div class="blog-meta">
                            <span><i class="far fa-calendar-alt" aria-hidden="true"></i>20 Qershor 2023</span>
                            <span><i class="far fa-eye" aria-hidden="true"></i>1.5K</span>
                        </div>
                        <h3 class="blog-title">Aktivitet në kuadër të lëndës së Matematikës</h3>
                        <p class="blog-excerpt">Në kuadër të lëndës së Matematikës me nxënësit e klasës së dhjetë ndërkombëtare është zhvilluar aktiviteti “Paraqitja gjeometrike e numrave iracionalë’’. Një numër iracional është një numër që nuk mund të shprehet si raport i dy numrave të plotë. Nëse shkruhet si numër decimal, atëherë ai është me pafund shifra pas presjes dhjetore të cilat përsëriten pa ndonjë rregull të caktuar.</p>
                        <a href="https://britishschoolkosova.com/aktivitet-ne-kuader-te-lendes-se-matematikes/" class="read-more" aria-label="Lexo më shumë: Aktivitet në kuadër të lëndës së Matematikës">Lexo më shumë <i class="fas fa-arrow-right" aria-hidden="true"></i></a>
                    </div>
                </article>
            </div>
        </div>
    </section>

    <!-- Newsletter Section -->
    <section class="page-section section-tint">
        <div class="container">
            <div class="newsletter-inner">
                <h2>Abonohu në Newsletter-in tonë</h2>
                <p>Regjistrohu për të marrë njoftimet më të fundit për ofertat dhe risitë tona</p>

                <form class="newsletter-form">
                    <input type="email" class="newsletter-input" placeholder="Shkruani email-in tuaj" aria-label="Email" required>
                    <button type="submit" class="btn btn-primary">Abonohu</button>
                </form>
            </div>
        </div>
    </section>

<?php include("book_journey.php");?>
<?php include("footer.php");?>
