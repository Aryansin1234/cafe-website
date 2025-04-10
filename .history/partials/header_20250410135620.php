<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cozy Corner Cafe</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <!-- AOS Library -->
    <link href="https://unpkg.com/aos@2.3.1/dist/aos.css" rel="stylesheet">
    <script src="https://unpkg.com/aos@2.3.1/dist/aos.js"></script>
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    fontFamily: {
                        sans: ['Poppins', 'sans-serif'],
                    },
                    colors: {
                        'cafe-brown': '#6B4423',
                        'cafe-cream': '#FFF8E7',
                        'cafe-accent': '#D4A373',
                    }
                }
            }
        }
    </script>
</head>
<body class="bg-cafe-cream min-h-screen">
    <nav class="bg-white shadow-lg fixed w-full z-50">
        <div class="max-w-7xl mx-auto px-4">
            <div class="flex justify-between h-20">
                <div class="flex items-center">
                    <div class="flex-shrink-0">
                        <a href="/" class="text-2xl font-bold text-cafe-brown flex items-center">
                            <i class="fas fa-coffee mr-2"></i>
                            Cozy Corner
                        </a>
                    </div>
                    <div class="hidden sm:ml-6 sm:flex sm:space-x-8">
                        <a href="index.php" class="text-cafe-brown hover:text-cafe-accent px-3 py-2 rounded-md text-sm font-medium transition duration-300">Home</a>
                        <a href="menu.php" class="text-cafe-brown hover:text-cafe-accent px-3 py-2 rounded-md text-sm font-medium transition duration-300">Menu</a>
                        <a href="reservations.php" class="text-cafe-brown hover:text-cafe-accent px-3 py-2 rounded-md text-sm font-medium transition duration-300">Reservations</a>
                        <a href="about.php" class="text-cafe-brown hover:text-cafe-accent px-3 py-2 rounded-md text-sm font-medium transition duration-300">About</a>
                        <a href="contact.php" class="text-cafe-brown hover:text-cafe-accent px-3 py-2 rounded-md text-sm font-medium transition duration-300">Contact</a>
                    </div>
                </div>
                <div class="hidden sm:ml-6 sm:flex sm:items-center sm:space-x-4">
                    <?php if(isset($_SESSION['user_id'])): ?>
                        <a href="cart.php" class="text-cafe-brown hover:text-cafe-accent px-3 py-2 rounded-md text-sm font-medium transition duration-300 flex items-center">
                            <i class="fas fa-shopping-cart mr-2"></i>
                            Cart
                        </a>
                        <a href="profile.php" class="text-cafe-brown hover:text-cafe-accent px-3 py-2 rounded-md text-sm font-medium transition duration-300 flex items-center">
                            <i class="fas fa-user mr-2"></i>
                            Profile
                        </a>
                        <a href="logout.php" class="bg-cafe-brown text-white hover:bg-cafe-accent px-4 py-2 rounded-md text-sm font-medium transition duration-300 flex items-center">
                            <i class="fas fa-sign-out-alt mr-2"></i>
                            Logout
                        </a>
                    <?php else: ?>
                        <a href="login.php" class="text-cafe-brown hover:text-cafe-accent px-3 py-2 rounded-md text-sm font-medium transition duration-300 flex items-center">
                            <i class="fas fa-sign-in-alt mr-2"></i>
                            Login
                        </a>
                        <a href="register.php" class="bg-cafe-brown text-white hover:bg-cafe-accent px-4 py-2 rounded-md text-sm font-medium transition duration-300 flex items-center">
                            <i class="fas fa-user-plus mr-2"></i>
                            Register
                        </a>
                    <?php endif; ?>
                </div>
                <!-- Mobile menu button -->
                <div class="sm:hidden flex items-center">
                    <button type="button" class="mobile-menu-button inline-flex items-center justify-center p-2 rounded-md text-cafe-brown hover:text-cafe-accent focus:outline-none">
                        <i class="fas fa-bars text-xl"></i>
                    </button>
                </div>
            </div>
        </div>
        <!-- Mobile menu -->
        <div class="sm:hidden mobile-menu hidden">
            <div class="px-2 pt-2 pb-3 space-y-1">
                <a href="index.php" class="text-cafe-brown hover:text-cafe-accent block px-3 py-2 rounded-md text-base font-medium">Home</a>
                <a href="menu.php" class="text-cafe-brown hover:text-cafe-accent block px-3 py-2 rounded-md text-base font-medium">Menu</a>
                <a href="reservations.php" class="text-cafe-brown hover:text-cafe-accent block px-3 py-2 rounded-md text-base font-medium">Reservations</a>
                <a href="about.php" class="text-cafe-brown hover:text-cafe-accent block px-3 py-2 rounded-md text-base font-medium">About</a>
                <a href="contact.php" class="text-cafe-brown hover:text-cafe-accent block px-3 py-2 rounded-md text-base font-medium">Contact</a>
                <?php if(isset($_SESSION['user_id'])): ?>
                    <a href="cart.php" class="text-cafe-brown hover:text-cafe-accent block px-3 py-2 rounded-md text-base font-medium">Cart</a>
                    <a href="profile.php" class="text-cafe-brown hover:text-cafe-accent block px-3 py-2 rounded-md text-base font-medium">Profile</a>
                    <a href="logout.php" class="text-cafe-brown hover:text-cafe-accent block px-3 py-2 rounded-md text-base font-medium">Logout</a>
                <?php else: ?>
                    <a href="login.php" class="text-cafe-brown hover:text-cafe-accent block px-3 py-2 rounded-md text-base font-medium">Login</a>
                    <a href="register.php" class="text-cafe-brown hover:text-cafe-accent block px-3 py-2 rounded-md text-base font-medium">Register</a>
                <?php endif; ?>
            </div>
        </div>
    </nav>

    <!-- Add padding to main content to account for fixed navbar -->
    <div class="pt-20">
        <main class="max-w-7xl mx-auto px-4 py-6">
            <?php // Main content will go here ?>
        </main>
    </div>

    <!-- Mobile menu script -->
    <script>
        const mobileMenuButton = document.querySelector('.mobile-menu-button');
        const mobileMenu = document.querySelector('.mobile-menu');

        mobileMenuButton.addEventListener('click', () => {
            mobileMenu.classList.toggle('hidden');
        });
    </script>
</body>
</html> 