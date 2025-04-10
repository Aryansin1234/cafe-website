<?php
require_once 'config/database.php';
session_start();

// Redirect to login if not authenticated
if (!isset($_SESSION['user_id'])) {
    header('Location: login.php');
    exit;
}

// Get order ID from URL
$order_id = isset($_GET['order_id']) ? (int)$_GET['order_id'] : 0;

// Get order details
$stmt = $conn->prepare("
    SELECT o.*, u.name as customer_name 
    FROM orders o 
    JOIN users u ON o.user_id = u.id 
    WHERE o.id = ? AND o.user_id = ?
");
$stmt->execute([$order_id, $_SESSION['user_id']]);
$order = $stmt->fetch(PDO::FETCH_ASSOC);

if (!$order) {
    header('Location: index.php');
    exit;
}

// Get order items
$stmt = $conn->prepare("
    SELECT oi.*, mi.name, mi.image_url 
    FROM order_items oi 
    JOIN menu_items mi ON oi.menu_item_id = mi.id 
    WHERE oi.order_id = ?
");
$stmt->execute([$order_id]);
$order_items = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>

<?php require_once 'partials/header.php'; ?>

<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-12">
    <div class="text-center mb-12">
        <div class="inline-flex items-center justify-center w-16 h-16 rounded-full bg-green-100 mb-6">
            <svg class="w-8 h-8 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
            </svg>
        </div>
        <h1 class="text-3xl font-bold text-cafe-brown mb-4">Order Confirmed!</h1>
        <p class="text-gray-600">Thank you for your order. We'll start preparing it right away.</p>
    </div>

    <div class="bg-white rounded-lg shadow-md p-6 mb-8">
        <div class="border-b pb-4 mb-4">
            <h2 class="text-xl font-semibold text-cafe-brown">Order Details</h2>
            <p class="text-gray-600 mt-1">Order #<?php echo str_pad($order['id'], 6, '0', STR_PAD_LEFT); ?></p>
        </div>

        <div class="space-y-4">
            <?php foreach ($order_items as $item): ?>
                <div class="flex items-center">
                    <img src="<?php echo htmlspecialchars($item['image_url']); ?>" 
                        alt="<?php echo htmlspecialchars($item['name']); ?>" 
                        class="w-16 h-16 object-cover rounded-md">
                    <div class="ml-4 flex-grow">
                        <h3 class="font-medium text-gray-800"><?php echo htmlspecialchars($item['name']); ?></h3>
                        <p class="text-gray-600">Quantity: <?php echo $item['quantity']; ?></p>
                    </div>
                    <div class="text-right">
                        <p class="font-medium">₹<?php echo number_format($item['price'] * $item['quantity'], 2); ?></p>
                    </div>
                </div>
            <?php endforeach; ?>

            <div class="border-t pt-4 mt-4">
                <div class="flex justify-between font-semibold">
                    <span>Total</span>
                    <span class="text-cafe-brown">₹<?php echo number_format($order['total_amount'], 2); ?></span>
                </div>
            </div>
        </div>
    </div>

    <div class="text-center">
        <a href="menu.php" class="inline-flex items-center text-cafe-brown hover:text-cafe-accent">
            <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/>
            </svg>
            Continue Shopping
        </a>
    </div>
</div>

<?php require_once 'partials/footer.php'; ?> 