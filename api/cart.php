<?php
require_once '../config/database.php';
session_start();

header('Content-Type: application/json');

// Check if user is logged in
if (!isset($_SESSION['user_id'])) {
    http_response_code(401);
    echo json_encode(['success' => false, 'message' => 'Please login to continue']);
    exit;
}

// Get the request body
$data = json_decode(file_get_contents('php://input'), true);

if (!isset($data['action'])) {
    http_response_code(400);
    echo json_encode(['success' => false, 'message' => 'Invalid request']);
    exit;
}

// Initialize cart if it doesn't exist
if (!isset($_SESSION['cart'])) {
    $_SESSION['cart'] = [];
}

switch ($data['action']) {
    case 'add':
        if (!isset($data['item_id']) || !isset($data['quantity'])) {
            http_response_code(400);
            echo json_encode(['success' => false, 'message' => 'Missing item_id or quantity']);
            exit;
        }

        $item_id = (int)$data['item_id'];
        $quantity = (int)$data['quantity'];

        // Validate item exists
        $stmt = $conn->prepare("SELECT id, price FROM menu_items WHERE id = ?");
        $stmt->execute([$item_id]);
        $item = $stmt->fetch(PDO::FETCH_ASSOC);

        if (!$item) {
            http_response_code(404);
            echo json_encode(['success' => false, 'message' => 'Item not found']);
            exit;
        }

        // Add or update cart item
        if (isset($_SESSION['cart'][$item_id])) {
            $_SESSION['cart'][$item_id]['quantity'] += $quantity;
        } else {
            $_SESSION['cart'][$item_id] = [
                'quantity' => $quantity,
                'price' => $item['price']
            ];
        }

        echo json_encode(['success' => true, 'message' => 'Item added to cart']);
        break;

    case 'update':
        if (!isset($data['item_id']) || !isset($data['quantity'])) {
            http_response_code(400);
            echo json_encode(['success' => false, 'message' => 'Missing item_id or quantity']);
            exit;
        }

        $item_id = (int)$data['item_id'];
        $quantity = (int)$data['quantity'];

        if ($quantity <= 0) {
            unset($_SESSION['cart'][$item_id]);
        } else {
            $_SESSION['cart'][$item_id]['quantity'] = $quantity;
        }

        echo json_encode(['success' => true, 'message' => 'Cart updated']);
        break;

    case 'remove':
        if (!isset($data['item_id'])) {
            http_response_code(400);
            echo json_encode(['success' => false, 'message' => 'Missing item_id']);
            exit;
        }

        $item_id = (int)$data['item_id'];
        unset($_SESSION['cart'][$item_id]);

        echo json_encode(['success' => true, 'message' => 'Item removed from cart']);
        break;

    case 'get':
        $cart_items = [];
        $total = 0;

        foreach ($_SESSION['cart'] as $item_id => $item) {
            $stmt = $conn->prepare("SELECT name, image_url FROM menu_items WHERE id = ?");
            $stmt->execute([$item_id]);
            $menu_item = $stmt->fetch(PDO::FETCH_ASSOC);

            if ($menu_item) {
                $cart_items[] = [
                    'id' => $item_id,
                    'name' => $menu_item['name'],
                    'image_url' => $menu_item['image_url'],
                    'quantity' => $item['quantity'],
                    'price' => $item['price'],
                    'subtotal' => $item['quantity'] * $item['price']
                ];
                $total += $item['quantity'] * $item['price'];
            }
        }

        echo json_encode([
            'success' => true,
            'cart' => $cart_items,
            'total' => $total
        ]);
        break;

    default:
        http_response_code(400);
        echo json_encode(['success' => false, 'message' => 'Invalid action']);
        break;
} 