-- Sample menu data for Cozy Corner Cafe

-- Categories
INSERT INTO categories (name, description) VALUES
('Hot Coffee', 'Our signature hot coffee drinks'),
('Cold Coffee', 'Refreshing iced coffee beverages'),
('Tea', 'Premium loose leaf teas'),
('Pastries', 'Freshly baked goods'),
('Sandwiches', 'Delicious sandwiches and wraps'),
('Desserts', 'Sweet treats and desserts');

-- Menu Items
INSERT INTO menu_items (category_id, name, description, price, image_url, is_available) VALUES
-- Hot Coffee
(1, 'Espresso', 'Single shot of our premium espresso', 2.99, 'images/menu/espresso.jpg', 1),
(1, 'Cappuccino', 'Espresso with steamed milk and foam', 3.99, 'images/menu/cappuccino.jpg', 1),
(1, 'Latte', 'Espresso with steamed milk', 3.99, 'images/menu/latte.jpg', 1),
(1, 'Mocha', 'Espresso with chocolate and steamed milk', 4.49, 'images/menu/mocha.jpg', 1),
(1, 'Americano', 'Espresso with hot water', 2.99, 'images/menu/americano.jpg', 1),

-- Cold Coffee
(2, 'Iced Coffee', 'Chilled coffee with ice', 3.49, 'images/menu/iced-coffee.jpg', 1),
(2, 'Iced Latte', 'Espresso with cold milk and ice', 4.49, 'images/menu/iced-latte.jpg', 1),
(2, 'Cold Brew', 'Slow-brewed cold coffee', 4.99, 'images/menu/cold-brew.jpg', 1),
(2, 'Frappuccino', 'Blended coffee drink with ice', 5.49, 'images/menu/frappuccino.jpg', 1),

-- Tea
(3, 'English Breakfast', 'Classic black tea blend', 2.99, 'images/menu/english-breakfast.jpg', 1),
(3, 'Green Tea', 'Premium Japanese green tea', 2.99, 'images/menu/green-tea.jpg', 1),
(3, 'Chamomile', 'Soothing herbal tea', 2.99, 'images/menu/chamomile.jpg', 1),
(3, 'Earl Grey', 'Bergamot flavored black tea', 2.99, 'images/menu/earl-grey.jpg', 1),

-- Pastries
(4, 'Croissant', 'Buttery French croissant', 3.49, 'images/menu/croissant.jpg', 1),
(4, 'Blueberry Muffin', 'Fresh blueberry muffin', 3.49, 'images/menu/blueberry-muffin.jpg', 1),
(4, 'Cinnamon Roll', 'Sweet cinnamon roll with icing', 3.99, 'images/menu/cinnamon-roll.jpg', 1),
(4, 'Chocolate Croissant', 'Croissant with chocolate filling', 3.99, 'images/menu/chocolate-croissant.jpg', 1),

-- Sandwiches
(5, 'Turkey Club', 'Turkey, bacon, lettuce, tomato on wheat', 7.99, 'images/menu/turkey-club.jpg', 1),
(5, 'Grilled Cheese', 'Classic grilled cheese sandwich', 6.99, 'images/menu/grilled-cheese.jpg', 1),
(5, 'Veggie Wrap', 'Fresh vegetables in a whole wheat wrap', 7.49, 'images/menu/veggie-wrap.jpg', 1),
(5, 'Chicken Panini', 'Grilled chicken with pesto and mozzarella', 8.49, 'images/menu/chicken-panini.jpg', 1),

-- Desserts
(6, 'Chocolate Cake', 'Rich chocolate cake with ganache', 5.99, 'images/menu/chocolate-cake.jpg', 1),
(6, 'Cheesecake', 'Classic New York style cheesecake', 5.99, 'images/menu/cheesecake.jpg', 1),
(6, 'Tiramisu', 'Italian coffee-flavored dessert', 6.49, 'images/menu/tiramisu.jpg', 1),
(6, 'Chocolate Chip Cookie', 'Freshly baked cookie', 2.49, 'images/menu/chocolate-chip-cookie.jpg', 1); 