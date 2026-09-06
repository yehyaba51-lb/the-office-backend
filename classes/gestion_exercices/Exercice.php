<?php
    require_once('ExerciceManager.php');

    class Exercice{
        private $exercise_id;
        private $lecon_id;
        private $cours_id;
        private $exercise_titre;
        private $manager;

        public function __construct(){
            $this->manager = new ExerciceManager();
        }


        public function getExerciseId(){
            return $this->exercise_id;
        }

        public function setExerciseId($exercise_id){
            $this->exercise_id = $exercise_id;
        }

        public function getLeconId(){
            return $this->lecon_id;
        }

        public function setLeconId($lecon_id){
            $this->lecon_id = $lecon_id;
        }

        public function getCoursId(){
            return $this->cours_id;
        }

        public function setCoursId($cours_id){
            $this->cours_id = $cours_id;
        }

        public function getTitre(){
            return $this->exercise_titre;
        }

        public function setTitre($exercise_titre){
            $this->exercise_titre = $exercise_titre;
        }

        public function estDeverrouille(){
            return $this->manager->estDeverrouille();
        }

    }