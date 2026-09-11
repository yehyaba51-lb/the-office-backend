<?php
    require_once(__DIR__ . '/../vendor/autoload.php');
    $dotenv = Dotenv\Dotenv::createImmutable(__DIR__ . '/..');
    $dotenv->load();

    header('Access-Control-Allow-Origin: *');
    header('Content-Type: application/json');

    require_once(__DIR__ . '/../classes/gestion_exercices/ExerciceManager.php');

    $manager = new ExerciceManager();

    if($_SERVER['REQUEST_METHOD'] === 'GET'){
        $allSoumissions = $manager->getAllSoumissions();
    }