CREATE TABLE users (
    id SERIAL PRIMARY KEY,
    username VARCHAR(50) UNIQUE NOT NULL,
    password VARCHAR(255) NOT NULL,
    role VARCHAR(20) DEFAULT 'editor' CHECK (role IN ('admin', 'editor'))
);

CREATE TABLE article_types (
    id SERIAL PRIMARY KEY,
    name VARCHAR(100) UNIQUE NOT NULL,
    slug VARCHAR(100) UNIQUE NOT NULL
);

CREATE TABLE articles (
    id SERIAL PRIMARY KEY,
    title VARCHAR(255) NOT NULL,
    content TEXT NOT NULL,
    slug VARCHAR(255) UNIQUE NOT NULL,
    meta_description TEXT,
    type_id INTEGER REFERENCES article_types(id),
    image_path VARCHAR(255),
    image_alt VARCHAR(255),
    published BOOLEAN DEFAULT true,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

CREATE TABLE images (
    id SERIAL PRIMARY KEY,
    article_id INTEGER REFERENCES articles(id) ON DELETE CASCADE,
    path VARCHAR(255) NOT NULL,
    alt_text VARCHAR(255)
);

-- ============================================================
-- DONNÉES DE RÉFÉRENCE
-- ============================================================

-- Mot de passe par défaut : password
INSERT INTO users (username, password, role) VALUES
('admin', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 'admin'),
('editor', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 'editor');

-- ============================================================
-- TYPES D'ARTICLES
-- ============================================================

INSERT INTO article_types (name, slug) VALUES
('Géopolitique', 'geopolitique'),
('Histoire', 'histoire'),
('Humanitaire', 'humanitaire'),
('Économie', 'economie'),
('Chronologie', 'chronologie');

-- ============================================================
-- ARTICLES — Données complètes avec tous les attributs
-- ============================================================

-- Article 1 — Géopolitique
INSERT INTO articles (title, content, slug, meta_description, type_id, image_path, image_alt, published, created_at, updated_at) VALUES (
    'Tensions au Moyen-Orient : les enjeux géopolitiques du conflit iranien',
    '<p class="article-lead">Depuis plusieurs décennies, l''Iran occupe une place centrale sur l''échiquier géopolitique mondial. Les tensions persistantes entre Téhéran et les puissances occidentales façonnent profondément l''équilibre des forces au Moyen-Orient, avec des répercussions qui dépassent largement les frontières de la région.</p>

<h2>Un carrefour stratégique mondial</h2>
<p>Situé entre le golfe Persique et la mer Caspienne, l''Iran contrôle le détroit d''Ormuz, passage maritime par lequel transite environ <strong>21 % du pétrole mondial</strong>. Cette position géographique exceptionnelle confère au pays un levier considérable sur les marchés énergétiques internationaux. En cas de blocage, même partiel, les prix du baril pourraient grimper de 30 à 50 % en quelques jours, selon les estimations de l''Agence internationale de l''énergie (AIE).</p>

<h2>Le programme nucléaire : pomme de discorde</h2>
<p>Depuis l''abandon de l''accord de Vienne (JCPOA) par les États-Unis en 2018, l''Iran a progressivement repris ses activités d''enrichissement d''uranium. En mars 2026, l''AIEA estime que Téhéran dispose de stocks d''uranium enrichi à 60 %, bien au-delà du seuil autorisé de 3,67 %. Les négociations pour un nouvel accord restent dans l''impasse, chaque partie campant sur ses positions.</p>

<h2>Les alliances régionales</h2>
<p>L''Iran entretient un réseau d''alliances complexe à travers la région :</p>
<ul>
    <li><strong>Hezbollah au Liban</strong> — soutien financier et militaire estimé à 700 millions de dollars par an</li>
    <li><strong>Milices chiites en Irak</strong> — les Forces de mobilisation populaire (Hachd al-Chaabi) comptent plus de 100 000 combattants</li>
    <li><strong>Houthis au Yémen</strong> — fourniture d''armement et de conseillers militaires</li>
    <li><strong>Régime de Bachar al-Assad en Syrie</strong> — présence militaire directe des Gardiens de la Révolution</li>
</ul>

<h2>Les sanctions et leurs conséquences</h2>
<p>Le régime de sanctions internationales, renforcé depuis 2018, a provoqué une contraction du PIB iranien de 12 % entre 2018 et 2020. L''inflation dépasse les 45 % en 2026, et le rial a perdu plus de 80 % de sa valeur face au dollar sur le marché parallèle. La population civile est la première touchée : pénuries de médicaments, hausse du coût des denrées alimentaires et chômage des jeunes dépassant les 30 %.</p>

<h2>Perspectives d''avenir</h2>
<p>Les élections présidentielles iraniennes prévues en 2025 et les évolutions au sein de l''administration américaine pourraient ouvrir une fenêtre diplomatique. Cependant, les analystes restent prudents : la méfiance mutuelle, accumulée sur des décennies, constitue un obstacle majeur à toute avancée significative. Le rôle de médiateurs comme le Qatar et Oman pourrait s''avérer déterminant dans les mois à venir.</p>',
    'tensions-moyen-orient-enjeux-geopolitiques-conflit-iranien',
    'Analyse approfondie des enjeux géopolitiques du conflit iranien : programme nucléaire, alliances régionales, sanctions économiques et perspectives diplomatiques au Moyen-Orient.',
    1,
    '/assets/img/uploads/geopolitique-iran-moyen-orient.jpg',
    'Carte du Moyen-Orient montrant les zones d''influence iranienne et les bases militaires américaines dans la région du golfe Persique',
    true,
    '2026-03-15 08:30:00',
    '2026-03-20 14:15:00'
);

-- Article 2 — Histoire
INSERT INTO articles (title, content, slug, meta_description, type_id, image_path, image_alt, published, created_at, updated_at) VALUES (
    'De la révolution de 1979 à aujourd''hui : comprendre l''histoire du conflit iranien',
    '<p class="article-lead">Pour saisir la complexité du conflit iranien actuel, il est indispensable de remonter aux racines historiques qui ont façonné les relations entre l''Iran et le reste du monde. De la chute du Shah à l''ère des sanctions, chaque étape a laissé des cicatrices profondes dans la mémoire collective iranienne.</p>

<h2>La révolution islamique de 1979</h2>
<p>Le 11 février 1979, la monarchie Pahlavi s''effondre sous la pression d''un mouvement populaire hétéroclite mené par l''ayatollah Rouhollah Khomeini. Le Shah Mohammad Reza Pahlavi, soutenu par les États-Unis et le Royaume-Uni depuis le coup d''État de 1953 contre le Premier ministre Mossadegh, est contraint à l''exil. La République islamique d''Iran est proclamée le 1er avril 1979, après un référendum approuvé à 98,2 %.</p>

<h2>La crise des otages (1979-1981)</h2>
<p>Le 4 novembre 1979, des étudiants iraniens prennent d''assaut l''ambassade américaine à Téhéran et retiennent 52 diplomates en otage pendant <strong>444 jours</strong>. Cet événement marque une rupture irrémédiable dans les relations irano-américaines. La tentative de sauvetage avortée (opération Eagle Claw, avril 1980) humilie l''administration Carter et contribue à sa défaite électorale face à Ronald Reagan.</p>

<h2>La guerre Iran-Irak (1980-1988)</h2>
<p>Le 22 septembre 1980, Saddam Hussein lance une offensive terrestre contre l''Iran. Ce conflit, l''un des plus meurtriers de la seconde moitié du XXe siècle, dure huit ans et fait entre <strong>500 000 et 1 million de morts</strong>. L''Irak utilise des armes chimiques à grande échelle, notamment lors de l''attaque de Halabja en mars 1988 (5 000 victimes kurdes). Les puissances occidentales, inquiètes de l''expansion de la révolution islamique, soutiennent tacitement Bagdad.</p>

<h2>L''ère des réformateurs (1997-2005)</h2>
<p>L''élection de Mohammad Khatami en 1997 ouvre une période de relative détente. Son programme de « dialogue des civilisations » suscite l''espoir, mais se heurte à la résistance des conservateurs au sein du système politique iranien. Les manifestations étudiantes de juillet 1999 à Téhéran sont violemment réprimées, illustrant les limites du réformisme dans le cadre de la République islamique.</p>

<h2>L''accord nucléaire de Vienne (2015)</h2>
<p>Après des années de négociations, le Plan d''action global commun (JCPOA) est signé le 14 juillet 2015 entre l''Iran, les États-Unis, la Russie, la Chine, la France, le Royaume-Uni et l''Allemagne. Téhéran accepte de limiter drastiquement son programme nucléaire en échange de la levée progressive des sanctions. L''accord est salué comme une avancée historique par la communauté internationale.</p>

<h2>Le retrait américain et l''escalade (2018-2026)</h2>
<p>Le 8 mai 2018, le président Donald Trump annonce le retrait unilatéral des États-Unis de l''accord. Le rétablissement des sanctions provoque une spirale d''escalade : attaques contre des pétroliers dans le golfe d''Ormuz (2019), assassinat du général Qassem Soleimani à Bagdad (3 janvier 2020), et riposte iranienne par des tirs de missiles balistiques sur la base d''Aïn al-Assad en Irak. Depuis, les tentatives de relance des négociations se sont multipliées sans aboutir à un résultat concret.</p>',
    'revolution-1979-comprendre-histoire-conflit-iranien',
    'Retour historique complet sur le conflit iranien : de la révolution islamique de 1979 à la crise nucléaire actuelle, en passant par la guerre Iran-Irak et l''accord de Vienne.',
    2,
    '/assets/img/uploads/revolution-iran-1979-histoire.jpg',
    'Photographie d''archive montrant des manifestants iraniens brandissant le portrait de l''ayatollah Khomeini lors de la révolution de 1979 à Téhéran',
    true,
    '2026-03-10 10:00:00',
    '2026-03-18 09:45:00'
);

-- Article 3 — Humanitaire
INSERT INTO articles (title, content, slug, meta_description, type_id, image_path, image_alt, published, created_at, updated_at) VALUES (
    'Crise humanitaire en Iran : les civils pris en étau entre sanctions et répression',
    '<p class="article-lead">Au-delà des jeux de pouvoir diplomatiques, le conflit a des conséquences dramatiques sur la vie quotidienne de 88 millions d''Iraniens. Les sanctions internationales, combinées à la mauvaise gestion économique et à la corruption endémique, ont plongé une part croissante de la population dans la précarité.</p>

<h2>Un système de santé sous pression</h2>
<p>Les sanctions américaines, bien qu''elles prévoient théoriquement des exemptions pour les produits médicaux, ont provoqué un effondrement de la chaîne d''approvisionnement pharmaceutique. L''Organisation mondiale de la santé (OMS) rapporte en 2025 des <strong>pénuries critiques</strong> concernant plus de 200 médicaments essentiels, dont des traitements anticancéreux, des insulines et des anesthésiques. Les hôpitaux publics fonctionnent avec du matériel vétuste, et les délais d''attente pour des interventions chirurgicales non urgentes dépassent souvent 18 mois.</p>

<h2>L''effondrement du pouvoir d''achat</h2>
<p>Le salaire minimum officiel, fixé à environ 180 millions de rials par mois (soit 36 dollars au taux du marché libre), ne couvre plus les besoins essentiels d''une famille. Selon le Centre de recherche du Parlement iranien :</p>
<ul>
    <li>Le prix du pain a augmenté de <strong>300 %</strong> entre 2020 et 2026</li>
    <li>Le coût du logement à Téhéran a été multiplié par <strong>5 en dix ans</strong></li>
    <li>Plus de <strong>30 % de la population</strong> vit sous le seuil de pauvreté, contre 15 % en 2015</li>
    <li>Le chômage des 15-29 ans atteint <strong>32 %</strong> selon les chiffres officiels (probablement sous-estimés)</li>
</ul>

<h2>La crise de l''eau</h2>
<p>L''Iran fait face à une crise hydrique sans précédent. Le lac d''Ourmia, autrefois le plus grand lac salé du Moyen-Orient avec une superficie de 5 200 km², a perdu plus de 80 % de sa surface en trente ans. Les rivières Zayandeh-Rud et Karoun sont à sec une partie de l''année. La combinaison du changement climatique, de la surexploitation des nappes phréatiques et de politiques agricoles inadaptées menace l''approvisionnement en eau potable de plusieurs grandes villes, dont Ispahan (2 millions d''habitants).</p>

<h2>Les mouvements de protestation et la répression</h2>
<p>Depuis le mouvement « Femme, Vie, Liberté » déclenché par la mort de Mahsa Amini en septembre 2022, les manifestations se succèdent malgré une répression féroce. Selon Amnesty International, au moins <strong>551 manifestants</strong> ont été tués et plus de <strong>22 000 personnes arrêtées</strong> lors des manifestations de 2022-2023. Les organisations de défense des droits humains documentent le recours systématique à la torture, aux exécutions et aux disparitions forcées.</p>

<h2>L''action des ONG internationales</h2>
<p>Les organisations humanitaires opérant en Iran font face à des obstacles considérables. Médecins Sans Frontières (MSF) maintient une présence limitée dans les zones frontalières. Le Comité international de la Croix-Rouge (CICR) a vu ses activités restreintes depuis 2023. Malgré ces difficultés, des ONG locales tentent de pallier les carences de l''État, notamment dans les domaines de l''alphabétisation, du soutien aux femmes victimes de violences et de l''aide alimentaire.</p>',
    'crise-humanitaire-iran-civils-sanctions-repression',
    'Enquête sur la crise humanitaire en Iran : impact des sanctions sur la santé, effondrement économique, crise de l''eau et répression des mouvements de protestation civile.',
    3,
    '/assets/img/uploads/crise-humanitaire-iran-civils.jpg',
    'Famille iranienne faisant la queue devant une pharmacie de Téhéran pour obtenir des médicaments devenus rares à cause des sanctions internationales',
    true,
    '2026-03-12 14:20:00',
    '2026-03-22 11:30:00'
);

-- Article 4 — Économie
INSERT INTO articles (title, content, slug, meta_description, type_id, image_path, image_alt, published, created_at, updated_at) VALUES (
    'L''économie iranienne face aux sanctions : entre résilience et asphyxie',
    '<p class="article-lead">Quatrième réserve mondiale de pétrole et deuxième réserve de gaz naturel, l''Iran dispose d''un potentiel économique considérable. Pourtant, des décennies de sanctions internationales, de corruption institutionnelle et de mauvaise gouvernance ont transformé cette richesse en malédiction, laissant un pays de 88 millions d''habitants dans une crise économique structurelle.</p>

<h2>Le pétrole : richesse et vulnérabilité</h2>
<p>L''Iran possède des réserves prouvées de <strong>208,6 milliards de barils de pétrole</strong>, représentant environ 12 % des réserves mondiales. Avant les sanctions de 2018, le pays exportait 2,5 millions de barils par jour (mb/j). En 2026, les exportations officielles ont chuté à environ 1,2 mb/j, bien que des livraisons clandestines vers la Chine, via des navires-citernes désactivant leurs transpondeurs, compensent partiellement cette baisse. Le manque à gagner annuel est estimé entre <strong>40 et 60 milliards de dollars</strong>.</p>

<h2>Le rial en chute libre</h2>
<p>La monnaie iranienne illustre à elle seule l''ampleur de la crise :</p>
<ul>
    <li><strong>2015</strong> — 1 USD = 32 000 rials (marché libre)</li>
    <li><strong>2018</strong> — 1 USD = 120 000 rials (après le retrait du JCPOA)</li>
    <li><strong>2022</strong> — 1 USD = 350 000 rials (mouvement « Femme, Vie, Liberté »)</li>
    <li><strong>2026</strong> — 1 USD = 580 000 rials (record historique)</li>
</ul>
<p>Le gouvernement maintient un taux officiel à 42 000 rials par dollar pour les importations de biens essentiels, créant un système dual qui alimente la corruption et le marché noir.</p>

<h2>La stratégie de « l''économie de résistance »</h2>
<p>Depuis 2014, le Guide suprême Ali Khamenei prône une « économie de résistance » visant à réduire la dépendance aux exportations pétrolières. Cette stratégie a produit des résultats mitigés :</p>
<ul>
    <li><strong>Succès relatifs</strong> — développement du secteur pétrochimique (exportations de 15 milliards $/an), autosuffisance en acier et ciment, essor du commerce électronique local (Digikala, Snapp)</li>
    <li><strong>Échecs</strong> — fuite des cerveaux (environ 150 000 diplômés quittent le pays chaque année), investissements étrangers quasi nuls, secteur bancaire déconnecté du système SWIFT international</li>
</ul>

<h2>Le rôle des Gardiens de la Révolution dans l''économie</h2>
<p>Le Corps des Gardiens de la Révolution islamique (Pasdaran) contrôle un empire économique estimé entre <strong>20 et 40 % du PIB iranien</strong>. À travers des conglomérats comme Khatam al-Anbiya (construction, pétrole, télécommunications), ils dominent des secteurs entiers de l''économie, écartant le secteur privé et créant un système oligarchique opaque. Cette mainmise constitue l''un des principaux freins structurels au développement économique du pays.</p>

<h2>Perspectives économiques</h2>
<p>Le FMI prévoit une croissance de 2,1 % pour l''Iran en 2026, insuffisante pour absorber les 800 000 jeunes qui arrivent chaque année sur le marché du travail. Sans levée significative des sanctions et réformes structurelles profondes, les économistes estiment que le pays pourrait connaître une récession durable dans les cinq prochaines années. L''adhésion récente de l''Iran aux BRICS+ (janvier 2024) ouvre néanmoins de nouvelles perspectives de coopération économique avec la Chine, la Russie et l''Inde.</p>',
    'economie-iranienne-sanctions-resilience-asphyxie',
    'Analyse économique de l''Iran sous sanctions : effondrement du rial, exportations pétrolières, économie de résistance, rôle des Gardiens de la Révolution et perspectives du FMI.',
    4,
    '/assets/img/uploads/economie-iran-sanctions-petrole.jpg',
    'Vue aérienne d''une raffinerie de pétrole iranienne sur l''île de Kharg dans le golfe Persique, principal terminal d''exportation du pays',
    true,
    '2026-03-08 07:45:00',
    '2026-03-19 16:00:00'
);

-- Article 5 — Chronologie
INSERT INTO articles (title, content, slug, meta_description, type_id, image_path, image_alt, published, created_at, updated_at) VALUES (
    'Chronologie complète du conflit iranien : de 1953 à 2026',
    '<p class="article-lead">Plus de sept décennies de tensions, de ruptures diplomatiques et de crises jalonnent l''histoire des relations entre l''Iran et la communauté internationale. Cette chronologie détaillée retrace les événements clés qui ont conduit à la situation actuelle.</p>

<h2>Les prémices (1953-1978)</h2>
<ul>
    <li><strong>19 août 1953</strong> — Coup d''État orchestré par la CIA et le MI6 (opération Ajax) contre le Premier ministre Mohammad Mossadegh, qui avait nationalisé le pétrole iranien. Le Shah Mohammad Reza Pahlavi est rétabli au pouvoir.</li>
    <li><strong>1963</strong> — Révolte du 15 Khordad : l''ayatollah Khomeini est arrêté puis exilé après avoir dénoncé les réformes de la « Révolution blanche » du Shah et l''influence américaine.</li>
    <li><strong>1971</strong> — Célébrations fastueuses du 2 500e anniversaire de l''Empire perse à Persépolis, symbole de la déconnexion du régime avec la réalité du peuple iranien.</li>
    <li><strong>1975</strong> — Création de la SAVAK (police secrète), formée par la CIA et le Mossad, qui mène une répression brutale contre toute opposition.</li>
</ul>

<h2>La révolution et ses conséquences (1979-1989)</h2>
<ul>
    <li><strong>1er février 1979</strong> — Retour triomphal de l''ayatollah Khomeini à Téhéran après 15 ans d''exil.</li>
    <li><strong>11 février 1979</strong> — Chute du régime Pahlavi. Proclamation de la République islamique.</li>
    <li><strong>4 novembre 1979</strong> — Prise d''otages à l''ambassade américaine : 52 diplomates retenus pendant 444 jours.</li>
    <li><strong>22 septembre 1980</strong> — L''Irak de Saddam Hussein envahit l''Iran. Début de la guerre Iran-Irak.</li>
    <li><strong>3 juillet 1988</strong> — Le croiseur USS Vincennes abat le vol Iran Air 655 au-dessus du golfe Persique : 290 civils tués.</li>
    <li><strong>20 août 1988</strong> — Cessez-le-feu entre l''Iran et l''Irak. Khomeini accepte la résolution 598 de l''ONU, qu''il compare à « boire du poison ».</li>
    <li><strong>3 juin 1989</strong> — Mort de l''ayatollah Khomeini. Ali Khamenei lui succède comme Guide suprême.</li>
</ul>

<h2>L''ère de la méfiance (1990-2014)</h2>
<ul>
    <li><strong>1995</strong> — Les États-Unis imposent un embargo commercial total contre l''Iran (Executive Order 12959, Bill Clinton).</li>
    <li><strong>1997</strong> — Élection du réformateur Mohammad Khatami à la présidence. Début d''une politique de « dialogue des civilisations ».</li>
    <li><strong>2002</strong> — Révélation de sites nucléaires clandestins à Natanz (enrichissement d''uranium) et Arak (réacteur à eau lourde) par un groupe d''opposition.</li>
    <li><strong>2005</strong> — Élection de Mahmoud Ahmadinejad, ultraconservateur. Reprise du programme nucléaire et escalade verbale (« Israël doit être rayé de la carte »).</li>
    <li><strong>2006-2010</strong> — Le Conseil de sécurité de l''ONU adopte six résolutions de sanctions contre l''Iran.</li>
    <li><strong>2009</strong> — Mouvement vert : contestation massive de la réélection controversée d''Ahmadinejad. Répression violente (au moins 72 morts).</li>
    <li><strong>2010</strong> — Le virus informatique Stuxnet, attribué aux États-Unis et à Israël, sabote les centrifugeuses de Natanz, retardant le programme nucléaire de plusieurs années.</li>
    <li><strong>2013</strong> — Élection du modéré Hassan Rohani. Ouverture de négociations secrètes avec Washington via le sultanat d''Oman.</li>
</ul>

<h2>De l''accord à l''escalade (2015-2026)</h2>
<ul>
    <li><strong>14 juillet 2015</strong> — Signature de l''accord de Vienne (JCPOA) entre l''Iran et le groupe P5+1. L''Iran accepte de limiter son enrichissement à 3,67 % et de réduire ses centrifugeuses de deux tiers.</li>
    <li><strong>16 janvier 2016</strong> — « Implementation Day » : levée des sanctions européennes et multilatérales. L''Iran récupère 100 milliards de dollars d''avoirs gelés.</li>
    <li><strong>8 mai 2018</strong> — Les États-Unis se retirent unilatéralement du JCPOA. Rétablissement de sanctions « maximales ».</li>
    <li><strong>20 juin 2019</strong> — L''Iran abat un drone américain RQ-4A Global Hawk au-dessus du détroit d''Ormuz. Trump annule une frappe de représailles « dix minutes avant l''exécution ».</li>
    <li><strong>3 janvier 2020</strong> — Assassinat du général Qassem Soleimani à Bagdad par une frappe de drone américaine. L''Iran riposte le 8 janvier par des tirs de missiles sur la base d''Aïn al-Assad.</li>
    <li><strong>Septembre 2022</strong> — Mort de Mahsa Amini en détention. Début du mouvement « Femme, Vie, Liberté ». Des centaines de morts et des milliers d''arrestations.</li>
    <li><strong>Janvier 2024</strong> — L''Iran rejoint officiellement les BRICS+, renforçant ses liens avec la Chine et la Russie.</li>
    <li><strong>Mars 2026</strong> — L''AIEA confirme que l''Iran enrichit de l''uranium à 60 %, ravivant les craintes internationales sur un potentiel programme militaire.</li>
</ul>',
    'chronologie-complete-conflit-iranien-1953-2026',
    'Chronologie détaillée du conflit iranien de 1953 à 2026 : coup d''État, révolution islamique, guerre Iran-Irak, programme nucléaire, accord de Vienne et escalade récente.',
    5,
    '/assets/img/uploads/chronologie-conflit-iran-frise.jpg',
    'Frise chronologique illustrée des principaux événements du conflit iranien, de la révolution de 1979 aux tensions nucléaires de 2026',
    true,
    '2026-03-05 09:15:00',
    '2026-03-25 10:00:00'
);

-- Article 6 — Géopolitique
INSERT INTO articles (title, content, slug, meta_description, type_id, image_path, image_alt, published, created_at, updated_at) VALUES (
    'Le rôle de la Chine et de la Russie dans la crise iranienne',
    '<p class="article-lead">Alors que les puissances occidentales maintiennent leur pression sur Téhéran, la Chine et la Russie ont considérablement renforcé leurs relations avec l''Iran au cours de la dernière décennie. Ce rapprochement redessine les équilibres géopolitiques mondiaux et complique toute tentative de résolution multilatérale de la crise.</p>

<h2>L''axe Pékin-Téhéran : un partenariat stratégique de 25 ans</h2>
<p>En mars 2021, l''Iran et la Chine ont signé un accord de coopération stratégique d''une durée de <strong>25 ans</strong>, prévoyant des investissements chinois massifs dans les infrastructures iraniennes en échange d''un approvisionnement pétrolier garanti à prix préférentiel. Selon des sources diplomatiques, l''accord porterait sur un montant total de <strong>400 milliards de dollars</strong>, incluant :</p>
<ul>
    <li>La modernisation du réseau ferroviaire iranien (liaison Téhéran-Ispahan-Chiraz)</li>
    <li>Le développement de zones économiques spéciales dans les ports de Chabahar et Bandar Abbas</li>
    <li>Des projets d''infrastructure numérique (réseau 5G déployé par Huawei)</li>
    <li>Une coopération militaire incluant la vente de systèmes de défense aérienne</li>
</ul>
<p>En 2025, la Chine importait environ <strong>1,5 million de barils par jour</strong> de pétrole iranien, représentant 90 % des exportations pétrolières de Téhéran, souvent via des navires fantômes pour contourner les sanctions.</p>

<h2>Moscou-Téhéran : une alliance de circonstance renforcée par l''Ukraine</h2>
<p>La guerre en Ukraine a accéléré le rapprochement russo-iranien. L''Iran a fourni des <strong>drones Shahed-136</strong> à la Russie, utilisés massivement contre les infrastructures ukrainiennes. En contrepartie, Moscou a livré à Téhéran des avions de chasse Sukhoi Su-35 et des systèmes de défense antiaérienne S-400, renforçant significativement les capacités militaires iraniennes.</p>
<p>Les échanges commerciaux bilatéraux ont atteint <strong>5 milliards de dollars</strong> en 2025, en hausse de 40 % par rapport à 2022. Les deux pays collaborent également dans le domaine spatial et le nucléaire civil, Moscou aidant Téhéran à construire de nouvelles tranches de la centrale de Bouchehr.</p>

<h2>Le corridor Nord-Sud : redessiner les routes commerciales</h2>
<p>L''Iran occupe une position clé dans le projet de Corridor international de transport Nord-Sud (INSTC), reliant Saint-Pétersbourg à Mumbai via le territoire iranien. Ce corridor de <strong>7 200 kilomètres</strong>, combinant rail, route et voie maritime, offre une alternative aux routes commerciales traditionnelles contrôlées par les puissances occidentales. Le transit de marchandises par ce corridor a augmenté de 25 % en 2025.</p>

<h2>Les limites du soutien sino-russe</h2>
<p>Malgré ces rapprochements, les analystes soulignent les limites de l''axe Pékin-Moscou-Téhéran :</p>
<ul>
    <li>La Chine reste prudente pour ne pas compromettre ses relations commerciales avec les États-Unis et l''Europe (plus de 1 500 milliards de dollars d''échanges annuels)</li>
    <li>La Russie, affaiblie économiquement et militairement par le conflit en Ukraine, dispose de capacités limitées pour soutenir l''Iran en cas de conflit direct</li>
    <li>Les intérêts stratégiques des trois pays ne sont pas toujours alignés, notamment en Asie centrale et dans le Caucase</li>
</ul>

<h2>Implications pour les négociations nucléaires</h2>
<p>Le soutien diplomatique de Pékin et Moscou au Conseil de sécurité de l''ONU, où ils disposent du droit de veto, rend pratiquement impossible l''adoption de nouvelles sanctions multilatérales contre l''Iran. Cette situation renforce la position de négociation de Téhéran et limite les options des puissances occidentales à des sanctions unilatérales ou des actions diplomatiques en dehors du cadre onusien.</p>',
    'role-chine-russie-crise-iranienne',
    'Analyse du rôle croissant de la Chine et de la Russie dans la crise iranienne : partenariat stratégique de 25 ans, drones Shahed, corridor Nord-Sud et implications diplomatiques.',
    1,
    '/assets/img/uploads/chine-russie-iran-alliance.jpg',
    'Les présidents Xi Jinping, Vladimir Poutine et Ebrahim Raïssi lors du sommet de l''Organisation de coopération de Shanghai en 2023',
    true,
    '2026-03-18 11:00:00',
    '2026-03-26 08:30:00'
);

-- Article 7 — Humanitaire
INSERT INTO articles (title, content, slug, meta_description, type_id, image_path, image_alt, published, created_at, updated_at) VALUES (
    'Les réfugiés afghans en Iran : une crise oubliée au cœur du conflit',
    '<p class="article-lead">Avec plus de <strong>3,4 millions de réfugiés et migrants afghans</strong> sur son territoire, l''Iran est l''un des plus grands pays d''accueil au monde. Pourtant, cette population vulnérable reste largement invisible dans les discussions internationales sur la crise iranienne, alors qu''elle subit de plein fouet les conséquences économiques des sanctions et les discriminations institutionnelles.</p>

<h2>Une présence historique</h2>
<p>Les flux migratoires afghans vers l''Iran remontent à l''invasion soviétique de l''Afghanistan en 1979. Ils se sont intensifiés durant la guerre civile des années 1990, le régime taliban (1996-2001) et à nouveau après la chute de Kaboul en août 2021. Le Haut-Commissariat des Nations unies pour les réfugiés (HCR) estime que seuls <strong>800 000 Afghans</strong> possèdent un statut de réfugié reconnu (carte « Amayesh »), tandis que 2,6 millions vivent dans une situation irrégulière.</p>

<h2>Conditions de vie précaires</h2>
<p>Les réfugiés afghans en Iran sont soumis à des restrictions considérables :</p>
<ul>
    <li><strong>Emploi</strong> — cantonnés aux secteurs de la construction, de l''agriculture et de la collecte des déchets, avec des salaires inférieurs de 30 à 50 % à ceux des Iraniens</li>
    <li><strong>Éducation</strong> — depuis 2015, les enfants afghans non documentés ont accès à l''école publique (décision du Guide suprême), mais les taux de décrochage restent très élevés (60 % au secondaire)</li>
    <li><strong>Santé</strong> — accès limité au système de santé public ; pas de couverture par l''assurance maladie nationale pour les sans-papiers</li>
    <li><strong>Logement</strong> — concentration dans les quartiers périphériques défavorisés des grandes villes (sud de Téhéran, banlieue d''Ispahan et Machhad)</li>
    <li><strong>Liberté de circulation</strong> — interdiction d''accès à certaines provinces sans autorisation spéciale</li>
</ul>

<h2>Expulsions et refoulements</h2>
<p>Depuis 2023, les autorités iraniennes ont intensifié les opérations d''expulsion. Selon l''Organisation internationale pour les migrations (OIM), <strong>870 000 Afghans</strong> ont été renvoyés de force en Afghanistan entre janvier 2023 et décembre 2025. Les organisations humanitaires dénoncent des violations graves du principe de non-refoulement, certains expulsés étant renvoyés vers des zones contrôlées par les talibans où leur sécurité ne peut être garantie.</p>

<h2>Le poids des sanctions sur les réfugiés</h2>
<p>La crise économique iranienne, aggravée par les sanctions, touche disproportionnellement les populations les plus vulnérables, dont les réfugiés afghans. La dépréciation du rial a réduit la valeur réelle de leurs revenus, déjà modestes, tandis que l''inflation alimentaire dépasse les 70 % sur certains produits de base. Les transferts d''argent vers l''Afghanistan, qui transitent par le système informel hawala, sont également perturbés.</p>

<h2>L''action de la communauté internationale</h2>
<p>Le HCR et l''UNICEF maintiennent des programmes en Iran, mais leurs financements sont largement insuffisants. En 2025, le plan de réponse humanitaire pour les réfugiés afghans en Iran n''a été financé qu''à <strong>23 %</strong> de son objectif de 118 millions de dollars. Les ONG appellent à une augmentation significative de l''aide et à l''inclusion des réfugiés afghans dans les négociations sur la levée des sanctions.</p>',
    'refugies-afghans-iran-crise-oubliee',
    'Enquête sur les 3,4 millions de réfugiés afghans en Iran : conditions de vie, expulsions forcées, impact des sanctions et action humanitaire insuffisante.',
    3,
    '/assets/img/uploads/refugies-afghans-iran-camp.jpg',
    'Enfants afghans jouant dans une cour d''école publique en banlieue de Téhéran, où ils sont autorisés à suivre une scolarité depuis 2015',
    true,
    '2026-03-20 16:45:00',
    '2026-03-27 13:20:00'
);

-- Article 8 — Économie
INSERT INTO articles (title, content, slug, meta_description, type_id, image_path, image_alt, published, created_at, updated_at) VALUES (
    'Pétrole et gaz : comment l''Iran contourne les sanctions énergétiques',
    '<p class="article-lead">Malgré les sanctions américaines qualifiées de « pression maximale », l''Iran a développé un réseau sophistiqué de contournement pour maintenir ses exportations d''hydrocarbures. Des navires fantômes aux crypto-monnaies, en passant par des réseaux de sociétés-écrans, Téhéran déploie des stratégies toujours plus inventives pour vendre son pétrole.</p>

<h2>La flotte fantôme : un commerce maritime clandestin</h2>
<p>Au cœur du dispositif iranien se trouve une flotte de plus de <strong>300 pétroliers</strong> opérant sous de fausses identités. Ces navires, souvent des vieux tankers rachetés à des compagnies en faillite, pratiquent systématiquement :</p>
<ul>
    <li><strong>Le « spoofing » AIS</strong> — falsification des données de positionnement satellite pour brouiller les pistes</li>
    <li><strong>Le transfert de navire à navire (STS)</strong> — transbordement en haute mer, notamment au large de Malacca, des Émirats arabes unis et de la côte malaisienne</li>
    <li><strong>Le changement de pavillon</strong> — immatriculation sous des pavillons de complaisance (Cameroun, Tanzanie, Palaos) pour échapper aux contrôles</li>
    <li><strong>Le mélange de cargaisons</strong> — le pétrole iranien est mélangé avec du brut irakien ou omanais pour masquer son origine</li>
</ul>

<h2>Le rôle central de la Chine</h2>
<p>Les raffineries indépendantes chinoises, appelées « teapots », situées principalement dans la province du Shandong, constituent le principal débouché du pétrole iranien sanctionné. En 2025, ces achats représentaient environ <strong>1,5 million de barils par jour</strong>, payés en yuan chinois ou via des mécanismes de troc (pétrole contre produits manufacturés). Le port de Zhoushan, dans le Zhejiang, est devenu la plaque tournante de ce commerce.</p>

<h2>Les circuits financiers parallèles</h2>
<p>Exclu du système SWIFT depuis 2018, l''Iran a développé des alternatives :</p>
<ul>
    <li><strong>SEPAM</strong> — le système de messagerie financière iranien, connecté au réseau russe SPFS et au CIPS chinois</li>
    <li><strong>Crypto-monnaies</strong> — utilisation du Bitcoin et de l''USDT (Tether) pour les transactions transfrontalières ; le minage de crypto-monnaies représente 4,5 % du minage mondial de Bitcoin</li>
    <li><strong>Réseau hawala</strong> — système traditionnel de transfert informel exploité à travers les diasporas iraniennes à Dubaï, Istanbul et Kuala Lumpur</li>
    <li><strong>Sociétés-écrans</strong> — réseau de plus de 200 entités enregistrées aux Émirats, en Turquie, en Malaisie et à Hong Kong</li>
</ul>

<h2>Le gaz naturel : l''atout sous-exploité</h2>
<p>L''Iran possède les <strong>deuxièmes réserves mondiales de gaz naturel</strong> (33 800 milliards de mètres cubes), principalement dans le gisement offshore South Pars, partagé avec le Qatar. Cependant, faute d''investissements suffisants dans les infrastructures de liquéfaction (GNL), le pays ne parvient pas à exporter son gaz à grande échelle. Les exportations par gazoduc vers la Turquie et l''Irak restent modestes (environ 40 millions de m³/jour) et font l''objet de disputes contractuelles fréquentes.</p>

<h2>L''efficacité contestée des sanctions</h2>
<p>Les experts sont divisés sur l''efficacité réelle des sanctions énergétiques. Si elles ont indéniablement réduit les revenus pétroliers iraniens de 50 à 60 % par rapport à 2017, elles n''ont pas atteint leur objectif politique principal : contraindre Téhéran à revenir à la table des négociations nucléaires. Les revenus du contournement, estimés à <strong>50 milliards de dollars par an</strong>, suffisent à maintenir l''appareil sécuritaire et les programmes stratégiques du régime, tandis que le coût est supporté par la population civile.</p>',
    'petrole-gaz-iran-contournement-sanctions-energetiques',
    'Enquête sur les méthodes de contournement des sanctions pétrolières par l''Iran : flotte fantôme, spoofing AIS, raffineries chinoises, crypto-monnaies et circuits financiers parallèles.',
    4,
    '/assets/img/uploads/petrole-iran-navire-fantome.jpg',
    'Image satellite d''un transfert de pétrole de navire à navire (STS) au large du détroit de Malacca, méthode utilisée par l''Iran pour contourner les sanctions',
    true,
    '2026-03-22 06:30:00',
    '2026-03-28 15:45:00'
);

-- Article 9 — Histoire
INSERT INTO articles (title, content, slug, meta_description, type_id, image_path, image_alt, published, created_at, updated_at) VALUES (
    'Le coup d''État de 1953 : la blessure originelle des relations Iran-Occident',
    '<p class="article-lead">Le renversement du Premier ministre Mohammad Mossadegh le 19 août 1953, orchestré par les services de renseignement américains (CIA) et britanniques (MI6), reste la matrice de la méfiance iranienne envers l''Occident. Cet événement fondateur, longtemps nié puis tardivement reconnu, continue de hanter les relations diplomatiques plus de sept décennies plus tard.</p>

<h2>Le contexte : la nationalisation du pétrole</h2>
<p>En 1951, le Parlement iranien vote à l''unanimité la nationalisation de l''Anglo-Iranian Oil Company (AIOC), ancêtre de BP, qui exploitait le pétrole iranien depuis 1908 dans des conditions jugées coloniales. Le Premier ministre Mohammad Mossadegh, avocat et homme politique charismatique, devient le symbole de la souveraineté iranienne. L''AIOC versait à l''Iran des royalties de seulement <strong>16 % des bénéfices</strong>, alors que l''Arabian American Oil Company (Aramco) en accordait 50 % à l''Arabie saoudite.</p>

<h2>L''opération Ajax</h2>
<p>Face au refus de Mossadegh de revenir sur la nationalisation, Londres et Washington mettent en place l''opération TP-AJAX. Le plan, approuvé par le président Eisenhower et le Premier ministre Churchill, comprend :</p>
<ul>
    <li><strong>Propagande médiatique</strong> — financement de journaux et de religieux pour discréditer Mossadegh, présenté comme un danger communiste</li>
    <li><strong>Corruption parlementaire</strong> — achat de votes de députés et de sénateurs pour provoquer une crise politique</li>
    <li><strong>Mobilisation de foules</strong> — recrutement de voyous et d''agitateurs pour organiser des manifestations anti-Mossadegh à Téhéran</li>
    <li><strong>Complicité militaire</strong> — coordination avec le général Fazlollah Zahedi, choisi pour remplacer Mossadegh</li>
</ul>
<p>Après une première tentative ajournée le 15 août, le coup d''État réussit le 19 août 1953. Mossadegh est arrêté, jugé et condamné à trois ans de prison, suivis d''une assignation à résidence à vie dans son village d''Ahmadabad, où il meurt en 1967.</p>

<h2>Les conséquences immédiates</h2>
<p>Le Shah, qui avait brièvement fui à Rome, revient triomphalement à Téhéran. Un nouveau consortium pétrolier international est formé, accordant 40 % des parts aux compagnies américaines (qui n''avaient aucune présence antérieure en Iran), 40 % à la BP et 20 % à des compagnies françaises et néerlandaises. L''Iran récupère formellement 50 % des bénéfices, mais perd tout contrôle opérationnel sur son industrie pétrolière. Le Shah instaure progressivement un régime autocratique soutenu par les États-Unis, créant la SAVAK en 1957 avec l''aide de la CIA et du Mossad.</p>

<h2>La reconnaissance tardive</h2>
<p>Il faut attendre 2013 pour que la CIA déclassifie officiellement des documents confirmant son rôle dans le coup d''État. En 2000, la secrétaire d''État Madeleine Albright avait reconnu que « le coup d''État était clairement un revers pour le développement politique de l''Iran ». En 2009, Barack Obama évoque brièvement l''épisode de 1953 dans son discours du Caire. Ces gestes restent jugés largement insuffisants par l''opinion publique iranienne.</p>

<h2>Un traumatisme toujours vivant</h2>
<p>L''épisode de 1953 occupe une place centrale dans la mémoire collective iranienne et dans le discours politique du régime actuel. Les dirigeants iraniens y font systématiquement référence pour justifier leur méfiance envers les engagements occidentaux et leur volonté d''indépendance stratégique, y compris en matière nucléaire. Pour de nombreux Iraniens, toutes tendances politiques confondues, le coup d''État de 1953 est la preuve originelle que les puissances occidentales ne respecteront jamais la souveraineté de leur pays.</p>',
    'coup-etat-1953-blessure-originelle-relations-iran-occident',
    'Retour historique sur le coup d''État de 1953 contre Mossadegh : opération Ajax de la CIA et du MI6, nationalisation du pétrole, conséquences et traumatisme durable en Iran.',
    2,
    '/assets/img/uploads/mossadegh-1953-coup-etat-iran.jpg',
    'Le Premier ministre Mohammad Mossadegh s''adressant à la foule devant le Parlement iranien en 1951 lors du vote de nationalisation du pétrole',
    true,
    '2026-03-02 12:00:00',
    '2026-03-15 17:30:00'
);

-- Article 10 — Géopolitique
INSERT INTO articles (title, content, slug, meta_description, type_id, image_path, image_alt, published, created_at, updated_at) VALUES (
    'Israël-Iran : la guerre de l''ombre qui menace d''exploser',
    '<p class="article-lead">Depuis la révolution islamique de 1979, Israël et l''Iran sont engagés dans une confrontation indirecte permanente. Assassinats ciblés, cyberattaques, frappes aériennes en Syrie et guerre par procuration au Liban : cette rivalité souterraine pourrait, selon de nombreux experts, basculer à tout moment en conflit ouvert.</p>

<h2>Les origines de l''antagonisme</h2>
<p>Jusqu''en 1979, Israël et l''Iran entretenaient des relations étroites. Le Shah reconnaissait de facto l''État hébreu (sans reconnaissance diplomatique formelle), et les deux pays coopéraient en matière de renseignement, de défense et d''énergie dans le cadre de la « doctrine de la périphérie » israélienne. La révolution islamique a transformé cette alliance en hostilité absolue : l''ayatollah Khomeini a qualifié Israël de « tumeur cancéreuse » et a fait de la cause palestinienne un pilier rhétorique du régime.</p>

<h2>Le champ de bataille syrien</h2>
<p>Depuis 2013, Israël a mené plus de <strong>300 frappes aériennes</strong> contre des positions iraniennes et du Hezbollah en Syrie. Ces raids, rarement commentés officiellement par Jérusalem, visent à empêcher le transfert d''armes sophistiquées au Hezbollah et l''établissement de bases iraniennes permanentes à proximité du plateau du Golan. L''Iran a subi des pertes significatives, dont plusieurs officiers de haut rang des Gardiens de la Révolution tués en 2024 et 2025.</p>

<h2>La guerre cybernétique</h2>
<p>Le cyberespace est devenu un théâtre majeur de cette confrontation :</p>
<ul>
    <li><strong>Stuxnet (2010)</strong> — virus américano-israélien ayant saboté 1 000 centrifugeuses à Natanz</li>
    <li><strong>Flame (2012)</strong> — logiciel espion ciblant les ordinateurs du ministère iranien du Pétrole</li>
    <li><strong>Attaque contre le port de Shahid Rajaee (2020)</strong> — cyberattaque israélienne perturbant le trafic portuaire de Bandar Abbas</li>
    <li><strong>Riposte iranienne (2021-2025)</strong> — attaques DDoS contre des infrastructures hydrauliques israéliennes, piratage de bases de données gouvernementales et campagnes de désinformation</li>
</ul>

<h2>Le programme d''assassinats ciblés</h2>
<p>Le Mossad est soupçonné d''être derrière une série d''assassinats de scientifiques nucléaires iraniens. Le plus retentissant reste celui de <strong>Mohsen Fakhrizadeh</strong>, considéré comme le « père du programme nucléaire militaire iranien », abattu le 27 novembre 2020 près de Téhéran par une arme télécommandée pilotée par satellite. Depuis 2020, au moins trois autres incidents suspects ont visé des installations nucléaires iraniennes, dont un sabotage à Natanz en avril 2021 ayant détruit des centaines de centrifugeuses avancées IR-6.</p>

<h2>Le Hezbollah : l''épée de Damoclès</h2>
<p>Le Hezbollah libanais, créé et financé par l''Iran depuis 1982, constitue la menace la plus directe pour Israël. L''organisation dispose d''un arsenal estimé à <strong>150 000 roquettes et missiles</strong>, dont certains missiles de précision Fateh-110 capables d''atteindre n''importe quel point du territoire israélien. Le Hezbollah a également renforcé ses capacités en matière de drones et de missiles antinavires, transformant le sud du Liban en une véritable forteresse.</p>

<h2>Le scénario du conflit ouvert</h2>
<p>Les simulations militaires américaines et israéliennes envisagent plusieurs scénarios d''escalade :</p>
<ul>
    <li><strong>Frappe préventive israélienne</strong> sur les installations nucléaires iraniennes (Natanz, Fordow, Ispahan), nécessitant des ravitailleurs en vol et potentiellement un survol de l''espace aérien saoudien</li>
    <li><strong>Riposte iranienne</strong> par des missiles balistiques Shahab-3 et Emad sur le territoire israélien, simultanément à une offensive du Hezbollah depuis le Liban</li>
    <li><strong>Guerre régionale</strong> impliquant les milices pro-iraniennes en Irak et en Syrie, les Houthis au Yémen et potentiellement des attaques sur les bases américaines dans la région</li>
</ul>
<p>Les analystes estiment qu''un tel conflit pourrait faire des <strong>dizaines de milliers de victimes</strong> en quelques semaines et provoquer une crise pétrolière mondiale majeure.</p>',
    'israel-iran-guerre-ombre-menace-exploser',
    'Analyse de la confrontation Israël-Iran : frappes en Syrie, cyberguerre, assassinats ciblés, arsenal du Hezbollah et scénarios de conflit ouvert au Moyen-Orient.',
    1,
    '/assets/img/uploads/israel-iran-guerre-ombre-missiles.jpg',
    'Système de défense antimissile Dôme de Fer israélien interceptant des roquettes au-dessus de Tel-Aviv lors d''une attaque nocturne',
    true,
    '2026-03-25 09:00:00',
    '2026-03-29 11:00:00'
);

-- ============================================================
-- IMAGES — Galeries associées aux articles
-- ============================================================

-- Galerie Article 1 (Géopolitique)
INSERT INTO images (article_id, path, alt_text) VALUES
(1, '/assets/img/uploads/detruit-ormuz-vue-aerienne.jpg', 'Vue aérienne du détroit d''Ormuz montrant le trafic maritime de pétroliers entre l''Iran et Oman'),
(1, '/assets/img/uploads/centrifugeuses-natanz.jpg', 'Intérieur de l''installation d''enrichissement d''uranium de Natanz, montrant des rangées de centrifugeuses IR-2m'),
(1, '/assets/img/uploads/carte-alliances-iraniennes.jpg', 'Carte infographique des alliances régionales de l''Iran : Hezbollah, milices irakiennes, Houthis et forces en Syrie');

-- Galerie Article 2 (Histoire)
INSERT INTO images (article_id, path, alt_text) VALUES
(2, '/assets/img/uploads/shah-pahlavi-exil-1979.jpg', 'Le Shah Mohammad Reza Pahlavi et l''impératrice Farah quittant l''Iran le 16 janvier 1979'),
(2, '/assets/img/uploads/otages-ambassade-teheran.jpg', 'Étudiants iraniens présentant des otages américains devant l''ambassade des États-Unis à Téhéran en novembre 1979'),
(2, '/assets/img/uploads/guerre-iran-irak-soldats.jpg', 'Soldats iraniens dans les tranchées lors de la bataille de Khorramshahr pendant la guerre Iran-Irak en 1982');

-- Galerie Article 3 (Humanitaire)
INSERT INTO images (article_id, path, alt_text) VALUES
(3, '/assets/img/uploads/pharmacie-tehran-penurie.jpg', 'Étagères vides dans une pharmacie hospitalière de Téhéran illustrant la pénurie de médicaments due aux sanctions'),
(3, '/assets/img/uploads/lac-ourmia-assechement.jpg', 'Comparaison satellite du lac d''Ourmia entre 1995 et 2025 montrant la perte de 80 % de sa surface'),
(3, '/assets/img/uploads/manifestation-mahsa-amini.jpg', 'Manifestantes iraniennes brandissant des pancartes lors du mouvement Femme Vie Liberté en septembre 2022 à Téhéran');

-- Galerie Article 4 (Économie)
INSERT INTO images (article_id, path, alt_text) VALUES
(4, '/assets/img/uploads/rial-iranien-inflation.jpg', 'Bureau de change à Téhéran affichant le taux du dollar en rials iraniens, illustrant l''effondrement de la monnaie'),
(4, '/assets/img/uploads/bazaar-teheran-commerce.jpg', 'Grand Bazar de Téhéran : marchands de tapis discutant de l''impact des sanctions sur le commerce'),
(4, '/assets/img/uploads/pasdaran-khatam-construction.jpg', 'Chantier de construction du métro de Téhéran par Khatam al-Anbiya, conglomérat des Gardiens de la Révolution');

-- Galerie Article 5 (Chronologie)
INSERT INTO images (article_id, path, alt_text) VALUES
(5, '/assets/img/uploads/soleimani-funerailles-2020.jpg', 'Des millions d''Iraniens lors des funérailles du général Qassem Soleimani à Kerman en janvier 2020'),
(5, '/assets/img/uploads/accord-vienne-jcpoa-2015.jpg', 'Les ministres des Affaires étrangères du P5+1 et de l''Iran lors de la signature du JCPOA à Vienne le 14 juillet 2015');

-- Galerie Article 7 (Réfugiés afghans)
INSERT INTO images (article_id, path, alt_text) VALUES
(7, '/assets/img/uploads/refugies-afghans-ecole-teheran.jpg', 'Classe d''une école publique en banlieue de Téhéran accueillant des enfants afghans réfugiés'),
(7, '/assets/img/uploads/ouvriers-afghans-construction.jpg', 'Ouvriers afghans sur un chantier de construction à Ispahan, l''un des rares secteurs d''emploi qui leur est accessible');

-- Galerie Article 10 (Israël-Iran)
INSERT INTO images (article_id, path, alt_text) VALUES
(10, '/assets/img/uploads/frappe-aerienne-syrie-israel.jpg', 'Explosion nocturne à proximité de Damas suite à une frappe aérienne israélienne visant un dépôt d''armes iranien'),
(10, '/assets/img/uploads/drone-shahed-136.jpg', 'Drone kamikaze iranien Shahed-136 exposé lors d''un défilé militaire à Téhéran'),
(10, '/assets/img/uploads/hezbollah-arsenal-missiles.jpg', 'Infographie montrant la portée des différents missiles du Hezbollah capables d''atteindre le territoire israélien');

