<?php require_once 'partials/header.php'; ?>

<!-- Hero Section -->
<div class="relative h-[600px] -mt-6">
    <div class="absolute inset-0">
        <img src="assets/images/hero-bg.jpg" alt="Cafe Interior" class="w-full h-full object-cover">
        <div class="absolute inset-0 bg-black opacity-50"></div>
    </div>
    <div class="relative max-w-7xl mx-auto h-full flex items-center px-4">
        <div class="text-white max-w-2xl">
            <h1 class="text-5xl font-bold mb-4">Welcome to Cozy Corner</h1>
            <p class="text-xl mb-8">Experience the perfect blend of comfort and taste in every cup. Join us for artisanal coffee, fresh pastries, and a warm atmosphere.</p>
            <div class="space-x-4">
                <a href="/menu.php" class="bg-cafe-brown hover:bg-cafe-accent text-white px-8 py-3 rounded-md text-lg font-medium transition duration-300">View Menu</a>
                <a href="/reservations.php" class="border-2 border-white hover:bg-white hover:text-cafe-brown text-white px-8 py-3 rounded-md text-lg font-medium transition duration-300">Book a Table</a>
            </div>
        </div>
    </div>
</div>

<!-- Featured Menu Section -->
<section class="py-16">
    <div class="text-center mb-12">
        <h2 class="text-3xl font-bold text-cafe-brown mb-4">Our Signature Items</h2>
        <p class="text-gray-600 max-w-2xl mx-auto">Discover our most loved coffee blends and delicious treats that keep our customers coming back for more.</p>
    </div>
    <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
        <?php
        require_once 'config/database.php';
        $stmt = $conn->query("SELECT * FROM menu_items WHERE id IN (1, 2, 3) LIMIT 3");
        while ($item = $stmt->fetch(PDO::FETCH_ASSOC)) {
        ?>
        <div class="bg-white rounded-lg shadow-md overflow-hidden">
            <img src="<?php echo htmlspecialchars($item['image_url']); ?>" alt="<?php echo htmlspecialchars($item['name']); ?>" class="w-full h-48 object-cover">
            <div class="p-6">
                <h3 class="text-xl font-semibold text-cafe-brown mb-2"><?php echo htmlspecialchars($item['name']); ?></h3>
                <p class="text-gray-600 mb-4"><?php echo htmlspecialchars($item['description']); ?></p>
                <p class="text-cafe-accent font-semibold">$<?php echo number_format($item['price'], 2); ?></p>
            </div>
        </div>
        <?php } ?>
    </div>
</section>

<!-- About Section -->
<section class="py-16 bg-white">
    <div class="max-w-7xl mx-auto px-4">
        <div class="grid grid-cols-1 md:grid-cols-2 gap-12 items-center">
            <div>
                <h2 class="text-3xl font-bold text-cafe-brown mb-6">Our Story</h2>
                <p class="text-gray-600 mb-4">Founded in 2020, Cozy Corner has been serving the community with passion and dedication. Our commitment to quality coffee and exceptional service has made us a beloved destination for coffee enthusiasts and casual visitors alike.</p>
                <p class="text-gray-600 mb-6">Every cup we serve is crafted with care, using ethically sourced beans and traditional brewing methods that bring out the perfect flavor profile.</p>
                <a href="/about.php" class="text-cafe-brown hover:text-cafe-accent font-medium">Learn more about us →</a>
            </div>
            <div class="relative h-[400px]">
                <img src="assets/images/about-img.jpg" alt="Cafe Ambiance" class="w-full h-full object-cover rounded-lg shadow-lg">
            </div>
        </div>
    </div>
</section>

<?php require_once 'partials/footer.php'; ?> 