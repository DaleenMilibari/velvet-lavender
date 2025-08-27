<!-- Responsive Bootstrap4 Shop Template, Created by Imran Hossain from https://imransdesign.com/ -->
<!-- Footer -->
    <div class="footer-area">
        <div class="container">
            <div class="row">
                <div class="col-lg-3 col-md-6">
                    <div class="footer-box about-widget">
                        <h2 class="widget-title">About Us</h2>
                        <p>Premium florist & gift boutique creating memorable moments through floral artistry and sweet indulgences.</p>
                    </div>
                </div>
                <div class="col-lg-3 col-md-6">
                    <div class="footer-box location">
                        <h2 class="widget-title">Our Location</h2>
                        <p>650, CCSIT, 7550 King Faisal St., Dammam 34221, KSA.</p>
                    </div>
                </div>
                <div class="col-lg-3 col-md-6">
                    <div class="footer-box explore">
                        <h2 class="widget-title">Explore</h2>
                        <ul>
                            <li><a href="index.php">Home</a></li>
                            <li><a href="flowers.php">Flowers</a></li>
                            <li><a href="cakes.php">Cakes</a></li>
                            <li><a href="chocolate-boxes.php">Chocolate Boxes</a></li>
                        </ul>
                    </div>
                </div>
                <div class="col-lg-3 col-md-6">
                    <div class="footer-box customer-service">
                        <h2 class="widget-title">Customer Service</h2>
                        <ul>
                            <li><a href="/velvet_lavender/contact.php">Contact Us</a></li>
                            <li><a href="/velvet_lavender/faq.php">FAQs</a></li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Copyright -->
    <div class="copyright">
        <div class="container">
            <div class="row">
                <div class="col-lg-6 col-md-12">
                    <p>Copyrights &copy; <?= date('Y') ?> Velvet Lavender. All rights reserved.</p>
                </div>
                <div class="col-lg-6 text-right col-md-12">
                    <div class="social-icons">
                        <ul>
                            <li><a href="#" target="_blank" aria-label="Facebook"><i class="fab fa-facebook-f"></i></a></li>
                            <li><a href="#" target="_blank" aria-label="Twitter"><i class="fab fa-twitter"></i></a></li>
                            <li><a href="#" target="_blank" aria-label="Instagram"><i class="fab fa-instagram"></i></a></li>
                            <li><a href="#" target="_blank" aria-label="LinkedIn"><i class="fab fa-linkedin"></i></a></li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Help Modal -->
    <div class="help-button" onclick="toggleHelpModal()">
        <i class="fas fa-question"></i>
    </div>
    <div class="help-modal" id="helpModal">
        <div class="help-modal-content">
            <span class="close-help" onclick="toggleHelpModal()">&times;</span>
            <h3>Need Assistance?</h3>
            <ul class="help-options">
                <li><a href="tel:+966130000000"><i class="fas fa-phone"></i> +966 13 000 0000</a></li>
                <li><a href="/velvet_lavender/faq.php"><i class="fas fa-question-circle"></i> FAQ Section</a></li>
                <li><a href="mailto:help@velvetlavender.com"><i class="fas fa-envelope"></i> Email Support</a></li>
            </ul>
        </div>
    </div>

    <!-- Scripts -->
    <!-- Core Libraries First -->
    <script src="/velvet_lavender/assets/js/jquery-1.11.3.min.js"></script>
    <script src="/velvet_lavender/assets/bootstrap/js/bootstrap.min.js"></script>

    <!-- Plugins (Order Matters for Dependent Libraries) -->
    <script src="/velvet_lavender/assets/js/waypoints.js"></script> <!-- Should come before isotope -->
    <script src="/velvet_lavender/assets/js/jquery.isotope-3.0.6.min.js"></script>
    <script src="/velvet_lavender/assets/js/owl.carousel.min.js"></script>
    <script src="/velvet_lavender/assets/js/jquery.magnific-popup.min.js"></script>
    <script src="/velvet_lavender/assets/js/jquery.meanmenu.min.js"></script>
    <script src="/velvet_lavender/assets/js/jquery.countdown.js"></script>

    <!-- UI Helpers Last -->
    <script src="/velvet_lavender/assets/js/sticker.js"></script>

    <!-- Your Custom Scripts Always Last -->
    <script src="/velvet_lavender/assets/js/main.js?v=1.0"></script>
    </body>

    </html>