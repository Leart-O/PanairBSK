

<?php
session_start();
include("config.php"); 

// Fetch the 4 newest books
$result = $db->query("SELECT id, title, author, foto, total_books, available_books FROM librat ORDER BY id DESC LIMIT 4");
?>
<?php include("header.php");?>


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
               

                <a href="books.php?category=Klasa+1-5" class="filter-tag">Klasa 1-5</a>

                <a href="books.php?category=Klasa+6-9" class="filter-tag">Klasa 6-9</a>

                <a href="books.php?category=Klasa+10-12" class="filter-tag">Klasa 10-12</a>

                <a href="books.php" class="filter-tag">Të tjerat</a>
               
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
                        <i class="fas fa-book"></i>
                    </div>
                    <h3>Biblioteka e The British School of Kosova ka shumëllojshmëri te librave.</h3>
                    <p>Zgjedhjet e shumëta nga kategori të ndryshme mundësojnë që nxënësit të kenë akses në njohuri të pakufijtë.</p>
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
                <a href="books.php" class="view-all">Shiko të gjitha <i class="fas fa-arrow-right"></i></a>
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
                            <a href="details.php?id=<?php echo $row['id']; ?>" class="btn btn-primary">Shiko Detajet</a>
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
                <h2>Kategoritë tona</h2>
                <p>Zgjidhni sipas klasave dhe lëndëve tuaja të preferuara</p>
            </div>

            <div class="categories-grid">
                <a href="books.php?category=Klasa+1-5" class="category-card">
                    <div class="category-icon">
                        <i class="fas fa-child"></i>
                    </div>
                    <h3>Klasa 1-5</h3>
                    <p class="category-count">15+ libra</p>
                </a>

                <a href="books.php?category=Klasa+6-9" class="category-card">
                    <div class="category-icon">
                        <i class="fas fa-user-graduate"></i>
                    </div>
                    <h3>Klasa 6-9</h3>
                    <p class="category-count">30+ libra</p>
                </a>

                <a href="books.php?category=Klasa+10-12" class="category-card">
                    <div class="category-icon">
                        <i class="fas fa-graduation-cap"></i>
                    </div>
                    <h3>Klasa 10-12</h3>
                    <p class="category-count">450+ libra</p>
                </a>

                <a href="books.php?category=Fantazi" class="category-card">
                    <div class="category-icon">
                        <i class="fas fa-atom"></i>
                    </div>
                    <h3>Thriller</h3>
                    <p class="category-count">180+ libra</p>
                </a>

                <a href="books.php?category=Dramë" class="category-card">
                    <div class="category-icon">
                        <i class="fas fa-landmark"></i>
                    </div>
                    <h3>Romancë</h3>
                    <p class="category-count">120+ libra</p>
                </a>

                <a href="books.php?category=Aventurë" class="category-card">
                    <div class="category-icon">
                        <i class="fas fa-book-reader"></i>
                    </div>
                    <h3>Poezia</h3>
                    <p class="category-count">250+ libra</p>
                </a>
            </div>
        </div>
    </section>

    <!-- Testimonials Section -->
    <section class="testimonials">
        <div class="container">
            <div class="section-title">
                
                <p>Opinione nga nxënësit</p>
            </div>

            <div class="testimonials-grid">
                <div class="testimonial-card">
                    <div class="testimonial-text">
                        <br>
                        <p>Platforma e bibliotekës na ndihmon të zgjerim horizontet tona dhe të gjejmë burime që nuk mund t'i gjejmë lehtësisht diku tjetër.</p>
                    </div>
                    <div class="testimonial-author">
                        <div class="author-info">
                            <h4>Loris Geci</h4>
                            <p>Nxënës, Klasa 10</p>
                        </div>
                    </div>
                </div>

                <div class="testimonial-card">
                    <div class="testimonial-text">
                        <br>
                        <p>Falë bibliotekës digjitale, mësimet bëhen më interesante dhe mund të qasemi në libra dhe materiale që e bëjnë mësimin më të thjeshtë.</p>
                    </div>
                    <div class="testimonial-author">
                        <div class="author-info">
                            <h4>Mendim Shoshi</h4>
                            <p>Nxënës, Klasa 10</p>
                        </div>
                    </div>
                </div>

                <div class="testimonial-card">
                    <div class="testimonial-text">
                        <br>
                        <p>Biblioteka është një mundësi e shkëlqyer për të eksploruar dijen dhe për të zhvilluar aftësitë tona, duke pasur gjithmonë burimet e duhura në duar.</p>
                    </div>
                    <div class="testimonial-author">
                        <div class="author-info">
                            <h4>Arita Maxhuni</h4>
                            <p>Nxënës, Klasa 10</p>
                        </div>
                    </div>
                </div>
                <div class="testimonial-card">
                    <div class="testimonial-text">
                        <br>
                        <p>Me platformën e bibliotekës, çdo nxënës ka mundësinë të mësojë në mënyrë të pavarur dhe të thellojë njohuritë në çdo lëndë.</p>
                    </div>
                    <div class="testimonial-author">
                        <div class="author-info">
                            <h4>Leart Obertinca</h4>
                            <p>Nxënës, Klasa 10</p>
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
            <a href="https://britishschoolkosova.com/lajmet/" class="view-all" style="margin-left: 1180px">Shiko më shumë <i class="fas fa-arrow-right"></i></a>
            <div class="blog-grid">
                <div class="blog-card">
                    <div class="blog-img">
                        <img src="https://britishschoolkosova.com/wp-content/uploads/2023/03/9.jpg" alt="Blog post">
                    </div>
                    <div class="blog-content">
                        <div class="blog-meta">
                            <span><i class="far fa-calendar-alt"></i> 15 Maj 2023</span>
                            <span><i class="far fa-eye"></i> 1.2K</span>
                        </div>
                        <h3 class="blog-title">Në BSK shënohet Dita e Poezisë</h3>
                        <p class="blog-excerpt">Poezia është pikturë që dëgjohet” – ishin fjalët e Leonardo da Vinҁit me të cilën filloi “Ora e Poezisë” në BSK. E shenjuar në kuadër Ditës së Poezisë, kjo ngjarje mblodhi nxënës, profesorë, poetë dhe familje të poetëve tashmë të ndjerë.</p>
                        <a href="https://britishschoolkosova.com/ne-bsk-shenohet-dita-e-poezise/" class="read-more">Lexo më shumë <i class="fas fa-arrow-right"></i></a>
                    </div>
                </div>

                <div class="blog-card">
                    <div class="blog-img">
                        <img src="https://britishschoolkosova.com/wp-content/uploads/2023/02/5-2-1-scaled.jpg" alt="Blog post">
                    </div>
                    <div class="blog-content">
                        <div class="blog-meta">
                            <span><i class="far fa-calendar-alt"></i>24 Mars 2023</span>
                            <span><i class="far fa-eye"></i> 890</span>
                        </div>
                        <h3 class="blog-title">Punime rreth dizajnit të enterierit dhe eksterierit.</h3>
                        <p class="blog-excerpt">Sot, nxënësit e klasave të 8-ta të The British School of Kosova, punuan punime të dizajnit të enterierit dhe eksterierit. Ata mësuan si të bëjnë matjet, dizajnimin me vija dhe zhvilluan imagjinatën e tyre në një projekt arkitektural.</p>
                        <a href="https://britishschoolkosova.com/punime-rreth-dizajnit-te-interierit-dhe-eksterierit/" class="read-more">Lexo më shumë <i class="fas fa-arrow-right"></i></a>
                    </div>
                </div>

                <div class="blog-card">
                    <div class="blog-img">
                        <img src="https://britishschoolkosova.com/wp-content/uploads/2023/02/Matematika-0.jpg" alt="Blog post">
                    </div>
                    <div class="blog-content">
                        <div class="blog-meta">
                            <span><i class="far fa-calendar-alt"></i> 20 Qershor 2023</span>
                            <span><i class="far fa-eye"></i> 1.5K</span>
                        </div>
                        <h3 class="blog-title">Aktivitet në kuadër të lëndës së Matematikës</h3>
                        <p class="blog-excerpt">Në kuadër të lëndës së Matematikës me nxënësit e klasës së dhjetë ndërkombëtare është zhvilluar aktiviteti “Paraqitja gjeometrike e numrave iracionalë’’. Një numër iracional është një numër që nuk mund të shprehet si raport i dy numrave të plotë. Nëse shkruhet si numër decimal, atëherë ai është me pafund shifra pas presjes dhjetore të cilat përsëriten pa ndonjë rregull të caktuar.</p>
                        <a href="https://britishschoolkosova.com/aktivitet-ne-kuader-te-lendes-se-matematikes/" class="read-more">Lexo më shumë <i class="fas fa-arrow-right"></i></a>
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
                    <p>Biblioteka Shkollore Online është platforma kryesore për huazimin e librave arsimorë brenda shkolles.</p>
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
                    <h3>Kontakt</h3>
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
                            <span>E Hënë - E Premte: 08:00 - 16:00</span>
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

 