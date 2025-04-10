<?php
require_once 'config/database.php';
session_start();

// Redirect to login if not authenticated
if (!isset($_SESSION['user_id'])) {
    header('Location: login.php');
    exit;
}

$success = '';
$error = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $date = filter_input(INPUT_POST, 'date', FILTER_SANITIZE_STRING);
    $time = filter_input(INPUT_POST, 'time', FILTER_SANITIZE_STRING);
    $guests = filter_input(INPUT_POST, 'guests', FILTER_SANITIZE_NUMBER_INT);
    $notes = filter_input(INPUT_POST, 'notes', FILTER_SANITIZE_STRING);

    if (!empty($date) && !empty($time) && !empty($guests)) {
        // Validate date and time
        $datetime = DateTime::createFromFormat('Y-m-d H:i', $date . ' ' . $time);
        $now = new DateTime();

        if ($datetime && $datetime > $now) {
            // Check if there are too many reservations for this time slot
            $stmt = $conn->prepare("
                SELECT COUNT(*) as count 
                FROM reservations 
                WHERE date = ? AND time = ? AND status = 'confirmed'
            ");
            $stmt->execute([$date, $time]);
            $result = $stmt->fetch(PDO::FETCH_ASSOC);

            if ($result['count'] < 10) { // Maximum 10 reservations per time slot
                $stmt = $conn->prepare("
                    INSERT INTO reservations (user_id, date, time, guests, notes, status) 
                    VALUES (?, ?, ?, ?, ?, 'pending')
                ");

                if ($stmt->execute([$_SESSION['user_id'], $date, $time, $guests, $notes])) {
                    $success = 'Your reservation request has been submitted. We will confirm it shortly.';
                } else {
                    $error = 'Failed to submit reservation. Please try again.';
                }
            } else {
                $error = 'Sorry, this time slot is fully booked. Please choose another time.';
            }
        } else {
            $error = 'Please select a future date and time.';
        }
    } else {
        $error = 'Please fill in all required fields.';
    }
}

// Get user's existing reservations
$stmt = $conn->prepare("
    SELECT * FROM reservations 
    WHERE user_id = ? 
    ORDER BY date DESC, time DESC
");
$stmt->execute([$_SESSION['user_id']]);
$reservations = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>

<?php require_once 'partials/header.php'; ?>

<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-12">
    <h1 class="text-3xl font-bold text-cafe-brown mb-8">Make a Reservation</h1>

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

    <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
        <!-- Reservation Form -->
        <div class="bg-white rounded-lg shadow-md p-6">
            <form method="POST" class="space-y-6">
                <div>
                    <label for="date" class="block text-sm font-medium text-gray-700">Date</label>
                    <input type="date" id="date" name="date" required min="<?php echo date('Y-m-d'); ?>"
                        class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-cafe-brown focus:border-cafe-brown">
                </div>

                <div>
                    <label for="time" class="block text-sm font-medium text-gray-700">Time</label>
                    <select id="time" name="time" required
                        class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-cafe-brown focus:border-cafe-brown">
                        <?php
                        $start = strtotime('10:00');
                        $end = strtotime('21:00');
                        for ($time = $start; $time <= $end; $time += 1800) { // 30-minute intervals
                            echo '<option value="' . date('H:i', $time) . '">' . date('g:i A', $time) . '</option>';
                        }
                        ?>
                    </select>
                </div>

                <div>
                    <label for="guests" class="block text-sm font-medium text-gray-700">Number of Guests</label>
                    <select id="guests" name="guests" required
                        class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-cafe-brown focus:border-cafe-brown">
                        <?php for ($i = 1; $i <= 8; $i++): ?>
                            <option value="<?php echo $i; ?>"><?php echo $i; ?> <?php echo $i === 1 ? 'Guest' : 'Guests'; ?></option>
                        <?php endfor; ?>
                    </select>
                </div>

                <div>
                    <label for="notes" class="block text-sm font-medium text-gray-700">Special Requests</label>
                    <textarea id="notes" name="notes" rows="3"
                        class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-cafe-brown focus:border-cafe-brown"
                        placeholder="Any dietary requirements or special requests?"></textarea>
                </div>

                <button type="submit"
                    class="w-full bg-cafe-brown hover:bg-cafe-accent text-white py-3 rounded-md text-lg font-medium transition duration-300">
                    Book Table
                </button>
            </form>
        </div>

        <!-- Existing Reservations -->
        <div>
            <h2 class="text-xl font-semibold text-cafe-brown mb-4">Your Reservations</h2>
            <?php if (empty($reservations)): ?>
                <p class="text-gray-600">You don't have any reservations yet.</p>
            <?php else: ?>
                <div class="space-y-4">
                    <?php foreach ($reservations as $reservation): ?>
                        <div class="bg-white rounded-lg shadow-md p-4">
                            <div class="flex justify-between items-start">
                                <div>
                                    <p class="font-medium text-gray-800">
                                        <?php
                                        $date = new DateTime($reservation['date']);
                                        echo $date->format('l, F j, Y');
                                        ?>
                                    </p>
                                    <p class="text-gray-600">
                                        <?php
                                        $time = DateTime::createFromFormat('H:i:s', $reservation['time']);
                                        echo $time->format('g:i A');
                                        ?> • <?php echo $reservation['guests']; ?> Guests
                                    </p>
                                    <?php if ($reservation['notes']): ?>
                                        <p class="text-gray-600 mt-2"><?php echo htmlspecialchars($reservation['notes']); ?></p>
                                    <?php endif; ?>
                                </div>
                                <span class="px-3 py-1 rounded-full text-sm font-medium
                                    <?php echo $reservation['status'] === 'confirmed' ? 'bg-green-100 text-green-800' : 'bg-yellow-100 text-yellow-800'; ?>">
                                    <?php echo ucfirst($reservation['status']); ?>
                                </span>
                            </div>
                        </div>
                    <?php endforeach; ?>
                </div>
            <?php endif; ?>
        </div>
    </div>
</div>

<?php require_once 'partials/footer.php'; ?> 