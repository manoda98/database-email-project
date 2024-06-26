CREATE DATABASE test;

USE test;

CREATE TABLE EMAIL (
	id INT(11) UNSIGNED AUTO_INCREMENT PRIMARY KEY,
	sender VARCHAR(30) NOT NULL,
	receiver VARCHAR(30) NOT NULL,
	subject VARCHAR(30) NOT NULL,
	message VARCHAR(1000) NOT NULL,
	date TIMESTAMP NOT NULL
);

ALTER TABLE `EMAIL` ADD `cc` VARCHAR(30) NOT NULL AFTER `date`, ADD `bcc` VARCHAR(30) NOT NULL AFTER `cc`;

CREATE TABLE CATEGORY (
    category_id INT(11) UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    category_type VARCHAR(50) NOT NULL,
    colour VARCHAR(100) NOT NULL
);

CREATE TABLE EMAIL_CATEGORY (
    email_category_id INT(11) UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    email_id INT(11) UNSIGNED,
    FOREIGN KEY (email_id) REFERENCES EMAIL(id),
    category_id INT(11) UNSIGNED,
    FOREIGN KEY (category_id) REFERENCES CATEGORY(category_id)
);
CREATE INDEX sender_index ON EMAIL (sender);
