
CREATE TABLE users (
    id SERIAL PRIMARY KEY,
    username VARCHAR(50) UNIQUE NOT NULL,
    password VARCHAR(255) NOT NULL,
    role VARCHAR(20) DEFAULT 'editor'
        CHECK (role IN ('admin', 'editor'))
);

CREATE TABLE articles (
    id SERIAL PRIMARY KEY,
    title VARCHAR(255) NOT NULL,
    content TEXT NOT NULL,
    slug VARCHAR(255) UNIQUE NOT NULL,
    image VARCHAR(255),                  -- chemin ou nom du fichier image
    meta_description TEXT,
    status VARCHAR(20) DEFAULT 'draft' CHECK (status IN ('draft','published')),  -- statut de publication
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
('admin', '$2y$10$examplehashedpassword', 'admin'),
('editor', '$2y$10$examplehashedpassword', 'editor');

INSERT INTO articles (title, slug, content, image, meta_description, status)
VALUES ('Guerre en Iran 2026', 'guerre-iran-2026', '<p>Contenu de l''article...</p>', 'article1.jpg', 'Article sur la situation en Iran', 'published');