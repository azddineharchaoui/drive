<?php 
    require_once('Utilisateur.php');

    class Client extends Utilisateur {
        public function register() {
            try {
                $pdo = DatabaseConnection::getInstance()->getConnection();
                if ($pdo === null) {
                    echo "Erreur : la connexion à la bases de données ne peut pas être établie !";
                    return false;
                }
                if (empty($this->password)) {
                    echo "Erreur : Le mot de passe est manquant.";
                    return false;
                }
                $sql = "INSERT INTO users (nom, prenom, email, mot_de_passe, id_role) VALUES (:nom, :prenom, :email, :password, :id_role)";
                $stmt = $pdo->prepare($sql);
                $stmt->bindParam(':nom', $this->nom);
                $stmt->bindParam(':prenom', $this->prenom);
                $stmt->bindParam(':email', $this->email);
                $stmt->bindParam(':mot_de_passe', $this->password);
                $stmt->bindParam(':id_role', $this->id_role, PDO::PARAM_INT);
    
                if ($stmt->execute()) {
                    $this->id = $pdo->lastInsertId();
                    return true;
                }
            } catch (PDOException $e) {
                echo "Erreur d'inscription: " . $e->getMessage();
                return false;
            } catch (Exception $e) {
                echo "Erreur: " . $e->getMessage();
                return false;
            }
        }
    }

?>