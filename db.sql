--
-- DON'T IMPORT YET : this will only serve testing purposes in later developpment stages of Quizzy
--

--
-- Base de donnée tests : 'quizzy'
--

--
-- ------------------------------------------------------------------------------
--

--
-- Structure de la table 'question'
--
CREATE TABLE question ( id INT NOT NULL AUTO_INCREMENT PRIMARY KEY, question VARCHAR(200) NOT NULL, theme_id INT, author_id INT);

--
-- Structure de la table 'choice'
--
CREATE TABLE choice ( id INT NOT NULL AUTO_INCREMENT PRIMARY KEY, answer VARCHAR(50) NOT NULL, validity BOOL NOT NULL, question_id INT);

--
-- Structure de la table 'author'
--
CREATE TABLE author ( id INT NOT NULL AUTO_INCREMENT PRIMARY KEY, name VARCHAR(100) NOT NULL, password VARCHAR(255) NOT NULL);

--
-- Structure de la table 'theme'
--
CREATE TABLE theme ( id INT NOT NULL AUTO_INCREMENT PRIMARY KEY, title VARCHAR(20) NOT NULL);

--
-- Ajout de foreign key pour lier 'question' et 'choice'
--
ALTER TABLE choice ADD CONSTRAINT fk_choice_question FOREIGN KEY (question_id) REFERENCES question(id) ON DELETE CASCADE;

--
-- Contenu de base de la table 'question' pour les tests
--
INSERT INTO question (question) VALUES ("Les chaussettes de l'archiduchesse sont-elles sèches?");

INSERT INTO question (question) VALUES ("Pourquoi?");

INSERT INTO question (question) VALUES ("0+0=?");

INSERT INTO question (question) VALUES ("Quelle est la capitale du Venezuela?");

--
-- Contenu de base de la table 'choice' pour les tests
--
INSERT INTO choice (answer, validity, question_id) VALUES ("Oui" , TRUE , 1);

INSERT INTO choice (answer, validity, question_id) VALUES ("Archi-sèches" , TRUE , 1);

INSERT INTO choice (answer, validity, question_id) VALUES ("Non" , FALSE , 1);

INSERT INTO choice (answer, validity, question_id) VALUES ("Parce-que" , TRUE , 2);

INSERT INTO choice (answer, validity, question_id) VALUES ("42" , TRUE , 2);

INSERT INTO choice (answer, validity, question_id) VALUES ("Je sais pô..." , FALSE , 2);

INSERT INTO choice (answer, validity, question_id) VALUES ("0" , TRUE , 3);

INSERT INTO choice (answer, validity, question_id) VALUES ("La tête à Toto" , TRUE , 3);

INSERT INTO choice (answer, validity, question_id) VALUES ("78" , FALSE , 3);

INSERT INTO choice (answer, validity, question_id) VALUES ("False" , TRUE , 3);

INSERT INTO choice (answer, validity, question_id) VALUES ("Paris" , FALSE , 4);

INSERT INTO choice (answer, validity, question_id) VALUES ("Londres" , FALSE , 4);

INSERT INTO choice (answer, validity, question_id) VALUES ("Pékin" , FALSE , 4);

INSERT INTO choice (answer, validity, question_id) VALUES ("Caracas" , TRUE , 4);

INSERT INTO choice (answer, validity, question_id) VALUES ("Montevideo" , FALSE , 4);

INSERT INTO choice (answer, validity, question_id) VALUES ("Moscou" , FALSE , 4);