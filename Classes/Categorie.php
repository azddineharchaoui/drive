<?php 
    require_once('db.php');

    class Categorie{
        private $id; 
        private $nom; 
        private $description;
        public function __construct($id, $nom, $description){
            $this->id = $id; 
            $this->nom = $nom; 
            $this->description = $description;
        }
        public function get_id(){
            return $this->id;
        }
        public function set_id($id){
            $this->id = $id;
        }
        public function get_nom(){
            return $this->nom;
        }
        public function set_nom($nom){
            $this->nom = $nom;
        }
        public function get_description(){
            return $this->description;
        }
        public function set_description($description){
            $this->description = $description;
        }

        public function ajouterCategorie() {
            $pdo = DatabaseConnection::getInstance()->getConnection();
            if (!$pdo) {
                echo "Erreur de connexion à la base de données.";
                return false;
            }
            $query = "INSERT INTO Categories (nom_categorie, description) VALUES (:nom, :description)";
            $stmt = $pdo->prepare($query);
            $stmt->bindParam(':nom', $this->nom);
            $stmt->bindParam(':description', $this->description);
            if ($stmt->execute()) {
                $this->id = $db->lastInsertId(); 
                return true;
            } else {
                return false;
            }
        }
    
        public function modifierCategorie($id) {
            $pdo = DatabaseConnection::getInstance()->getConnection();
            if (!$pdo) {
                echo "Erreur de connexion à la base de données.";
                return false;
            }
            $query = "UPDATE Categories SET nom_categorie = :nom, description = :description WHERE id_categorie = :id";
            $stmt = $pdo->prepare($query);
            $stmt->bindParam(':nom', $this->nom);
            $stmt->bindParam(':description', $this->description);
            $stmt->bindParam(':id', $id, PDO::PARAM_INT);
            return $stmt->execute();
        }
    
        public function supprimerCategorie($id) {
            $pdo = DatabaseConnection::getInstance()->getConnection();
            if (!$pdo) {
                echo "Erreur de connexion à la base de données.";
                return false;
            }
            $query = "DELETE FROM Categories WHERE id_categorie = :id";
            $stmt = $pdo->prepare($query);
            $stmt->bindParam(':id', $id, PDO::PARAM_INT);
            return $stmt->execute();
        }
    
        public static function listerCategories() {
            $pdo = DatabaseConnection::getInstance()->getConnection();
            if (!$pdo) {
                echo "Erreur de connexion à la base de données.";
                return [];
            }
            $query = "SELECT id_categorie, nom_categorie FROM Categories";
            $stmt = $pdo->prepare($query);
            $stmt->execute();
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        }
        
    }

?>