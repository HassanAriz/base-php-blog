CREATE TABLE users
(
	id INT NOT NULL AUTO_INCREMENT,
	username VARCHAR(20) NOT NULL UNIQUE,
	password VARCHAR(60) NOT NULL,
	PRIMARY KEY (id)
);

CREATE TABLE article
(
	id INT NOT NULL AUTO_INCREMENT,
	title VARCHAR(50) NOT NULL,
	content TEXT NOT NULL,
  author VARCHAR(22) NOT NULL,
	image VARCHAR (255) NOT NULL,
	PRIMARY KEY (id),
	FOREIGN KEY(author) REFERENCE user(username)
);

CREATE TABLE comments
(
	id INT NOT NULL AUTO_INCREMENT,
	username VARCHAR(20) NOT NULL,
	content TEXT NOT NULL,
	article INT NOT NULL,
	PRIMARY KEY (id),
	FOREIGN KEY(article) REFERENCE article(id)
);