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
('admin', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 'admin'),
('editor', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 'editor');


INSERT INTO articles (title, content, slug, meta_description, published) VALUES
(
    'Contexte historique du conflit en Iran',
    '<h2>Les racines du conflit</h2>
<p>L''Iran, situé au carrefour du Moyen-Orient, a été le théâtre de nombreux conflits au cours de son histoire moderne. La révolution islamique de 1979, qui a renversé le Shah Mohammad Reza Pahlavi, a profondément transformé le paysage géopolitique de la région.</p>

<h2>La révolution de 1979</h2>
<p>La révolution iranienne a marqué un tournant décisif dans l''histoire du pays. Sous la direction de l''Ayatollah Khomeini, le mouvement révolutionnaire a conduit à l''établissement de la République islamique d''Iran. Cet événement a eu des répercussions considérables sur les relations internationales au Moyen-Orient.</p>

<h3>Les causes de la révolution</h3>
<p>Parmi les facteurs déclencheurs, on trouve le mécontentement populaire face aux politiques de modernisation autoritaire du Shah, les inégalités économiques croissantes, et la répression politique exercée par la SAVAK, la police secrète du régime.</p>

<h2>L''héritage du conflit</h2>
<p>Les tensions issues de cette période continuent d''influencer la politique régionale et internationale. La compréhension de ce contexte historique est essentielle pour analyser les dynamiques actuelles au Moyen-Orient.</p>',
    'contexte-historique-conflit-iran',
    'Découvrez le contexte historique du conflit en Iran : révolution de 1979, causes profondes et héritage géopolitique au Moyen-Orient.',
    true
);