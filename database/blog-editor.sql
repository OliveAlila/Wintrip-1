CREATE TABLE IF NOT EXISTS blog_content (
    id TINYINT UNSIGNED NOT NULL PRIMARY KEY,
    title_html MEDIUMTEXT NOT NULL,
    body_html MEDIUMTEXT NOT NULL,
    updated_at TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- Keep the content already saved through the previous editor.
INSERT INTO blog_content (id, title_html, body_html)
SELECT id, title_html, body_html
FROM testimonials
WHERE id = 1
ON DUPLICATE KEY UPDATE
    title_html = VALUES(title_html),
    body_html = VALUES(body_html);
