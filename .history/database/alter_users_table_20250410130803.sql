-- Add phone and address fields to users table
ALTER TABLE users
ADD COLUMN phone VARCHAR(20) DEFAULT NULL AFTER email,
ADD COLUMN address TEXT DEFAULT NULL AFTER phone; 