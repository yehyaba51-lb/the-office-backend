<?php
    require_once(__DIR__ . '/../acces_donnees/BaseDeDonnee.php');
    require_once(__DIR__ . '/../acces_donnees/QuestionModel.php');
    require_once(__DIR__ . '/../acces_donnees/SoumissionModel.php');
    require_once(__DIR__ . '/../acces_donnees/ProgressionExerciceModel.php');

    class NoteCalculateur{
        private $questionModel;
        private $soumissionModel;
        private $progressionExerciceModel;

        public function __construct(){
            $db = new BaseDeDonnee();

            $this->questionModel = new QuestionModel($db);
            $this->soumissionModel = new SoumissionModel($db);
            $this->progressionExerciceModel = new ProgressionExerciceModel($db);
        }


        public function calculerMoyenneExercice($exercice_id, $etudiant_id){
            $questions_rows = $this->questionModel->getQuestionsByExercice($exercice_id);
            
            $areAllCorrected = [];
            $allNotes = [];

            if(!$questions_rows) {
                return false;
            }
            
            foreach ($questions_rows as $question) {
                $soumission_row = $this->soumissionModel->getSoumissionByEtudiantQuestion($etudiant_id, $question['question_id']);

                if($soumission_row && $soumission_row['note'] !== null){
                    $areAllCorrected[] = true;
                    $allNotes[] = $soumission_row['note'];
                } else {
                    $areAllCorrected[] = false;
                }                
            }

            if(in_array(false, $areAllCorrected)){
                return false;
            } else {
                $sum = 0;
                foreach ($allNotes as $note) {
                    $sum = $sum + $note;
                }

                $moy = $sum / count($allNotes);

                $data = [
                    'note' => $moy,
                    'exercice_id' => $exercice_id,
                    'etudiant_id' => $etudiant_id
                ];

                $this->progressionExerciceModel->updateProgressionExercice($data);

                return $moy;
            }
        }
    }