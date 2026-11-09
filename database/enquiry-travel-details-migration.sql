-- Run once on the existing Wintrip Safaris database in phpMyAdmin.
ALTER TABLE enquiries
  ADD COLUMN nationality VARCHAR(100) NOT NULL DEFAULT '' AFTER email,
  ADD COLUMN travel_from DATE DEFAULT NULL AFTER destination,
  ADD COLUMN travel_to DATE DEFAULT NULL AFTER travel_from;
