<?php require_once "../inc/init.php" ?>

<?php

    // AJOUT D'UN VEHICULE 
        if( isset($_POST['ajouterVehicule']) ){
            
            // Sécurisation des données
                dataEscape();
            //

            // Vérification des données
                if( empty($_POST['titre_vehicule']) ){
                    $_SESSION['error']['titre_vehicule'] = "Merci d'ajouter un titre";
                }
                if( empty($_POST['marque']) || iconv_strlen($_POST['marque']) > 50 ){
                    $_SESSION['error']['marque'] = "Merci d'ajouter un marque (caractères max 50)";
                }
                if( empty($_POST['modele']) || iconv_strlen($_POST['modele']) > 50 ){
                    $_SESSION['error']['modele'] = "Merci d'ajouter un modèle (caractères max 50)";
                }
                if( empty($_POST['description_vehicule']) ){
                    $_SESSION['error']['description_vehicule'] = "Merci d'ajouter une description";
                }
                if( empty($_POST['prix_journalier']) || !is_numeric($_POST['prix_journalier']) || $_POST['prix_journalier'] <= 0 ){
                    $_SESSION['error']['prix_journalier'] = "Merci d'indiquer un prix journalier supèrieur à 0€";
                }
                if( empty($_POST['id_agence']) ){
                    $_SESSION['error']['id_agence'] = "Merci de sélectionner une Agence";
                }
            //

            // Upload de la photo
                if( empty($_FILES['photo_vehicule']['name']) ){
                    $_SESSION['error']['photo_vehicule'] = "Merci de sélectionner une photo";
                } else {

                    copy($_FILES['photo_vehicule']['tmp_name'], RACINE_SITE . "assets/images/vehicules/" . $_FILES['photo_vehicule']['name']);

                    $_POST['photo_vehicule'] = $_FILES['photo_vehicule']['name'];

                }
            //

            // Envoie des données
                if(!isset($_SESSION['error'])){

                    $success = addVehicule($_POST);

                    if($success){
                        $_SESSION['success'] = "Vehicule ajouté";
                    } else {
                        $_SESSION['error']['general'] = "Erreur lors de l'insertion";
                    }

                }
            //
        }
    //

    // GESTION DE LA SUPPRESSION DES DONNÉES 
        if( isset($_GET['action']) && $_GET['action'] === "supprimer" ){

            $success = deleteFrom($_GET['id_vehicule'], 'vehicule');

            if($success){
                $_SESSION['success'] = "Le vehicule bien a été supprimé";
            } else {
                $_SESSION['error']['general'] = "Erreur lors de la suppression";
            }
            
        }
    //

    // GESTION DE LA MODIFICATION DES DONNÉES
        if(isset($_GET['action']) && $_GET['action'] === "modifier"){

            // Récupération du véhicule
                $vehiculeSelected = getVehiculeById($_GET['id_vehicule']);
                $formData = formData($vehiculeSelected);

                // debug($formData);
            //

        }
    //

    // Récupération des agences pour le select/option
    $agences = getAllAgences();
    $vehicules = getAllVehicules();
        // debug($vehicules);
?>

<?php $title = "Gestion vehicules"; require_once RACINE_SITE . "inc/header.php" ?>

