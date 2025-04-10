<?php session_start(); ?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cozy Corner Cafe</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
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
    <nav class="bg-white shadow-lg">
        <div class="max-w-7xl mx-auto px-4">
            <div class="flex justify-between h-16">
                <div class="flex">
                    <div class="flex-shrink-0 flex items-center">
                        <a href="/" class="text-2xl font-bold text-cafe-brown">Cozy Corner</a>
                    </div>
                    <div class="hidden sm:ml-6 sm:flex sm:space-x-8">
                        <a href="index.php" class="text-cafe-brown hover:text-cafe-accent px-3 py-2 rounded-md text-sm font-medium">Home</a>
                        <a href="menu.php" class="text-cafe-brown hover:text-cafe-accent px-3 py-2 rounded-md text-sm font-medium">Menu</a>
                        <a href="reservations.php" class="text-cafe-brown hover:text-cafe-accent px-3 py-2 rounded-md text-sm font-medium">Reservations</a>
                        <a href="contact.php" class="text-cafe-brown hover:text-cafe-accent px-3 py-2 rounded-md text-sm font-medium">Contact</a>
                    </div>
                </div>
                <div class="hidden sm:ml-6 sm:flex sm:items-center sm:space-x-4">
                    <?php if(isset($_SESSION['user_id'])): ?>
                        <a href="cart.php" class="text-cafe-brown hover:text-cafe-accent px-3 py-2 rounded-md text-sm font-medium">Cart</a>
                        <a href="profile.php" class="text-cafe-brown hover:text-cafe-accent px-3 py-2 rounded-md text-sm font-medium">Profile</a>
                        <a href="logout.php" class="bg-cafe-brown text-white hover:bg-cafe-accent px-4 py-2 rounded-md text-sm font-medium">Logout</a>
                    <?php else: ?>
                        <a href="login.php" class="text-cafe-brown hover:text-cafe-accent px-3 py-2 rounded-md text-sm font-medium">Login</a>
                        <a href="register.php" class="bg-cafe-brown text-white hover:bg-cafe-accent px-4 py-2 rounded-md text-sm font-medium">Register</a>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </nav>
    <main class="max-w-7xl mx-auto px-4 py-6"><?php // Main content will go here ?> 