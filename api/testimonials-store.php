<?php
declare(strict_types=1);

/**
 * Ensure the testimonials table exists and contains the two supplied starter reviews.
 * Safe to call from the admin dashboard, save handler and public API.
 */
function wintrip_ensure_testimonials(PDO $pdo): void {
    $pdo->exec("CREATE TABLE IF NOT EXISTS blog_testimonials (
        id INT UNSIGNED NOT NULL AUTO_INCREMENT PRIMARY KEY,
        reviewer_name VARCHAR(100) NOT NULL,
        review_text VARCHAR(1200) NOT NULL,
        trip_label VARCHAR(160) NOT NULL DEFAULT '',
        sort_order TINYINT UNSIGNED NOT NULL DEFAULT 0,
        created_at TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
        updated_at TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
        INDEX idx_blog_testimonials_sort (sort_order,id)
    ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4");

    $seed = $pdo->prepare(
        'INSERT INTO blog_testimonials (reviewer_name,review_text,trip_label,sort_order)
         SELECT ?,?,?,? WHERE NOT EXISTS (
             SELECT 1 FROM blog_testimonials WHERE reviewer_name = ?
         )'
    );
    $seed->execute([
        'Lydia Kwamboka',
        'Anytime any day the best services with an amazing team. Never disappoints',
        'Honeymoon Package — Dubai',
        1,
        'Lydia Kwamboka'
    ]);
    $seed->execute([
        'Martin Mato',
        'A good experience I had by booking with you, and the pocket friendly prices, good customer service you are like a family. Thank you Wintrip safaris',
        'Game Drive — Maasai Mara',
        2,
        'Martin Mato'
    ]);
}