<section class="mainAdmin col">

    <?php
        if( isset($_SESSION['success']) ){
            echo '<div class="alert alert-success col-md-6 mx-auto text-center">';
                echo $_SESSION['success'];
                unset($_SESSION['success']);
            echo '</div>';
        }
        
        if( isset($_SESSION['error']['general']) ){
            echo '<div class="alert alert-danger col-md-6 mx-auto text-center">';
                echo $_SESSION['error']['general'];
                unset($_SESSION['error']['general']);
            echo '</div>';
        }
    ?>
    <!-- Exercice : 
        Récupérer les véhicules via une fonction et les afficher dans le tableau
    -->
    <!-- Tableau des Véhicules -->
        <table class="table text-center mt-5">
            <thead>
                <tr>
                    <th>id</th>
                    <th>Titre</th>
                    <th>Description</th>
                    <th>Marque</th>
                    <th>Modèle</th>
                    <th>Prix Journalier</th>
                    <th>Photo</th>
                    <th>Agence</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach($vehicules as $vehicule) : ?>
                    <tr>
                        <td><?= $vehicule['id_vehicule'] ?></td>
                        <td><?= $vehicule['titre_vehicule'] ?></td>
                        <td><?= $vehicule['description_vehicule'] ?></td>
                        <td><?= $vehicule['marque'] ?></td>
                        <td><?= $vehicule['modele'] ?></td>
                        <td><?= $vehicule['prix_journalier'] . "€" ?></td>
                        <td>
                            <img src="<?= URL ?>assets/images/vehicules/<?= $vehicule['photo_vehicule'] ?>" alt="" width="150px">
                        </td>
                        <td><?= $vehicule['titre_agence'] ?></td>
                        <td>
                            <a href="?action=modifier&id_vehicule=<?= $vehicule['id_vehicule'] ?>" class="text-warning me-2"><i class="fa-solid fa-pen-to-square"></i></a>
                            <a href="?action=supprimer&id_vehicule=<?= $vehicule['id_vehicule'] ?>" class="text-danger ms-2"><i class="fa-solid fa-trash"></i></a>
                        </td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    <!--  -->


    <!-- Formulaire d'ajout et de mofication -->
    <h3 class="text-center mt-5">Ajouter un Véhicule</h3>

    <form action="" method="POST" class="d-flex flex-wrap justify-content-between mx-5 mb-5" enctype="multipart/form-data">
        <div class="form-group col-md-5 my-3">
            <label for="titre_vehicule">Titre</label>
            <input class="form-control <?= isset($_SESSION['error']['titre_vehicule']) ? "is-invalid" : "" ?>" type="text" name="titre_vehicule" id="titre_vehicule" placeholder="Titre" value="<?= $formData['titre_vehicule'] ?? "" ?>">
            <div class="invalid-feedback">
                <?= $_SESSION['error']['titre_vehicule'] ?? "" ?>
            </div>
        </div>
        <div class="form-group col-md-5 my-3">
            <label for="description_vehicule">Description</label>
            <textarea class="form-control <?= isset($_SESSION['error']['description_vehicule']) ? "is-invalid" : "" ?>" name="description_vehicule" id="description_vehicule" cols="30" rows="3" placeholder="Description du véhicule"><?= $formData['description_vehicule'] ?? "" ?></textarea>
            <div class="invalid-feedback">
                <?= $_SESSION['error']['description_vehicule'] ?? "" ?>
            </div>
        </div>
        <div class="form-group col-md-5 my-3">
            <label for="marque">Marque</label>
            <input class="form-control <?= isset($_SESSION['error']['marque']) ? "is-invalid" : "" ?>" type="text" name="marque" id="marque" placeholder="Marque du Véhicule" value="<?= $formData['marque'] ?? "" ?>">
            <div class="invalid-feedback">
                <?= $_SESSION['error']['marque'] ?? "" ?>
            </div>
        </div>
        <div class="form-group col-md-5 my-3">
            <label for="modele">Modèle</label>
            <input class="form-control <?= isset($_SESSION['error']['modele']) ? "is-invalid" : "" ?>" type="text" name="modele" id="modele" placeholder="Modèle du Véhicule" value="<?= $formData['modele'] ?? "" ?>">
            <div class="invalid-feedback">
                <?= $_SESSION['error']['modele'] ?? "" ?>
            </div>
        </div>
        <div class="form-group col-md-5 my-3">
            <label for="photo_vehicule">Photo</label>
            <input class="form-control <?= isset($_SESSION['error']['photo_vehicule']) ? "is-invalid" : "" ?>" type="file" name="photo_vehicule" id="photo_vehicule" value="<?= $formData['photo_vehicule'] ?? "" ?>">
            <div class="invalid-feedback">
                <?= $_SESSION['error']['photo_vehicule'] ?? "" ?>
            </div>
        </div>
        <div class="form-group col-md-5 my-3">
            <label for="prix_journalier">Prix Journalier</label>
            <input class="form-control <?= isset($_SESSION['error']['prix_journalier']) ? "is-invalid" : "" ?>" type="number" name="prix_journalier" id="prix_journalier" value="<?= $formData['prix_journalier'] ?? "" ?>">
            <div class="invalid-feedback">
                <?= $_SESSION['error']['prix_journalier'] ?? "" ?>
            </div>
        </div>

        <div class="form-group col-md-5 my-3">
            <label for="id_agence" class="form-label">Agence</label>
            <select class="form-select <?= isset($_SESSION['error']['id_agence']) ? "is-invalid" : "" ?>" name="id_agence" id="id_agence">
                <option selected disabled>Agence</option>
                <?php foreach ($agences as $agence) { ?>
                    <option value="<?= $agence['id_agence'] ?>"><?= $agence['titre_agence'] ?></option>
                <?php } ?>
            </select>
            <div class="invalid-feedback">
                <?= $_SESSION['error']['id_agence'] ?? "" ?>
            </div>
        </div>


        <div class="col-12 d-flex justify-content-center mt-3">
            <button class="btn btn-primary" name="ajouterVehicule">Ajouter le véhicule</button>
        </div>

    </form>

    <?php unset($_SESSION['error']) ?>

</section>


<?php require_once RACINE_SITE . "inc/footer.php" ?>