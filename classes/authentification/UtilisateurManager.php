<?php
    require_once('BaseDeDonnee.php');

    class UtilisateurManager{
        private $db;

        public function __construct(){
            $this->db = new BaseDeDonnee();
        }

        public function getUtilisateur($id){
            $row =  $this->db->getUtilisateur($id);
        }



        
    }
