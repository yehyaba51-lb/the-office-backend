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

        public function getSoumissionsByEtudiant($etudiant_id){
            $stmt = mysqli_prepare($this->conn, 
                "SELECT *
                FROM soumission
                WHERE etudiant_id = ?"
            );

            if(!$stmt){
                error_log('Prepare failed' . mysqli_error($this->conn));
                return false;
            }

            mysqli_stmt_bind_param($stmt, "i", $etudiant_id);
            mysqli_stmt_execute($stmt);

            $result = mysqli_stmt_get_result($stmt);

            return mysqli_fetch_all($result, MYSQLI_ASSOC);
        }


        public function getSoumissionByEtudiantQuestion($etudiant_id, $question_id){
            $stmt = mysqli_prepare($this->conn, 
                "SELECT * FROM soumission WHERE etudiant_id = ? AND question_id = ?"
            );

            if(!$stmt){
                error_log('Prepare failed: ' . mysqli_error($this->conn));
                return false;
            }

            mysqli_stmt_bind_param($stmt, "ii", $etudiant_id, $question_id);
            mysqli_stmt_execute($stmt);

            $result = mysqli_stmt_get_result($stmt);
            return mysqli_fetch_assoc($result);
        }


        public function creerSoumission($data){
            $stmt = mysqli_prepare($this->conn, 
            "INSERT INTO soumission(etudiant_id, question_id, soumission_reponse, url_fichier, soumis_le)
            VALUES(?, ?, ?, ?, ?)");

            if (!$stmt) {
                error_log('Prepare failed: ' . mysqli_error($this->conn));
                return false;
            }

            mysqli_stmt_bind_param($stmt, "iisss", $data['etudiant_id'], $data['question_id'], $data['soumission_reponse'], $data['url_fichier'], $data['soumis_le']);
            mysqli_stmt_execute($stmt);

            return mysqli_insert_id($this->conn);
        }

        public function corrigerSoumission($id, $data){
            $stmt = mysqli_prepare($this->conn, "UPDATE soumission SET note = ?, commentaire = ?, corrige_le = NOW(), corrige_par = ? WHERE soumission_id = ?");

            if (!$stmt) {
                error_log('Prepare failed: ' . mysqli_error($this->conn));
                return false;
            }

            mysqli_stmt_bind_param($stmt, "dsii", $data['note'], $data['commentaire'], $data['corrige_par'], $id);
            return mysqli_stmt_execute($stmt);
        }


        public function resoumettre($soumission_id, $data){
            $stmt = mysqli_prepare($this->conn, 
            "UPDATE soumission
            SET soumission_reponse = ?,
            url_fichier = ?,
            soumis_le = NOW(),
            corrige_le = NULL,
            corrige_par = NULL,
            note = NULL,
            commentaire = NULL
            WHERE soumission_id = ?");

            if (!$stmt) {
                error_log('Prepare failed: ' . mysqli_error($this->conn));
                return false;
            }

            mysqli_stmt_bind_param($stmt, "ssi", $data['soumission_reponse'], $data['url_fichier'], $soumission_id);
            mysqli_stmt_execute($stmt);

            return mysqli_stmt_execute($stmt);
        }
    }