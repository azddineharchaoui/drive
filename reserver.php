<?php

session_start();
require_once 'Classes/Reservation.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $id_utilisateur = $_SESSION['user_id'];
    $id_vehicule = $_POST['id_voiture'];
    $date_debut = $_POST['date_debut'];
    $date_fin = $_POST['date_fin'];
    $lieu_depart = $_POST['lieu_depart'];
    $lieu_retour = $_POST['lieu_retour'];

    $reservation = new Reservation();
    if ($reservation->reserverVoiture($id_utilisateur, $id_vehicule, $date_debut, $date_fin, $lieu_depart, $lieu_retour)) {
        header("Location: index.php?message=Réservation effectuée avec succès");
    } else {
        header("Location: index.php?message=Erreur lors de la réservation");
    }
}
?>
