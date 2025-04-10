# Cozy Corner Cafe - Website

A modern, responsive website for Cozy Corner Cafe built with PHP, MySQL, and Tailwind CSS. This website provides a complete solution for cafe management including menu display, online ordering, table reservations, and user account management.

## 🌟 Features

### For Customers
- 📱 Responsive design that works on all devices
- 🍽️ Browse complete menu with categories
- 🛒 Online ordering system with cart functionality
- 📅 Table reservation system
- 👤 User account management
- 💳 Secure checkout process

### For Management
- 👥 User authentication and authorization
- 📊 Order management system
- ✅ Reservation confirmation system
- 🗂️ Menu management capabilities

## 🛠️ Technologies Used

- **Backend:** PHP 7.4+
- **Database:** MySQL 5.7+
- **Frontend:** 
  - HTML5
  - Tailwind CSS
  - JavaScript
  - AOS (Animate On Scroll) library
- **Icons:** Font Awesome
- **Security:** PDO for database operations

## 📁 Project Structure

```
cafe_project/
├── assets/
│   └── images/
│       ├── menu/
│       └── team/
├── config/
│   └── database.php
├── database/
│   ├── schema.sql
│   ├── sample_menu_data.sql
│   └── alter_users_table.sql
├── partials/
│   ├── header.php
│   └── footer.php
├── about.php
├── cart.php
├── checkout.php
├── contact.php
├── index.php
├── login.php
├── menu.php
├── order-confirmation.php
├── profile.php
├── register.php
└── reservations.php
```

## 🚀 Installation

1. **Prerequisites**
   - PHP 7.4 or higher
   - MySQL 5.7 or higher
   - Web server (Apache/Nginx)
   - Composer (for dependency management)

2. **Setup Instructions**

   ```bash
   # Clone the repository
   git clone https://github.com/yourusername/cafe-project.git
   cd cafe-project

   # Import database schema
   mysql -u root -p < database/schema.sql
   mysql -u root -p cafe_db < database/sample_menu_data.sql

   # Configure database connection
   cp config/database.example.php config/database.php
   # Edit database.php with your credentials
   ```

3. **Database Configuration**
   
   Edit `config/database.php` with your database credentials:
   ```php
   define('DB_HOST', 'localhost');
   define('DB_USER', 'your_username');
   define('DB_PASS', 'your_password');
   define('DB_NAME', 'cafe_db');
   ```

## 💻 Usage

### Customer Features

1. **Browsing Menu**
   - View all menu items categorized by type
   - Filter items by category
   - View detailed item descriptions and prices

2. **Ordering Process**
   - Add items to cart
   - Modify quantities in cart
   - Secure checkout process
   - Order confirmation and tracking

3. **Table Reservations**
   - Select date and time
   - Specify number of guests
   - Add special requests
   - View reservation status

4. **User Account**
   - Register/Login functionality
   - View order history
   - Manage profile information
   - Track current orders

### Admin Features

1. **Order Management**
   - View all orders
   - Update order status
   - Process refunds

2. **Reservation Management**
   - Confirm/reject reservations
   - View daily reservation schedule
   - Manage table availability

## 🔒 Security Features

- Password hashing using PHP's password_hash()
- PDO prepared statements for SQL injection prevention
- Input sanitization
- Session-based authentication
- CSRF protection
- XSS prevention

## 🎨 Customization

The website uses Tailwind CSS for styling. Main theme colors can be customized in the Tailwind config:

- Primary color (cafe-brown)
- Accent color (cafe-accent)
- Background colors
- Text colors

## 📱 Responsive Design

The website is fully responsive and optimized for:
- Desktop computers
- Tablets
- Mobile phones

## 🤝 Contributing

1. Fork the repository
2. Create your feature branch (`git checkout -b feature/AmazingFeature`)
3. Commit your changes (`git commit -m 'Add some AmazingFeature'`)
4. Push to the branch (`git push origin feature/AmazingFeature`)
5. Open a Pull Request

## 📄 License

This project is licensed under the MIT License - see the LICENSE file for details.

## 👥 Authors

- Your Name - Initial work

## 🙏 Acknowledgments

- Tailwind CSS team
- Font Awesome
- AOS Library
- All contributors who helped with the project 
