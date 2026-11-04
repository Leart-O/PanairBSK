<?php
session_start();
include("config.php");

// Fetch the 4 newest books, with the demo books counted as newest
$result = $db->query("SELECT id, title, author, foto, total_books, available_books FROM librat ORDER BY id DESC LIMIT 4");
$books = array_slice(array_merge(demo_home_books(), $result->fetch_all(MYSQLI_ASSOC)), 0, 4);
$useScrollMotion = true;
$useMotionPath = true;
?>
<?php include("headerA.php");?>

    <!-- Hero and search -->
    <section class="hero">
        <div class="hero-bg" aria-hidden="true"></div>
        <div class="container">
            <div class="hero-inner">
                <p class="hero-eyebrow" data-intro>School library</p>
                <h1 data-intro>The British School of Kosova</h1>
                <p class="hero-lead" data-intro>Discover our rich collection of educational books for all grades and levels</p>
                <form method="GET" action="searchAnglisht.php" class="search-container" role="search" data-intro>
                    <input type="text" name="kerko" class="search-input" placeholder="Search by title or author" aria-label="Search books" required>
                    <button type="submit" class="search-btn"><i class="fas fa-search" aria-hidden="true"></i>Search</button>
                </form>
                <div class="hero-btns" data-intro>
                    <a href="books.php" class="btn btn-gold">Browse all books</a>
                    <?php if (!isset($_SESSION['user_id'])): ?>
                        <a href="login.php" class="btn btn-ghost-light">Log in</a>
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
                    <h2>Books</h2>
                    <p>Discover our book collection</p>
                </div>
                <a href="books.php" class="view-all">View all <i class="fas fa-arrow-right" aria-hidden="true"></i></a>
            </div>

            <div class="books-grid">
                <?php foreach ($books as $row): ?>
                    <?php include("book_card.php"); ?>
                <?php endforeach; ?>
            </div>
        </div>
    </section>

    <!-- Categories Section -->
    <section class="page-section section-tint">
        <div class="container">
            <div class="section-title">
                <h2>Our Categories</h2>
                <p>Choose according to your preferred classes and subjects</p>
            </div>

            <div class="categories-grid">
                <a href="books.php?category=Klasa+1-5" class="category-card">
                    <div class="category-icon"><i class="fas fa-child" aria-hidden="true"></i></div>
                    <h3>Grades 1-5</h3>
                    <p class="category-count">15+ Books</p>
                </a>

                <a href="books.php?category=Klasa+6-9" class="category-card">
                    <div class="category-icon"><i class="fas fa-user-graduate" aria-hidden="true"></i></div>
                    <h3>Grades 6-9</h3>
                    <p class="category-count">12+ Books</p>
                </a>

                <a href="books.php?category=Klasa+10-12" class="category-card">
                    <div class="category-icon"><i class="fas fa-graduation-cap" aria-hidden="true"></i></div>
                    <h3>Grades 10-12</h3>
                    <p class="category-count">8+ Books</p>
                </a>

                <a href="books.php?category=Fantazi" class="category-card">
                    <div class="category-icon"><i class="fas fa-atom" aria-hidden="true"></i></div>
                    <h3>Thriller</h3>
                    <p class="category-count">9+ Books</p>
                </a>

                <a href="books.php?category=Dramë" class="category-card">
                    <div class="category-icon"><i class="fas fa-landmark" aria-hidden="true"></i></div>
                    <h3>Romance</h3>
                    <p class="category-count">8+ Books</p>
                </a>

                <a href="books.php?category=Aventurë" class="category-card">
                    <div class="category-icon"><i class="fas fa-book-reader" aria-hidden="true"></i></div>
                    <h3>Poetry</h3>
                    <p class="category-count">9+ Books</p>
                </a>
            </div>
        </div>
    </section>

    <!-- How it works -->
    <section class="page-section">
        <div class="container">
            <div class="section-title">
                <h2>How it works</h2>
                <p>From search to the book in your hands, in three steps.</p>
            </div>

            <ol class="process-steps">
                <li class="process-step">
                    <div class="process-icon"><i class="fas fa-search" aria-hidden="true"></i></div>
                    <div>
                        <h3>Search</h3>
                        <p>Find a book by searching or browsing a category.</p>
                    </div>
                </li>
                <li class="process-step">
                    <div class="process-icon"><i class="far fa-calendar-alt" aria-hidden="true"></i></div>
                    <div>
                        <h3>Reserve</h3>
                        <p>Log in, open the book and choose a pickup date.</p>
                    </div>
                </li>
                <li class="process-step">
                    <div class="process-icon"><i class="fas fa-book-open" aria-hidden="true"></i></div>
                    <div>
                        <h3>Collect</h3>
                        <p>Pick up the book at the library on the date you chose.</p>
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
                    <h2>The library of The British School of Kosova has a variety of books.</h2>
                    <p>Multiple choices from different categories enable students to access limitless knowledge.</p>
                </div>
            </div>
        </div>
    </section>

    <!-- Testimonials Section -->
    <section class="page-section testimonials">
        <div class="container">
            <div class="section-title">
                <h2>Opinions from students</h2>
            </div>

            <div class="testimonials-grid">
                <figure class="testimonial-card">
                    <blockquote>The library platform helps us broaden our horizons and find resources that we can't easily find elsewhere.</blockquote>
                    <figcaption><strong>Loris Geci</strong><span>Student, Grade 10</span></figcaption>
                </figure>

                <figure class="testimonial-card">
                    <blockquote>Thanks to the digital library, lessons become more interesting and we can access books and materials that make learning easier.</blockquote>
                    <figcaption><strong>Mendim Shoshi</strong><span>Student, Grade 10</span></figcaption>
                </figure>

                <figure class="testimonial-card">
                    <blockquote>The library is a great opportunity to explore knowledge and develop our skills, always having the right resources on hand.</blockquote>
                    <figcaption><strong>Arita Maxhuni</strong><span>Student, Grade 10</span></figcaption>
                </figure>

                <figure class="testimonial-card">
                    <blockquote>With the library platform, every learner has the opportunity to learn independently and deepen their knowledge in any subject.</blockquote>
                    <figcaption><strong>Leart Obertinca</strong><span>Student, Grade 10</span></figcaption>
                </figure>
            </div>
        </div>
    </section>

    <!-- Blog Section -->
    <section class="page-section">
        <div class="container">
            <div class="section-header">
                <div class="section-title">
                    <h2>News &amp; Articles</h2>
                    <p>Read our latest articles about education and books</p>
                </div>
                <a href="https://britishschoolkosova.com/lajmet/" class="view-all">View more <i class="fas fa-arrow-right" aria-hidden="true"></i></a>
            </div>
            <div class="blog-grid">
                <article class="blog-card">
                    <div class="blog-img">
                        <img src="https://britishschoolkosova.com/wp-content/uploads/2023/03/9.jpg" alt="" loading="lazy">
                    </div>
                    <div class="blog-content">
                        <div class="blog-meta">
                            <span><i class="far fa-calendar-alt" aria-hidden="true"></i>15 May 2023</span>
                            <span><i class="far fa-eye" aria-hidden="true"></i>1.2K</span>
                        </div>
                        <h3 class="blog-title">BSK marks Poetry Day</h3>
                        <p class="blog-excerpt">Poetry is a painting that can be heard" – were the words of Leonardo da Vinci with which he started the "Poetry Hour" at BSK. Marked in the framework of the Poetry Day, this event gathered students, professors, poets and families of poets who have already died.</p>
                        <a href="https://britishschoolkosova.com/ne-bsk-shenohet-dita-e-poezise/" class="read-more" aria-label="Read more: BSK marks Poetry Day">Read more <i class="fas fa-arrow-right" aria-hidden="true"></i></a>
                    </div>
                </article>

                <article class="blog-card">
                    <div class="blog-img">
                        <img src="https://britishschoolkosova.com/wp-content/uploads/2023/02/5-2-1-scaled.jpg" alt="" loading="lazy">
                    </div>
                    <div class="blog-content">
                        <div class="blog-meta">
                            <span><i class="far fa-calendar-alt" aria-hidden="true"></i>24 March 2023</span>
                            <span><i class="far fa-eye" aria-hidden="true"></i>890</span>
                        </div>
                        <h3 class="blog-title">Works on interior and exterior design.</h3>
                        <p class="blog-excerpt">Today, the students of the 8th grade of The British School of Kosova, worked on interior and exterior design works. They learned how to make measurements, design with lines, and developed their imagination in an architectural project.</p>
                        <a href="https://britishschoolkosova.com/punime-rreth-dizajnit-te-interierit-dhe-eksterierit/" class="read-more" aria-label="Read more: Works on interior and exterior design">Read more <i class="fas fa-arrow-right" aria-hidden="true"></i></a>
                    </div>
                </article>

                <article class="blog-card">
                    <div class="blog-img">
                        <img src="https://britishschoolkosova.com/wp-content/uploads/2023/02/Matematika-0.jpg" alt="" loading="lazy">
                    </div>
                    <div class="blog-content">
                        <div class="blog-meta">
                            <span><i class="far fa-calendar-alt" aria-hidden="true"></i>20 June 2023</span>
                            <span><i class="far fa-eye" aria-hidden="true"></i>1.5K</span>
                        </div>
                        <h3 class="blog-title">Activity within the subject of Mathematics</h3>
                        <p class="blog-excerpt">Within the subject of Mathematics, the activity "Geometric representation of irrational numbers" was carried out with the students of the tenth international class. An irrational number is a number that cannot be expressed as the ratio of two integers. If it is written as a decimal number, then it is with infinite digits after the decimal point which are repeated without any definite rule.</p>
                        <a href="https://britishschoolkosova.com/aktivitet-ne-kuader-te-lendes-se-matematikes/" class="read-more" aria-label="Read more: Activity within the subject of Mathematics">Read more <i class="fas fa-arrow-right" aria-hidden="true"></i></a>
                    </div>
                </article>
            </div>
        </div>
    </section>

    <!-- Newsletter Section -->
    <section class="page-section section-tint">
        <div class="container">
            <div class="newsletter-inner">
                <h2>Subscribe to our Newsletter</h2>
                <p>Sign up to receive the latest notifications about our offers and innovations</p>

                <form class="newsletter-form">
                    <input type="email" class="newsletter-input" placeholder="Enter your email" aria-label="Email" required>
                    <button type="submit" class="btn btn-primary">Subscribe</button>
                </form>
            </div>
        </div>
    </section>

<?php include("book_journey.php");?>
<?php include("footer.php");?>
