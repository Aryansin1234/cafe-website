<?php
require_once 'config/database.php';
session_start();

$success = '';
$error = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $name = filter_input(INPUT_POST, 'name', FILTER_SANITIZE_STRING);
    $email = filter_input(INPUT_POST, 'email', FILTER_SANITIZE_EMAIL);
    $subject = filter_input(INPUT_POST, 'subject', FILTER_SANITIZE_STRING);
    $message = filter_input(INPUT_POST, 'message', FILTER_SANITIZE_STRING);

    if (!empty($name) && !empty($email) && !empty($subject) && !empty($message)) {
        // In a real application, you would send an email here
        // For this demo, we'll just show a success message
        $success = 'Thank you for your message. We will get back to you soon!';
    } else {
        $error = 'Please fill in all fields.';
    }
}
?>

<?php require_once 'partials/header.php'; ?>

<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-12">
    <div class="text-center mb-12">
        <h1 class="text-4xl font-bold text-cafe-brown mb-4">Contact Us</h1>
        <p class="text-gray-600 max-w-2xl mx-auto">Have a question or feedback? We'd love to hear from you.</p>
    </div>

    <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
        <!-- Contact Form -->
        <div class="bg-white rounded-lg shadow-md p-6">
            <?php if ($success): ?>
                <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded mb-6">
                    <?php echo htmlspecialchars($success); ?>
                </div>
            <?php endif; ?>

            <?php if ($error): ?>
                <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded mb-6">
                    <?php echo htmlspecialchars($error); ?>
                </div>
            <?php endif; ?>

            <form method="POST" class="space-y-6">
                <div>
                    <label for="name" class="block text-sm font-medium text-gray-700">Name</label>
                    <input type="text" id="name" name="name" required
                        class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-cafe-brown focus:border-cafe-brown">
                </div>

                <div>
                    <label for="email" class="block text-sm font-medium text-gray-700">Email</label>
                    <input type="email" id="email" name="email" required
                        class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-cafe-brown focus:border-cafe-brown">
                </div>

                <div>
                    <label for="subject" class="block text-sm font-medium text-gray-700">Subject</label>
                    <input type="text" id="subject" name="subject" required
                        class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-cafe-brown focus:border-cafe-brown">
                </div>

                <div>
                    <label for="message" class="block text-sm font-medium text-gray-700">Message</label>
                    <textarea id="message" name="message" rows="4" required
                        class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-cafe-brown focus:border-cafe-brown"></textarea>
                </div>

                <button type="submit"
                    class="w-full bg-cafe-brown hover:bg-cafe-accent text-white py-3 rounded-md text-lg font-medium transition duration-300">
                    Send Message
                </button>
            </form>
        </div>

        <!-- Contact Information -->
        <div class="space-y-8">
            <div class="bg-white rounded-lg shadow-md p-6">
                <h2 class="text-xl font-semibold text-cafe-brown mb-4">Visit Us</h2>
                <div class="space-y-4">
                    <p class="flex items-center text-gray-600">
                        <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" 
                                d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/>
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" 
                                d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"/>
                        </svg>
                        123 Coffee Street<br>
                        Cafe City, CC 12345
                    </p>
                    <p class="flex items-center text-gray-600">
                        <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" 
                                d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z"/>
                        </svg>
                        (555) 123-4567
                    </p>
                    <p class="flex items-center text-gray-600">
                        <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" 
                                d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/>
                        </svg>
                        hello@cozycorner.com
                    </p>
                </div>
            </div>

            <div class="bg-white rounded-lg shadow-md p-6">
                <h2 class="text-xl font-semibold text-cafe-brown mb-4">Opening Hours</h2>
                <div class="space-y-2">
                    <p class="flex justify-between text-gray-600">
                        <span>Monday - Friday</span>
                        <span>7:00 AM - 8:00 PM</span>
                    </p>
                    <p class="flex justify-between text-gray-600">
                        <span>Saturday</span>
                        <span>8:00 AM - 9:00 PM</span>
                    </p>
                    <p class="flex justify-between text-gray-600">
                        <span>Sunday</span>
                        <span>8:00 AM - 7:00 PM</span>
                    </p>
                </div>
            </div>

            <!-- Google Maps Embed -->
            <div class="bg-white rounded-lg shadow-md p-6">
                <h2 class="text-xl font-semibold text-cafe-brown mb-4">Location</h2>
                <div class="aspect-w-16 aspect-h-9">
                    <iframe
                        src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3022.1!2d-73.9!3d40.7!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x0%3A0x0!2zM40°42'00.0%22N+73°54'00.0%22W!5e0!3m2!1sen!2sus!4v1234567890"
                        width="100%"
                        height="300"
                        style="border:0;"
                        allowfullscreen=""
                        loading="lazy">
                    </iframe>
                </div>
            </div>
        </div>
    </div>
</div>

<?php require_once 'partials/footer.php'; ?> 