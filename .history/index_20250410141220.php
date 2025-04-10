<?php require_once 'partials/header.php'; ?>

<!-- Hero Section -->
<div class="relative h-[600px] -mt-6">
    <div class="absolute inset-0">
        <img src="assets/images/hero-bg.jpg" alt="Cafe Interior" class="w-full h-full object-cover object-center">
        <div class="absolute inset-0 bg-black opacity-50"></div>
    </div>
    <div class="relative max-w-7xl mx-auto h-full flex items-center px-4">
        <div class="text-white max-w-2xl" data-aos="fade-up" data-aos-duration="1000">
            <h1 class="text-5xl font-bold mb-4">Welcome to Cozy Corner</h1>
            <p class="text-xl mb-8">Experience the perfect blend of comfort and taste in every cup. Join us for artisanal coffee, fresh pastries, and a warm atmosphere.</p>
            <div class="space-x-4" data-aos="fade-up" data-aos-delay="300" data-aos-duration="1000">
                <a href="menu.php" class="bg-cafe-brown hover:bg-cafe-accent text-white px-8 py-3 rounded-md text-lg font-medium transition duration-300">View Menu</a>
                <a href="reservations.php" class="border-2 border-white hover:bg-white hover:text-cafe-brown text-white px-8 py-3 rounded-md text-lg font-medium transition duration-300">Book a Table</a>
            </div>
        </div>
    </div>
</div>

<!-- Featured Menu Section -->
<section class="py-16">
    <div class="text-center mb-12" data-aos="fade-up" data-aos-duration="1000">
        <h2 class="text-3xl font-bold text-cafe-brown mb-4">Our Signature Items</h2>
        <p class="text-gray-600 max-w-2xl mx-auto">Discover our most loved coffee blends and delicious treats that keep our customers coming back for more.</p>
    </div>
    <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
        <?php
        require_once 'config/database.php';
        $stmt = $conn->query("SELECT * FROM menu_items WHERE id IN (1, 2, 3) LIMIT 3");
        $delay = 0;
        while ($item = $stmt->fetch(PDO::FETCH_ASSOC)) {
        ?>
        <div class="bg-white rounded-lg shadow-md overflow-hidden transform transition duration-500 hover:scale-105" 
             data-aos="fade-up" 
             data-aos-delay="<?php echo $delay; ?>" 
             data-aos-duration="1000">
            <img src="<?php echo htmlspecialchars($item['image_url']); ?>" 
                 alt="<?php echo htmlspecialchars($item['name']); ?>" 
                 class="w-full h-48 object-cover object-center">
            <div class="p-6">
                <h3 class="text-xl font-semibold text-cafe-brown mb-2"><?php echo htmlspecialchars($item['name']); ?></h3>
                <p class="text-gray-600 mb-4"><?php echo htmlspecialchars($item['description']); ?></p>
                <p class="text-cafe-accent font-semibold">$<?php echo number_format($item['price'], 2); ?></p>
            </div>
        </div>
        <?php 
            $delay += 200;
        } 
        ?>
    </div>
</section>

<!-- About Section -->
<section class="py-16 bg-white">
    <div class="max-w-7xl mx-auto px-4">
        <div class="grid grid-cols-1 md:grid-cols-2 gap-12 items-center">
            <div data-aos="fade-right" data-aos-duration="1000">
                <h2 class="text-3xl font-bold text-cafe-brown mb-6">Our Story</h2>
                <p class="text-gray-600 mb-4">Founded in 2020, Cozy Corner has been serving the community with passion and dedication. Our commitment to quality coffee and exceptional service has made us a beloved destination for coffee enthusiasts and casual visitors alike.</p>
                <p class="text-gray-600 mb-6">Every cup we serve is crafted with care, using ethically sourced beans and traditional brewing methods that bring out the perfect flavor profile.</p>
                <a href="about.php" class="text-cafe-brown hover:text-cafe-accent font-medium transition duration-300 inline-flex items-center">
                    Learn more about us 
                    <i class="fas fa-arrow-right ml-2 transform transition-transform duration-300 group-hover:translate-x-1"></i>
                </a>
            </div>
            <div class="relative" data-aos="fade-left" data-aos-duration="1000">
                <img src="assets/images/about-hero.jpg" alt="Cafe Ambiance" class="w-full h-auto object-contain rounded-lg shadow-lg transform transition duration-500 hover:scale-105">
            </div>
        </div>
    </div>
</section>

<!-- Initialize AOS -->
<script>
    AOS.init({
        duration: 1000,
        once: true,
        offset: 100,
        easing: 'ease-in-out'
    });
</script>

<?php require_once 'partials/footer.php'; ?> 