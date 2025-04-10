<?php
require_once 'config/database.php';
session_start();

// Get all categories
$categories = $conn->query("SELECT * FROM categories ORDER BY name")->fetchAll(PDO::FETCH_ASSOC);

// Get selected category or show all
$category_id = isset($_GET['category']) ? (int)$_GET['category'] : null;

// Prepare menu items query
if ($category_id) {
    $stmt = $conn->prepare("SELECT * FROM menu_items WHERE category_id = ? ORDER BY name");
    $stmt->execute([$category_id]);
} else {
    $stmt = $conn->query("SELECT * FROM menu_items ORDER BY category_id, name");
}
$menu_items = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>

<?php require_once 'partials/header.php'; ?>

<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-12">
    <div class="text-center mb-12">
        <h1 class="text-4xl font-bold text-cafe-brown mb-4">Our Menu</h1>
        <p class="text-gray-600 max-w-2xl mx-auto">Discover our carefully curated selection of coffee, pastries, and light meals.</p>
    </div>

    <!-- Category Filter -->
    <div class="flex justify-center space-x-4 mb-12">
        <a href="menu.php" 
            class="px-4 py-2 rounded-md <?php echo !$category_id ? 'bg-cafe-brown text-white' : 'bg-white text-cafe-brown hover:bg-cafe-accent hover:text-white'; ?> transition duration-300">
            All
        </a>
        <?php foreach ($categories as $category): ?>
            <a href="menu.php?category=<?php echo $category['id']; ?>" 
                class="px-4 py-2 rounded-md <?php echo $category_id === $category['id'] ? 'bg-cafe-brown text-white' : 'bg-white text-cafe-brown hover:bg-cafe-accent hover:text-white'; ?> transition duration-300">
                <?php echo htmlspecialchars($category['name']); ?>
            </a>
        <?php endforeach; ?>
    </div>

    <!-- Menu Items Grid -->
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
        <?php foreach ($menu_items as $item): ?>
            <div class="bg-white rounded-lg shadow-md overflow-hidden">
                <img src="<?php echo htmlspecialchars($item['image_url']); ?>" 
                    alt="<?php echo htmlspecialchars($item['name']); ?>" 
                    class="w-full h-48 object-cover">
                <div class="p-6">
                    <h3 class="text-xl font-semibold text-cafe-brown mb-2">
                        <?php echo htmlspecialchars($item['name']); ?>
                    </h3>
                    <p class="text-gray-600 mb-4">
                        <?php echo htmlspecialchars($item['description']); ?>
                    </p>
                    <div class="flex justify-between items-center">
                        <span class="text-cafe-accent font-semibold">
                            ₹<?php echo number_format($item['price'], 2); ?>
                        </span>
                        <?php if (isset($_SESSION['user_id'])): ?>
                            <button onclick="addToCart(<?php echo $item['id']; ?>)" 
                                class="bg-cafe-brown hover:bg-cafe-accent text-white px-4 py-2 rounded-md text-sm font-medium transition duration-300">
                                Add to Cart
                            </button>
                        <?php else: ?>
                            <a href="login.php" 
                                class="bg-cafe-brown hover:bg-cafe-accent text-white px-4 py-2 rounded-md text-sm font-medium transition duration-300">
                                Login to Order
                            </a>
                        <?php endif; ?>
                    </div>
                </div>
            </div>
        <?php endforeach; ?>
    </div>
</div>

<script>
function addToCart(itemId) {
    fetch('api/cart.php', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
        },
        body: JSON.stringify({
            action: 'add',
            item_id: itemId,
            quantity: 1
        })
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            alert('Item added to cart!');
        } else {
            alert('Error adding item to cart. Please try again.');
        }
    })
    .catch(error => {
        console.error('Error:', error);
        alert('Error adding item to cart. Please try again.');
    });
}
</script>

<?php require_once 'partials/footer.php'; ?> 