CREATE DATABASE  cookbook;
USE utilisateurs;
CREATE TABLE  utilisateurs (
 id int(255) unsigned NOT NULL AUTO_INCREMENT,
    nom varchar(50) DEFAULT NULL,
    prenom varchar(50) DEFAULT NULL,
    mail varchar(191) DEFAULT NULL,
    mdp text,
    date_creation_compte datetime DEFAULT NULL,
    n_mdp int(1) DEFAULT (0), ================================================= Permet de savoir si on a fait une demande de mot de passe =================================
    PRIMARY KEY (id),
    UNIQUE KEY mail (mail)
);




