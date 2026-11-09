-- Run once on the existing Wintrip Safaris database in phpMyAdmin.
-- Run this after the earlier enquiry-travel-details-migration.sql migration.
ALTER TABLE enquiries
  ADD COLUMN trip_type VARCHAR(40) DEFAULT NULL AFTER nationality,
  ADD COLUMN travellers VARCHAR(40) DEFAULT NULL AFTER travel_to;
