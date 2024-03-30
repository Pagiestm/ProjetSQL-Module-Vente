# Vérification du stock d’un produit choisi pour une vente avant de valider la commande

```sql

DELIMITER //

CREATE PROCEDURE PasserCommande (
   IN idProduit INT,
   IN quantiteCommande INT
)
BEGIN
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
END //

DELIMITER ;


```

## Exemple d'appelle de la procédure stockée pour vérification et ajout dans la table commandes ou non

### Attention ! Pour avoir les mêmes valeurs que moi veuillez utiliser le dump dans le dossier dump à la racine du projet

Affichera le message "Commande passée avec succès." :

```sql

CALL PasserCommande(1, 5);

```

Affichera le message "La quantité commandée est supérieure au stock disponible." :

```sql

CALL PasserCommande(1, 8);

```