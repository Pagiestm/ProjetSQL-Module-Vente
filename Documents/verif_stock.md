# Vérification du stock d’un produit choisi pour une vente avant de valider la commande

```sql

DELIMITER //
CREATE PROCEDURE PasserCommande (
   IN nomProduit VARCHAR(25),
   IN quantiteCommande INT
)
BEGIN
   DECLARE stockDisponible INT;

   SELECT quantite_dispo INTO stockDisponible
   FROM stock s
   INNER JOIN produit p ON p.id = s.fk_produit
   WHERE p.nom = nomProduit;

   IF quantiteCommande <= stockDisponible THEN
      INSERT INTO commandes (Date_Commande, Montant_Total, Quantite_Total, Statut)
      VALUES (NOW(), (SELECT prix_unitaire FROM produit WHERE nom = nomProduit) * quantiteCommande, quantiteCommande, 'En attente');

      SELECT 'Commande passée avec succès.' AS message;
    ELSE
      SELECT 'La quantité commandée est supérieure au stock disponible.' AS message;
    END IF;
END //
DELIMITER ;

```