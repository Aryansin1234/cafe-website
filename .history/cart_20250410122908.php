<?php
require_once 'config/database.php';
session_start();

// Redirect to login if not authenticated
if (!isset($_SESSION['user_id'])) {
    header('Location: login.php');
    exit;
}
?>

<?php require_once 'partials/header.php'; ?>

<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-12">
    <h1 class="text-3xl font-bold text-cafe-brown mb-8">Your Cart</h1>

    <div id="cart-items" class="space-y-6">
        <!-- Cart items will be loaded here -->
    </div>

    <div id="cart-summary" class="mt-8 bg-white rounded-lg shadow-md p-6">
        <div class="flex justify-between items-center mb-4">
            <span class="text-lg font-semibold text-gray-700">Total:</span>
            <span id="cart-total" class="text-2xl font-bold text-cafe-brown">$0.00</span>
        </div>
        <button onclick="proceedToCheckout()" 
            class="w-full bg-cafe-brown hover:bg-cafe-accent text-white py-3 rounded-md text-lg font-medium transition duration-300">
            Proceed to Checkout
        </button>
    </div>
</div>

<template id="cart-item-template">
    <div class="bg-white rounded-lg shadow-md p-6 flex items-center">
        <img class="w-24 h-24 object-cover rounded-md" src="" alt="">
        <div class="ml-6 flex-grow">
            <h3 class="text-lg font-semibold text-cafe-brown"></h3>
            <div class="flex items-center mt-2">
                <button onclick="updateQuantity(this)" data-action="decrease" 
                    class="text-gray-500 hover:text-cafe-brown focus:outline-none">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 12H4"/>
                    </svg>
                </button>
                <span class="mx-4 text-gray-700"></span>
                <button onclick="updateQuantity(this)" data-action="increase" 
                    class="text-gray-500 hover:text-cafe-brown focus:outline-none">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v12m6-6H6"/>
                    </svg>
                </button>
            </div>
        </div>
        <div class="ml-6 text-right">
            <p class="text-lg font-semibold text-cafe-accent"></p>
            <button onclick="removeItem(this)" 
                class="mt-2 text-red-600 hover:text-red-800 text-sm font-medium focus:outline-none">
                Remove
            </button>
        </div>
    </div>
</template>

<script>
function loadCart() {
    fetch('api/cart.php', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
        },
        body: JSON.stringify({ action: 'get' })
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            const cartItems = document.getElementById('cart-items');
            const template = document.getElementById('cart-item-template');
            cartItems.innerHTML = '';

            if (data.cart.length === 0) {
                cartItems.innerHTML = '<p class="text-gray-600 text-center py-8">Your cart is empty</p>';
                return;
            }

            data.cart.forEach(item => {
                const clone = template.content.cloneNode(true);
                
                const container = clone.querySelector('.bg-white');
                container.dataset.itemId = item.id;
                
                const img = clone.querySelector('img');
                img.src = item.image_url;
                img.alt = item.name;
                
                clone.querySelector('h3').textContent = item.name;
                clone.querySelector('.mx-4').textContent = item.quantity;
                clone.querySelector('.text-cafe-accent').textContent = 
                    `$${(item.subtotal).toFixed(2)}`;
                
                cartItems.appendChild(clone);
            });

            document.getElementById('cart-total').textContent = 
                `$${data.total.toFixed(2)}`;
        }
    })
    .catch(error => {
        console.error('Error:', error);
        alert('Error loading cart. Please try again.');
    });
}

function updateQuantity(button) {
    const container = button.closest('[data-item-id]');
    const itemId = container.dataset.itemId;
    const action = button.dataset.action;
    const quantitySpan = container.querySelector('.mx-4');
    let quantity = parseInt(quantitySpan.textContent);

    if (action === 'increase') {
        quantity++;
    } else if (action === 'decrease' && quantity > 1) {
        quantity--;
    }

    fetch('api/cart.php', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
        },
        body: JSON.stringify({
            action: 'update',
            item_id: itemId,
            quantity: quantity
        })
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            loadCart();
        }
    })
    .catch(error => {
        console.error('Error:', error);
        alert('Error updating cart. Please try again.');
    });
}

function removeItem(button) {
    const container = button.closest('[data-item-id]');
    const itemId = container.dataset.itemId;

    fetch('api/cart.php', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
        },
        body: JSON.stringify({
            action: 'remove',
            item_id: itemId
        })
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            loadCart();
        }
    })
    .catch(error => {
        console.error('Error:', error);
        alert('Error removing item. Please try again.');
    });
}

function proceedToCheckout() {
    window.location.href = 'checkout.php';
}

// Load cart when page loads
document.addEventListener('DOMContentLoaded', loadCart);
</script>

<?php require_once 'partials/footer.php'; ?> 