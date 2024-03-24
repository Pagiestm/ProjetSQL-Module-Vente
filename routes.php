<?php

require_once 'Controller/LivraisonController.php';

class Router {
    public function routeRequest() {
        $uri = $_SERVER['REQUEST_URI'];

        if ($uri == '/') {
            $controller = new LivraisonController();
            $controller->Livraison();
        }
    }
}