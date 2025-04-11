<?php
// DB details
$dbHost = 'localhost';
$dbUsername = 'root';
$dbPassword = '';
$dbName = 'bibloteka';

// Create connection and select DB
$db = new mysqli($dbHost, $dbUsername, $dbPassword, $dbName);

// Check connection
if ($db->connect_error) {
    die("Connection failed: " . $db->connect_error);
}

// Fetch unique books from the database
$result = $db->query("SELECT id, title, author, foto, total_books, available_books FROM librat GROUP BY id");
?>
<?php include("header.php");?>

    <!-- Header -->
    <header>
        <div class="container">
            <div class="header-inner">
                <a href="index.php" class="logo">
                    <img src="https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcRnpRjK0y6ryJlazJhzOrwJO7t6xppvj2pLjikw2xzhupMWG216NvKchLiyn9KCSRcniEw&usqp=CAU" alt="Logo">
                    <span>Biblioteka </span>BSK
                </a>

                <ul class="nav-links" id="navLinks">
                    <li><a href="index.php" class="active">Kryefaqja</a></li>
                    <li><a href="#kontakt">Rreth nesh</a></li>
                    <li><a href="signup.php">Regjistrohu</a></li>
                    <li><a href="login.php">Kyqu</a></li>
                </ul>
            </div>
        </div>
    </header>

    <!-- Hero Section -->
    <section class="hero">
        <div class="container">
            <h1 class="animate fadeIn">The British School of Kosova</h1>
            <p class="animate fadeIn delay-1">Zbuloni koleksionin tonë të pasur të librave arsimorë për të gjitha klasat dhe nivelet</p>
            <div class="hero-btns animate fadeIn delay-2">

            </div>
        </div>
    </section>

    <!-- Search Section -->
    <section class="search-section">
        <div class="container">
            <div class="search-container">
                <input type="text" class="search-input" placeholder="Kërko librat, autorët, ose ISBN...">
                <button class="search-btn"><i class="fas fa-search"></i> Kërko</button>
            </div>
            <div class="search-filters">
                <span class="filter-tag active">Ballina</span>
                <span class="filter-tag">Klasa 1-5</span>
                <span class="filter-tag">Klasa 6-9</span>
                <span class="filter-tag">Klasa 10-12</span>
               
            </div>
        </div>
    </section>

    <!-- Features Section -->
    <section class="features">
        <div class="container">
            <div class="section-title">
                <h2>Pse të na zgjidhni ne?</h2>
                <p>Ofrojmë shërbime cilësore për nevojat tuaja arsimore</p>
            </div>

        
                <div class="feature-card animate slideInUp delay-3">
                    <div class="feature-icon">
                        <i class="fas fa-headset"></i>
                    </div>
                    <h3>Mbështetje per te gjith nxensit Ndreqe...</h3>
                    <p>Ekipi ynë është gjithmonë i gatshëm t'ju ndihmojë.</p>
                </div>
            </div>
        </div>
    </section>

    <!-- New Books Section -->
    <section class="books-section bg-light">
        <div class="container">
            <div class="section-header">
                <div class="section-title">
                    <h2>Librat</h2>
                    <p>Zbuloni koleksionin tonë të librave</p>
                </div>
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
                                <strong>Total Copies:</strong> <?php echo $row['total_books']; ?><br>
                                <strong>Available Copies:</strong> <?php echo $row['available_books']; ?>
                            </p>
                            <a href="details.php?id=<?php echo $row['id']; ?>" class="btn btn-primary">View Details</a>
                        </div>
                    </div>
                <?php endwhile; ?>
            </div>
        </div>
    </section>

    <!-- Offers Section -->
    <section class="books-section">
        <div class="container">
            <div class="section-header">
                <div class="section-title">
                    <h2>Opsionet tjera</h2>
                    <p>...........</p>
                </div>
                <a href="offers.html" class="view-all">Shiko të gjitha <i class="fas fa-arrow-right"></i></a>
            </div>

            <div class="books-grid">
                <div class="book-card">
                    <div class="book-badge">-30%</div>
                    <div class="book-img">
                        <img src="https://images.unsplash.com/photo-1581726707445-75cbe4efc586?ixlib=rb-1.2.1&auto=format&fit=crop&w=800&q=80" alt="Libër në ofertë">
                    </div>
                    <div class="book-info">
                        <h3 class="book-title">Abetare për Fillestarë</h3>
                        <p class="book-author">Autor i Panjohur</p>
                        <div class="book-meta">
                            <span class="book-grade">Klasa 1-4</span>
                            <span class="book-rating"><i class="fas fa-star"></i> 4.9</span>
                        </div>
                        <div class="book-price">
                            <span class="price-original">15€</span>
                            <span class="price-current">10€</span>
                            <button class="add-to-cart"><i class="fas fa-cart-plus"></i> Shto</button>
                        </div>
                    </div>
                </div>

                <div class="book-card">
                    <div class="book-badge">-25%</div>
                    <div class="book-img">
                        <img src="https://images.unsplash.com/photo-1512820790803-83ca734da794?ixlib=rb-1.2.1&auto=format&fit=crop&w=800&q=80" alt="Libër në ofertë">
                    </div>
                    <div class="book-info">
                        <h3 class="book-title">Kimia për Abiturientë</h3>
                        <p class="book-author">Dr. Kimist</p>
                        <div class="book-meta">
                            <span class="book-grade">Klasa 9-12</span>
                            <span class="book-rating"><i class="fas fa-star"></i> 4.8</span>
                        </div>
                        <div class="book-price">
                            <span class="price-original">25€</span>
                            <span class="price-current">18€</span>
                            <button class="add-to-cart"><i class="fas fa-cart-plus"></i> Shto</button>
                        </div>
                    </div>
                </div>

                <div class="book-card">
                    <div class="book-badge">-20%</div>
                    <div class="book-img">
                        <img src="https://images.unsplash.com/photo-1544947950-fa07a98d237f?ixlib=rb-1.2.1&auto=format&fit=crop&w=800&q=80" alt="Libër në ofertë">
                    </div>
                    <div class="book-info">
                        <h3 class="book-title">Gjeografi për Klasën 8</h3>
                        <p class="book-author">Prof. Gjeograf</p>
                        <div class="book-meta">
                            <span class="book-grade">Klasa 5-8</span>
                            <span class="book-rating"><i class="fas fa-star"></i> 4.6</span>
                        </div>
                        <div class="book-price">
                            <span class="price-original">18€</span>
                            <span class="price-current">14€</span>
                            <button class="add-to-cart"><i class="fas fa-cart-plus"></i> Shto</button>
                        </div>
                    </div>
                </div>

                <div class="book-card">
                    <div class="book-badge">-15%</div>
                    <div class="book-img">
                        <img src="https://images.unsplash.com/photo-1589998059171-988d887df646?ixlib=rb-1.2.1&auto=format&fit=crop&w=800&q=80" alt="Libër në ofertë">
                    </div>
                    <div class="book-info">
                        <h3 class="book-title">Biologji për Klasën 9</h3>
                        <p class="book-author">Dr. Biolog</p>
                        <div class="book-meta">
                            <span class="book-grade">Klasa 9-12</span>
                            <span class="book-rating"><i class="fas fa-star"></i> 4.7</span>
                        </div>
                        <div class="book-price">
                            <span class="price-original">20€</span>
                            <span class="price-current">17€</span>
                            <button class="add-to-cart"><i class="fas fa-cart-plus"></i> Shto</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Categories Section -->
    <section class="categories">
        <div class="container">
            <div class="section-title">
                <h2>Kategoritë tona</h2>
                <p>Zgjidhni sipas klasave dhe lëndëve tuaja të preferuara</p>
            </div>

            <div class="categories-grid">
                <a href="grade1-4.html" class="category-card">
                    <div class="category-icon">
                        <i class="fas fa-child"></i>
                    </div>
                    <h3>Klasa 1-5</h3>
                    <p class="category-count">15+ libra</p>
                </a>

                <a href="grade5-8.html" class="category-card">
                    <div class="category-icon">
                        <i class="fas fa-user-graduate"></i>
                    </div>
                    <h3>Klasa 5-9</h3>
                    <p class="category-count">30+ libra</p>
                </a>

                <a href="grade9-12.html" class="category-card">
                    <div class="category-icon">
                        <i class="fas fa-graduation-cap"></i>
                    </div>
                    <h3>Klasa 10-12</h3>
                    <p class="category-count">450+ libra</p>
                </a>

                

                <a href="science.html" class="category-card">
                    <div class="category-icon">
                        <i class="fas fa-atom"></i>
                    </div>
                    <h3>Shkencë</h3>
                    <p class="category-count">180+ libra</p>
                </a>

                <a href="history.html" class="category-card">
                    <div class="category-icon">
                        <i class="fas fa-landmark"></i>
                    </div>
                    <h3>Histori</h3>
                    <p class="category-count">120+ libra</p>
                </a>

                <a href="literature.html" class="category-card">
                    <div class="category-icon">
                        <i class="fas fa-book-reader"></i>
                    </div>
                    <h3>Letërsi</h3>
                    <p class="category-count">250+ libra</p>
                </a>
            </div>
        </div>
    </section>

    <!-- Testimonials Section -->
    <section class="testimonials">
        <div class="container">
            <div class="section-title">
                <h2>Çfarë thonë klientët tanë</h2>
                <p>Opinione të vërteta nga nxënësit dhe prindërit</p>
            </div>

            <div class="testimonials-grid">
                <div class="testimonial-card">
                    <div class="testimonial-text">
                        <p>Biblioteka më e mirë online për libra shkollorë! Kam gjetur gjithçka që më duhej për klasën time me çmime shumë të volitshme.</p>
                    </div>
                    <div class="testimonial-author">
                        <div class="author-img">
                            <img src="https://randomuser.me/api/portraits/women/45.jpg" alt="Klient">
                        </div>
                        <div class="author-info">
                            <h4>Loris Geci</h4>
                            <p>Nxënëse, Klasa 8</p>
                        </div>
                    </div>
                </div>

                <div class="testimonial-card">
                    <div class="testimonial-text">
                        <p>Shërbim i shkëlqyeshëm dhe dërgesë shumë e shpejtë. Librat erdhën në kushte të përkryera dhe me pakicë më të lirë se në librari.</p>
                    </div>
                    <div class="testimonial-author">
                        <div class="author-img">
                            <img src="https://randomuser.me/api/portraits/men/32.jpg" alt="Klient">
                        </div>
                        <div class="author-info">
                            <h4>Mendim Shoshi</h4>
                            <p>Prind</p>
                        </div>
                    </div>
                </div>

                <div class="testimonial-card">
                    <div class="testimonial-text">
                        <p>Si mësues, e vlerësoj shumë koleksionin e gjerë të librave arsimorë. Gjithmonë gjej atë që më nevojitet për orët e mia.</p>
                    </div>
                    <div class="testimonial-author">
                        <div class="author-img">
                            <img src="https://randomuser.me/api/portraits/women/68.jpg" alt="Klient">
                        </div>
                        <div class="author-info">
                            <h4>Leart Obertinca</h4>
                            <p>Mësuese</p>
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
                <h2>Lajme dhe Artikuj</h2>
                <p>Lexoni artikujt tanë më të fundit rreth arsimit dhe librave</p>
            </div>

            <div class="blog-grid">
                <div class="blog-card">
                    <div class="blog-img">
                        <img src="https://images.unsplash.com/photo-1589998059171-988d887df646?ixlib=rb-1.2.1&auto=format&fit=crop&w=800&q=80" alt="Blog post">
                    </div>
                    <div class="blog-content">
                        <div class="blog-meta">
                            <span><i class="far fa-calendar-alt"></i> 15 Maj 2023</span>
                            <span><i class="far fa-eye"></i> 1.2K</span>
                        </div>
                        <h3 class="blog-title">Si të zgjedhësh librat e duhur për vitin e ri shkollor</h3>
                        <p class="blog-excerpt">Një udhëzues i thjeshtë për prindërit dhe nxënësit për të zgjedhur librat më të përshtatshëm për nevojat e tyre arsimore...</p>
                        <a href="#" class="read-more">Lexo më shumë <i class="fas fa-arrow-right"></i></a>
                    </div>
                </div>

                <div class="blog-card">
                    <div class="blog-img">
                        <img src="https://images.unsplash.com/photo-1541963463532-d68292c34b19?ixlib=rb-1.2.1&auto=format&fit=crop&w=800&q=80" alt="Blog post">
                    </div>
                    <div class="blog-content">
                        <div class="blog-meta">
                            <span><i class="far fa-calendar-alt"></i> 2 Qershor 2023</span>
                            <span><i class="far fa-eye"></i> 890</span>
                        </div>
                        <h3 class="blog-title">Rëndësia e leximit në zhvillimin e fëmijëve</h3>
                        <p class="blog-excerpt">Studime tregojnë se fëmijët që lexojnë rregullisht kanë përfitime të mëdha në zhvillimin intelektual dhe emocional...</p>
                        <a href="#" class="read-more">Lexo më shumë <i class="fas fa-arrow-right"></i></a>
                    </div>
                </div>

                <div class="blog-card">
                    <div class="blog-img">
                        <img src="https://images.unsplash.com/photo-1531346878377-a5be20888e57?ixlib=rb-1.2.1&auto=format&fit=crop&w=800&q=80" alt="Blog post">
                    </div>
                    <div class="blog-content">
                        <div class="blog-meta">
                            <span><i class="far fa-calendar-alt"></i> 20 Qershor 2023</span>
                            <span><i class="far fa-eye"></i> 1.5K</span>
                        </div>
                        <h3 class="blog-title">Top 10 librat më të kërkuar për Abiturientët</h3>
                        <p class="blog-excerpt">Lista jonë e librave më të kërkuar për studentët e klasës së 12-të që po përgatiten për provimet e maturës...</p>
                        <a href="#" class="read-more">Lexo më shumë <i class="fas fa-arrow-right"></i></a>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Newsletter Section -->
    <section class="newsletter">
        <div class="container">
            <h2>Abonohu në Newsletter-in tonë</h2>
            <p>Regjistrohu për të marrë njoftimet më të fundit për ofertat dhe risitë tona</p>

            <form class="newsletter-form">
                <input type="email" class="newsletter-input" placeholder="Shkruani email-in tuaj" required>
                <button type="submit" class="newsletter-btn">Abonohu</button>
            </form>
        </div>
    </section>

    <!-- Footer -->
    <footer>
        <div class="container">
            <div class="footer-grid">
                <div class="footer-col">
                    <div id="kontakt"></div>
                    <h3>Rreth nesh</h3>
                    <p>Biblioteka Shkollore Online është platforma kryesore për blerjen e librave arsimorë në Kosovë. Misioni ynë është të bëjmë arsimin më të arritshëm për të gjithë.</p>
                    <div class="social-links">
                        <a href="#"><i class="fab fa-facebook-f"></i></a>
                        <a href="#"><i class="fab fa-instagram"></i></a>
                        <a href="#"><i class="fab fa-twitter"></i></a>
                        <a href="#"><i class="fab fa-youtube"></i></a>
                    </div>
                </div>

                <div class="footer-col">
                    <h3>Linqe të shpejta</h3>
                    <ul class="footer-links">
                        <li><a href="index.html">Kryefaqja</a></li>
                        <li><a href="about.html">Rreth nesh</a></li>
                        <li><a href="books.html">Të gjithë librat</a></li>
                        <li><a href="new-books.html">Libra të rinj</a></li>
                        <li><a href="offers.html">Oferta</a></li>
                        <li><a href="contact.html">Kontakt</a></li>
                    </ul>
                </div>

                <div class="footer-col">
                    <h3>Klasat</h3>
                    <ul class="footer-links">
                        <li><a href="grade1-4.html">Klasa 1-4</a></li>
                        <li><a href="grade5-8.html">Klasa 5-8</a></li>
                        <li><a href="grade9-12.html">Klasa 9-12</a></li>
                        <li><a href="mathematics.html">Matematikë</a></li>
                        <li><a href="language.html">Gjuhë Shqipe</a></li>
                        <li><a href="science.html">Shkencë</a></li>
                    </ul>
                </div>

                <div class="footer-col">
                    <h3>Kontakt</h3>
                    <ul class="footer-contact">
                        <li>
                            <i class="fas fa-map-marker-alt"></i>
                            <span>Rruga e Arsimit, Nr. 15, Prishtinë, Kosovë</span>
                        </li>
                        <li>
                            <i class="fas fa-phone-alt"></i>
                            <span>+383 44 123 456</span>
                        </li>
                        <li>
                            <i class="fas fa-envelope"></i>
                            <span>info@bibliotekashkollore.com</span>
                        </li>
                        <li>
                            <i class="fas fa-clock"></i>
                            <span>E Hënë - E Premte: 08:00 - 20:00<br>E Shtunë: 09:00 - 15:00</span>
                        </li>
                    </ul>
                </div>
            </div>
        </div>

        <div class="footer-bottom">
            <div class="container">
                <p>&copy; 2023 Biblioteka Shkollore Online. Të gjitha të drejtat e rezervuara.</p>
            </div>
        </div>
    </footer>
</div>
 <script src="main.js"></script>
   
 <?php include("footer.php");?>