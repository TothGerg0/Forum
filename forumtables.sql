CREATE DATABASE forum
	CHARACTER SET utf8
	COLLATE utf8_general_ci;

USE forum;

CREATE TABLE users(
  id int(8) NOT NULL AUTO_INCREMENT,
  username varchar(30) NOT NULL UNIQUE,
  PRIMARY KEY (id)
  );

-- CREATE TABLE images(
--   id int(8) NOT NULL AUTO_INCREMENT,
--   image varchar(200),
--   PRIMARY KEY (id)
--   
--   );

CREATE TABLE topics(
  id int(8) NOT NULL AUTO_INCREMENT,
  topicsubject varchar(255) NOT NULL,
  user_id int(8) NOT NULL,
  topicdate timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (id),
  CONSTRAINT fk_user_id FOREIGN KEY (user_id)
  REFERENCES users(id)
  );

CREATE TABLE posts(
  id int(8) NOT NULL AUTO_INCREMENT,
  content text NOT NULL,
  topic_id int(8) NOT NULL,
  user_id int(8) NOT NULL,
  -- image_id int(8),
  image varchar(255) NULL,
  postdate timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (id),
  CONSTRAINT fk_topic_id FOREIGN KEY (topic_id)
  REFERENCES topics(id), 
  CONSTRAINT fk_user_id2 FOREIGN KEY (user_id)
  REFERENCES users(id)

  );
