<?php
    require_once(__DIR__ . '/../acces_donnees/BaseDeDonnee.php');
    require_once(__DIR__ .'/../acces_donnees/ExerciceModel.php');
    class ExerciceManager{
        private $exerciceModel;

        public function __construct()
        {
            $db = new BaseDeDonnee();

            $this->exerciceModel = new ExerciceModel($db);
        }


        public function creerPlaceholder($lecon_id, $cours_id, $exercice_titre){
            $data = [
                'lecon_id' => $lecon_id,
                'cours_id' => $cours_id,
                'exercice_titre' => $exercice_titre
            ];

            return $this->exerciceModel->creerExercice($data);
        }
        
        public function creerSoumission($data){
            
        }

        public function updateSoumission(){

        }
    }