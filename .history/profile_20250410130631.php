<?php
session_start();
require_once 'config/database.php';

// Check if user is logged in
if (!isset($_SESSION['user_id'])) {
    header('Location: login.php');
    exit();
}

$user_id = $_SESSION['user_id'];
$error = '';
$success = '';

// Fetch user information
$stmt = $conn->prepare("SELECT * FROM users WHERE id = :id");
$stmt->bindParam(':id', $user_id, PDO::PARAM_INT);
$stmt->execute();
$user = $stmt->fetch(PDO::FETCH_ASSOC);

// Handle form submission
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $name = trim($_POST['name']);
    $email = trim($_POST['email']);
    $phone = trim($_POST['phone']);
    $address = trim($_POST['address']);

    // Basic validation
    if (empty($name) || empty($email)) {
        $error = "Name and email are required fields.";
    } else {
        // Check if email is already taken by another user
        $stmt = $conn->prepare("SELECT id FROM users WHERE email = :email AND id != :id");
        $stmt->bindParam(':email', $email);
        $stmt->bindParam(':id', $user_id, PDO::PARAM_INT);
        $stmt->execute();
        
        if ($stmt->rowCount() > 0) {
            $error = "This email is already registered.";
        } else {
            // Update user information
            $stmt = $conn->prepare("UPDATE users SET name = :name, email = :email, phone = :phone, address = :address WHERE id = :id");
            $stmt->bindParam(':name', $name);
            $stmt->bindParam(':email', $email);
            $stmt->bindParam(':phone', $phone);
            $stmt->bindParam(':address', $address);
            $stmt->bindParam(':id', $user_id, PDO::PARAM_INT);
            
            if ($stmt->execute()) {
                $success = "Profile updated successfully!";
                // Refresh user data
                $stmt = $conn->prepare("SELECT * FROM users WHERE id = :id");
                $stmt->bindParam(':id', $user_id, PDO::PARAM_INT);
                $stmt->execute();
                $user = $stmt->fetch(PDO::FETCH_ASSOC);
            } else {
                $error = "Error updating profile. Please try again.";
            }
        }
    }
}

// Fetch order history
$stmt = $conn->prepare("
    SELECT o.*, COUNT(oi.id) as item_count, SUM(oi.quantity * oi.price) as total_amount 
    FROM orders o 
    LEFT JOIN order_items oi ON o.id = oi.order_id 
    WHERE o.user_id = :user_id 
    GROUP BY o.id 
    ORDER BY o.created_at DESC 
    LIMIT 5
");
$stmt->bindParam(':user_id', $user_id, PDO::PARAM_INT);
$stmt->execute();
$order_history = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>My Profile - Cozy Corner Cafe</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
</head>
<body class="bg-cafe-cream min-h-screen">
    <?php include 'partials/header.php'; ?>

    <main class="max-w-7xl mx-auto px-4 py-8">
        <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
            <!-- Profile Information -->
            <div class="md:col-span-2">
                <div class="bg-white rounded-lg shadow-md p-6">
                    <h2 class="text-2xl font-bold text-cafe-brown mb-6">Profile Information</h2>
                    
                    <?php if ($error): ?>
                        <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded mb-4">
                            <?php echo $error; ?>
                        </div>
                    <?php endif; ?>
                    
                    <?php if ($success): ?>
                        <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded mb-4">
                            <?php echo $success; ?>
                        </div>
                    <?php endif; ?>

                    <form method="POST" class="space-y-4">
                        <div>
                            <label class="block text-sm font-medium text-gray-700">Full Name</label>
                            <input type="text" name="name" value="<?php echo htmlspecialchars($user['name']); ?>" 
                                   class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-cafe-brown focus:ring-cafe-brown">
                        </div>

                        <div>
                            <label class="block text-sm font-medium text-gray-700">Email</label>
                            <input type="email" name="email" value="<?php echo htmlspecialchars($user['email']); ?>" 
                                   class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-cafe-brown focus:ring-cafe-brown">
                        </div>

                        <div>
                            <label class="block text-sm font-medium text-gray-700">Phone</label>
                            <input type="tel" name="phone" value="<?php echo htmlspecialchars($user['phone']); ?>" 
                                   class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-cafe-brown focus:ring-cafe-brown">
                        </div>

                        <div>
                            <label class="block text-sm font-medium text-gray-700">Address</label>
                            <textarea name="address" rows="3" 
                                      class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-cafe-brown focus:ring-cafe-brown"><?php echo htmlspecialchars($user['address']); ?></textarea>
                        </div>

                        <div class="pt-4">
                            <button type="submit" 
                                    class="w-full bg-cafe-brown text-white py-2 px-4 rounded-md hover:bg-cafe-accent focus:outline-none focus:ring-2 focus:ring-cafe-brown focus:ring-offset-2">
                                Update Profile
                            </button>
                        </div>
                    </form>
                </div>
            </div>

            <!-- Order History -->
            <div>
                <div class="bg-white rounded-lg shadow-md p-6">
                    <h2 class="text-2xl font-bold text-cafe-brown mb-6">Recent Orders</h2>
                    
                    <?php if (count($order_history) > 0): ?>
                        <div class="space-y-4">
                            <?php foreach ($order_history as $order): ?>
                                <div class="border-b border-gray-200 pb-4">
                                    <div class="flex justify-between items-center">
                                        <span class="text-sm text-gray-600">Order #<?php echo $order['id']; ?></span>
                                        <span class="text-sm font-medium">$<?php echo number_format($order['total_amount'], 2); ?></span>
                                    </div>
                                    <div class="text-sm text-gray-500">
                                        <?php echo $order['item_count']; ?> items
                                    </div>
                                    <div class="text-sm text-gray-500">
                                        <?php echo date('M d, Y', strtotime($order['created_at'])); ?>
                                    </div>
                                </div>
                            <?php endforeach; ?>
                        </div>
                    <?php else: ?>
                        <p class="text-gray-500">No order history yet.</p>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </main>

    <?php include 'partials/footer.php'; ?>
</body>
</html> 