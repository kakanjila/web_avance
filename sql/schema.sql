CREATE TABLE users (
    id SERIAL PRIMARY KEY,
    username VARCHAR(50) UNIQUE NOT NULL,
    password VARCHAR(255) NOT NULL,
    role VARCHAR(20) DEFAULT 'editor' CHECK (role IN ('admin', 'editor'))
);

CREATE TABLE articles (
    id SERIAL PRIMARY KEY,
    title VARCHAR(255) NOT NULL,
    content TEXT NOT NULL,
    slug VARCHAR(255) UNIQUE NOT NULL,
    meta_description TEXT,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

CREATE TABLE images (
    id SERIAL PRIMARY KEY,
    article_id INTEGER REFERENCES articles(id) ON DELETE CASCADE,
    path VARCHAR(255) NOT NULL,
    alt_text VARCHAR(255)
);

INSERT INTO users (username, password, role) VALUES
('admin', '\\\.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 'admin'),
('editor', '\\\.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 'editor');
