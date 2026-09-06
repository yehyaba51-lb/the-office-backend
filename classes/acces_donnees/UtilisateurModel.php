<?php
    require_once('BaseDeDonnee.php');

    class UtilisateurModel{
        private $conn;

        public function __construct(BaseDeDonnee $db){
            $this->conn = $db->getConn();
        }

        // utilisateur table
        public function getUtilisateur($id)
        {
            $stmt = mysqli_prepare($this->conn, "SELECT * FROM utilisateur WHERE utilisateur_id = ?");

            if (!$stmt) {
                error_log('Prepare failed: ' . mysqli_error($this->conn));
                return false;
            }

            mysqli_stmt_bind_param($stmt, "i", $id);
            mysqli_stmt_execute($stmt);

            $result = mysqli_stmt_get_result($stmt);


            return mysqli_fetch_assoc($result);
        }

        public function getUtilisateurByEmail($email){
            $stmt = mysqli_prepare($this->conn, "SELECT * FROM utilisateur WHERE email = ?");

            if (!$stmt) {
                error_log('Prepare failed: ' . mysqli_error($this->conn));
                return false;
            }

            mysqli_stmt_bind_param($stmt, "s", $email);
            mysqli_stmt_execute($stmt);

            $result = mysqli_stmt_get_result($stmt);

            return mysqli_fetch_assoc($result);

        }

        public function getAllUtilisateurs(){
            $query = "SELECT * FROM utilisateur";

            $result = mysqli_query($this->conn, $query);

            if (!$result) {
                error_log('Query failed: ' . mysqli_error($this->conn));
                return false;
            }

            return mysqli_fetch_all($result, MYSQLI_ASSOC);
        }

        public function creerUtilisateur($data)
        {
            if(!filter_var($data['email'], FILTER_VALIDATE_EMAIL)){
                return false;
            };

            $mot_de_passe_hash = password_hash($data['mot_de_passe'], PASSWORD_DEFAULT);

            $stmt = mysqli_prepare($this->conn, "INSERT INTO utilisateur(prenom, nom, email, mot_de_passe, role) VALUES(?, ?, ?, ?, ?)");
            
            if (!$stmt) {
                error_log('Prepare failed: ' . mysqli_error($this->conn));
                return false;
            }
            
            mysqli_stmt_bind_param($stmt, 'sssss', $data['prenom'], $data['nom'], $data['email'], $mot_de_passe_hash, $data['role']);
            mysqli_stmt_execute($stmt);

            return mysqli_insert_id($this->conn);

        }

        public function updateUtilisateur($id, $data){
            $stmt = mysqli_prepare($this->conn, "UPDATE utilisateur SET prenom = ?, nom = ?, email = ? WHERE utilisateur_id  = ?");

            if (!$stmt) {
                error_log('Prepare failed: ' . mysqli_error($this->conn));
                return false;
            }

            mysqli_stmt_bind_param($stmt, "sssi", $data['prenom'], $data['nom'], $data['email'], $id);
            return mysqli_stmt_execute($stmt);
            
        }

        public function supprimerUtilisateur($id){
            $stmt = mysqli_prepare($this->conn, "DELETE FROM utilisateur WHERE utilisateur_id = ?");

            if (!$stmt) {
                error_log('Prepare failed: ' . mysqli_error($this->conn));
                return false;
            }

            mysqli_stmt_bind_param($stmt, "i", $id);
            return mysqli_stmt_execute($stmt);
        }
    }