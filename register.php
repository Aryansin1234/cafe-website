<?php
require_once 'config/database.php';
session_start();

$error = '';
$success = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $name = filter_input(INPUT_POST, 'name', FILTER_SANITIZE_STRING);
    $email = filter_input(INPUT_POST, 'email', FILTER_SANITIZE_EMAIL);
    $password = $_POST['password'];
    $confirm_password = $_POST['confirm_password'];

    if (!empty($name) && !empty($email) && !empty($password) && !empty($confirm_password)) {
        if ($password === $confirm_password) {
            // Check if email already exists
            $stmt = $conn->prepare("SELECT id FROM users WHERE email = ?");
            $stmt->execute([$email]);
            if ($stmt->fetch()) {
                $error = 'Email already registered';
            } else {
                // Create new user
                $hashed_password = password_hash($password, PASSWORD_DEFAULT);
                $stmt = $conn->prepare("INSERT INTO users (name, email, password) VALUES (?, ?, ?)");
                
                if ($stmt->execute([$name, $email, $hashed_password])) {
                    $success = 'Registration successful! You can now login.';
                } else {
                    $error = 'Registration failed. Please try again.';
                }
            }
        } else {
            $error = 'Passwords do not match';
        }
    } else {
        $error = 'Please fill in all fields';
    }
}
?>

<?php require_once 'partials/header.php'; ?>

<div class="min-h-screen flex items-center justify-center bg-cafe-cream py-12 px-4 sm:px-6 lg:px-8">
    <div class="max-w-md w-full bg-white rounded-lg shadow-lg p-8">
        <div class="text-center">
            <h2 class="text-3xl font-bold text-cafe-brown mb-6">Create Account</h2>
            <p class="text-gray-600 mb-8">Join our coffee-loving community</p>
        </div>

        <?php if ($error): ?>
            <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded mb-4">
                <?php echo htmlspecialchars($error); ?>
            </div>
        <?php endif; ?>

        <?php if ($success): ?>
            <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded mb-4">
                <?php echo htmlspecialchars($success); ?>
                <p class="mt-2">
                    <a href="login.php" class="font-medium text-green-700 hover:text-green-900">
                        Click here to login →
                    </a>
                </p>
            </div>
        <?php endif; ?>

        <form class="space-y-6" method="POST" action="">
            <div>
                <label for="name" class="block text-sm font-medium text-gray-700">Full Name</label>
                <input id="name" name="name" type="text" required 
                    class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-cafe-brown focus:border-cafe-brown">
            </div>

            <div>
                <label for="email" class="block text-sm font-medium text-gray-700">Email address</label>
                <input id="email" name="email" type="email" required 
                    class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-cafe-brown focus:border-cafe-brown">
            </div>

            <div>
                <label for="password" class="block text-sm font-medium text-gray-700">Password</label>
                <input id="password" name="password" type="password" required 
                    class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-cafe-brown focus:border-cafe-brown">
            </div>

            <div>
                <label for="confirm_password" class="block text-sm font-medium text-gray-700">Confirm Password</label>
                <input id="confirm_password" name="confirm_password" type="password" required 
                    class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-cafe-brown focus:border-cafe-brown">
            </div>

            <div>
                <button type="submit" 
                    class="w-full flex justify-center py-2 px-4 border border-transparent rounded-md shadow-sm text-sm font-medium text-white bg-cafe-brown hover:bg-cafe-accent focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-cafe-brown">
                    Create Account
                </button>
            </div>
        </form>

        <div class="mt-6 text-center">
            <p class="text-sm text-gray-600">
                Already have an account? 
                <a href="login.php" class="font-medium text-cafe-brown hover:text-cafe-accent">
                    Sign in
                </a>
            </p>
        </div>
    </div>
</div>

<?php require_once 'partials/footer.php'; ?> 