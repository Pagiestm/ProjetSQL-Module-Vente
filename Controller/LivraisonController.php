<?php

require_once 'Model/bdd.php';

class LivraisonController
{
    private $model;

    public function __construct()
    {
        $this->model = new Bdd();
    }

    public function index()
    {
        if (!empty($_POST['Adresse']) && !empty($_POST['Date_Livraison']) && !empty($_POST['Numero_Livraison'])) {
            $AdresseLivraison = $_POST['Adresse'];
            $Date_Livraison = $_POST['Date_Livraison'];
            $Numero_Livraison = $_POST['Numero_Livraison'];

            $this->model->addTest($AdresseLivraison, $Date_Livraison, $Numero_Livraison);
        }

        if (isset($_POST['update_id']) && isset($_POST['update_test'])) {
            $id = $_POST['update_id'];
            $test = $_POST['update_test'];
            $this->model->updateTest($id, $test);
        }

        if (isset($_POST['supprimerLivraison'])) {
            $id_Livraison = $_POST['supprimerLivraison'];
            $this->model->deleteTest($id_Livraison);
        }

        $tests = $this->model->getTest();
        require_once 'View/Livraison.php';
    }
}
