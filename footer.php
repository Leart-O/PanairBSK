<?php
// Shared footer and scripts. $en comes from header.php.
// Pages with scroll reveals set $useScrollMotion = true before including this file.
// Pages with animated SVG paths also set $useMotionPath = true.
$gsapPath = 'gsap-public/gsap-public/minified/';
?>
</main>

<footer class="site-footer">
    <div class="container">
        <div class="footer-grid">
            <div class="footer-col" id="kontakt">
                <h2 class="footer-heading"><?php echo $en ? 'About Us' : 'Rreth nesh'; ?></h2>
                <p><?php echo $en
                    ? 'The Online School Library is the leading platform for borrowing educational books within the school.'
                    : 'Biblioteka Shkollore Online është platforma kryesore për huazimin e librave arsimorë brenda shkollës.'; ?></p>
                <div class="social-links">
                    <a href="https://britishschoolkosova.com/" aria-label="<?php echo $en ? 'School website' : 'Faqja e shkollës'; ?>"><i class="fa fa-globe" aria-hidden="true"></i></a>
                    <a href="https://www.facebook.com/BritishSchoolKosova/" aria-label="Facebook"><i class="fab fa-facebook-f" aria-hidden="true"></i></a>
                    <a href="https://www.instagram.com/thebritishschoolofkosova/?hl=en" aria-label="Instagram"><i class="fab fa-instagram" aria-hidden="true"></i></a>
                    <a href="https://www.linkedin.com/in/bsk-the-british-school-of-kosova-a2b5051a5" aria-label="LinkedIn"><i class="fab fa-linkedin-in" aria-hidden="true"></i></a>
                </div>
            </div>

            <div class="footer-col">
                <iframe class="footer-map" title="<?php echo $en ? 'Map to The British School of Kosova' : 'Harta e The British School of Kosova'; ?>" src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d2935.012643531661!2d21.10708847661339!3d42.639891917375856!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x13549e09a30ff837%3A0xd43d44deb9fe3567!2sThe%20British%20School%20of%20Kosova!5e0!3m2!1sen!2s!4v1744883171335!5m2!1sen!2s" allowfullscreen="" loading="lazy" referrerpolicy="no-referrer-when-downgrade"></iframe>
            </div>

            <div class="footer-col">
                <h2 class="footer-heading"><?php echo $en ? 'Contact' : 'Kontakt'; ?></h2>
                <ul class="footer-contact">
                    <li><i class="fas fa-map-marker-alt" aria-hidden="true"></i><span>Rr Aleks Çaçi, Fushë Kosovë</span></li>
                    <li><i class="fas fa-phone-alt" aria-hidden="true"></i><span>+383 48 999 172 / 173</span></li>
                    <li><i class="fas fa-envelope" aria-hidden="true"></i><span>info@britishschoolkosova.com</span></li>
                    <li><i class="fas fa-clock" aria-hidden="true"></i><span><?php echo $en ? 'Monday - Friday: 08:00 - 16:00' : 'E Hënë - E Premte: 08:00 - 16:00'; ?></span></li>
                </ul>
            </div>
        </div>
    </div>

    <div class="footer-bottom">
        <div class="container">
            <p>&copy; <?php echo date('Y'); ?> <?php echo $en
                ? 'Online School Library. All rights reserved.'
                : 'Biblioteka Shkollore Online. Të gjitha të drejtat e rezervuara.'; ?></p>
        </div>
    </div>
</footer>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.5/dist/js/bootstrap.bundle.min.js" integrity="sha384-k6d4wzSIapyDyv1kpU366/PK5hCdSbCRGRCMv+eplOQJWyd1fbcAu9OCUj5zNLiq" crossorigin="anonymous"></script>
<script src="main.js?v=<?php echo filemtime(__DIR__ . '/main.js'); ?>"></script>
<script src="<?php echo $gsapPath; ?>gsap.min.js"></script>
<?php if (!empty($useScrollMotion)): ?>
<script src="<?php echo $gsapPath; ?>ScrollTrigger.min.js"></script>
<?php endif; ?>
<?php if (!empty($useMotionPath)): ?>
<script src="<?php echo $gsapPath; ?>MotionPathPlugin.min.js"></script>
<?php endif; ?>
<script src="motion.js?v=<?php echo filemtime(__DIR__ . '/motion.js'); ?>"></script>
</body>
</html>
