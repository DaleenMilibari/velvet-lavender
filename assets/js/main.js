(function ($) {
    "use strict";

    $(document).ready(function($){
        $(".loader").fadeIn(0);
        setTimeout(function () {
            $(".loader").fadeOut(800);
        }, 3000);

        function initCarousels() {
            $(".testimonial-sliders").owlCarousel({
                items: 1,
                loop: true,
                autoplay: true,
                responsive: {
                    0: { items: 1, nav: false },
                    600: { items: 1, nav: false },
                    1000: { items: 1, nav: false, loop: true }
                }
            });

            $(".homepage-slider").owlCarousel({
                items: 1,
                loop: true,
                autoplay: true,
                nav: true,
                dots: false,
                autoplayTimeout: 5000,
                navText: [
                    '<i class="fas fa-chevron-left"></i>',
                    '<i class="fas fa-chevron-right"></i>'
                ],
                onInitialized: setSliderHeight,
                onResized: setSliderHeight
            });

            $(".logo-carousel-inner").owlCarousel({
                items: 4,
                loop: true,
                autoplay: true,
                margin: 30,
                responsive: {
                    0: { items: 1, nav: false },
                    600: { items: 3, nav: false },
                    1000: { items: 4, nav: false, loop: true }
                }
            });
        }

        function setSliderHeight() {
            const windowHeight = $(window).height();
            $('.homepage-slider .owl-stage-outer, .homepage-slider .owl-item').css('height', windowHeight * 0.8);
        }

        function initIsotope() {
            $('.product-lists').isotope({
                itemSelector: '.col-lg-4',
                percentPosition: true,
                layoutMode: 'fitRows'
            });

            $('.product-filters li').on('click', function () {
                $('.product-filters li').removeClass('active');
                $(this).addClass('active');
                const selector = $(this).attr('data-filter');
                $('.product-lists').isotope({ filter: selector });
            });
        }

        function initCountdown() {
            if($('.time-countdown').length){  
                $('.time-countdown').each(function() {
                    const $this = $(this);
                    const finalDate = $this.data('countdown');
                    $this.countdown(finalDate, function(event) {
                        $this.html(event.strftime(
                            '<div class="counter-column"><div class="inner"><span class="count">%D</span>Days</div></div>' +
                            '<div class="counter-column"><div class="inner"><span class="count">%H</span>Hours</div></div>' +
                            '<div class="counter-column"><div class="inner"><span class="count">%M</span>Mins</div></div>' +
                            '<div class="counter-column"><div class="inner"><span class="count">%S</span>Secs</div></div>'
                        ));
                    });
                });
            }
        }

        function initLightbox() {
            $('.popup-youtube').magnificPopup({
                disableOn: 700,
                type: 'iframe',
                mainClass: 'mfp-fade',
                removalDelay: 160,
                preloader: false,
                fixedContentPos: false
            });

            $('.image-popup-vertical-fit').magnificPopup({
                type: 'image',
                closeOnContentClick: true,
                mainClass: 'mfp-img-mobile',
                image: { verticalFit: true }
            });
        }

        function initComponents() {
            $("#sticker").sticky({ topSpacing: 0 });

            $('.main-menu').meanmenu({
                meanMenuContainer: '.mobile-menu',
                meanScreenWidth: "992"
            });

            $(".search-bar-icon").on("click", function(){
                $(".search-area").addClass("search-active");
            });

            $(".close-btn").on("click", function() {
                $(".search-area").removeClass("search-active");
            });

            $(".homepage-slider")
                .on("translate.owl.carousel", function(){
                    $(".hero-text-tablecell .subtitle, .hero-text-tablecell h1, .hero-btns")
                        .removeClass("animated fadeInUp")
                        .css({'opacity': '0'});
                })
                .on("translated.owl.carousel", function(){
                    $(".hero-text-tablecell .subtitle, .hero-text-tablecell h1, .hero-btns")
                        .addClass("animated fadeInUp")
                        .css({'opacity': '0'});
                });

            const helpModal = $('#helpModal');
            if (helpModal.length) {
                const toggleHelpModal = (e) => {
                    e.preventDefault();
                    helpModal.fadeToggle(200);
                };

                $('.help-button').on('click', toggleHelpModal);
                $('.close-help').on('click', toggleHelpModal);

                $(document).on('click', (e) => {
                    if (!$(e.target).closest(helpModal).length && 
                        !$(e.target).closest('.help-button').length && 
                        helpModal.is(':visible')) {
                        helpModal.fadeOut(200);
                    }
                });

                $(document).on('keyup', (e) => {
                    if (e.key === "Escape" && helpModal.is(':visible')) {
                        helpModal.fadeOut(200);
                    }
                });
            }
        }

        initCarousels();
        initCountdown();
        initLightbox();
        initComponents();

        $(window).on('load', function () {
            initIsotope();
            $(".loader").fadeOut(800);
        });
    });

/* ---------------------------------------------------------------
FORM VALIDATIONS
------------------------------------------------------------------ */
    document.addEventListener("DOMContentLoaded", function () {
        // Admin Login Validation
        const loginForm = document.querySelector("#adminLoginForm");
        if (loginForm) {
            const username = document.getElementById("username");
            const password = document.getElementById("password");
            const showError = (el, msg) => {
                el.classList.add("is-invalid");
                let msgEl = el.nextElementSibling;
                if (!msgEl || !msgEl.classList.contains("error-message")) {
                    msgEl = document.createElement("div");
                    msgEl.className = "error-message text-danger mt-1 small";
                    el.after(msgEl);
                }
                msgEl.textContent = msg;
            };
            loginForm.addEventListener("submit", function (e) {
                let valid = true;
                [username, password].forEach(el => {
                    el.classList.remove("is-invalid");
                    if (el.nextElementSibling?.classList.contains("error-message")) {
                        el.nextElementSibling.textContent = '';
                    }
                });

                if (!username.value.trim()) {
                    showError(username, "Username is required.");
                    valid = false;
                } else if (!/^[a-zA-Z][a-zA-Z0-9]{2,}$/.test(username.value)) {
                    showError(username, "Username must start with a letter and be at least 3 characters.");
                    valid = false;
                }

                if (!password.value.trim()) {
                    showError(password, "Password is required.");
                    valid = false;
                } else if (password.value.length < 3) {
                    showError(password, "Password must be at least 3 characters.");
                    valid = false;
                }

                if (!valid) e.preventDefault();
            });
        }

        // === Add Product Validation ===
        const addForm = document.querySelector("#addProductForm");
        if (addForm) {
            const fields = {
                productName: {
                    el: document.getElementById("productName"),
                    validate: (v) => v.trim() !== "" && /^[a-zA-Z][a-zA-Z0-9 ]{2,}$/.test(v),
                    msgEmpty: "Product name is required.",
                    msgInvalid: "Product name must start with a letter and be at least 3 characters."
                },
                category: {
                    el: document.getElementById("category"),
                    validate: (v) => v.trim() !== "",
                    msgEmpty: "Category is required.",                
                },
                stock: {
                    el: document.getElementById("stock"),
                    validate: (v) => v.trim() !== "" && parseInt(v) > 0,
                    msgEmpty: "Stock quantity is required.",
                    msgInvalid: "Stock must be greater than 0."
                },
                price: {
                    el: document.getElementById("price"),
                    validate: (v) => v.trim() !== "" && parseFloat(v) > 0,
                    msgEmpty: "Price is required.",
                    msgInvalid: "Price must be greater than 0."
                },
                description: {
                    el: document.getElementById("description"),
                    validate: (v) => v.trim() !== "" && v.trim().length >= 10,
                    msgEmpty: "Product description is required.",
                    msgInvalid: "Description must be at least 10 characters."
                },
                image: {
                    el: document.getElementById("productImage"),
                    validate: (el) =>
                        el.files.length > 0 &&
                    ["image/jpeg", "image/png", "image/gif"].includes(el.files[0].type),
                    msgEmpty: "Product image is required.",
                    msgInvalid: "Only JPEG, PNG, and GIF images are allowed."
                }
            };
            
            function showError(el, msg) {
                el.classList.add("is-invalid");
                let errorEl = el.nextElementSibling;
                if (!errorEl || !errorEl.classList.contains("error-message")) {
                    errorEl = document.createElement("div");
                    errorEl.className = "error-message text-danger mt-1 small";
                    el.after(errorEl);
                }
                errorEl.textContent = msg;
            }
            
            function clearError(el) {
                el.classList.remove("is-invalid");
                const err = el.nextElementSibling;
                if (err && err.classList.contains("error-message")) err.textContent = "";
            }
            
            addForm.addEventListener("submit", function (e) {
                let valid = true;
                
                for (const key in fields) {
                    const { el, validate, msgEmpty, msgInvalid } = fields[key];
                    const value = el.type === "file" ? el : el.value;
                    
                    clearError(el);
                    
                    if (el.type === "file" && el.files.length === 0) {
                        showError(el, msgEmpty);
                        valid = false;
                    } else if (el.type !== "file" && value.trim() === "") {
                        showError(el, msgEmpty);
                        valid = false;
                    } else if (!validate(value)) {
                        showError(el, msgInvalid);
                        valid = false;
                    }
                }
                
                if (!valid) e.preventDefault();
            });
        }

        // === Update Product Validation ===
        const updateForm = document.querySelector("#uppdateProductForm");
        if (updateForm) {
            const fields = {
                productName: {
                    el: document.getElementById("productName"),
                    validate: (v) => v.trim() !== "" && /^[a-zA-Z][a-zA-Z0-9 ]{2,}$/.test(v),
                    msgEmpty: "Product name is required.",
                    msgInvalid: "Product name must start with a letter and be at least 3 characters."
                },
                category: {
                    el: document.getElementById("category"),
                    validate: (v) => v.trim() !== "",
                    msgEmpty: "Category is required.",
                },
                stock: {
                    el: document.getElementById("stock"),
                    validate: (v) => v.trim() !== "" && parseInt(v) > 0,
                    msgEmpty: "Stock quantity is required.",
                    msgInvalid: "Stock must be greater than 0."
                },
                price: {
                    el: document.getElementById("price"),
                    validate: (v) => v.trim() !== "" && parseFloat(v) > 0,
                    msgEmpty: "Price is required.",
                    msgInvalid: "Price must be greater than 0."
                },
                description: {
                    el: document.getElementById("description"),
                    validate: (v) => v.trim() !== "" && v.trim().length >= 10,
                    msgEmpty: "Product description is required.",
                    msgInvalid: "Description must be at least 10 characters."
                },
                image: {
                    el: document.getElementById("productImage"),
                    validate: (el) => {
                        if (el.disabled || el.files.length === 0) return true; // optional on update
                        const type = el.files[0].type;
                        return ["image/jpeg", "image/png", "image/gif"].includes(type);
                    },
                    msgInvalid: "Only JPEG, PNG, and GIF images are allowed."
                }
            };

            function showError(el, msg) {
                el.classList.add("is-invalid");
                let err = el.nextElementSibling;
                if (!err || !err.classList.contains("error-message")) {
                    err = document.createElement("div");
                    err.className = "error-message text-danger mt-1 small";
                    el.after(err);
                }
                err.textContent = msg;
            }

            function clearError(el) {
                el.classList.remove("is-invalid");
                const err = el.nextElementSibling;
                if (err && err.classList.contains("error-message")) err.textContent = "";
            }

            updateForm.addEventListener("submit", function (e) {
                let valid = true;
            
                for (const key in fields) {
                    const { el, validate, msgEmpty, msgInvalid } = fields[key];
                    const value = el.type === "file" ? el : el.value;
            
                    clearError(el);
            
                    if (el.disabled || el.readOnly) continue;
            
                    if (el.type !== "file" && value.trim() === "") {
                        showError(el, msgEmpty);
                        valid = false;
                    } else if (!validate(value)) {
                        showError(el, msgInvalid || msgEmpty);
                        valid = false;
                    }
                }
            
                if (!valid) e.preventDefault();
            });            
        }

        // === Quantity Validation for single-product.php ===
        const singleProductForm = document.querySelector('form[action^="single-product.php"]');
        if (singleProductForm) {
            const qtyInput = singleProductForm.querySelector('input[name="quantity"]');
            const maxQty = parseInt(qtyInput.getAttribute("max"));

            singleProductForm.addEventListener("submit", function (e) {
                const qty = parseInt(qtyInput.value.trim());
                const existingError = document.getElementById("qty-error");

                if (existingError) existingError.remove();
                qtyInput.classList.remove("is-invalid");

                if (isNaN(qty) || qty < 1 || qty > maxQty) {
                    e.preventDefault();
                    qtyInput.classList.add("is-invalid");

                    const errorDiv = document.createElement("div");
                    errorDiv.id = "qty-error";
                    errorDiv.className = "error-message text-danger mt-1 small";
                    errorDiv.textContent = `Please enter a quantity between 1 and ${maxQty}.`;

                    qtyInput.after(errorDiv);
                    qtyInput.scrollIntoView({ behavior: "smooth", block: "center" });
                }
            });
        }

        // === Validation for related product "Add to Cart" forms ===
        document.querySelectorAll('.add-to-cart-form').forEach(function (form) {
            form.addEventListener("submit", function (e) {
                const qtyInput = form.querySelector('input[name="quantity"]');
                const qty = parseInt(qtyInput.value.trim());

                if (isNaN(qty) || qty < 1) {
                    e.preventDefault();
                    alert("Please enter a valid quantity (1 or more).");
                }
            });
        });

        // === Validation for cart form ===
        const cartForm = document.getElementById("cartForm");
        if (cartForm) {
            cartForm.addEventListener("submit", function (e) {
                let valid = true;

                // Remove existing error messages
                document.querySelectorAll(".qty-error").forEach(el => el.remove());
                cartForm.querySelectorAll("input[name^='quantities']").forEach(input => {
                    input.classList.remove("is-invalid");
                    const value = parseInt(input.value.trim());
                    const min = parseInt(input.getAttribute("min"));
                    const max = parseInt(input.getAttribute("max"));

                    if (isNaN(value) || value < min || value > max) {
                        valid = false;
                        input.classList.add("is-invalid");

                        const errorDiv = document.createElement("div");
                        errorDiv.className = "qty-error text-danger small mt-1";
                        errorDiv.textContent = `Please enter a value between ${min} and ${max}.`;

                        input.after(errorDiv);
                    }
                });

                if (!valid) {
                    e.preventDefault();
                    // Optionally scroll to first error
                    const firstInvalid = cartForm.querySelector(".is-invalid");
                    if (firstInvalid) firstInvalid.scrollIntoView({ behavior: "smooth", block: "center" });
                }
            });
        }

        // === Validation for checkout form ===
        const form = document.getElementById("checkoutForm");
        if (!form) return;

        const name = form.querySelector('input[name="name"]');
        const email = form.querySelector('input[name="email"]');
        const phone = form.querySelector('input[name="phone"]');
        const address = form.querySelector('textarea[name="address"]');

        function showError(input, message) {
            input.classList.add("is-invalid");

            let err = input.nextElementSibling;
            if (!err || !err.classList.contains("error-message")) {
                err = document.createElement("div");
                err.className = "error-message text-danger mt-1 small";
                input.after(err);
            }
            err.textContent = message;
        }

        function clearError(input) {
            input.classList.remove("is-invalid");
            const err = input.nextElementSibling;
            if (err && err.classList.contains("error-message")) err.remove();
        }

        form.addEventListener("submit", function (e) {
            let valid = true;

            // Clear all previous errors
            [name, email, phone, address].forEach(clearError);

            // Name: required, only letters, two words separated by one space
            const namePattern = /^[A-Za-z]{2,}\s[A-Za-z]{2,}$/;
            if (!name.value.trim()) {
                showError(name, "Name is required.");
                valid = false;
            } else if (!namePattern.test(name.value.trim())) {
                showError(name, "Enter full name with two words (letters only).");
                valid = false;
            }


            // Email: required + valid format
            if (!email.value.trim()) {
                showError(email, "Email is required.");
                valid = false;
            } else if (!/^[^\s@]+@[^\s@]+\.[^\s@]+$/.test(email.value)) {
                showError(email, "Enter a valid email address.");
                valid = false;
            }

            // Phone: required + Saudi format +9665xxxxxxxx
            const saudiPattern = /^\+9665[0-9]{8}$/;
            if (!phone.value.trim()) {
                showError(phone, "Phone number is required.");
                valid = false;
            } else if (!saudiPattern.test(phone.value.trim())) {
                showError(phone, "Enter a valid Saudi number (+9665xxxxxxxx).");
                valid = false;
            }

            // Address: required, min 10 characters
            if (!address.value.trim()) {
                showError(address, "Address is required.");
                valid = false;
            } else if (address.value.trim().length < 10) {
                showError(address, "Address must be at least 10 characters.");
                valid = false;
            }

            if (!valid) {
                e.preventDefault();
                const firstInvalid = form.querySelector(".is-invalid");
                if (firstInvalid) firstInvalid.scrollIntoView({ behavior: "smooth", block: "center" });
            }
        });
    });

}(jQuery));
