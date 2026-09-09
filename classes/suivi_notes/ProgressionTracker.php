<?php
    require_once(__DIR__ . '/../acces_donnees/BaseDeDonnee.php');
    require_once(__DIR__ . '/../acces_donnees/progressionModel.php');
    require_once(__DIR__ . '/../acces_donnees/ProgressionLeconModel.php');
    require_once('Progression.php');
    require_once('ProgressionLecon.php');

    class ProgressionTracker{
        private $progressionModel;
        private $progressionLeconModel;

        public function __construct(){
            $db = new BaseDeDonnee();

            $this->progressionModel = new progressionModel($db);
            $this->progressionLeconModel = new ProgressionLeconModel($db);
        }

        public function estLeconVerrouille($etudiant_id, $cours_id, $lecon_id){
            $row = $this->progressionLeconModel->getProgressionByLeconEtudiant($etudiant_id, $cours_id, $lecon_id);
            
            return $row !== null && $row['status'] !== null;
        }
    }
