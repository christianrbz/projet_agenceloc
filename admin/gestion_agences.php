<?php require_once "../inc/init.php"; ?>

<?php

    // AJOUT D'UNE AGENCE EN BDD
        if( isset($_POST['ajouterAgence']) ){   

            $formData = formData($_POST);

            // Sécurisation des données
                dataEscape();
            //

            // Vérification des données
                if( empty($_POST['titre_agence']) ){
                    $_SESSION['error']['titre_agence'] = "Merci d'indiquer un titre";
                }
                if( empty($_POST['adresse']) ){
                    $_SESSION['error']['adresse'] = "Merci d'indiquer une adresse";
                }
                if(empty($_POST['ville']) || !in_array($_POST['ville'], ['paris', 'marseille', 'toulouse'])){
                    $_SESSION['error']['ville'] = "Merci de sélectionner une ville dans la liste donnée";
                }
                if (empty($_POST['cp']) || !is_numeric($_POST['cp']) || iconv_strlen($_POST['cp']) != 5 ) {
                    $_SESSION['error']['cp'] = "Merci d'indiquer un code postal valide";
                }
                if( empty($_POST['description_agence']) ){
                    $_SESSION['error']['description_agence'] = "Merci d'indiquer une description";
                }
            //

            // Upload Photo
                // debug($_FILES);
                if(empty($_FILES['photo_agence']['name'])){
                    $_SESSION['error']['photo_agence'] = "Merci de sélectionner une photo";
                } else {

                    copy($_FILES['photo_agence']['tmp_name'], RACINE_SITE . "assets/images/agences/". $_FILES['photo_agence']['name']);

                    $_POST['photo_agence'] = $_FILES['photo_agence']['name'];

                }
            //
            
            // Envoie des données si je n'ai pas d'erreur
                if( !isset($_SESSION['error']) ){

                    $success = addAgence($_POST);

                    if($success){
                        $_SESSION['success'] = "Agence ajouté";
                        $formData = [];
                    } else {
                        $_SESSION['error']['general'] = "Erreur lors de l'insertion des données";
                    }
                }
            //

        }
    //

    // GESTION DE LA SUPPRESSION DES DONNÉES 
        if( isset($_GET['action']) && $_GET['action'] === "supprimer" ){

            $success = deleteFrom($_GET['id_agence'], 'agence');

            if($success){
                $_SESSION['success'] = "L'agence bien a été supprimé";
            } else {
                $_SESSION['error']['delete'] = "Erreur lors de la suppression";
            }
            
        }
    //

    // GESTION DE LA MODIFICATION DES DONNÉES
        if(isset($_GET['action']) && $_GET['action'] === "modifier"){

            // Récupération de l'agence
            $agenceSelected = getAgenceById($_GET['id_agence']);
            // debug($agenceSelected);
            $formData = formData($agenceSelected);

            // Je vérifie si j'ai cliqué sur le bouton de la validation du formulaire
            if( isset($_POST['modifierAgence']) ){

                // Sécurisation des données
                    dataEscape();
                //

                // Vérification des données
                    if( empty($_POST['titre_agence']) ){
                        $_SESSION['error']['titre_agence'] = "Merci d'indiquer un titre";
                    }
                    if( empty($_POST['adresse']) ){
                        $_SESSION['error']['adresse'] = "Merci d'indiquer une adresse";
                    }
                    if(empty($_POST['ville']) || !in_array($_POST['ville'], ['paris', 'marseille', 'toulouse'])){
                        $_SESSION['error']['ville'] = "Merci de sélectionner une ville dans la liste donnée";
                    }
                    if (empty($_POST['cp']) || !is_numeric($_POST['cp']) || iconv_strlen($_POST['cp']) != 5 ) {
                        $_SESSION['error']['cp'] = "Merci d'indiquer un code postal valide";
                    }
                    if( empty($_POST['description_agence']) ){
                        $_SESSION['error']['description_agence'] = "Merci d'indiquer une description";
                    }
                //
                
                // Upload de la photo
                    if( !empty($_FILES['photo_agence']['name']) ){ // Si j'ai sélectionné une photo
                        copy($_FILES['photo_agence']['tmp_name'], RACINE_SITE . "assets/images/agences/". $_FILES['photo_agence']['name']);

                        $_POST['photo_agence'] = $_FILES['photo_agence']['name'];
                    } elseif ( !empty($agenceSelected['photo_agence']) ){ // Sinon si j'ai déjà une photo présente dans l'agence je garde celle ci
                        $_POST['photo_agence'] = $agenceSelected['photo_agence'];
                    } else { // Sinon j'affiche un message d'erreur pour l'obliger à rentrer une photo
                        $_SESSION['error']['photo_agence'] = "Merci de sélectionner une photo";
                    }
                //

                // Envoie des données
                    if( !isset($_SESSION['error']) ){
                        // debug($formData);
                        $success = updateAgence($_GET['id_agence'], $_POST);

                        if($success){
                            $_SESSION['success'] = "L'agence a été modifiée";
                            $formData = formData($_POST);
                        } else {
                            $_SESSION['error']['general'] = "Erreur lors de la modification des données";
                        }

                    }
                //
            }

        }
    //

    // RÉCUPÉRATION DES DONNÉES
        $agences = getAllAgences();
        // debug($agences);
    //

?>


