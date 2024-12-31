<?php
require_once('db.php');

class Reservation {
    private $id;
    private $idUtilisateur;
    private $idVehicule;
    private $dateDebut;
    private $dateFin;
    private $lieuDepart;
    private $lieuRetour;
    private $statut;

    public function __construct($id = null, $idUtilisateur = null, $idVehicule = null, $dateDebut = null, $dateFin = null, $lieuDepart = null, $lieuRetour = null, $statut = 'en attente') {
        $this->id = $id;
        $this->idUtilisateur = $idUtilisateur;
        $this->idVehicule = $idVehicule;
        $this->dateDebut = $dateDebut;
        $this->dateFin = $dateFin;
        $this->lieuDepart = $lieuDepart;
        $this->lieuRetour = $lieuRetour;
        $this->statut = $statut;
    }

    public function ajouterReservation() {
        $pdo = DatabaseConnection::getInstance()->getConnection();
        $query = "CALL AjouterReservation(:idUtilisateur, :idVehicule, :dateDebut, :dateFin, :lieuDepart, :lieuRetour)";
        $stmt = $pdo->prepare($query);
        $stmt->bindParam(':idUtilisateur', $this->idUtilisateur, PDO::PARAM_INT);
        $stmt->bindParam(':idVehicule', $this->idVehicule, PDO::PARAM_INT);
        $stmt->bindParam(':dateDebut', $this->dateDebut);
        $stmt->bindParam(':dateFin', $this->dateFin);
        $stmt->bindParam(':lieuDepart', $this->lieuDepart);
        $stmt->bindParam(':lieuRetour', $this->lieuRetour);
        return $stmt->execute();
    }

    public function modifierReservation($id) {
        $pdo = DatabaseConnection::getInstance()->getConnection();
        $query = "UPDATE Reservations 
                  SET id_utilisateur = :idUtilisateur, id_vehicule = :idVehicule, date_debut = :dateDebut, 
                      date_fin = :dateFin, lieu_depart = :lieuDepart, lieu_retour = :lieuRetour, statut = :statut 
                  WHERE id_reservation = :id";
        $stmt = $pdo->prepare($query);
        $stmt->bindParam(':idUtilisateur', $this->idUtilisateur, PDO::PARAM_INT);
        $stmt->bindParam(':idVehicule', $this->idVehicule, PDO::PARAM_INT);
        $stmt->bindParam(':dateDebut', $this->dateDebut);
        $stmt->bindParam(':dateFin', $this->dateFin);
        $stmt->bindParam(':lieuDepart', $this->lieuDepart);
        $stmt->bindParam(':lieuRetour', $this->lieuRetour);
        $stmt->bindParam(':statut', $this->statut);
        $stmt->bindParam(':id', $id, PDO::PARAM_INT);
        return $stmt->execute();
    }

    public function annulerReservation($id) {
        $pdo = DatabaseConnection::getInstance()->getConnection();
        $query = "UPDATE Reservations SET statut = 'annulée' WHERE id_reservation = :id";
        $stmt = $pdo->prepare($query);
        $stmt->bindParam(':id', $id, PDO::PARAM_INT);
        return $stmt->execute();
    }

    public function confirmerReservation($id) {
        $pdo = DatabaseConnection::getInstance()->getConnection();
        $query = "UPDATE Reservations SET statut = 'confirmée' WHERE id_reservation = :id";
        $stmt = $pdo->prepare($query);
        $stmt->bindParam(':id', $id, PDO::PARAM_INT);
        return $stmt->execute();
    }

    public static function listerReservations() {
        $pdo = DatabaseConnection::getInstance()->getConnection();
        $query = "SELECT r.id_reservation, r.date_debut, r.date_fin, r.lieu_depart, r.lieu_retour, 
                         r.statut, v.nom_modele, v.prix_journee 
                  FROM Reservations r
                  JOIN Vehicules v ON r.id_vehicule = v.id_vehicule";
        $stmt = $pdo->query($query);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
    public static function listerReservationsParId($id) {
        $pdo = DatabaseConnection::getInstance()->getConnection();
        $query = "SELECT r.id_reservation, r.date_debut, r.date_fin, r.lieu_depart, r.lieu_retour, 
                         r.statut, v.nom_modele, v.prix_journee 
                  FROM Reservations r
                  JOIN Vehicules v ON r.id_vehicule = v.id_vehicule
                  WHERE r.id_utilisateur = :id
                  ORDER BY r.date_debut DESC";
        $stmt = $pdo->prepare($query);
        $stmt->bindParam(':id', $id, PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
    
}
?>
