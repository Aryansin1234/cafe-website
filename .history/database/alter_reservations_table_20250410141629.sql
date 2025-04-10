-- Add notes column to reservations table
ALTER TABLE reservations
ADD COLUMN notes TEXT DEFAULT NULL AFTER guests; 