<?php $title = "Gestion Agences";  require_once RACINE_SITE . "inc/header.php"; ?>

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

    <!-- Tableau des agences -->
        <table class="table text-center mt-5">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Titre</th>
                    <th>Adresse</th>
                    <th>Description</th>
                    <th>Photo</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
                <!-- Affichage des données -->
                <?php foreach($agences as $agence) : ?>

                    <tr>
                        <td><?= $agence['id_agence'] ?></td>
                        <td><?= $agence['titre_agence'] ?></td>
                        <!-- <td><?= $agence['adresse'] . ", " . $agence['cp'] . " " . $agence['ville'] ?></td> -->
                        <td><?= "$agence[adresse], $agence[cp] $agence[ville]" ?></td>
                        <td><?= $agence['description_agence'] ?></td>
                        <td>
                            <img src="<?= URL ?>assets/images/agences/<?= $agence['photo_agence'] ?>" alt="" width="100px">
                        </td>
                        <td>
                            <a href="?action=modifier&id_agence=<?= $agence['id_agence'] ?>"><i class="fa-solid fa-pen-to-square"></i></a>
                            <a href="?action=supprimer&id_agence=<?= $agence['id_agence'] ?>"><i class="fa-solid fa-trash"></i></a>
                        </td>
                    </tr>

                <?php endforeach; ?>
            </tbody>
        </table>
    <!--  -->

    <!-- Formulaire d'ajout et de modification -->

        <?php if( isset($_GET['action']) && $_GET['action'] == 'modifier' ) { ?>
            <div class="position-relative">
                <a href="<?= URL ?>admin/gestion_agences.php" class="btn btn-primary position-absolute end-0 me-5">Ajouter une nouvelle agence</a>
                <h3 class="text-center mt-5 text-warning">Modifier l'Agence</h3>
            </div>
        <?php } else { ?>
            <h3 class="text-center mt-5">Ajouter une nouvelle Agence</h3>
        <?php } ?>

        <form class="d-flex flex-wrap justify-content-between mx-5 mb-5" action="" method="post" enctype="multipart/form-data">

            <!-- div.form-group.col-md-5.my-3*5>label.form-label+input.form-control+div.invalid-feedback -->
            <div class="form-group col-md-5 my-3">
                <label for="titre_agence" class="form-label">Titre Agence</label>
                <input type="text" class="form-control <?= isset($_SESSION['error']['titre_agence']) ? "is-invalid" : "" ?>" name="titre_agence" id="titre_agence" value="<?= $formData['titre_agence'] ?? "" ?>">
                <div class="invalid-feedback"><?= $_SESSION['error']['titre_agence'] ?? "" ?></div>
            </div>
            <div class="form-group col-md-5 my-3">
                <label for="adresse" class="form-label">Adresse</label>
                <input type="text" class="form-control <?= isset($_SESSION['error']['adresse']) ? "is-invalid" : "" ?>" name="adresse" id="adresse" value="<?= $formData['adresse'] ?? "" ?>">
                <div class="invalid-feedback"><?= $_SESSION['error']['adresse'] ?? "" ?></div>
            </div>
            <div class="form-group col-md-5 my-3">
                <label for="ville" class="form-label">Ville</label>
                <select name="ville" id="ville" class="form-select <?= isset($_SESSION['error']['ville']) ? "is-invalid" : "" ?>">
                    <option disabled selected>-- Choisissez une ville --</option>
                    <option <?= isset($formData['ville']) && $formData['ville'] == "paris" ? "selected" : ""  ?> value="paris">Paris</option>
                    <option <?= isset($formData['ville']) && $formData['ville'] == "marseille" ? "selected" : ""  ?> value="marseille">Marseille</option>
                    <option <?= isset($formData['ville']) && $formData['ville'] == "toulouse" ? "selected" : ""  ?> value="toulouse">Toulouse</option>
                </select>
                <div class="invalid-feedback"><?= $_SESSION['error']['ville'] ?? "" ?></div>
            </div>
            <div class="form-group col-md-5 my-3">
                <label for="cp" class="form-label">Code Postal</label>
                <input type="text" class="form-control <?= isset($_SESSION['error']['cp']) ? "is-invalid" : "" ?>" name="cp" id="cp" value="<?= $formData['cp'] ?? "" ?>">
                <div class="invalid-feedback"><?= $_SESSION['error']['cp'] ?? "" ?></div>
            </div>
            <div class="form-group col-md-5 my-3">
                <label for="description_agence" class="form-label">Description</label>
                <textarea name="description_agence" id="description_agence" cols="30" rows="10" class="form-control <?= isset($_SESSION['error']['description_agence']) ? "is-invalid" : "" ?>"><?= $formData['description_agence'] ?? "" ?></textarea>
                <div class="invalid-feedback"><?= $_SESSION['error']['description_agence'] ?? "" ?></div>
            </div>
            <div class="form-group col-md-5 my-3">
                <label for="photo_agence" class="form-label">Photo Agence</label>
                <input type="file" class="form-control <?= isset($_SESSION['error']['photo_agence']) ? "is-invalid" : "" ?>" name="photo_agence" id="photo_agence">
                <div class="invalid-feedback"><?= $_SESSION['error']['photo_agence'] ?? "" ?></div>
            </div>

            <?php if( isset($_GET['action']) && $_GET['action'] == 'modifier' ) { ?>
                <div class="col-12 d-flex justify-content-center mt-3">
                    <button class="btn btn-warning d-block mx-auto" name="modifierAgence">Modifier Agence</button>
                </div>
            <?php } else { ?>
                <div class="col-12 d-flex justify-content-center mt-3">
                    <button class="btn btn-success d-block mx-auto" name="ajouterAgence">Ajouter Agence</button>
                </div>
            <?php } ?>



        </form>

        <?php unset($_SESSION['error']); ?>

    <!--  -->
    </section>

<?php require_once RACINE_SITE . "inc/footer.php"; ?>