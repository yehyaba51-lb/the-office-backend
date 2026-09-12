<?php
    require_once(__DIR__ . '/../vendor/autoload.php');
    $dotenv = Dotenv\Dotenv::createImmutable(__DIR__ . '/..');
    $dotenv->load();

    header('Access-Control-Allow-Origin: *');
    header('Access-Control-Allow-Headers: Content-Type');
    header('Content-Type: application/json');

    require_once(__DIR__ . '/../classes/gestion_cours/CoursManager.php');

    $manager = new CoursManager();

    if ($_SERVER['REQUEST_METHOD'] === 'OPTIONS') {
        http_response_code(200);
        exit;
    } else if($_SERVER['REQUEST_METHOD'] === 'GET'){
        $allCategories = $manager->getCategories();

        if(!$allCategories){
            http_response_code(500);
            echo json_encode(['error' => 'Impossible de récupérer les categories']);
            exit;
        }

        http_response_code(200);
        echo json_encode($allCategories);
    } else if($_SERVER['REQUEST_METHOD'] === 'POST') {
        $data = json_decode(file_get_contents("php://input"), true);

        $id = $manager->ajouterCategorie($data['categorie_nom']);

        if(!$id){
            http_response_code(400);
            echo json_encode(['error' => 'Nom de catégorie invalide']);
            exit;
        }

        http_response_code(201);
        echo json_encode(['id' => $id]);
    } else if($_SERVER['REQUEST_METHOD'] === 'PUT'){

    } else {
        http_response_code(405);
        echo json_encode(['error' => 'Méthode non autorisée']);
    }