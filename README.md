# Création des tables

```sql

CREATE DATABASE IF NOT EXISTS vente;

CREATE TABLE IF NOT EXISTS vente.Bon_de_Livraisons(
   id_Livraison INT PRIMARY KEY AUTO_INCREMENT,
   Adresse VARCHAR(50) NOT NULL,
   Date_Livraison DATE NOT NULL,
   Numero_Livraison VARCHAR(25) NOT NULL
);

CREATE TABLE IF NOT EXISTS vente.Commandes(
   id_Commande INT PRIMARY KEY AUTO_INCREMENT,
   Date_Commande DATE NOT NULL,
   Montant_Total DECIMAL(25,2) NOT NULL,
   Quantite_Total VARCHAR(25) NOT NULL,
   Statut VARCHAR(15) NOT NULL
);

CREATE TABLE IF NOT EXISTS vente.Alertes(
    id_Alerte INT PRIMARY KEY AUTO_INCREMENT,
    Message VARCHAR(50) NOT NULL,
    Date_Alerte DATE NOT NULL,
    fk_Commande INT NOT NULL REFERENCES Commandes(id_Commande)
);

CREATE TABLE IF NOT EXISTS vente.Correspondre(
   id INT PRIMARY KEY AUTO_INCREMENT,
   fk_Commande INT  NOT NULL REFERENCES Commandes(id_Commande),
   fk_Livraison INT NOT NULL REFERENCES Bon_de_Livraison(id_Livraison)
);

```

# Procédures stockées 

```sql

DELIMITER //
   CREATE PROCEDURE `afficherBon_de_Livraisons`()
      BEGIN 
         SELECT * FROM vente.Bon_de_Livraisons;
   END //
DELIMITER ;

DELIMITER //
   CREATE PROCEDURE `creerBon_de_Livraisons`(
      IN l_Adresse VARCHAR(50),
      IN l_Date_Livraison DATE,
      IN l_Numero_Livraison VARCHAR(25)
   )
   BEGIN 
      INSERT INTO vente.Bon_de_Livraisons (`Adresse`, `Date_Livraison`, `Numero_Livraison`) VALUES
      (l_Adresse, l_Date_Livraison, l_Numero_Livraison);
   END //
DELIMITER ; 

DELIMITER //
   CREATE PROCEDURE `modifierBon_de_Livraisons`(
      IN l_id_Livraison INT, 
      IN l_Adresse VARCHAR(50),
      IN l_Date_Livraison DATE,
      IN l_Numero_Livraison VARCHAR(25)
   )
   BEGIN 
      UPDATE vente.Bon_de_Livraisons 
      SET Adresse = l_Adresse, 
          Date_Livraison = l_Date_Livraison, 
          Numero_Livraison = l_Numero_Livraison  
      WHERE id_Livraison = l_id_Livraison;
   END //
DELIMITER ;

DELIMITER //
   CREATE PROCEDURE `supprimerBon_de_Livraisons`(
      IN l_id_Livraison INT
   )
   BEGIN 
      DELETE FROM vente.Bon_de_Livraisons WHERE id_Livraison = l_id_Livraison;
   END //
DELIMITER ;




DELIMITER //
CREATE TRIGGER vente_superieur_3000
AFTER INSERT ON vente.commandes
FOR EACH ROW
BEGIN
    IF NEW.Montant_Total > 3000 THEN
        INSERT INTO vente.alertes (`Message`, `Date_Alerte`, `fk_Commande`) VALUES
        (
            CONCAT('La commande ', NEW.id_Commande, ' est supérieure à 3000€.'), 
            NOW(), 
            NEW.id_Commande
        );
    END IF;
END //
DELIMITER ;

```