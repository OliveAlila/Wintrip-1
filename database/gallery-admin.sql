CREATE TABLE IF NOT EXISTS admin_users (id INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,email VARCHAR(190) NOT NULL UNIQUE,password_hash VARCHAR(255) NOT NULL,created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;
CREATE TABLE IF NOT EXISTS gallery_images (id INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,title VARCHAR(180) NOT NULL,category ENUM('Wildlife','Safaris','Our Guests','Landscapes','Experiences') NOT NULL DEFAULT 'Wildlife',image_url VARCHAR(1000) NOT NULL,is_active TINYINT(1) NOT NULL DEFAULT 1,sort_order INT NOT NULL DEFAULT 0,created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;
INSERT INTO gallery_images(title,category,image_url,sort_order)
SELECT 'Waterbuck in the wild','Wildlife','assets/images/gallery/wintrip-01.webp',1 WHERE NOT EXISTS (SELECT 1 FROM gallery_images);
INSERT INTO gallery_images(title,category,image_url,sort_order) VALUES
('Lioness in the savannah','Wildlife','assets/images/gallery/wintrip-02.webp',2),
('Safari guests with Wintrip vehicle','Our Guests','assets/images/gallery/wintrip-03.webp',3),
('Lions in the Mara','Wildlife','assets/images/gallery/wintrip-04.webp',4),
('Elephant in the bush','Wildlife','assets/images/gallery/wintrip-05.webp',5),
('Rock formations and open country','Landscapes','assets/images/gallery/wintrip-06.webp',6),
('A quiet wilderness landscape','Landscapes','assets/images/gallery/wintrip-07.webp',7),
('Lioness and cub','Wildlife','assets/images/gallery/wintrip-08.webp',8),
('Antelope herd','Wildlife','assets/images/gallery/wintrip-09.webp',9),
('A lion at a picnic stop','Experiences','assets/images/gallery/wintrip-10.webp',10),
('Guests enjoying a safari outing','Our Guests','assets/images/gallery/wintrip-11.webp',11),
('Giraffe on the plains','Wildlife','assets/images/gallery/wintrip-12.webp',12),
('Lion resting in the shade','Wildlife','assets/images/gallery/wintrip-13.webp',13),
('Antelopes by the water','Wildlife','assets/images/gallery/wintrip-14.webp',14),
('Wintrip safari vehicle','Safaris','assets/images/gallery/wintrip-15.webp',15),
('Guests beside a safari vehicle','Our Guests','assets/images/gallery/wintrip-16.webp',16),
('Game drive with lions','Safaris','assets/images/gallery/wintrip-17.webp',17),
('A bush picnic experience','Experiences','assets/images/gallery/wintrip-18.webp',18),
('Family safari memories','Our Guests','assets/images/gallery/wintrip-19.webp',19),
('A Wintrip guest moment','Our Guests','assets/images/gallery/wintrip-20.webp',20),
('Friends on safari','Our Guests','assets/images/gallery/wintrip-21.webp',21),
('A safari picnic in the bush','Experiences','assets/images/gallery/wintrip-22.webp',22),
('A visit to Salt Lick Safari Lodge','Experiences','assets/images/gallery/wintrip-23.webp',23);
