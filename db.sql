--
-- Test Database : 'quizzy'
--

--
-- ------------------------------------------------------------------------------
--

--
-- Re-initializes tables
--
DROP TABLE IF EXISTS choice;

DROP TABLE IF EXISTS question;

DROP TABLE IF EXISTS author;

DROP TABLE IF EXISTS theme;

--
-- Table Structure 'question'
--
CREATE TABLE question ( id INT NOT NULL AUTO_INCREMENT PRIMARY KEY, question VARCHAR(200) NOT NULL, theme_id INT DEFAULT 1, author_id INT DEFAULT 1);

--
-- Table Structure 'choice'
--
CREATE TABLE choice ( id INT NOT NULL AUTO_INCREMENT PRIMARY KEY, answer VARCHAR(100) NOT NULL, validity BOOL NOT NULL, question_id INT);

--
-- Table Structure 'author'
--
CREATE TABLE author ( id INT NOT NULL AUTO_INCREMENT PRIMARY KEY, name VARCHAR(100) NOT NULL, password VARCHAR(255) NOT NULL);

--
-- Table Structure 'theme'
--
CREATE TABLE theme ( id INT NOT NULL AUTO_INCREMENT PRIMARY KEY, title VARCHAR(20) NOT NULL);

--
-- Add foreign key to link 'question' and 'choice'
--
ALTER TABLE choice ADD CONSTRAINT fk_choice_question FOREIGN KEY (question_id) REFERENCES question(id) ON DELETE CASCADE;

--
-- Add foreign key to link 'author' and 'question'
--
ALTER TABLE question ADD CONSTRAINT fk_question_author FOREIGN KEY (author_id) REFERENCES author(id);

--
-- Add foreign key to link 'theme' and 'question'
--
ALTER TABLE question ADD CONSTRAINT fk_question_theme FOREIGN KEY (theme_id) REFERENCES theme(id);

--
-- Table 'theme' : test content
--
INSERT INTO theme (title) VALUES ("Culture Gé");

--
-- Table 'author' : test content
--
INSERT INTO author (name , password) VALUES ("Quizzy" , "Quizzy");

--
-- Table 'question' : test content
--
INSERT INTO question (question) VALUES ("Les chaussettes de l'archiduchesse sont-elles sèches?");

INSERT INTO question (question) VALUES ("Pourquoi?");

INSERT INTO question (question) VALUES ("0+0=?");

INSERT INTO question (question) VALUES ("Quelle est la capitale du Venezuela?");

INSERT INTO question (question) VALUES ("Il va faire tout noir!");

INSERT INTO question (question) VALUES ("C'est une bonne situation ça scribe?");

INSERT INTO question (question) VALUES ("Le 12e anniversiare de mariage s'appelle les noces de...");

INSERT INTO question (question) VALUES ("Quel est le groupe ou l'artiste qui a vendu à ce jour (29/09/2020) le plus de disques au monde?");

INSERT INTO question (question) VALUES ("Quel est l'élément numéro 83 du tableau périodique?");

INSERT INTO question (question) VALUES ("Quelle est la réponse à la vie, l'univers, et tout le reste?");

--
-- Table 'choice' : test content
--
INSERT INTO choice (answer, validity, question_id) VALUES ("Oui" , TRUE , 1);

INSERT INTO choice (answer, validity, question_id) VALUES ("Archi-sèches" , TRUE , 1);

INSERT INTO choice (answer, validity, question_id) VALUES ("Non" , FALSE , 1);

INSERT INTO choice (answer, validity, question_id) VALUES ("Parce-que" , TRUE , 2);

INSERT INTO choice (answer, validity, question_id) VALUES ("Pour quoi." , TRUE , 2);

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

INSERT INTO choice (answer, validity, question_id) VALUES ("???" , FALSE , 5);

INSERT INTO choice (answer, validity, question_id) VALUES ("La nuit?.." , FALSE , 5);

INSERT INTO choice (answer, validity, question_id) VALUES ("TA GUEULE!" , TRUE , 5);

INSERT INTO choice (answer, validity, question_id) VALUES ("Oui" , FALSE , 6);

INSERT INTO choice (answer, validity, question_id) VALUES ("Non" , FALSE , 6);

INSERT INTO choice (answer, validity, question_id) VALUES ("Vous savez, moi je ne crois pas qu’il y ait de bonne ou de mauvaise situation..." , TRUE , 6);

INSERT INTO choice (answer, validity, question_id) VALUES ("Ne se prononce pas" , FALSE , 6);

INSERT INTO choice (answer, validity, question_id) VALUES ("Bronze" , FALSE , 7);

INSERT INTO choice (answer, validity, question_id) VALUES ("Corail" , FALSE , 7);

INSERT INTO choice (answer, validity, question_id) VALUES ("Crêpe" , FALSE , 7);

INSERT INTO choice (answer, validity, question_id) VALUES ("Soie" , TRUE , 7);

INSERT INTO choice (answer, validity, question_id) VALUES ("Eau" , FALSE , 7);

INSERT INTO choice (answer, validity, question_id) VALUES ("Michael Jackson" , FALSE , 8);

INSERT INTO choice (answer, validity, question_id) VALUES ("The Beatles" , TRUE , 8);

INSERT INTO choice (answer, validity, question_id) VALUES ("Queen" , FALSE , 8);

INSERT INTO choice (answer, validity, question_id) VALUES ("Rihanna" , FALSE , 8);

INSERT INTO choice (answer, validity, question_id) VALUES ("Bismuth" , TRUE , 9);

INSERT INTO choice (answer, validity, question_id) VALUES ("Uranium" , FALSE , 9);

INSERT INTO choice (answer, validity, question_id) VALUES ("Bronze" , FALSE , 9);

INSERT INTO choice (answer, validity, question_id) VALUES ("Vibranium" , TRUE , 9);

INSERT INTO choice (answer, validity, question_id) VALUES ("Hydrogène" , FALSE , 9);

INSERT INTO choice (answer, validity, question_id) VALUES ("Ultimatum" , FALSE , 9);

INSERT INTO choice (answer, validity, question_id) VALUES ("L'amour <3" , FALSE , 10);

INSERT INTO choice (answer, validity, question_id) VALUES ("La paix dans le monde ^.^" , FALSE , 10);

INSERT INTO choice (answer, validity, question_id) VALUES ("La réponse D" , TRUE , 10);

INSERT INTO choice (answer, validity, question_id) VALUES ("42" , TRUE , 10);