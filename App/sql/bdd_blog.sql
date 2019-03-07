DROP TABLE IF EXISTS comment;
DROP TABLE IF EXISTS blog_post;
DROP TABLE IF EXISTS user;

CREATE TABLE user (
                id INT AUTO_INCREMENT NOT NULL,
                name VARCHAR(25) NOT NULL,
                password VARCHAR(100) NOT NULL,
                email VARCHAR(50) NOT NULL,
                role VARCHAR(25) NOT NULL,
                keyActivate VARCHAR(40) NOT NULL,
                isActivate BOOLEAN NOT NULL,
                PRIMARY KEY (id),
                UNIQUE KEY (email)
);


CREATE TABLE blog_post (
                id INT AUTO_INCREMENT NOT NULL,
                title VARCHAR(75) NOT NULL,
                chapo VARCHAR(200) NOT NULL,
                content VARCHAR(5000) NOT NULL,
                createdAt DATETIME NOT NULL,
                updatedAt DATETIME NOT NULL,
                idUser INT NOT NULL,
                PRIMARY KEY (id)
);


CREATE TABLE comment (
                id INT AUTO_INCREMENT NOT NULL,
                content VARCHAR(500) NOT NULL,
                createdAt DATETIME NOT NULL,
                updatedAt DATETIME NOT NULL,
                isValid BOOLEAN NOT NULL,
                idBlogPost INT NOT NULL,
                idUser INT NOT NULL,
                PRIMARY KEY (id)
);


ALTER TABLE blog_post ADD CONSTRAINT user_blog_post_fk
FOREIGN KEY (idUser)
REFERENCES user (id)
ON DELETE NO ACTION
ON UPDATE NO ACTION;

ALTER TABLE comment ADD CONSTRAINT user_comment_fk
FOREIGN KEY (idUser)
REFERENCES user (id)
ON DELETE NO ACTION
ON UPDATE NO ACTION;

ALTER TABLE comment ADD CONSTRAINT blog_post_comment_fk
FOREIGN KEY (idBlogPost)
REFERENCES blog_post (id)
ON DELETE NO ACTION
ON UPDATE NO ACTION;
