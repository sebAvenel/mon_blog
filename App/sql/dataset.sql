INSERT INTO users
	(name, password, email, role, keyActivate, isActivate)
VALUES
	('melron14', 'cdcyducvjn', 'sebastien.avenel@outlook.fr', 'admin', 'f71c8cb7bba3eb44adb7f3aefd6bc89c', 1),
	('gro67', 'GYuhuhr65g', 'sebastien.azel@outlook.fr', 'user', '381b53b707cd5b716d6cf23de70e7b43', 1),
	('Jambon78', 'htdBHU76nj', 'sebastien.leroy@gmail.com', 'user', '0c157435771446f7f6de1b088f0b176e', 1),
	('marka23', 'HJyut67FFG', 'jb.lepoitevin@hotmail.fr', 'user', '507b06616f94c0c6a1d29cc4419b7889', 1),
	('julius09', 'GThy6h8KI', 'ma.dan@gmail.com', 'user', '1f5689246679276218d32c5917e80cd0', 1);
	
INSERT INTO blog_post
	(title, chapo, content, createdAt, updatedAt, idUser)
VALUES
	('mon premier post', 'mon premier chapo', 'contenu de mon premier post...', NOW(), NOW(), 1),
	('mon deuxième post', 'mon deuxième chapo', 'contenu de mon deuxième post...', NOW(), NOW(), 1 ),
	('mon troisième post', 'mon troisième chapo', 'contenu de mon troisième post...', NOW(), NOW(), 1),
	('mon quatrième post', 'mon quatrième chapo', 'contenu de mon quatrième post...', NOW(), NOW(), 1),
	('mon cinquième post', 'mon cinquième chapo', 'contenu de mon cinquième post...', NOW(), NOW(), 1);
	
INSERT INTO comment
	(content, createdAt, updatedAt, isValid, idBlogPost, idUser)
VALUES
	('mon premier commentaire', NOW(), NOW(), 1, 2, 1),
	('mon deuxième commentaire', NOW(), NOW(), 0, 1, 2),
	('mon troisième commentaire', NOW(), NOW(), 1, 4, 3),
	('mon quatrième commentaire', NOW(), NOW(), 0, 3, 5),
	('mon cinquième commentaire', NOW(), NOW(), 0, 5, 3),
	('mon sixième commentaire', NOW(), NOW(), 1, 2, 3),
	('mon septième commentaire', NOW(), NOW(), 0, 1, 4),
	('mon huitième commentaire', NOW(), NOW(), 1, 4, 1),
	('mon neuvième commentaire', NOW(), NOW(), 0, 3, 2),
	('mon dixième commentaire', NOW(), NOW(), 1, 5, 4),
	('mon onzième commentaire', NOW(), NOW(), 1, 2, 5),
	('mon douzième commentaire', NOW(), NOW(), 0, 1, 5),
	('mon treizième commentaire', NOW(), NOW(), 1, 4, 2),
	('mon quatorzième commentaire', NOW(), NOW(), 0, 3, 1),
	('mon quinzième commentaire', NOW(), NOW(), 1, 5, 1);
