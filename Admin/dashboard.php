<?php 
// session_start();
// if (!isset($_SESSION['user_id']) || (isset($_SESSION['role_id']) && $_SESSION['role_id'] != 1)) {
//     header("Location: ../index.php");
//     exit;
// }

?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <style>
    .custom-btn {
        background-color: #ce1212;
        color: #fff;
    }
    </style>
</head>

<body>
    <nav class="navbar fixed-top navbar-expand-lg navbar-dark bg-dark">
        <div class="container-fluid">
            <a class="navbar-brand" href="#">Admin</a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav"
                aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav">
                    <li class="nav-item">
                        <a class="nav-link active" aria-current="page" href="../index.php">Home</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#reservations">Reservations</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#activites">Activités</a>
                    </li>

                </ul>
            </div>
        </div>
    </nav>

    <div class="container-fluid">
        <div class="row">
            <!-- Main Content -->
            <main class="col-md-12 ms-sm-auto col-lg-12 px-md-4 mt-10">
                <div
                    class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom ">
                    <h1 class="h2">Dashboard</h1>
                </div>

                <!-- Reservations Table -->
                <div class="card mb-4" id="reservations">
                    <div class="card-header">
                        <i class="fas fa-calendar-check"></i>Reservations récentes
                    </div>

                    <?php 
                    require_once('../Classes/Reservation.php');
                    $reservations = Reservation::listerReservations();?>
                    <div class="row row-cols-1 row-cols-md-3 g-4">
                        <?php foreach ($reservations as $reservation): ?>
                        <div class="col">
                            <div class="card h-100 shadow">
                                <div class="card-body">
                                    <h5 class="card-title">Réservation #<?= $reservation['id_reservation'] ?></h5>
                                    <p class="card-text">
                                        <strong>Modèle :</strong> <?= $reservation['nom_modele'] ?><br>
                                        <strong>Date Début :</strong> <?= $reservation['date_debut'] ?><br>
                                        <strong>Date Fin :</strong> <?= $reservation['date_fin'] ?><br>
                                        <strong>Lieu Départ :</strong> <?= $reservation['lieu_depart'] ?><br>
                                        <strong>Lieu Retour :</strong> <?= $reservation['lieu_retour'] ?><br>
                                        <strong>Statut :</strong>
                                        <span
                                            class="badge bg-<?= $reservation['statut'] == 'en attente' ? 'warning text-dark' : ($reservation['statut'] == 'confirmée' ? 'success' : 'danger') ?>">
                                            <?= ucfirst($reservation['statut']) ?>
                                        </span><br>
                                    </p>
                                </div>
                                <div class="card-footer d-flex justify-content-between">
                                    <button class="btn btn-success w-45">Accepter</button>
                                    <button class="btn btn-danger w-45">Refuser</button>
                                </div>
                            </div>
                        </div>
                        <?php endforeach; ?>
                    </div>


                </div>

                <!-- Manage Vehicules Section -->
                <div class="card mb-4" id="vehicules">
                    <div class="card-header bg-primary text-white">
                        <h2 class="text-center">Ajout de Véhicule</h2>
                    </div>
                    <div class="card-body">
                        <form action="ajouterVehicule.php" method="post" enctype="multipart/form-data">
                            <div class="mb-3">
                                <label for="nomModele" class="form-label">Nom du Modèle :</label>
                                <input type="text" class="form-control" name="nomModele" id="nomModele"
                                    placeholder="Entrez le modèle du véhicule" required>
                            </div>

                            <div class="mb-3">
                                <label for="idCategorie" class="form-label">Catégorie :</label>
                                <select class="form-select" name="idCategorie" id="idCategorie" required>
                                    <option value="" disabled selected>Choisissez une catégorie</option>
                                    <?php
                                        require_once('Categorie.php');
                                        $categories = Categorie::listerCategories();
                                        foreach ($categories as $categorie) {
                                            echo '<option value="' . htmlspecialchars($categorie['id_categorie']) . '">' . htmlspecialchars($categorie['nom_categorie']) . '</option>';
                                        }
                                    ?>
                                </select>
                            </div>

                            <div class="mb-3">
                                <label for="prixJournee" class="form-label">Prix par Journée :</label>
                                <input type="number" class="form-control" name="prixJournee" id="prixJournee"
                                    step="0.01" placeholder="Entrez le prix par journée" required>
                            </div>

                            <div class="mb-3">
                                <label for="disponibilite" class="form-label">Disponibilité :</label>
                                <select class="form-select" name="disponibilite" id="disponibilite" required>
                                    <option value="" disabled selected>Choisissez la disponibilité</option>
                                    <option value="Disponible">Disponible</option>
                                    <option value="Non disponible">Non disponible</option>
                                </select>
                            </div>

                            <div class="mb-3">
                                <label for="imageUrl" class="form-label">Image du Véhicule :</label>
                                <input type="file" class="form-control" name="imageUrl" id="imageUrl" accept="image/*"
                                    required>
                            </div>

                            <div class="text-center">
                                <button type="submit" class="btn btn-primary w-50">Ajouter Véhicule</button>
                            </div>
                        </form>
                    </div>
                </div>

                <!-- Liste des Véhiculess -->
                <h3>Liste des Véhicules</h3>
                <table class="table table-striped">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>Nom</th>
                            <th>Description</th>
                            <th>Destination</th>
                            <th>Prix</th>
                            <th>Date de début</th>
                            <th>Date de fin</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                require_once("../classes/activity.php");

                $activity = new Activity(null, null, null, null, null, null);
                $activites = $activity->allActivites();
                if (count($activites) > 0): ?>
                        <?php foreach ($activites as $act): ?>
                        <tr>
                            <td><?= $act['id_activite']; ?></td>
                            <td><?= $act['name']; ?></td>
                            <td><?= $act['description']; ?></td>
                            <td><?= $act['destination']; ?></td>
                            <td><?= $act['price']; ?></td>
                            <td><?= $act['start_date']; ?></td>
                            <td><?= $act['end_date']; ?></td>
                            <td>
                                <button type="button" class="btn btn-success btn-sm editActivityBtn"
                                    data-id="<?= $act['id_activite']; ?>" data-name="<?= $act['name']; ?>"
                                    data-description="<?= $act['description']; ?>"
                                    data-destination="<?= $act['destination']; ?>" data-price="<?= $act['price']; ?>"
                                    data-start-date="<?= $act['start_date']; ?>"
                                    data-end-date="<?= $act['end_date']; ?>">
                                    Modifier
                                </button>
                                <form method="POST" action="manage_activities.php" class="d-inline">
                                    <button type="submit" name="delete_activity" value="<?= $act['id_activite']; ?>"
                                        class="btn btn-danger btn-sm">Supprimer</button>
                                </form>
                            </td>
                        </tr>
                        <?php endforeach; ?>
                        <?php else: ?>
                        <tr>
                            <td colspan="8" class="text-center">Aucune activité trouvée.</td>
                        </tr>
                        <?php endif; ?>
                    </tbody>
                </table>
        </div>
    </div>
    <!-- Modal Modifier Activité -->
    <div class="modal fade" id="editActivityModal" tabindex="-1" aria-labelledby="editActivityModalLabel"
        aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <form method="POST" action="manage_activities.php">
                    <div class="modal-header">
                        <h5 class="modal-title" id="editActivityModalLabel">Modifier une Activité</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <input type="hidden" id="edit_activity_id" name="id_act">
                        <div class="mb-3">
                            <label for="edit_activity_name" class="form-label">Nom d'activité</label>
                            <input type="text" class="form-control" id="edit_activity_name" name="menu_name" required>
                        </div>
                        <div class="mb-3">
                            <label for="edit_activity_description" class="form-label">Description</label>
                            <textarea class="form-control" id="edit_activity_description" name="activite_description"
                                rows="4" required></textarea>
                        </div>
                        <div class="mb-3">
                            <label for="edit_activity_destination" class="form-label">Destination</label>
                            <input type="text" class="form-control" id="edit_activity_destination"
                                name="activite_destination" required>
                        </div>
                        <div class="mb-3">
                            <label for="edit_activity_price" class="form-label">Prix</label>
                            <input type="text" class="form-control" id="edit_activity_price" name="activite_price"
                                required>
                        </div>
                        <div class="mb-3">
                            <label for="edit_activity_start_date" class="form-label">Date de début</label>
                            <input type="date" class="form-control" id="edit_activity_start_date" name="start_date"
                                required>
                        </div>
                        <div class="mb-3">
                            <label for="edit_activity_end_date" class="form-label">Date de fin</label>
                            <input type="date" class="form-control" id="edit_activity_end_date" name="end_date"
                                required>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Fermer</button>
                        <button type="submit" name="edit_activity" class="btn btn-primary">Enregistrer</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    </main>
    </div>
    </div>




    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>


</body>

</html>