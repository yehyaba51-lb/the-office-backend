<?php
    require_once('BaseDeDonnee.php');

    class InscriptionModel{
        private $conn;

        public function __construct(BaseDeDonnee $db){
            $this->conn = $db->getConn();
        }

        // inscription table
        public function getInscription($id){
            $stmt = mysqli_prepare($this->conn, "SELECT * FROM inscription WHERE inscription_id = ?");

            if (!$stmt) {
                error_log('Prepare failed: ' . mysqli_error($this->conn));
                return false;
            }

            mysqli_stmt_bind_param($stmt, "i", $id);
            mysqli_stmt_execute($stmt);

            $result = mysqli_stmt_get_result($stmt);

            return mysqli_fetch_assoc($result);
        }

        public function getAllInscriptions(){
            $query = "SELECT * FROM inscription";

            $result = mysqli_query($this->conn, $query);

            if (!$result) {
                error_log('Query failed: ' . mysqli_error($this->conn));
                return false;
            }

            return mysqli_fetch_all($result, MYSQLI_ASSOC);
        }

        public function creerInscription($data){
            $stmt = mysqli_prepare($this->conn, "INSERT INTO inscription(etudiant_id, cours_id, note_finale) VALUES(?, ?, ?)");

            if (!$stmt) {
                error_log('Prepare failed: ' . mysqli_error($this->conn));
                return false;
            }

            mysqli_stmt_bind_param($stmt, "iid", $data['etudiant_id'], $data['cours_id'], $data['note_finale']);
            mysqli_stmt_execute($stmt);

            return mysqli_insert_id($this->conn);
        }

        public function supprimerInscription($id){
            $stmt = mysqli_prepare($this->conn, "DELETE FROM inscription WHERE inscription_id = ?");

            if (!$stmt) {
                error_log('Prepare failed: ' . mysqli_error($this->conn));
                return false;
            }

            mysqli_stmt_bind_param($stmt, "i", $id);
            return mysqli_stmt_execute($stmt);
        }
    }