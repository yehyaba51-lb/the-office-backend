<?php
    require_once('BaseDeDonnee.php');

    class CoursModel{
        private $conn;

        public function __construct(BaseDeDonnee $db){
            $this->conn = $db->getConn();
        }

        // cours table
        public function getCours($id){
            $stmt = mysqli_prepare($this->conn, "SELECT * FROM cours WHERE cours_id = ?");

            if (!$stmt) {
                error_log('Prepare failed: ' . mysqli_error($this->conn));
                return false;
            }

            mysqli_stmt_bind_param($stmt, "i", $id);
            mysqli_stmt_execute($stmt);

            $result = mysqli_stmt_get_result($stmt);

            if (!$result) {
                error_log('Query failed: ' . mysqli_error($this->conn));
                return false;
            }

            return mysqli_fetch_assoc($result);
        }

        public function getAllCours(){
            $query = "SELECT * FROM cours";

            $result = mysqli_query($this->conn, $query);

            return mysqli_fetch_all($result, MYSQLI_ASSOC);
        }

        public function getCoursByFormateur($formateur_id){
            $stmt = mysqli_prepare($this->conn, "SELECT * FROM cours WHERE formateur_id = ?");

            if (!$stmt) {
                error_log('Prepare failed: ' . mysqli_error($this->conn));
                return false;
            }

            mysqli_stmt_bind_param($stmt, "i", $formateur_id);
            mysqli_stmt_execute($stmt);

            $result = mysqli_stmt_get_result($stmt);

            return mysqli_fetch_all($result, MYSQLI_ASSOC);

        }

        public function getCoursByEtudiant($etudiant_id){
            $stmt = mysqli_prepare($this->conn, "SELECT * FROM cours AS c INNER JOIN inscription AS i ON c.cours_id = i.cours_id WHERE i.etudiant_id = ?");

            if(!$stmt){
                error_log('Prepare failed: ' . mysqli_error($this->conn));
                return false;
            }

            mysqli_stmt_bind_param($stmt, "i", $etudiant_id);
            mysqli_stmt_execute($stmt);

            $result = mysqli_stmt_get_result($stmt);

            return mysqli_fetch_all($result, MYSQLI_ASSOC);
        }

        public function getEtudiantsByCours($cours_id){
            $stmt = mysqli_prepare($this->conn, "SELECT * FROM cours AS c INNER JOIN inscription AS i ON c.cours_id = i.cours_id INNER JOIN utilisateur AS u ON i.etudiant_id = u.utilisateur_id WHERE i.cours_id = ?");

            if(!$stmt){
                error_log('Prepare failed: ' . mysqli_error($this->conn));
                return false;
            }

            mysqli_stmt_bind_param($stmt, "i", $cours_id);
            mysqli_stmt_execute($stmt);

            $result = mysqli_stmt_get_result($stmt);

            return mysqli_fetch_all($result, MYSQLI_ASSOC);
        }

        public function creerCours($data){
            $stmt = mysqli_prepare($this->conn, "INSERT INTO cours(cours_titre, formateur_id, categorie_id) VALUES(?, ?, ?)");

            if (!$stmt) {
                error_log('Prepare failed: ' . mysqli_error($this->conn));
                return false;
            }

            mysqli_stmt_bind_param($stmt, "sii", $data['cours_titre'], $data['formateur_id'], $data['categorie_id']);
            mysqli_stmt_execute($stmt);

            return mysqli_insert_id($this->conn);

        }

        public function updateCours($id, $data){
            $stmt = mysqli_prepare($this->conn, "UPDATE cours SET cours_titre = ?, description = ?, formateur_id = ?, categorie_id = ? WHERE cours_id = ?");

            if (!$stmt) {
                error_log('Prepare failed: ' . mysqli_error($this->conn));
                return false;
            }

            mysqli_stmt_bind_param($stmt, "ssiii", $data['titre'], $data['description'], $data['formateur_id'], $data['categorie_id'], $id);
            return mysqli_stmt_execute($stmt);
        }

        public function supprimerCours($id){
            $stmt = mysqli_prepare($this->conn, "DELETE FROM cours WHERE cours_id = ?");
        
            if (!$stmt) {
                error_log('Prepare failed: ' . mysqli_error($this->conn));
                return false;
            }

            mysqli_stmt_bind_param($stmt, "i", $id);
            return mysqli_stmt_execute($stmt);    
        }
    }