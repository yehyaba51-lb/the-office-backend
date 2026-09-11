<?php
    require_once(__DIR__ . '/../vendor/autoload.php');
    $dotenv = Dotenv\Dotenv::createImmutable(__DIR__ . '/..');
    $dotenv->load();

    header('Access-Control-Allow-Origin: *');
    header('Content-Type: application/json');

    require_once(__DIR__ . '/../classes/authentification/UtilisateurManager.php');

    $manager = new UtilisateurManager();

    if($_SERVER['REQUEST_METHOD'] === 'GET'){
        $allUtilisateurs = $manager->getAllUtilisateurs();

        if(!$allUtilisateurs){
            http_response_code(500);
            echo json_encode(['error' => 'Impossible de récupérer les utilisateurs']);
            exit;
        }

        $data = [];

        foreach ($allUtilisateurs as $utilisateur) {
            $data[] = [
                'id' => $utilisateur->getUtilisateurId(),
                'prenom' => $utilisateur->getPrenom(),
                'nom' => $utilisateur->getNom(),
                'email' => $utilisateur->getEmail(),
                'role' => $utilisateur->getRole(),
                'cree_le' => $utilisateur->getCreeLe(),
            ];
        }
        http_response_code(200);
        echo json_encode($data);
    } else {
        http_response_code(405);
        echo json_encode(['error' => 'Méthode non autorisée']);
    }