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
INSERT INTO menu_items (category_id, name, description, price, image_url) VALUES
-- Hot Coffee
(1, 'Espresso', 'Single shot of our premium espresso', 120, 'images/menu/espresso.jpg'),
(1, 'Cappuccino', 'Espresso with steamed milk and foam', 150, 'images/menu/cappuccino.jpg'),
(1, 'Latte', 'Espresso with steamed milk', 160, 'images/menu/latte.jpg'),
(1, 'Mocha', 'Espresso with chocolate and steamed milk', 180, 'images/menu/mocha.jpg'),
(1, 'Americano', 'Espresso with hot water', 130, 'images/menu/americano.jpg'),

-- Cold Coffee
(2, 'Iced Coffee', 'Chilled coffee with ice', 140, 'images/menu/iced-coffee.jpg'),
(2, 'Iced Latte', 'Espresso with cold milk and ice', 170, 'images/menu/iced-latte.jpg'),
(2, 'Cold Brew', 'Slow-brewed cold coffee', 190, 'images/menu/cold-brew.jpg'),
(2, 'Frappuccino', 'Blended coffee drink with ice', 220, 'images/menu/frappuccino.jpg'),

-- Tea
(3, 'English Breakfast', 'Classic black tea blend', 100, 'images/menu/english-breakfast.jpg'),
(3, 'Green Tea', 'Premium Japanese green tea', 110, 'images/menu/green-tea.jpg'),
(3, 'Chamomile', 'Soothing herbal tea', 100, 'images/menu/chamomile.jpg'),
(3, 'Earl Grey', 'Bergamot flavored black tea', 110, 'images/menu/earl-grey.jpg'),

-- Pastries
(4, 'Croissant', 'Buttery French croissant', 140, 'images/menu/croissant.jpg'),
(4, 'Blueberry Muffin', 'Fresh blueberry muffin', 150, 'images/menu/blueberry-muffin.jpg'),
(4, 'Cinnamon Roll', 'Sweet cinnamon roll with icing', 160, 'images/menu/cinnamon-roll.jpg'),
(4, 'Chocolate Croissant', 'Croissant with chocolate filling', 160, 'images/menu/chocolate-croissant.jpg'),

-- Sandwiches
(5, 'Turkey Club', 'Turkey, bacon, lettuce, tomato on wheat', 320, 'images/menu/turkey-club.jpg'),
(5, 'Grilled Cheese', 'Classic grilled cheese sandwich', 280, 'images/menu/grilled-cheese.jpg'),
(5, 'Veggie Wrap', 'Fresh vegetables in a whole wheat wrap', 300, 'images/menu/veggie-wrap.jpg'),
(5, 'Chicken Panini', 'Grilled chicken with pesto and mozzarella', 340, 'images/menu/chicken-panini.jpg'),

-- Desserts
(6, 'Chocolate Cake', 'Rich chocolate cake with ganache', 240, 'images/menu/chocolate-cake.jpg'),
(6, 'Cheesecake', 'Classic New York style cheesecake', 250, 'images/menu/cheesecake.jpg'),
(6, 'Tiramisu', 'Italian coffee-flavored dessert', 260, 'images/menu/tiramisu.jpg'),
(6, 'Chocolate Chip Cookie', 'Freshly baked cookie', 100, 'images/menu/chocolate-chip-cookie.jpg'); 