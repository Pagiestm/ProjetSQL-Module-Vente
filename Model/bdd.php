<?php

class Bdd
{
    public $bdd;

    public function __construct()
    {
        $dsn = 'mysql:dbname=vente;host=127.0.0.1:3306';
        $dbUser = 'root';
        $dbPwd = '';

        try {
            $this->bdd = new PDO($dsn, $dbUser, $dbPwd);
        } catch (PDOException $e) {
            echo $e->getMessage();
        }
    }

    public function getBonLivraison()
    {
        $sql = "CALL afficherBon_de_Livraisons()";
        $query =  $this->bdd->prepare($sql);
        $query->execute();
        return $query->fetchAll();
    }

    public function addBonLivraison($Adresse, $Date_Livraison, $Numero_Livraison)
    {
        $sql = "CALL creerBon_de_Livraisons(:Adresse, :Date_Livraison, :Numero_Livraison)";
        $query = $this->bdd->prepare($sql);
        $query->execute(array(":Adresse" => $Adresse, ":Date_Livraison" => $Date_Livraison, ":Numero_Livraison" => $Numero_Livraison));
        return $query->fetchAll();
    }

    public function modifierBonDeLivraisons($id_Livraison, $Adresse, $Date_Livraison, $Numero_Livraison)
    {
        $sql = "CALL modifierBon_de_Livraisons(:id_Livraison, :Adresse, :Date_Livraison, :Numero_Livraison)";
        $query = $this->bdd->prepare($sql);
        $query->execute(array(
            ":id_Livraison" => $id_Livraison,
            ":Adresse" => $Adresse,
            ":Date_Livraison" => $Date_Livraison,
            ":Numero_Livraison" => $Numero_Livraison
        ));
        return $query->fetchAll();
    }


    public function deleteBonLivraison($id_Livraison)
    {
        $sql = "CALL supprimerBon_de_Livraisons(:id_Livraison)";

        $query =  $this->bdd->prepare($sql);
        $query->bindParam(':id_Livraison', $id_Livraison, PDO::PARAM_INT);
        $query->execute();
        return $query->fetchAll();
    }

    // DELIMITER //
    // CREATE PROCEDURE `read_test`()
    //     BEGIN 
    //         SELECT * FROM test;
    //     END //
    // DELIMITER ;


    // DELIMITER //
    // CREATE PROCEDURE `creer_test`(
    //     IN t_test VARCHAR(25)
    // )
    // BEGIN 
    //     INSERT INTO vente.test (`test`) VALUES
    //     (t_test);
    // END //
    // DELIMITER ; 


    // DELIMITER //
    //     CREATE PROCEDURE `update_test`(
    //         IN t_id INT, 
    //         IN t_test VARCHAR(25)
    //     )
    //     BEGIN 
    //         UPDATE test SET test = t_test WHERE id = t_id;
    //     END //
    // DELIMITER ;

    // DELIMITER //
    //     CREATE PROCEDURE `delete_test`(
    //         IN t_id INT
    //     )
    //     BEGIN 
    //         DELETE FROM test WHERE id = t_id;
    //     END //
    // DELIMITER ;
}
