<?php
    class BaseDeDonnee {
        private $conn;

        public function __construct() {
            $this->conn = mysqli_connect(
                $_ENV['DB_HOST'],
                $_ENV['DB_USER'],
                $_ENV['DB_PASS'],
                $_ENV['DB_NAME']
            );
            
            
            if(!$this->conn) {
                error_log('Database connection failed: ' . mysqli_connect_error());
                exit;
            }
        }

    
        // utilisateur table
        public function getUtilisateur($id)
        {
            $stmt = mysqli_prepare($this->conn, "SELECT * FROM utilisateur WHERE utilisateur_id = ?");
            mysqli_stmt_bind_param($stmt, "i", $id);
            mysqli_stmt_execute($stmt);

            $result = mysqli_stmt_get_result($stmt);


            return mysqli_fetch_assoc($result);
        }

        public function getAllUtilisateurs(){
            $query = "SELECT * FROM utilisateur";

            $result = mysqli_query($this->conn, $query);

            return mysqli_fetch_all($result, MYSQLI_ASSOC);
        }

        public function createUtilisateur($data)
        {
            if(!filter_var($data['email'], FILTER_VALIDATE_EMAIL)){
                return false;
            };

            $mot_de_passe_hash = password_hash($data['mot_de_passe'], PASSWORD_DEFAULT);

            $stmt = mysqli_prepare($this->conn, "INSERT INTO utilisateur(prenom, nom, email, mot_de_passe, role) VALUES(?, ?, ?, ?, ?)");
            mysqli_stmt_bind_param($stmt, 'sssss', $data['prenom'], $data['nom'], $data['email'], $mot_de_passe_hash, $data['role']);
            mysqli_stmt_execute($stmt);

            return mysqli_insert_id($this->conn);

        }

        public function updateUtilisateur($id, $data){
            $stmt = mysqli_prepare($this->conn, "UPDATE utilisateur SET prenom = ?, nom = ?, email = ? WHERE utilisateur_id  = ?");

            mysqli_stmt_bind_param($stmt, "sssi", $data['prenom'], $data['nom'], $data['email'], $id);
            return mysqli_stmt_execute($stmt);
            
        }

        public function supprimerUtilisateur($id){
            $stmt = mysqli_prepare($this->conn, "DELETE FROM utilisateur WHERE utilisateur_id = ?");

            mysqli_stmt_bind_param($stmt, "i", $id);
            return mysqli_stmt_execute($stmt);
        }

        // cours table
        public function getCours($id){
            $stmt = mysqli_prepare($this->conn, "SELECT * FROM cours WHERE cours_id = ?");

            mysqli_stmt_bind_param($stmt, "i", $id);
            mysqli_stmt_execute($stmt);

            $result = mysqli_stmt_get_result($stmt);

            return mysqli_fetch_assoc($result);
        }

        public function getAllCours(){
            $query = "SELECT * FROM cours";

            $result = mysqli_query($this->conn, $query);

            return mysqli_fetch_all($result, MYSQLI_ASSOC);
        }

        public function creerCours($data){
            $stmt = mysqli_prepare($this->conn, "INSERT INTO cours(cours_titre, description, formateur_id, categorie_id) VALUES(?, ?, ?, ?)");

            mysqli_stmt_bind_param($stmt, "ssii", $data['titre'], $data['description'], $data['formateur_id'], $data['categorie_id']);
            mysqli_stmt_execute($stmt);

            return mysqli_insert_id($this->conn);

        }

        public function updateCours($id, $data){
            $stmt = mysqli_prepare($this->conn, "UPDATE cours SET cours_titre = ?, description = ?, formateur_id = ?, categorie_id = ? WHERE cours_id = ?");

            mysqli_stmt_bind_param($stmt, "ssiii", $data['titre'], $data['description'], $data['formateur_id'], $data['categorie_id'], $id);
            return mysqli_stmt_execute($stmt);
        }

        public function supprimerCours($id){
            $stmt = mysqli_prepare($this->conn, "DELETE FROM cours WHERE cours_id = ?");
        
            mysqli_stmt_bind_param($stmt, "i", $id);
            return mysqli_stmt_execute($stmt);    
        }

        // categorie table
        public function getCategorie($id){
            $stmt = mysqli_prepare($this->conn, "SELECT * FROM categorie WHERE categorie_id = ?");

            mysqli_stmt_bind_param($stmt, "i", $id);
            mysqli_stmt_execute($stmt);

            $result = mysqli_stmt_get_result($stmt);

            return mysqli_fetch_assoc($result);
        }

        public function getAllCategories(){
            $query = "SELECT * FROM categorie";

            $result = mysqli_query($this->conn, $query);

            return mysqli_fetch_all($result, MYSQLI_ASSOC);
        }

        public function creerCategorie($data){
            $stmt = mysqli_prepare($this->conn, "INSERT INTO categorie(categorie_nom) VALUES(?)");

            mysqli_stmt_bind_param($stmt, "s", $data['categorie_nom']);
            return mysqli_stmt_execute($stmt);
        }

        public function updateCategorie($id, $data){
            $stmt = mysqli_prepare($this->conn, "UPDATE categorie SET categorie_nom = ? WHERE categorie_id = ?");

            mysqli_stmt_bind_param($stmt, "si", $data['categorie_nom'], $id);
            return mysqli_stmt_execute($stmt);
        }

        public function supprimerCategorie($id){
            $stmt = mysqli_prepare($this->conn, "DELETE FROM categorie WHERE categorie_id = ?");

            mysqli_stmt_bind_param($stmt, "i", $id);
            return mysqli_stmt_execute($stmt);
        }


        // lecon table
        public function getLecon($id){
            $stmt = mysqli_prepare($this->conn, "SELECT * FROM lecon WHERE lecon_id = ?");

            mysqli_stmt_bind_param($stmt, "i", $id);
            mysqli_stmt_execute($stmt);

            $result = mysqli_stmt_get_result($stmt);

            return mysqli_fetch_assoc($result);
        }

        public function getAllLecons(){
            $query = "SELECT * FROM lecon";

            $result = mysqli_query($this->conn, $query);

            return mysqli_fetch_all($result, MYSQLI_ASSOC);
        }

        public function creerLecon($data){
            $stmt = mysqli_prepare($this->conn, "INSERT INTO lecon(cours_id, lecon_titre, lecon_order) VALUES(?, ?, ?)");

            mysqli_stmt_bind_param($stmt, "isi", $data['cours_id'], $data['lecon_titre'], $data['lecon_order']);
            return mysqli_stmt_execute($stmt);
        }

        public function updateLecon($id, $data){
            $stmt = mysqli_prepare($this->conn, "UPDATE lecon SET cours_id = ?, lecon_titre = ?, lecon_order = ? WHERE lecon_id = ?");

            mysqli_stmt_bind_param($stmt, "isii", $data['cours_id'], $data['lecon_titre'], $data['lecon_order'], $id);
            return mysqli_stmt_execute($stmt);
        }

        public function supprimerLecon($id){
            $stmt = mysqli_prepare($this->conn, "DELETE FROM lecon WHERE lecon_id = ?");

            mysqli_stmt_bind_param($stmt, "i", $id);
            return mysqli_stmt_execute($stmt);
        }


        // exercice table
        public function getExercice($id){
            $stmt = mysqli_prepare($this->conn, "SELECT * FROM exercice WHERE exercice_id = ?");

            mysqli_stmt_bind_param($stmt, "i", $id);
            mysqli_stmt_execute($stmt);

            $result = mysqli_stmt_get_result($stmt);

            return mysqli_fetch_assoc($result);
        }

        public function getAllExercices(){
            $query = "SELECT * FROM exercice";

            $result = mysqli_query($this->conn, $query);

            return mysqli_fetch_all($result, MYSQLI_ASSOC);
        }

        public function creerExercice($data){
            $stmt = mysqli_prepare($this->conn, "INSERT INTO exercice(cours_id, lecon_id, exercice_titre) VALUES(?, ?, ?)");

            mysqli_stmt_bind_param($stmt, "iis", $data['cours_id'], $data['lecon_id'], $data['exercice_titre']);
            return mysqli_stmt_execute($stmt);
        }

        public function updateExercice($id, $data){
            $stmt = mysqli_prepare($this->conn, "UPDATE exercice SET cours_id = ?, lecon_id = ?, exercice_titre = ? WHERE exercice_id = ?");

            mysqli_stmt_bind_param($stmt, "iisi", $data['cours_id'], $data['lecon_id'], $data['exercice_titre'], $id);
            return mysqli_stmt_execute($stmt);
        }

        public function supprimerExercice($id){
            $stmt = mysqli_prepare($this->conn, "DELETE FROM exercice WHERE exercice_id = ?");

            mysqli_stmt_bind_param($stmt, "i", $id);
            return mysqli_stmt_execute($stmt);
        }

        
        // question table
        public function getQuestion($id){
            $stmt = mysqli_prepare($this->conn, "SELECT * FROM question WHERE question_id = ?");

            mysqli_stmt_bind_param($stmt, "i", $id);
            mysqli_stmt_execute($stmt);

            $result = mysqli_stmt_get_result($stmt);

            return mysqli_fetch_assoc($result);
        }

        public function getAllQuestions(){
            $query = "SELECT * FROM question";

            $result = mysqli_query($this->conn, $query);

            return mysqli_fetch_all($result, MYSQLI_ASSOC);
        }

        public function creerQuestion($data){
            $stmt = mysqli_prepare($this->conn, "INSERT INTO question(exercice_id, texte_question, question_type) VALUES(?, ?, ?)");

            mysqli_stmt_bind_param($stmt, "iss", $data['exercice_id'], $data['texte_question'], $data['question_type']);
            return mysqli_stmt_execute($stmt);
        }

        public function updateQuestion($id, $data){
            $stmt = mysqli_prepare($this->conn, "UPDATE question SET exercice_id = ?, texte_question = ?, question_type = ? WHERE question_id = ?");

            mysqli_stmt_bind_param($stmt, "issi", $data['exercice_id'], $data['texte_question'], $data['question_type'], $id);
            return mysqli_stmt_execute($stmt);
        }

        public function supprimerQuestion($id){
            $stmt = mysqli_prepare($this->conn, "DELETE FROM question WHERE question_id = ?");

            mysqli_stmt_bind_param($stmt, "i", $id);
            return mysqli_stmt_execute($stmt);
        }


        // choix table
        public function getChoix($id){
            $stmt = mysqli_prepare($this->conn, "SELECT * FROM choix WHERE choix_id = ?");

            mysqli_stmt_bind_param($stmt, "i", $id);
            mysqli_stmt_execute($stmt);

            $result = mysqli_stmt_get_result($stmt);

            return mysqli_fetch_assoc($result);
        }

        public function getAllChoixs(){
            $query = "SELECT * FROM choix";

            $result = mysqli_query($this->conn, $query);

            return mysqli_fetch_all($result, MYSQLI_ASSOC);
        }

        public function creerChoix($data){
            $stmt = mysqli_prepare($this->conn, "INSERT INTO choix(question_id, texte_choix, est_correct) VALUES(?, ?, ?)");

            mysqli_stmt_bind_param($stmt, "isi", $data['question_id'], $data['texte_choix'], $data['est_correct']);
            return mysqli_stmt_execute($stmt);
        }

        public function updateChoix($id, $data){
            $stmt = mysqli_prepare($this->conn, "UPDATE choix SET question_id = ?, texte_choix = ?, est_correct = ? WHERE choix_id = ?");

            mysqli_stmt_bind_param($stmt, "isii", $data['question_id'], $data['texte_choix'], $data['est_correct'], $id);
            return mysqli_stmt_execute($stmt);
        }

        public function supprimerChoix($id){
            $stmt = mysqli_prepare($this->conn, "DELETE FROM choix WHERE choix_id = ?");

            mysqli_stmt_bind_param($stmt, "i", $id);
            return mysqli_stmt_execute($stmt);
        }


        // inscription table
        public function getInscription($id){
            $stmt = mysqli_prepare($this->conn, "SELECT * FROM inscription WHERE inscription_id = ?");

            mysqli_stmt_bind_param($stmt, "i", $id);
            mysqli_stmt_execute($stmt);

            $result = mysqli_stmt_get_result($stmt);

            return mysqli_fetch_assoc($result);
        }

        public function getAllInscriptions(){
            $query = "SELECT * FROM inscription";

            $result = mysqli_query($this->conn, $query);

            return mysqli_fetch_all($result, MYSQLI_ASSOC);
        }

        public function creerInscription($data){
            $stmt = mysqli_prepare($this->conn, "INSERT INTO inscription(etudiant_id, cours_id, note_finale) VALUES(?, ?, ?)");

            mysqli_stmt_bind_param($stmt, "iid", $data['etudiant_id'], $data['cours_id'], $data['note_finale']);
            return mysqli_stmt_execute($stmt);
        }

        public function supprimerInscription($id){
            $stmt = mysqli_prepare($this->conn, "DELETE FROM inscription WHERE inscription_id = ?");

            mysqli_stmt_bind_param($stmt, "i", $id);
            return mysqli_stmt_execute($stmt);
        }


        // soumission table
        public function getSoumission($id){
            $stmt = mysqli_prepare($this->conn, "SELECT * FROM soumission WHERE soumission_id = ?");

            mysqli_stmt_bind_param($stmt, "i", $id);
            mysqli_stmt_execute($stmt);

            $result = mysqli_stmt_get_result($stmt);

            return mysqli_fetch_assoc($result);
        }

        public function getAllSoumissions(){
            $query = "SELECT * FROM soumission";

            $result = mysqli_query($this->conn, $query);

            return mysqli_fetch_all($result, MYSQLI_ASSOC);
        }


        public function creerSoumission($data){
            $stmt = mysqli_prepare($this->conn, "INSERT INTO soumission(etudiant_id, question_id, soumission_reponse, url_fichier, soumis_le, note) VALUES(?, ?, ?, ?, ?, ?)");

            mysqli_stmt_bind_param($stmt, "iisssd", $data['etudiant_id'], $data['question_id'], $data['soumission_reponse'], $data['url_fichier'], $data['soumis_le'], $data['note']);
            return mysqli_stmt_execute($stmt);
        }

        public function updateSoumission($id, $data){
            $stmt = mysqli_prepare($this->conn, "UPDATE soumission SET note = ?, commentaire = ?, corrige_le = ?, corrige_par = ? WHERE soumission_id = ?");

            mysqli_stmt_bind_param($stmt, "dssii", $data['note'], $data['commentaire'], $data['corrige_le'], $data['corrige_par'], $id);
            return mysqli_stmt_execute($stmt);
        }


        // progression table
        public function getProgression($id){
            $stmt = mysqli_prepare($this->conn, "SELECT * FROM progression WHERE progression_id = ?");

            mysqli_stmt_bind_param($stmt, "i", $id);
            mysqli_stmt_execute($stmt);

            $result = mysqli_stmt_get_result($stmt);

            return mysqli_fetch_assoc($result);
        }

        public function getAllProgressions(){
            $query = "SELECT * FROM progression";

            $result = mysqli_query($this->conn, $query);

            return mysqli_fetch_all($result, MYSQLI_ASSOC);
        }

        public function creerProgression($data){
            $stmt = mysqli_prepare($this->conn, "INSERT INTO progression(etudiant_id, cours_id, complete_le, derniere_lecon_id, modifie_le) VALUES(?, ?, ?, ?, ?)");

            mysqli_stmt_bind_param($stmt, "iisis", $data['etudiant_id'], $data['cours_id'], $data['complete_le'], $data['derniere_lecon_id'], $data['modifie_le']);
            return mysqli_stmt_execute($stmt);
        }

        public function updateProgression($id, $data){
            $stmt = mysqli_prepare($this->conn, "UPDATE progression SET etudiant_id = ?, cours_id = ?, complete_le = ?, derniere_lecon_id = ?, modifie_le = ? WHERE progression_id = ?");

            mysqli_stmt_bind_param($stmt, "iisisi", $data['etudiant_id'], $data['cours_id'], $data['complete_le'], $data['derniere_lecon_id'], $data['modifie_le'], $id);
            return mysqli_stmt_execute($stmt);
        }


        // progressionLecon table
        public function getProgressionLecon($id){
            $stmt = mysqli_prepare($this->conn, "SELECT * FROM progression_lecon WHERE progression_lecon_id = ?");

            mysqli_stmt_bind_param($stmt, "i", $id);
            mysqli_stmt_execute($stmt);

            $result = mysqli_stmt_get_result($stmt);

            return mysqli_fetch_assoc($result);
        }

        public function getAllProgressionLecons(){
            $query = "SELECT * FROM progression_lecon";

            $result = mysqli_query($this->conn, $query);

            return mysqli_fetch_all($result, MYSQLI_ASSOC);
        }

        public function creerProgressionLecon($data){
            $stmt = mysqli_prepare($this->conn, "INSERT INTO progression_lecon(cours_id, lecon_id, etudiant_id, complete_le) VALUES(?, ?, ?, ?)");

            mysqli_stmt_bind_param($stmt, "iiis", $data['cours_id'], $data['lecon_id'], $data['etudiant_id'], $data['complete_le']);
            return mysqli_stmt_execute($stmt);
        }


        // leconTexte table
        public function getLeconTexte($id){
            $stmt = mysqli_prepare($this->conn, "SELECT * FROM lecon_texte WHERE texte_id = ?");

            mysqli_stmt_bind_param($stmt, "i", $id);
            mysqli_stmt_execute($stmt);

            $result = mysqli_stmt_get_result($stmt);

            return mysqli_fetch_assoc($result);
        }

        public function getAllLeconTextes(){
            $query = "SELECT * FROM lecon_texte";

            $result = mysqli_query($this->conn, $query);

            return mysqli_fetch_all($result, MYSQLI_ASSOC);
        }

        public function creerLeconTexte($data){
            $stmt = mysqli_prepare($this->conn, "INSERT INTO lecon_texte(lecon_id, cours_id, contenu_texte, texte_order) VALUES(?, ?, ?, ?)");

            mysqli_stmt_bind_param($stmt, "iisi", $data['lecon_id'], $data['cours_id'], $data['contenu_texte'], $data['texte_order']);
            return mysqli_stmt_execute($stmt);
        }


        // leconPDF table
        public function getLeconPdf($id){
            $stmt = mysqli_prepare($this->conn, "SELECT * FROM lecon_pdf WHERE pdf_id = ?");

            mysqli_stmt_bind_param($stmt, "i", $id);
            mysqli_stmt_execute($stmt);

            $result = mysqli_stmt_get_result($stmt);

            return mysqli_fetch_assoc($result);
        }

        public function getAllLeconPdfs(){
            $query = "SELECT * FROM lecon_pdf";

            $result = mysqli_query($this->conn, $query);

            return mysqli_fetch_all($result, MYSQLI_ASSOC);
        }

        public function creerLeconPdf($data){
            $stmt = mysqli_prepare($this->conn, "INSERT INTO lecon_pdf(lecon_id, cours_id, url_pdf, pdf_order) VALUES(?, ?, ?, ?)");

            mysqli_stmt_bind_param($stmt, "iisi", $data['lecon_id'], $data['cours_id'], $data['url_pdf'], $data['pdf_order']);
            return mysqli_stmt_execute($stmt);
        }


        // leconPDF table
        public function getLeconVideo($id){
            $stmt = mysqli_prepare($this->conn, "SELECT * FROM lecon_video WHERE video_id = ?");

            mysqli_stmt_bind_param($stmt, "i", $id);
            mysqli_stmt_execute($stmt);

            $result = mysqli_stmt_get_result($stmt);

            return mysqli_fetch_assoc($result);
        }

        public function getAllLeconVideos(){
            $query = "SELECT * FROM lecon_video";

            $result = mysqli_query($this->conn, $query);

            return mysqli_fetch_all($result, MYSQLI_ASSOC);
        }

        public function creerLeconVideo($data){
            $stmt = mysqli_prepare($this->conn, "INSERT INTO lecon_video(lecon_id, cours_id, url_video, video_order) VALUES(?, ?, ?, ?)");

            mysqli_stmt_bind_param($stmt, "iisi", $data['lecon_id'], $data['cours_id'], $data['url_video'], $data['video_order']);
            return mysqli_stmt_execute($stmt);
        }
    }

        