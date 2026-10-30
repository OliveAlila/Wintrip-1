CREATE TABLE IF NOT EXISTS destinations (
 id INT UNSIGNED NOT NULL AUTO_INCREMENT PRIMARY KEY,
 name VARCHAR(160) NOT NULL UNIQUE,
 slug VARCHAR(180) NOT NULL UNIQUE,
 country VARCHAR(100) DEFAULT NULL,
 region VARCHAR(80) NOT NULL,
 description TEXT NOT NULL,
 region_description TEXT DEFAULT NULL,
 image_url VARCHAR(1000) DEFAULT NULL,
 best_time TEXT DEFAULT NULL,
 visitor_guidance TEXT DEFAULT NULL,
 highlights JSON DEFAULT NULL,
 is_active TINYINT(1) NOT NULL DEFAULT 1,
 sort_order INT NOT NULL DEFAULT 0,
 created_at TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
 updated_at TIMESTAMP NULL DEFAULT NULL ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

CREATE TABLE IF NOT EXISTS enquiries (
 id BIGINT UNSIGNED NOT NULL AUTO_INCREMENT PRIMARY KEY,
 name VARCHAR(160) NOT NULL,
 email VARCHAR(190) NOT NULL,
 destination VARCHAR(160) DEFAULT NULL,
 travel_date DATE DEFAULT NULL,
 message TEXT NOT NULL,
 status ENUM('new','contacted','in_progress','closed','spam') NOT NULL DEFAULT 'new',
 created_at DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,
 INDEX idx_enquiries_status_created (status,created_at),
 INDEX idx_enquiries_email (email)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

CREATE TABLE IF NOT EXISTS newsletter_subscribers (
 id BIGINT UNSIGNED NOT NULL AUTO_INCREMENT PRIMARY KEY,
 email VARCHAR(190) NOT NULL UNIQUE,
 created_at DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

INSERT INTO destinations (name,slug,country,region,description,region_description,image_url,best_time,visitor_guidance,highlights,sort_order) VALUES
('Maasai Mara','maasai-mara','Kenya','Kenya','Explore the rolling grasslands of the Maasai Mara, one of Kenya’s most celebrated wildlife destinations. The reserve is known for big cats, large elephant herds and the seasonal Great Migration.','The Maasai Mara lies in south-western Kenya and forms part of the wider Mara-Serengeti ecosystem.','https://images.unsplash.com/photo-1516426122078-c23e76319801?auto=format&fit=crop&w=1600&q=85','July to October for the migration; wildlife viewing is rewarding throughout the year.','Pack neutral-coloured clothing, a hat, sunscreen and binoculars. Early-morning game drives are often rewarding. Follow your guide’s instructions and keep a respectful distance from wildlife.','["Game drives across the reserve","Big-cat and elephant sightings","Seasonal Great Migration","Hot-air balloon safaris (subject to availability)"]',1),
('Amboseli','amboseli','Kenya','Kenya','Amboseli is famed for its large elephant herds and striking views of Mount Kilimanjaro. Its open plains, swamps and acacia woodland make for varied landscapes and memorable game viewing.','Amboseli National Park is in southern Kenya near the Tanzania border.','https://images.unsplash.com/photo-1516026672322-bc52d61a55d5?auto=format&fit=crop&w=1600&q=85','June to October and January to February are generally drier periods.','Bring sun protection, a camera and binoculars. Kilimanjaro is often clearest early in the morning. Weather and mountain visibility vary.','["Elephant herds","Views of Mount Kilimanjaro","Birdwatching around the swamps","Guided game drives"]',2),
('Diani Beach','diani-beach','Kenya','Coast','Diani Beach is a beautiful stretch of Kenya’s south coast, known for its white sand, warm Indian Ocean waters and relaxed coastal atmosphere.','Diani is south of Mombasa on Kenya’s Indian Ocean coastline.','https://images.unsplash.com/photo-1500375592092-40eb2168fd21?auto=format&fit=crop&w=1600&q=85','January to March and July to October are popular drier periods.','Bring reef-conscious sun protection and light clothing. Check local sea conditions before swimming or arranging water activities. Respect marine life and local conservation guidance.','["White-sand beaches","Snorkelling and diving trips","Kitesurfing and water sports","Local Swahili food and culture"]',3),
('Lamu','lamu','Kenya','Coast','Lamu offers a slower pace shaped by Swahili culture, historic architecture and the Indian Ocean. Explore the old town, waterfront and nearby beaches.','Lamu is part of the Lamu Archipelago on Kenya’s northern coast.','https://images.unsplash.com/photo-1518509562904-e7ef99cdcc86?auto=format&fit=crop&w=1600&q=85','Generally drier from December to March and July to October.','Dress respectfully when visiting historic and religious areas. Comfortable walking shoes are useful on the narrow streets. Confirm boat transfers and local transport arrangements before travel.','["Lamu Old Town heritage","Dhow sailing experiences","Shela Beach","Swahili cuisine and crafts"]',4),
('Zanzibar','zanzibar','Tanzania','Coast','Zanzibar combines palm-fringed beaches with the history and character of Stone Town. Visitors can enjoy spice tours, dhow cruises and Indian Ocean experiences.','Zanzibar is an archipelago off the coast of Tanzania in the Indian Ocean.','https://images.unsplash.com/photo-1544551763-46a013bb70d5?auto=format&fit=crop&w=1600&q=85','June to October and December to February are popular drier seasons.','Check current entry and visa requirements before departure. Pack light clothing and modest attire for cultural and religious sites. Use licensed operators for excursions.','["Stone Town","Spice farm visits","Beach stays and dhow cruises","Snorkelling and diving"]',5),
('Cape Town','cape-town','South Africa','Africa','Cape Town brings together dramatic mountain scenery, beautiful coastlines, food, art and history. It is an excellent starting point for exploring the Cape Peninsula and nearby winelands.','Cape Town is in South Africa’s Western Cape province.','https://images.unsplash.com/photo-1580060839134-75a5edca2e99?auto=format&fit=crop&w=1600&q=85','November to March for warmer, drier summer weather; spring and autumn can also be pleasant.','Book popular attractions ahead where possible. Weather on Table Mountain can change quickly, so check conditions before hiking or taking the cableway. Use reputable transport providers.','["Table Mountain","Cape Peninsula drives","V&A Waterfront","Kirstenbosch and nearby winelands"]',6),
('Dubai','dubai','United Arab Emirates','Beyond','Dubai pairs a striking modern skyline with traditional markets, desert landscapes and a wide range of dining and shopping experiences.','Dubai is one of the seven emirates of the United Arab Emirates.','https://images.unsplash.com/photo-1512453979798-5ea266f8880c?auto=format&fit=crop&w=1600&q=85','November to March for milder outdoor conditions.','Check visa and entry requirements for your passport before booking. Dress respectfully in public and religious spaces. For desert activities, use licensed operators and follow safety instructions.','["Burj Khalifa and Downtown Dubai","Desert safari experiences","Traditional souks","Beaches and waterfront districts"]',7),
('Naivasha','naivasha','Kenya','Kenya','Lake Naivasha is a refreshing Rift Valley escape with lakeside stays, birdlife and nearby nature experiences. It is well suited to a short break from Nairobi.','Naivasha is in Kenya’s Great Rift Valley, north-west of Nairobi.','https://images.unsplash.com/photo-1470770841072-f978cf4d019e?auto=format&fit=crop&w=1600&q=85','January to March and June to October are often drier, though conditions vary.','Use licensed guides for boat trips and wildlife activities. Keep a safe distance from hippos and other wildlife, and follow lodge and guide instructions near the water.','["Boat trips on Lake Naivasha","Birdwatching","Crescent Island guided walks","Nearby Hell’s Gate National Park"]',8)
ON DUPLICATE KEY UPDATE name=VALUES(name),country=VALUES(country),region=VALUES(region),description=VALUES(description),region_description=VALUES(region_description),image_url=VALUES(image_url),best_time=VALUES(best_time),visitor_guidance=VALUES(visitor_guidance),highlights=VALUES(highlights),sort_order=VALUES(sort_order);
