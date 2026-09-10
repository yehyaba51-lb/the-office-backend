<?php
    require_once(__DIR__ . '/../acces_donnees/BaseDeDonnee.php');
    require_once(__DIR__ . '/../acces_donnees/ProgressionModel.php');
    require_once(__DIR__ . '/../acces_donnees/ProgressionLeconModel.php');
    require_once(__DIR__ . '/../acces_donnees/ProgressionExerciceModel.php');
    require_once(__DIR__ . '/../acces_donnees/ExerciceModel.php');
    require_once(__DIR__ . '/../acces_donnees/LeconModel.php');
    require_once('Progression.php');
    require_once('ProgressionLecon.php');
    require_once('ProgressionExercice.php');
    require_once('Exercice.php');


    class ProgressionTracker{
        private $progressionModel;
        private $progressionLeconModel;
        private $progressionExerciceModel;
        private $exerciceModel;
        private $leconModel;

        public function __construct(){
            $db = new BaseDeDonnee();

            $this->progressionModel = new ProgressionModel($db);
            $this->progressionLeconModel = new ProgressionLeconModel($db);
            $this->progressionExerciceModel = new ProgressionExerciceModel($db);
            $this->exerciceModel = new ExerciceModel($db);
            $this->leconModel = new LeconModel($db);
        }

        public function estLeconVerrouille($etudiant_id, $cours_id, $lecon_id){
            $row = $this->progressionLeconModel->getProgressionByLeconEtudiant($etudiant_id, $cours_id, $lecon_id);
            
            return $row !== null && $row['statut'] !== null;
        }

        public function estExerciceVerrouille($etudiant_id, $exercice_id){
            $row = $this->exerciceModel->getExercice($exercice_id);

            if(!$row){
                return false;
            } 
            
            $lecon_id = $row['lecon_id'];
            $cours_id = $row['cours_id'];

            $progression_lecon_row = $this->progressionLeconModel->getProgressionByLeconEtudiant($etudiant_id, $cours_id, $lecon_id);

            if(!$progression_lecon_row){
                return false;
            } 

            return $progression_lecon_row !== null && $progression_lecon_row['statut'] !== null;
        }


        
    }
