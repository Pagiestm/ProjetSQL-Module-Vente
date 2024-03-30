-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Hôte : 127.0.0.1:3306
-- Généré le : sam. 30 mars 2024 à 13:42
-- Version du serveur : 8.2.0
-- Version de PHP : 8.2.13

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de données : `vente`
--

DELIMITER $$
--
-- Procédures
--
DROP PROCEDURE IF EXISTS `afficherBon_de_Livraisons`$$
CREATE DEFINER=`root`@`localhost` PROCEDURE `afficherBon_de_Livraisons` ()   BEGIN 
         SELECT * FROM vente.Bon_de_Livraisons;
   END$$

DROP PROCEDURE IF EXISTS `creerBon_de_Livraisons`$$
CREATE DEFINER=`root`@`localhost` PROCEDURE `creerBon_de_Livraisons` (IN `l_Adresse` VARCHAR(50), IN `l_Date_Livraison` DATE, IN `l_Numero_Livraison` VARCHAR(25))   BEGIN 
      INSERT INTO vente.Bon_de_Livraisons (`Adresse`, `Date_Livraison`, `Numero_Livraison`) VALUES
      (l_Adresse, l_Date_Livraison, l_Numero_Livraison);
   END$$

DROP PROCEDURE IF EXISTS `modifierBon_de_Livraisons`$$
CREATE DEFINER=`root`@`localhost` PROCEDURE `modifierBon_de_Livraisons` (IN `l_id_Livraison` INT, IN `l_Adresse` VARCHAR(50), IN `l_Date_Livraison` DATE, IN `l_Numero_Livraison` VARCHAR(25))   BEGIN 
      UPDATE vente.Bon_de_Livraisons 
      SET Adresse = l_Adresse, 
          Date_Livraison = l_Date_Livraison, 
          Numero_Livraison = l_Numero_Livraison  
      WHERE id_Livraison = l_id_Livraison;
   END$$

DROP PROCEDURE IF EXISTS `PasserCommande`$$
CREATE DEFINER=`root`@`localhost` PROCEDURE `PasserCommande` (IN `idProduit` INT, IN `quantiteCommande` INT)   BEGIN
   DECLARE stockDisponible INT;

   SELECT quantite_dispo INTO stockDisponible
   FROM stock s
   WHERE s.fk_produit = idProduit;

   IF quantiteCommande <= stockDisponible THEN
      INSERT INTO commandes (Date_Commande, Montant_Total, Quantite_Total, Statut, id_produit)
      VALUES (NOW(), (SELECT prix_unitaire FROM produit WHERE id = idProduit) * quantiteCommande, quantiteCommande, 'En attente', idProduit);

      SELECT 'Commande passée avec succès.' AS message;
    ELSE
      SELECT 'La quantité commandée est supérieure au stock disponible.' AS message;
    END IF;
END$$

DROP PROCEDURE IF EXISTS `supprimerBon_de_Livraisons`$$
CREATE DEFINER=`root`@`localhost` PROCEDURE `supprimerBon_de_Livraisons` (IN `l_id_Livraison` INT)   BEGIN 
      DELETE FROM vente.Bon_de_Livraisons WHERE id_Livraison = l_id_Livraison;
   END$$

DELIMITER ;

-- --------------------------------------------------------

--
-- Structure de la table `alertes`
--

DROP TABLE IF EXISTS `alertes`;
CREATE TABLE IF NOT EXISTS `alertes` (
  `id_Alerte` int NOT NULL AUTO_INCREMENT,
  `Message` varchar(50) NOT NULL,
  `Date_Alerte` date NOT NULL,
  `fk_Commande` int NOT NULL,
  PRIMARY KEY (`id_Alerte`)
) ENGINE=InnoDB AUTO_INCREMENT=19 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Déchargement des données de la table `alertes`
--

INSERT INTO `alertes` (`id_Alerte`, `Message`, `Date_Alerte`, `fk_Commande`) VALUES
(18, 'La commande 25 est supérieure à 3000€.', '2024-03-30', 25);

-- --------------------------------------------------------

--
-- Structure de la table `bon_de_livraisons`
--

DROP TABLE IF EXISTS `bon_de_livraisons`;
CREATE TABLE IF NOT EXISTS `bon_de_livraisons` (
  `id_Livraison` int NOT NULL AUTO_INCREMENT,
  `Adresse` varchar(50) NOT NULL,
  `Date_Livraison` date NOT NULL,
  `Numero_Livraison` varchar(25) NOT NULL,
  PRIMARY KEY (`id_Livraison`)
) ENGINE=InnoDB AUTO_INCREMENT=17 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Déchargement des données de la table `bon_de_livraisons`
--

INSERT INTO `bon_de_livraisons` (`id_Livraison`, `Adresse`, `Date_Livraison`, `Numero_Livraison`) VALUES
(15, '56 rue de la paix, Paris', '2024-04-27', 'GHTY6789'),
(16, '67 rue de l\'église, Valenciennes', '2024-03-28', 'FDTR5640');

