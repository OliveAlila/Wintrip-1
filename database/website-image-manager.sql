-- Run once in phpMyAdmin after selecting the Wintrip database.
CREATE TABLE IF NOT EXISTS site_images (
 id INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
 image_key VARCHAR(120) NOT NULL UNIQUE,
 label VARCHAR(180) NOT NULL,
 image_url VARCHAR(1000) NOT NULL,
 alt_text VARCHAR(255) DEFAULT NULL,
 updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

CREATE TABLE IF NOT EXISTS destination_images (
 id INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
 destination_id INT UNSIGNED NOT NULL,
 image_url VARCHAR(1000) NOT NULL,
 alt_text VARCHAR(255) DEFAULT NULL,
 sort_order INT NOT NULL DEFAULT 0,
 created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
 INDEX idx_destination_images_order (destination_id, sort_order, id),
 CONSTRAINT fk_destination_images_destination FOREIGN KEY (destination_id)
   REFERENCES destinations(id) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;
