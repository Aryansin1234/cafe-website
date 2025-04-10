<?php
require_once 'config/database.php';
session_start();

// Redirect to login if not authenticated
if (!isset($_SESSION['user_id'])) {
    header('Location: login.php');
    exit;
}

// Process checkout
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Create order
    $stmt = $conn->prepare("INSERT INTO orders (user_id, total_amount, status) VALUES (?, ?, 'pending')");
    $total = 0;
    
    foreach ($_SESSION['cart'] as $item) {
        $total += $item['quantity'] * $item['price'];
    }
    
    $stmt->execute([$_SESSION['user_id'], $total]);
    $order_id = $conn->lastInsertId();

    // Create order items
    $stmt = $conn->prepare("INSERT INTO order_items (order_id, menu_item_id, quantity, price) VALUES (?, ?, ?, ?)");
    
    foreach ($_SESSION['cart'] as $item_id => $item) {
        $stmt->execute([
            $order_id,
            $item_id,
            $item['quantity'],
            $item['price']
        ]);
    }

    // Clear cart
    $_SESSION['cart'] = [];

    // Redirect to order confirmation
    header('Location: order-confirmation.php?order_id=' . $order_id);
    exit;
}

// Get cart items for display
$cart_items = [];
$total = 0;

foreach ($_SESSION['cart'] as $item_id => $item) {
    $stmt = $conn->prepare("SELECT name FROM menu_items WHERE id = ?");
    $stmt->execute([$item_id]);
    $menu_item = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($menu_item) {
        $cart_items[] = [
            'name' => $menu_item['name'],
            'quantity' => $item['quantity'],
            'price' => $item['price'],
            'subtotal' => $item['quantity'] * $item['price']
        ];
        $total += $item['quantity'] * $item['price'];
    }
}

// Redirect to cart if empty
if (empty($cart_items)) {
    header('Location: cart.php');
    exit;
}
?>

<?php require_once 'partials/header.php'; ?>

<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-12">
    <h1 class="text-3xl font-bold text-cafe-brown mb-8">Checkout</h1>

    <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
        <!-- Order Summary -->
        <div class="bg-white rounded-lg shadow-md p-6">
            <h2 class="text-xl font-semibold text-cafe-brown mb-4">Order Summary</h2>
            <div class="space-y-4">
                <?php foreach ($cart_items as $item): ?>
                    <div class="flex justify-between">
                        <div>
                            <span class="font-medium"><?php echo htmlspecialchars($item['name']); ?></span>
                            <span class="text-gray-600"> × <?php echo $item['quantity']; ?></span>
                        </div>
                        <span class="text-cafe-accent">$<?php echo number_format($item['subtotal'], 2); ?></span>
                    </div>
                <?php endforeach; ?>
                <div class="border-t pt-4 mt-4">
                    <div class="flex justify-between font-semibold">
                        <span>Total</span>
                        <span class="text-cafe-brown">₹<?php echo number_format($total, 2); ?></span>
                    </div>
                </div>
            </div>
        </div>

        <!-- Payment Form -->
        <div class="bg-white rounded-lg shadow-md p-6">
            <h2 class="text-xl font-semibold text-cafe-brown mb-4">Payment Details</h2>
            <form method="POST" class="space-y-6">
                <div>
                    <label for="card_name" class="block text-sm font-medium text-gray-700">Name on Card</label>
                    <input type="text" id="card_name" name="card_name" required 
                        class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-cafe-brown focus:border-cafe-brown">
                </div>

                <div>
                    <label for="card_number" class="block text-sm font-medium text-gray-700">Card Number</label>
                    <input type="text" id="card_number" name="card_number" required pattern="[0-9]{16}" 
                        class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-cafe-brown focus:border-cafe-brown"
                        placeholder="1234 5678 9012 3456">
                </div>

                <div class="grid grid-cols-2 gap-4">
                    <div>
                        <label for="expiry" class="block text-sm font-medium text-gray-700">Expiry Date</label>
                        <input type="text" id="expiry" name="expiry" required pattern="[0-9]{2}/[0-9]{2}" 
                            class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-cafe-brown focus:border-cafe-brown"
                            placeholder="MM/YY">
                    </div>
                    <div>
                        <label for="cvv" class="block text-sm font-medium text-gray-700">CVV</label>
                        <input type="text" id="cvv" name="cvv" required pattern="[0-9]{3,4}" 
                            class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-cafe-brown focus:border-cafe-brown"
                            placeholder="123">
                    </div>
                </div>

                <div class="border-t pt-6">
                    <button type="submit" 
                        class="w-full bg-cafe-brown hover:bg-cafe-accent text-white py-3 rounded-md text-lg font-medium transition duration-300">
                        Pay <?php echo number_format($total, 2); ?>
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
// Simple form validation
document.querySelector('form').addEventListener('submit', function(e) {
    e.preventDefault();
    
    // In a real application, you would handle payment processing here
    // For this demo, we'll just submit the form
    this.submit();
});

// Format card number input
document.getElementById('card_number').addEventListener('input', function(e) {
    let value = this.value.replace(/\D/g, '');
    if (value.length > 16) value = value.slice(0, 16);
    this.value = value;
});

// Format expiry date input
document.getElementById('expiry').addEventListener('input', function(e) {
    let value = this.value.replace(/\D/g, '');
    if (value.length > 4) value = value.slice(0, 4);
    if (value.length > 2) {
        value = value.slice(0, 2) + '/' + value.slice(2);
    }
    this.value = value;
});

// Format CVV input
document.getElementById('cvv').addEventListener('input', function(e) {
    let value = this.value.replace(/\D/g, '');
    if (value.length > 4) value = value.slice(0, 4);
    this.value = value;
});
</script>

<?php require_once 'partials/footer.php'; ?>