-- --------------------------------------------------------

--
-- Structure de la table `commandes`
--

DROP TABLE IF EXISTS `commandes`;
CREATE TABLE IF NOT EXISTS `commandes` (
  `id_Commande` int NOT NULL AUTO_INCREMENT,
  `Date_Commande` date NOT NULL,
  `Montant_Total` decimal(25,2) NOT NULL,
  `Quantite_Total` varchar(25) NOT NULL,
  `Statut` varchar(15) NOT NULL,
  `id_produit` int DEFAULT NULL,
  PRIMARY KEY (`id_Commande`),
  KEY `id_produit` (`id_produit`)
) ENGINE=InnoDB AUTO_INCREMENT=26 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Déchargement des données de la table `commandes`
--

INSERT INTO `commandes` (`id_Commande`, `Date_Commande`, `Montant_Total`, `Quantite_Total`, `Statut`, `id_produit`) VALUES
(22, '2024-03-30', 50.00, '5', 'En attente', 1),
(23, '2024-03-30', 10.00, '1', 'En attente', 1),
(24, '2024-03-30', 25.00, '1', 'En attente', 2),
(25, '2024-03-30', 9015.00, '3', 'En attente', 2);

--
-- Déclencheurs `commandes`
--
DROP TRIGGER IF EXISTS `vente_superieur_3000`;
DELIMITER $$
CREATE TRIGGER `vente_superieur_3000` AFTER INSERT ON `commandes` FOR EACH ROW BEGIN
    IF NEW.Montant_Total > 3000 THEN
        INSERT INTO vente.alertes (`Message`, `Date_Alerte`, `fk_Commande`) VALUES
        (
            CONCAT('La commande ', NEW.id_Commande, ' est supérieure à 3000€.'), 
            NOW(), 
            NEW.id_Commande
        );
    END IF;
END
$$
DELIMITER ;

-- --------------------------------------------------------

--
-- Structure de la table `correspondre`
--

DROP TABLE IF EXISTS `correspondre`;
CREATE TABLE IF NOT EXISTS `correspondre` (
  `id` int NOT NULL AUTO_INCREMENT,
  `fk_Commande` int NOT NULL,
  `fk_Livraison` int NOT NULL,
  PRIMARY KEY (`id`),
  KEY `fk_Comande` (`fk_Commande`),
  KEY `fk_bonLivraisons` (`fk_Livraison`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- --------------------------------------------------------

--
-- Structure de la table `produit`
--

DROP TABLE IF EXISTS `produit`;
CREATE TABLE IF NOT EXISTS `produit` (
  `id` int NOT NULL AUTO_INCREMENT,
  `nom` varchar(25) NOT NULL,
  `description` varchar(255) NOT NULL,
  `prix_unitaire` int NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Déchargement des données de la table `produit`
--

INSERT INTO `produit` (`id`, `nom`, `description`, `prix_unitaire`) VALUES
(1, 'produit1', 'produit haute qualité', 10),
(2, 'produit2', 'produit n°2 attention', 3005);

-- --------------------------------------------------------

--
-- Structure de la table `stock`
--

DROP TABLE IF EXISTS `stock`;
CREATE TABLE IF NOT EXISTS `stock` (
  `id` int NOT NULL AUTO_INCREMENT,
  `quantite_dispo` int NOT NULL,
  `date_entree` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `date_sortie` date NOT NULL,
  `fk_produit` int NOT NULL,
  PRIMARY KEY (`id`),
  KEY `fk_produit` (`fk_produit`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Déchargement des données de la table `stock`
--

INSERT INTO `stock` (`id`, `quantite_dispo`, `date_entree`, `date_sortie`, `fk_produit`) VALUES
(1, 5, '2024-03-24 12:09:49', '2024-05-10', 1),
(2, 4, '2024-03-24 12:10:43', '2024-05-10', 2);

--
-- Contraintes pour les tables déchargées
--

--
-- Contraintes pour la table `commandes`
--
ALTER TABLE `commandes`
  ADD CONSTRAINT `id_produit` FOREIGN KEY (`id_produit`) REFERENCES `produit` (`id`);

--
-- Contraintes pour la table `correspondre`
--
ALTER TABLE `correspondre`
  ADD CONSTRAINT `fk_bonLivraisons` FOREIGN KEY (`fk_Livraison`) REFERENCES `bon_de_livraisons` (`id_Livraison`) ON DELETE RESTRICT ON UPDATE RESTRICT,
  ADD CONSTRAINT `fk_Comande` FOREIGN KEY (`fk_Commande`) REFERENCES `commandes` (`id_Commande`) ON DELETE RESTRICT ON UPDATE RESTRICT;

--
-- Contraintes pour la table `stock`
--
ALTER TABLE `stock`
  ADD CONSTRAINT `fk_produit` FOREIGN KEY (`fk_produit`) REFERENCES `produit` (`id`) ON DELETE RESTRICT ON UPDATE RESTRICT;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
