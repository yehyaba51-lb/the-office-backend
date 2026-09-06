<?php
    require_once('BaseDeDonnee.php');

    class SoumissionModel{
        private $conn;

        public function __construct(BaseDeDonnee $db){
            $this->conn = $db->getConn();
        }


        // soumission table
        public function getSoumission($id){
            $stmt = mysqli_prepare($this->conn, "SELECT * FROM soumission WHERE soumission_id = ?");

            if (!$stmt) {
                error_log('Prepare failed: ' . mysqli_error($this->conn));
                return false;
            }

            mysqli_stmt_bind_param($stmt, "i", $id);
            mysqli_stmt_execute($stmt);

            $result = mysqli_stmt_get_result($stmt);

            return mysqli_fetch_assoc($result);
        }

        public function getAllSoumissions(){
            $query = "SELECT * FROM soumission";

            $result = mysqli_query($this->conn, $query);

            if (!$result) {
                error_log('Query failed: ' . mysqli_error($this->conn));
                return false;
            }

            return mysqli_fetch_all($result, MYSQLI_ASSOC);
        }


        public function creerSoumission($data){
            $stmt = mysqli_prepare($this->conn, "INSERT INTO soumission(etudiant_id, question_id, soumission_reponse, url_fichier, soumis_le, note) VALUES(?, ?, ?, ?, ?, ?)");

            if (!$stmt) {
                error_log('Prepare failed: ' . mysqli_error($this->conn));
                return false;
            }

            mysqli_stmt_bind_param($stmt, "iisssd", $data['etudiant_id'], $data['question_id'], $data['soumission_reponse'], $data['url_fichier'], $data['soumis_le'], $data['note']);
            mysqli_stmt_execute($stmt);

            return mysqli_insert_id($this->conn);
        }

        public function updateSoumission($id, $data){
            $stmt = mysqli_prepare($this->conn, "UPDATE soumission SET note = ?, commentaire = ?, corrige_le = ?, corrige_par = ? WHERE soumission_id = ?");

            if (!$stmt) {
                error_log('Prepare failed: ' . mysqli_error($this->conn));
                return false;
            }

            mysqli_stmt_bind_param($stmt, "dssii", $data['note'], $data['commentaire'], $data['corrige_le'], $data['corrige_par'], $id);
            return mysqli_stmt_execute($stmt);
        }


    }