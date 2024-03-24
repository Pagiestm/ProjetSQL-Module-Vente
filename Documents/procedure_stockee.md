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

```