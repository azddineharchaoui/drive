<?php
require_once('Vehicule.php');

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    try {
        $nomModele = $_POST['nomModele'];
        $idCategorie = $_POST['idCategorie'];
        $prixJournee = $_POST['prixJournee'];
        $disponibilite = $_POST['disponibilite'];


        if (isset($_FILES['imageUrl']) && $_FILES['imageUrl']['error'] === UPLOAD_ERR_OK) {
            $imagePath = $_FILES['imageUrl']['tmp_name'];
            $vehicule = new Vehicule(null, $nomModele, $idCategorie, $prixJournee, $disponibilite, null);
            $vehicule->set_imageUrl($imagePath);

            if ($vehicule->ajouterVehicule()) {
                echo "Véhicule ajouté avec succès.";
            } else {
                echo "Erreur lors de l'ajout du véhicule.";
            }
        } else {
            echo "Erreur lors de l'upload de l'image.";
        }
    } catch (Exception $e) {
        echo "Erreur : " . $e->getMessage();
    }
}
?>
