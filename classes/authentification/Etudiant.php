<?php
    require_once('Utilisateur.php');
    require_once('ExerciceManager.php');

    class Etudiant extends Utilisateur {
        private $manager;

        public function __construct(){
            $this->manager = new ExerciceManager();
        }

        public function soumettreReponse($data){
            return $this->manager->creerSoumission($data);
        }
    }