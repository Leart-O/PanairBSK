

<?php
session_start();
include("config.php"); 

// Fetch the 4 newest books
$result = $db->query("SELECT id, title, author, foto, total_books, available_books FROM librat ORDER BY id DESC LIMIT 4");
?>
<?php include("headerA.php");?>


    <!-- Hero Section -->
    <section class="hero">
        <div class="container">
            <h1 class="animate fadeIn">The British School of Kosova</h1>
            <p class="animate fadeIn delay-1">Discover our rich collection of educational books for all grades and levels</p>
            <div class="hero-btns animate fadeIn delay-2">

            </div>
        </div>
    </section>

    <!-- Search Section -->
    <section class="search-section">
        <div class="container">
            <div class="search-container">
                <input type="text" class="search-input" placeholder="Search for books, authors, or ISBNs...">
                <button class="search-btn"><i class="fas fa-search"></i>Search</button>
            </div>
            <div class="search-filters">
                <span class="filter-tag active">Home</span>
               

                <a href="books.php?category=Klasa+1-5" class="filter-tag">Grades 1-5</a>

                <a href="books.php?category=Klasa+6-9" class="filter-tag">Grades 6-9</a>

                <a href="books.php?category=Klasa+10-12" class="filter-tag">Grades 10-12</a>

                <a href="books.php" class="filter-tag">Others</a>
               
            </div>
        </div>
    </section>

    <!-- Features Section -->
    <section class="features">
        <div class="container">
            <div class="section-title">
                <h2>Why choose us?</h2>
                <p>We provide quality services for your educational needs</p>
            </div>

        
                <div class="feature-card animate slideInUp delay-3">
                    <div class="feature-icon">
                        <i class="fas fa-book"></i>
                    </div>
                    <h3>The library of The British School of Kosovo has a variety of books.</h3>
                    <p>Multiple choices from different categories enable students to access limitless knowledge.</p>
                </div>
            </div>
        </div>
    </section>

    <!-- New Books Section -->
    <section class="books-section bg-light">
        <div class="container">
            <div class="section-header">
                <div class="section-title">
                    <h2>Books</h2>
                    <p>Discover our book collection</p>
                </div>
                <a href="books.php" class="view-all">View all<i class="fas fa-arrow-right"></i></a>
            </div>

            <div class="books-grid">
                <?php while ($row = $result->fetch_assoc()): ?>
                    <div class="book-card">
                        <div class="book-img">
                            <img src="view.php?id=<?php echo $row['id']; ?>" alt="Book Image">
                        </div>
                        <div class="book-info">
                            <h3 class="book-title"><?php echo htmlspecialchars($row['title']); ?></h3>
                            <p class="book-author"><?php echo htmlspecialchars($row['author']); ?></p>
                            <p class="book-status">
                                <strong>Kopje gjithsej:</strong> <?php echo $row['total_books']; ?><br>
                                <strong>Kopje në dispozicion:</strong> <?php echo $row['available_books']; ?>
                            </p>
                            <a href="details.php?id=<?php echo $row['id']; ?>" class="btn btn-primary">View Details</a>
                        </div>
                    </div>
                <?php endwhile; ?>
            </div>
        </div>
    </section>

    <!-- Categories Section -->
    <section class="categories">
        <div class="container">
            <div class="section-title">
            <h2>Our Categories</h2>
            <p>Choose according to your preferred classes and subjects</p>
            </div>

            <div class="categories-grid">
                <a href="books.php?category=Klasa+1-5" class="category-card">
                    <div class="category-icon">
                        <i class="fas fa-child"></i>
                    </div>
                    <h3>Grades 1-5</h3>
                    <p class="category-count">15+ Books</p>
                </a>

                <a href="books.php?category=Klasa+6-9" class="category-card">
                    <div class="category-icon">
                        <i class="fas fa-user-graduate"></i>
                    </div>
                    <h3>Grades 6-9</h3>
                    <p class="category-count">12+ Books</p>
                </a>

                <a href="books.php?category=Klasa+10-12" class="category-card">
                    <div class="category-icon">
                        <i class="fas fa-graduation-cap"></i>
                    </div>
                    <h3>Grades 10-12</h3>
                    <p class="category-count">8+ Books</p>
                </a>

                <a href="books.php?category=Fantazi" class="category-card">
                    <div class="category-icon">
                        <i class="fas fa-atom"></i>
                    </div>
                    <h3>Thriller</h3>
                    <p class="category-count">9+ Books</p>
                </a>

                <a href="books.php?category=Dramë" class="category-card">
                    <div class="category-icon">
                        <i class="fas fa-landmark"></i>
                    </div>
                    <h3>Romance</h3>
                    <p class="category-count">8+ Books</p>
                </a>

                <a href="books.php?category=Aventurë" class="category-card">
                    <div class="category-icon">
                        <i class="fas fa-book-reader"></i>
                    </div>
                    <h3>Poetry</h3>
                    <p class="category-count">9++ Books</p>
                </a>
            </div>
        </div>
    </section>

    <!-- Testimonials Section -->
    <section class="testimonials">
        <div class="container">
            <div class="section-title">
                
                <p>Opinions from students</p>
            </div>

            <div class="testimonials-grid">
                <div class="testimonial-card">
                    <div class="testimonial-text">
                        <br>
                        <p>The library platform helps us broaden our horizons and find resources that we can't easily find elsewhere.</p>
                    </div>
                    <div class="testimonial-author">
                        <div class="author-info">
                            <h4>Loris Geci</h4>
                            <p>Student, Grade 10</p>
                        </div>
                    </div>
                </div>

                <div class="testimonial-card">
                    <div class="testimonial-text">
                        <br>
                        <p>Thanks to the digital library, lessons become more interesting and we can access books and materials that make learning easier.</p>
                    </div>
                    <div class="testimonial-author">
                        <div class="author-info">
                            <h4>Mendim Shoshi</h4>
                            <p>Student, Grade 10</p>
                        </div>
                    </div>
                </div>

                <div class="testimonial-card">
                    <div class="testimonial-text">
                        <br>
                        <p>The library is a great opportunity to explore knowledge and develop our skills, always having the right resources on hand.</p>
                    </div>
                    <div class="testimonial-author">
                        <div class="author-info">
                            <h4>Arita Maxhuni</h4>
                            <p>Student, Grade 10</p>
                        </div>
                    </div>
                </div>
                <div class="testimonial-card">
                    <div class="testimonial-text">
                        <br>
                        <p>With the library platform, every learner has the opportunity to learn independently and deepen their knowledge in any subject.</p>
                    </div>
                    <div class="testimonial-author">
                        <div class="author-info">
                            <h4>Leart Obertinca</h4>
                            <p>Student, Grade 10</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    

    <!-- Stats Section -->


    <!-- Blog Section -->
    <section class="blog">
        <div class="container">
            <div class="section-title">
                <h2>News & Articles</h2>
                <p>Read our latest articles about education and books</p>
            </div>
            <a href="https://britishschoolkosova.com/lajmet/" class="view-all" style="margin-left: 1180px">View More<i class="fas fa-arrow-right"></i></a>
            <div class="blog-grid">
                <div class="blog-card">
                    <div class="blog-img">
                        <img src="https://britishschoolkosova.com/wp-content/uploads/2023/03/9.jpg" alt="Blog post">
                    </div>
                    <div class="blog-content">
                        <div class="blog-meta">
                            <span><i class="far fa-calendar-alt"></i>15 May 2023 </span>
                            <span><i class="far fa-eye"></i> 1.2K</span>
                        </div>
                        <h3 class="blog-title">BSK marks Poetry Day</h3>
                        <p class="blog-excerpt">Poetry is a painting that can be heard" – were the words of Leonardo da Vinci with which he started the "Poetry Hour" at BSK. Marked in the framework of the Poetry Day, this event gathered students, professors, poets and families of poets who have already died.</p>
                        <a href="https://britishschoolkosova.com/ne-bsk-shenohet-dita-e-poezise/" class="read-more">Read more<i class="fas fa-arrow-right"></i></a>
                    </div>
                </div>

                <div class="blog-card">
                    <div class="blog-img">
                        <img src="https://britishschoolkosova.com/wp-content/uploads/2023/02/5-2-1-scaled.jpg" alt="Blog post">
                    </div>
                    <div class="blog-content">
                        <div class="blog-meta">
                            <span><i class="far fa-calendar-alt"></i>24 March 2023</span>
                            <span><i class="far fa-eye"></i> 890</span>
                        </div>
                        <h3 class="blog-title">Works on interior and exterior design.</h3>
                        <p class="blog-excerpt">Today, the students of the 8th grade of The British School of Kosovo, worked on interior and exterior design works. They learned how to make measurements, design with lines, and developed their imagination in an architectural project.</p>
                        <a href="https://britishschoolkosova.com/punime-rreth-dizajnit-te-interierit-dhe-eksterierit/" class="read-more">Read more<i class="fas fa-arrow-right"></i></a>
                    </div>
                </div>

                <div class="blog-card">
                    <div class="blog-img">
                        <img src="https://britishschoolkosova.com/wp-content/uploads/2023/02/Matematika-0.jpg" alt="Blog post">
                    </div>
                    <div class="blog-content">
                        <div class="blog-meta">
                            <span><i class="far fa-calendar-alt"></i> 20 June 2023</span>
                            <span><i class="far fa-eye"></i> 1.5K</span>
                        </div>
                        <h3 class="blog-title">Activity within the subject of Mathematics</h3>
                        <p class="blog-excerpt">Within the subject of Mathematics, the activity "Geometric representation of irrational numbers" was carried out with the students of the tenth international class. An irrational number is a number that cannot be expressed as the ratio of two integers. If it is written as a decimal number, then it is with infinite digits after the decimal point which are repeated without any definite rule.</p>
                        <a href="https://britishschoolkosova.com/aktivitet-ne-kuader-te-lendes-se-matematikes/" class="read-more">Read more<i class="fas fa-arrow-right"></i></a>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Newsletter Section -->
    <section class="newsletter">
        <div class="container">
            <h2>Subscribe to our Newsletter</h2>
            <p>Sign up to receive the latest notifications about our offers and innovations</p>

            <form class="newsletter-form">
                <input type="email" class="newsletter-input" placeholder="Enter your email" required>
                <button type="submit" class="newsletter-btn">Subscribe</button>
            </form>
        </div>
    </section>

    <!-- Footer -->
    <footer>
        <div class="container">
            <div class="footer-grid">
                <div class="footer-col">
                    <div id="kontakt"></div>
                    <h3>About Us</h3>
                    <p>The Online School Library is the leading platform for borrowing educational books within the school.</p>
                    <div class="social-links">
                        <a href="https://britishschoolkosova.com/"><i class="fa fa-globe"></i></a>
                        <a href="https://www.facebook.com/BritishSchoolKosova/"><i class="fab fa-facebook-f"></i></a>
                        <a href="https://www.instagram.com/thebritishschoolofkosova/?hl=en"><i class="fab fa-instagram"></i></a>
                        <a href="https://www.linkedin.com/in/bsk-the-british-school-of-kosova-a2b5051a5"><i class="fab fa-linkedin-in"></i></a>
                    </div>
                </div>


                <div class="footer-col">
                <iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d2935.012643531661!2d21.10708847661339!3d42.639891917375856!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x13549e09a30ff837%3A0xd43d44deb9fe3567!2sThe%20British%20School%20of%20Kosova!5e0!3m2!1sen!2s!4v1744883171335!5m2!1sen!2s" width="400" height="300" style="border:0;" allowfullscreen="" loading="lazy" referrerpolicy="no-referrer-when-downgrade"></iframe>
                </div>

                <div class="footer-col">
                    <h3>Contact</h3>
                    <ul class="footer-contact">
                        <li>
                            <i class="fas fa-map-marker-alt"></i>
                            <span>Rr Aleks Çaçi, Fushë Kosovë</span>
                        </li>
                        <li>
                            <i class="fas fa-phone-alt"></i>
                            <span> +383 48 999 172 / 173</span>
                        </li>
                        <li>
                            <i class="fas fa-envelope"></i>
                            <span>info@britishschoolkosova.com</span>
                        </li>
                        <li>
                            <i class="fas fa-clock"></i>
                            <span>Monday - Friday: 08:00 - 16:00</span>
                        </li>
                    </ul>
                </div>
            </div>
        </div>

        <div class="footer-bottom">
            <div class="container">
                <p>&copy; 2023 Online School Library. All rights reserved.</p>
            </div>
        </div>

    </footer>
</div>
 <script src="main.js"></script>
   
 <?php include("footer.php");?>

 