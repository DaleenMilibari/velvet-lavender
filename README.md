# Velvet Lavender 🌸🍰

An eCommerce website for **flowers, cakes, and chocolates**, designed with a lavender-inspired theme.  
Built using **PHP**, **MySQL**, **HTML/CSS**, **JavaScript**, **jQuery**, and **Bootstrap**.

---

## ✨ Features

- **Product Categories**:
  - Flower Bouquets (`BQTxx`)
  - Flower Vases (`VASExx`)
  - Cakes (`CAKExx`)
  - Chocolate Boxes (`CHOCxx`)
- Parent categories: **Flowers** and **Cakes & Chocolates**
- **Shopping Cart**:
  - Session-based cart management
  - Add, remove, update items
  - Checkout process
- **Past Purchases**:
  - Stored via persistent cookies
  - Allows customers to view previous orders even after closing the browser
- **Admin Panel**:
  - Add, update, and delete products
  - JavaScript-based client-side form validation
  - Secure admin authentication
- **Responsive Design**:
  - Mobile-first, works on all devices
  - Powered by **Bootstrap**
- **User Interface**:
  - Lavender & purple theme (`#a885b7`, `#5a4c80`, `#8b6f9a`)
  - Smooth interactions with jQuery and JavaScript enhancements
- Related products & category filtering

---

## 📂 Project Structure

```

velvet-lavender/
│── index.php                 # Home page
│── cart.php                  # Cart view
│── cart-action.php           # Handles cart actions
│── checkout.php              # Checkout process
│── past-purchases.php        # Persistent cart history
│── single-product.php        # Product details
│── cakes.php                 # Cakes category page
│── flowers.php               # Flowers category page
│── chocolate-boxes.php       # Chocolates category page
│── flower-bouquets.php       # Bouquets category page
│── flower-vases.php          # Vases category page
│── cakes-chocolates.php      # Cakes & Chocolates combined page
│── order-success.php         # Post-checkout confirmation
│── mail.php                  # Handles contact/order emails
│── faq.php / contact.php / help-documentation  # Informational pages
│
├── admin/                    # Admin panel
│   ├── manage.php            # Product management dashboard
│   ├── manage-add.php        # Add product form
│   ├── manage-add-handler.php# Handles product add
│   ├── manage-update.php     # Update product form
│   ├── manage-delete.php     # Delete products
│   ├── admin-login.php       # Admin login page
│   └── admin-logout.php      # Admin logout
│
├── includes/                 # Shared layout components
│   ├── header.php
│   ├── footer.php
│   ├── admin-header.php
│   └── auth-check.php        # Access control for admin
│
├── assets/                   # Static assets
│   ├── css/                  # Custom & vendor styles
│   ├── js/                   # Scripts (validation, UI)
│   ├── bootstrap/            # Bootstrap framework (CSS + JS)
│   ├── images/               # Icons, backgrounds, product images
│   └── webfonts/             # FontAwesome and custom fonts
│
├── config.sample.php          # Example configuration
├── config.php                 # Real config (ignored in Git)
├── .gitignore                 # Ignore sensitive/system files
└── README.md                  # Project documentation

````

---

## ⚙️ Setup Instructions

### 1. Clone the Repository
```bash
git clone https://github.com/YOUR-USERNAME/velvet-lavender.git
cd velvet-lavender
````

### 2. Configure the Application

* Copy `config.sample.php` → `config.php`
* Update database credentials in `config.php`:

```php
define('DB_USER', 'your_username');
define('DB_PASS', 'your_password');
```

### 3. Setup Database

* Export your local database and import it into MySQL
* Make sure the database name matches `DB_NAME` in `config.php`

### 4. Run the Project

Start a PHP built-in server:

```bash
php -S localhost:8080
```

Visit: [http://localhost:8080/velvet\_lavender/](http://localhost:8080/velvet_lavender/)

---

## 🛠️ Tech Stack

* **Frontend:** HTML, CSS, Bootstrap, JavaScript, jQuery
* **Backend:** PHP (PDO, session-based cart & admin logic)
* **Database:** MySQL
* **Version Control:** Git + GitHub

---

## 🔒 Security Notes

* `config.php` (real DB credentials) is excluded via `.gitignore`
* `config.sample.php` is provided as a template
* Inputs are sanitized using **PDO prepared statements**
* Admin panel protected with login and session checks

---

## 📌 Future Improvements

* User accounts with login/register
* Order history linked to user accounts
* Online payment gateway integration
* Deployment on cloud hosting (Heroku, Vercel, cPanel)
* Enhanced JavaScript interactions & animations

---

## 👩‍💻 Author

Developed by **Daleen Milibari**
For educational and portfolio purposes 🌸
