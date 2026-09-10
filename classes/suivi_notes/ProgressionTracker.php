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


        public function initialiserProgressionLecons($etudiant_id, $cours_id){
            $lecons_rows = $this->leconModel->getLeconsByCours($cours_id);

            if(!$lecons_rows){
                return false;
            }

            foreach ($lecons_rows as $lecon) {
                if($lecon['lecon_ordre'] === 1){
                    $data = [
                        'etudiant_id' => $etudiant_id,
                        'cours_id' => $cours_id,
                        'lecon_id' => $lecon['lecon_id'],
                        'complete_le' => null,
                        'statut' => 'en_cours'
                    ];
                } else {
                    $data = [
                        'etudiant_id' => $etudiant_id,
                        'cours_id' => $cours_id,
                        'lecon_id' => $lecon['lecon_id'],
                        'complete_le' => null,
                        'statut' => null
                    ];
                }
                $this->progressionLeconModel->creerProgressionLecon($data);
            }
            return true;
        }


        public function initialiserProgressionExercices($etudiant_id, $cours_id){
            $lecons_rows = $this->leconModel->getLeconsByCours($cours_id);

            if(!$lecons_rows){
                return false;
            }

            foreach ($lecons_rows as $lecon) {
                $exercices_rows = $this->exerciceModel->getExercicesByLecon($lecon['lecon_id'], $cours_id);

                foreach ($exercice_rows as $exercice) {
                    if($lecon['lecon_ordre'] === 1){
                        $data = [
                            'etudiant_id' => $etudiant_id,
                            'exercice_id' => $exercice['exercice_id'],
                            'statut' => 'a_faire',
                            'complete_le' => null,
                            'note' => null
                        ];
                    } else {
                        $data = [
                            'etudiant_id' => $etudiant_id,
                            'exercice_id' => $exercice['exercice_id'],
                            'statut' => null,
                            'complete_le' => null,
                            'note' => null
                        ];
                    }
                    $this->progressionExerciceModel->creerProgressionExercice($data);
                }
            }
            return true;
        }


        public function getExercicesAvecStatut($etudiant_id, $cours_id){
            $lecons_rows = $this->leconModel->getLeconsByCours($cours_id);
            
            $results = [];


            if(!$lecons_rows){
                return false;
            }

            foreach ($lecons_rows as $lecon) {
                $exercices_rows = $this->exerciceModel->getExercicesByLecon($lecon['lecon_id'], $cours_id);
                $exercice_avec_statut = [];

                foreach ($exercices_rows as $exercice) {
                    $progression_exercice_row = $this->progressionExerciceModel->getProgressionByExerciceEtudiant($etudiant_id, $exercice['exercice_id']);

                    if(!$progression_exercice_row){
                        $exercice['statut'] = null;
                    } else {
                        $exercice['statut'] = $progression_exercice_row['statut'];
                        $exercice['note'] = $progression_exercice_row['note'];
                    }
                    $exercice_avec_statut[] = $exercice;
                }
                $lecon['exercices'] = $exercice_avec_statut;
                $results[] = $lecon;
            }
            return $results;
        }


        
    }
