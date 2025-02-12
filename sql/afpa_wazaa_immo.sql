DROP DATABASE IF EXISTS afpa_wazaa_immo;
CREATE DATABASE IF NOT EXISTS afpa_wazaa_immo;

USE afpa_wazaa_immo;

CREATE TABLE IF NOT EXISTS waz_options(
   opt_id INT AUTO_INCREMENT,
   opt_libelle VARCHAR(100) ,
   PRIMARY KEY(opt_id)
);

INSERT INTO `waz_options` (`opt_id`, `opt_libelle`) VALUES
(1, 'Jardin'),
(2, 'Garage'),
(3, 'Parking'),
(4, 'Piscine'),
(5, 'Combles aménageables'),
(6, 'Cuisine ouverte'),
(7, 'Sans travaux'),
(8, 'Avec travaux'),
(9, 'Cave'),
(10, 'Plain-pied'),
(11, 'Ascenseur'),
(12, 'Terrasse/balcon'),
(13, 'Cheminée');

CREATE TABLE IF NOT EXISTS waz_type_utilisateur(
   tu_id INT AUTO_INCREMENT,
   tu_libelle VARCHAR(50)  NOT NULL,
   PRIMARY KEY(tu_id)
);

INSERT INTO `waz_type_utilisateur` (`tu_id`, `tu_libelle`) VALUES
(1, 'admin'),
(2, 'employé');

CREATE TABLE waz_type_annonce(
   ta_id INT AUTO_INCREMENT,
   ta_libelle VARCHAR(50)  NOT NULL,
   PRIMARY KEY(ta_id)
);
INSERT INTO `waz_type_annonce` (`ta_id`, `ta_libelle`) VALUES
(1, 'maison'),
(2, 'appartement'),
(3, 'immeuble'),
(4, 'garage'),
(5, 'terrain'),
(6, 'locaux professionnels'),
(7, 'bureaux'),
(8, 'studio');

CREATE TABLE IF NOT EXISTS waz_utilisateur(
   u_id INT AUTO_INCREMENT,
   u_email VARCHAR(50)  NOT NULL,
   u_password VARCHAR(50)  NOT NULL,
   tu_id INT NOT NULL,
   PRIMARY KEY(u_id),
   FOREIGN KEY(tu_id) REFERENCES waz_type_utilisateur(tu_id)
);
INSERT INTO `waz_utilisateur` (`u_id`, `u_email`, `u_password`, `tu_id`) VALUES
(1, 'placeholder@test.com', 'placeholder', 1);

CREATE TABLE waz_annonces(
   an_id INT AUTO_INCREMENT,
   an_offre VARCHAR(1)  NOT NULL,
   an_pieces INT,
   an_titre VARCHAR(200)  NOT NULL,
   an_ref VARCHAR(10)  NOT NULL,
   an_description TEXT NOT NULL,
   an_local VARCHAR(100) ,
   an_surf_hab INT,
   an_surf_tot INT NOT NULL,
   an_prix VARCHAR(13) ,
   an_diagnostic VARCHAR(1)  NOT NULL,
   an_d_ajout DATE NOT NULL,
   an_d_modif DATETIME,
   an_statut BOOLEAN NOT NULL,
   an_vues INT NOT NULL,
   ta_id INT NOT NULL,
   u_id INT NOT NULL,
   PRIMARY KEY(an_id),
   FOREIGN KEY(ta_id) REFERENCES waz_type_annonce(ta_id),
   FOREIGN KEY(u_id) REFERENCES waz_utilisateur(u_id)
);


INSERT INTO `waz_annonces` (`an_id`, `an_offre`, `an_pieces`, `an_ref`, `an_titre`, `an_description`, `an_local`, `an_surf_hab`, `an_surf_tot`, `an_prix`, `an_diagnostic`, `an_d_ajout`, `an_d_modif`, `an_statut`, `an_vues`, `ta_id`, `u_id`) VALUES
(1, 'A', 5, '20A100', '100 km de Paris, maison 85m2 avec jardin', 'Exclusivité : dans bourg tous commerces avec écoles, maison d\'environ 85m2 habitables, mitoyenne, offrant en rez-de-chaussée, une cuisine aménagée, un salon-séjour, un WC et une loggia et à l\'étage, 3 chambres dont 2 avec placard, salle de bains et WC séparé. 2 garages. Le tout sur une parcelle de 225m2. Chauffage individuel clim réversible, DPE : F. ', 'Somme (80), 1h00 de Paris', 85, 225, 197000, 'F', '2020-11-13', NULL, true, 0, 1, 1);

CREATE TABLE IF NOT EXISTS waz_photos(
   pht_id INT AUTO_INCREMENT,
   pht_libelle VARCHAR(50) ,
   an_id INT NOT NULL,
   PRIMARY KEY(pht_id),
   FOREIGN KEY(an_id) REFERENCES waz_annonces(an_id)
);

INSERT INTO `waz_photos` (`pht_id`, `pht_libelle`, `an_id`) VALUES
(1, "1-1.jpg", 1),
(2, "1-2.jpg", 1);

CREATE TABLE IF NOT EXISTS waz_opt_annonces(
   an_id INT,
   opt_id INT,
   PRIMARY KEY(an_id, opt_id),
   FOREIGN KEY(an_id) REFERENCES waz_annonces(an_id),
   FOREIGN KEY(opt_id) REFERENCES waz_options(opt_id)
);
