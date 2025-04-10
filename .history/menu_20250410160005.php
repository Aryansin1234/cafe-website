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
    <div class="text-center mb-12" data-aos="fade-up" data-aos-duration="1000">
        <h1 class="text-4xl font-bold text-cafe-brown mb-4">Our Menu</h1>
        <p class="text-gray-600 max-w-2xl mx-auto">Discover our carefully curated selection of coffee, pastries, and light meals.</p>
    </div>

    <!-- Category Filter -->
    <div class="flex flex-wrap justify-center gap-4 mb-12" data-aos="fade-up" data-aos-delay="200" data-aos-duration="1000">
        <a href="menu.php" 
            class="px-4 py-2 rounded-md transform transition duration-300 hover:scale-105 <?php echo !$category_id ? 'bg-cafe-brown text-white' : 'bg-white text-cafe-brown hover:bg-cafe-accent hover:text-white'; ?>">
            All
        </a>
        <?php 
        $delay = 300;
        foreach ($categories as $category): 
        ?>
            <a href="menu.php?category=<?php echo $category['id']; ?>" 
                class="px-4 py-2 rounded-md transform transition duration-300 hover:scale-105 <?php echo $category_id === $category['id'] ? 'bg-cafe-brown text-white' : 'bg-white text-cafe-brown hover:bg-cafe-accent hover:text-white'; ?>"
                data-aos="fade-up"
                data-aos-delay="<?php echo $delay; ?>"
                data-aos-duration="1000">
                <?php echo htmlspecialchars($category['name']); ?>
            </a>
        <?php 
            $delay += 100;
        endforeach; 
        ?>
    </div>

    <!-- Menu Items Grid -->
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
        <?php 
        $item_delay = 0;
        foreach ($menu_items as $item): 
        ?>
            <div class="bg-white rounded-lg shadow-md overflow-hidden transform transition duration-500 hover:scale-105 hover:shadow-lg"
                 data-aos="fade-up"
                 data-aos-delay="<?php echo $item_delay; ?>"
                 data-aos-duration="1000">
                <div class="relative h-64 overflow-hidden">
                    <img src="<?php echo htmlspecialchars($item['image_url']); ?>" 
                        alt="<?php echo htmlspecialchars($item['name']); ?>" 
                        class="absolute inset-0 w-full h-full object-cover transform transition-transform duration-500 hover:scale-110">
                </div>
                <div class="p-6">
                    <h3 class="text-xl font-semibold text-cafe-brown mb-2">
                        <?php echo htmlspecialchars($item['name']); ?>
                    </h3>
                    <p class="text-gray-600 mb-4">
                        <?php echo htmlspecialchars($item['description']); ?>
                    </p>
                    <p class="text-cafe-accent font-semibold">
                        ₹<?php echo number_format($item['price'], 2); ?>
                    </p>
                    <div class="flex justify-between items-center">
                        <?php if (isset($_SESSION['user_id'])): ?>
                            <button onclick="addToCart(<?php echo $item['id']; ?>)" 
                                class="bg-cafe-brown hover:bg-cafe-accent text-white px-4 py-2 rounded-md text-sm font-medium transition duration-300 transform hover:scale-105">
                                <i class="fas fa-shopping-cart mr-2"></i>
                                Add to Cart
                            </button>
                        <?php else: ?>
                            <a href="login.php" 
                                class="bg-cafe-brown hover:bg-cafe-accent text-white px-4 py-2 rounded-md text-sm font-medium transition duration-300 transform hover:scale-105">
                                <i class="fas fa-sign-in-alt mr-2"></i>
                                Login to Order
                            </a>
                        <?php endif; ?>
                    </div>
                </div>
            </div>
        <?php 
            $item_delay += 100;
        endforeach; 
        ?>
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
            // Show success animation
            const button = event.target;
            button.innerHTML = '<i class="fas fa-check mr-2"></i>Added!';
            button.classList.add('bg-green-500');
            setTimeout(() => {
                button.innerHTML = '<i class="fas fa-shopping-cart mr-2"></i>Add to Cart';
                button.classList.remove('bg-green-500');
            }, 2000);
        } else {
            alert('Error adding item to cart. Please try again.');
        }
    })
    .catch(error => {
        console.error('Error:', error);
        alert('Error adding item to cart. Please try again.');
    });
}

// Initialize AOS
AOS.init({
    duration: 1000,
    once: true,
    offset: 100,
    easing: 'ease-in-out'
});
</script>

<?php require_once 'partials/footer.php'; ?> 