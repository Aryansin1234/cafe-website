<?php
require_once 'config/database.php';
session_start();

$error = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $email = filter_input(INPUT_POST, 'email', FILTER_SANITIZE_EMAIL);
    $password = $_POST['password'];

    if (!empty($email) && !empty($password)) {
        $stmt = $conn->prepare("SELECT id, name, password FROM users WHERE email = ?");
        $stmt->execute([$email]);
        $user = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($user && password_verify($password, $user['password'])) {
            $_SESSION['user_id'] = $user['id'];
            $_SESSION['user_name'] = $user['name'];
            header('Location: index.php');
            exit;
        } else {
            $error = 'Invalid email or password';
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
            <h2 class="text-3xl font-bold text-cafe-brown mb-6">Welcome Back</h2>
            <p class="text-gray-600 mb-8">Sign in to your account</p>
        </div>

        <?php if ($error): ?>
            <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded mb-4">
                <?php echo htmlspecialchars($error); ?>
            </div>
        <?php endif; ?>

        <form class="space-y-6" method="POST" action="">
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
                <button type="submit" 
                    class="w-full flex justify-center py-2 px-4 border border-transparent rounded-md shadow-sm text-sm font-medium text-white bg-cafe-brown hover:bg-cafe-accent focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-cafe-brown">
                    Sign in
                </button>
            </div>
        </form>

        <div class="mt-6 text-center">
            <p class="text-sm text-gray-600">
                Don't have an account? 
                <a href="register.php" class="font-medium text-cafe-brown hover:text-cafe-accent">
                    Sign up
                </a>
            </p>
        </div>
    </div>
</div>

<?php require_once 'partials/footer.php'; ?> 