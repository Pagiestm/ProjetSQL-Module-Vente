<?php

require_once 'Model/bdd.php';

class LivraisonController
{
    private $model;

    public function __construct()
    {
        $this->model = new Bdd();
    }

    public function Livraison()
    {
        if (!empty($_POST['Adresse']) && !empty($_POST['Date_Livraison']) && !empty($_POST['Numero_Livraison']) && !isset($_POST['id_Livraison'])) {
            $AdresseLivraison = $_POST['Adresse'];
            $Date_Livraison = $_POST['Date_Livraison'];
            $Numero_Livraison = $_POST['Numero_Livraison'];

            $this->model->addBonLivraison($AdresseLivraison, $Date_Livraison, $Numero_Livraison);
        }

        if (isset($_POST['id_Livraison']) && isset($_POST['Adresse']) && isset($_POST['Date_Livraison']) && isset($_POST['Numero_Livraison'])) {
            $id_Livraison = $_POST['id_Livraison'];
            $Adresse = $_POST['Adresse'];
            $Date_Livraison = $_POST['Date_Livraison'];
            $Numero_Livraison = $_POST['Numero_Livraison'];

            $this->model->modifierBonDeLivraisons($id_Livraison, $Adresse, $Date_Livraison, $Numero_Livraison);
        }

        if (isset($_POST['supprimerLivraison'])) {
            $id_Livraison = $_POST['supprimerLivraison'];
            $this->model->deleteBonLivraison($id_Livraison);
        }

        $tests = $this->model->getBonLivraison();
        require_once 'View/Livraison.php';
    }
}
