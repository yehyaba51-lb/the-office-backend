<?php
    require_once(__DIR__ . '/../vendor/autoload.php');
    $dotenv = Dotenv\Dotenv::createImmutable(__DIR__ . '/..');
    $dotenv->load();

    header('Access-Control-Allow-Origin: *');
    header('Content-Type: application/json');

    require_once(__DIR__ . '/../classes/gestion_cours/CoursManager.php');

    $manager = new CoursManager();

    if($_SERVER['REQUEST_METHOD'] === 'GET'){
        $allCategories = $manager->getCategories();

        if(!$allCategories){
            http_response_code(500);
            echo json_encode(['error' => 'Impossible de récupérer les categories']);
            exit;
        }

        http_response_code(200);
        echo json_encode($allCategories);
    } else {
        http_response_code(405);
        echo json_encode(['error' => 'Méthode non autorisée']);
    }