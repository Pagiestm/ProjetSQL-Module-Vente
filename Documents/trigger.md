# Trigger

```sql

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

# Tester le Trigger avec la vérification du stock avec un produit dont le prix est supérieur à 3000

```sql

CALL PasserCommande(2, 3);

```