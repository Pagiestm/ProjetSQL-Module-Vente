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