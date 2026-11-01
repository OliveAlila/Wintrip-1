CREATE TABLE IF NOT EXISTS testimonials (
    id TINYINT UNSIGNED NOT NULL PRIMARY KEY,
    title_html MEDIUMTEXT NOT NULL,
    body_html MEDIUMTEXT NOT NULL,
    updated_at TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

INSERT INTO testimonials (id, title_html, body_html)
VALUES (
    1,
    'It''s not just where<br>you go. It''s <em>how you feel.</em>',
    'Every great journey begins with a little curiosity. Tell us what inspires you, and let''s make your next escape one to remember.'
)
ON DUPLICATE KEY UPDATE id = VALUES(id);
