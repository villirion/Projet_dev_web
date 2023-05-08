# Projet_dev_web
Projet dev web

SQL table:

CREATE TABLE utilisateurs (
   id int(10) unsigned NOT NULL auto_increment,
   nom varchar(255) NOT NULL,
   prenom varchar(255) NOT NULL,
   email varchar(255) NOT NULL,
   pass varchar(255) NOT NULL,
   BMR int(10) NOT NULL,
   PRIMARY KEY (id)
);

CREATE TABLE repas(
   id int(10) unsigned NOT NULL auto_increment,
   food_name varchar(255) NOT NULL,
   food_calorie int(10) NOT NULL,
   food_date date NOT NULL,
   user_id int(10) NOT NULL,
   PRIMARY KEY (id)
);
