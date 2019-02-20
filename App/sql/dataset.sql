INSERT INTO user
	(name, password, email, role)
VALUES
	('melron14', 'cdcyducvjn', 'sebastien.avenel@outlook.fr', 'admin'),
	('gro67', 'GYuhuhr65g', 'sebastien.azel@outlook.fr', 'user' ),
	('Jambon78', 'htdBHU76nj', 'sebastien.leroy@gmail.com', 'user'),
	('marka23', 'HJyut67FFG', 'jb.lepoitevin@hotmail.fr', 'user'),
	('julius09', 'GThy6h8KI', 'ma.dan@gmail.com', 'user');
	
INSERT INTO blog_post
	(title, chapo, content, created_at, updated_at, id_user)
VALUES
	('mon premier post', 'mon premier chapo', 'contenu de mon premier post...', NOW(), NOW(), 1),
	('mon deuxième post', 'mon deuxième chapo', 'contenu de mon deuxième post...', NOW(), NOW(), 1 ),
	('mon troisième post', 'mon troisième chapo', 'contenu de mon troisième post...', NOW(), NOW(), 1),
	('mon quatrième post', 'mon quatrième chapo', 'contenu de mon quatrième post...', NOW(), NOW(), 1),
	('mon cinquième post', 'mon cinquième chapo', 'contenu de mon cinquième post...', NOW(), NOW(), 1);
	
INSERT INTO comment
	(content, created_at, updated_at, is_valid, id_blog_post, id_user)
VALUES
	('mon premier commentaire', NOW(), NOW(), 1, 2, 2),
	('mon deuxième commentaire', NOW(), NOW(), 0, 1, 3),
	('mon troisième commentaire', NOW(), NOW(), 1, 4, 4),
	('mon quatrième commentaire', NOW(), NOW(), 0, 3, 5),
	('mon cinquième commentaire', NOW(), NOW(), 0, 5, 3),
	('mon sixième commentaire', NOW(), NOW(), 1, 2, 2),
	('mon septième commentaire', NOW(), NOW(), 0, 1, 3),
	('mon huitième commentaire', NOW(), NOW(), 1, 4, 4),
	('mon neuvième commentaire', NOW(), NOW(), 0, 3, 5),
	('mon dixième commentaire', NOW(), NOW(), 1, 5, 3),
	('mon onzième commentaire', NOW(), NOW(), 1, 2, 2),
	('mon douzième commentaire', NOW(), NOW(), 0, 1, 3),
	('mon treizième commentaire', NOW(), NOW(), 1, 4, 4),
	('mon quatorzième commentaire', NOW(), NOW(), 0, 3, 5),
	('mon quinzième commentaire', NOW(), NOW(), 1, 5, 3);
