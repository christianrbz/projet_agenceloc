<?php require_once "../inc/init.php"; ?>

<?php
    //  RESTRICTION D'ACCES
        if( !isAdmin() ){
            header("location:".URL."profil.php");
            exit;
        } 
    // 

    // GESTION DE LA SUPPRESSION DES DONNÉES 
        if( isset($_GET['action']) && $_GET['action'] === "supprimer" ){

            $success = deleteFrom($_GET['id_membre'], 'membre');

            if($success){
                $_SESSION['success'] = "Le membre a été supprimé";
            } else {
                $_SESSION['error']['delete'] = "Erreur lors de la suppression";
            }
            
        }
    //

    // GESTION DE LA MODIFICATION DES DONNÉES 
        if(isset($_GET['action']) && $_GET['action'] === "modifier" ) : 
            // Récupération du membre sélectionné 
            $membreSelected = getMembreById( $_GET['id_membre'] );
            debug($membreSelected);
        endif;
        
        if( isset($_POST['update']) ) :
            
            // Sécurisation des données
                dataEscape();
            //    

            // Vérification des données 
                
            //

        endif;
    //

    // GESTION DE LA RÉCUPÉRATION DES DONNÉES
        $membres = getAllMembres();
        // debug($membres);
    //

?>

<?php $title = "Gestion Membres"; require_once RACINE_SITE . "inc/header.php"; 

if( isset($_SESSION['success']) ){
    echo '<div class="alert alert-success col-md-6 mx-auto text-center">';
        echo $_SESSION['success'];
        unset($_SESSION['success']);
    echo '</div>';
}

if( isset($_SESSION['error']['delete']) ){
    echo '<div class="alert alert-danger col-md-6 mx-auto text-center">';
        echo $_SESSION['error']['delete'];
        unset($_SESSION['error']['delete']);
    echo '</div>';
}

?>

    <div class="d-flex">

        <section class="mainAdmin col">

            <!-- Tableau des membres -->
                <table class="table text-center mt-5">
                    <thead>
                        <tr>
                            <th>id</th>
                            <th>Pseudo</th>
                            <th>Nom</th>
                            <th>Prenom</th>
                            <th>Email</th>
                            <th>Civitilé</th>
                            <th>Statut</th>
                            <th>Date d'enregistrement</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        <!-- Affichage des données -->
                        <!-- Grace à $membres, essayez d'afficher les données dans le tableau -->
                        <?php foreach ($membres as $membre) { ?>
                            <tr>
                                <td><?= $membre['id_membre'] ?></td>
                                <td><?= $membre['pseudo'] ?></td>
                                <td><?= $membre['nom'] ?></td>
                                <td><?= $membre['prenom'] ?></td>
                                <td><?= $membre['email'] ?></td>
                                <td><?= $membre['civilite'] ?></td>
                                <td><?= $membre['statut'] ?></td>
                                <td><?= $membre['date_enregistrement'] ?></td>
                                <td>
                                    <a href="?action=modifier&id_membre=<?= $membre['id_membre'] ?>" class="text-warning me-2"><i class="fa-solid fa-pen-to-square"></i></a>
                                    <a href="?action=supprimer&id_membre=<?= $membre['id_membre'] ?>" class="text-danger ms-2"><i class="fa-solid fa-trash"></i></a>
                                </td>
                            </tr>
                        <?php } ?>
                    </tbody>
                </table>

            <!-- Formulaire de modification -->
                <?php if( isset($_GET['action']) && $_GET['action'] === "modifier" ) : ?>
                    <h3 class="text-center mt-5">Modifier le Membre</h3>

                    <form action="" method="POST" class="d-flex flex-wrap">

                        <div class="form-group col-6 px-3">
                            <input 
                                class="form-control mt-3 col-6" 
                                type="text" 
                                name="pseudo" 
                                id="pseudo" 
                                placeholder="Votre Pseudo"
                                value="<?= $membreSelected['pseudo'] ?>"
                            >     
                            <div class="invalid-feedback"></div> 
                        </div>

                        <div class="form-group col-6 px-3">
                            <input 
                                class="form-control mt-3" 
                                type="text" 
                                name="prenom" 
                                id="prenom" 
                                placeholder="Votre Prenom" 
                                value="<?= $membreSelected['prenom'] ?>"
                            >
                            <div class="invalid-feedback"></div> 
                        </div>

                        <div class="form-group col-6 px-3">
                            <input 
                                class="form-control mt-3" 
                                type="text" 
                                name="nom" 
                                id="nom" 
                                placeholder="Votre Nom" 
                                value="<?= $membreSelected['nom'] ?>"
                            >
                            <div class="invalid-feedback"></div> 
                        </div>

                        <div class="form-group col-6 px-3">
                            <input 
                                class="form-control mt-3" 
                                type="email" 
                                name="email" 
                                id="email" 
                                placeholder="Votre Email" 
                                value="<?= $membreSelected['email'] ?>"
                            >
                            <div class="invalid-feedback"></div> 
                        </div>

                        <div class="form-group col-6 px-3">
                            <select class="form-select mt-3" name="civilite" id="civilite" >
                                <option disabled selected>Civilité</option>
                                <option <?= $membreSelected['civilite'] === "m" ? "selected" : "" ?> value="m" >Homme</option>
                                <option <?= $membreSelected['civilite'] === "f" ? "selected" : "" ?> value="f" >Femme</option>
                            </select>
                            <div class="invalid-feedback"></div> 
                        </div>

                        <div class="form-group col-6 px-3">
                            <select class="form-select mt-3" name="statut" id="statut" >
                                <option disabled selected>Statut</option>
                                <option <?= $membreSelected['statut'] === "user" ? "selected" : "" ?> value="user">Utilisateur</option>
                                <option <?= $membreSelected['statut'] === "admin" ? "selected" : "" ?> value="admin">Administrateur</option>
                            </select>
                            <div class="invalid-feedback"></div> 
                        </div>

                        <div class="col-12 d-flex justify-content-center my-3">
                            <button class="btn btn-warning" name="update">Modifier</button>
                        </div>
                    </form>
                    
                <?php endif; ?>
        </section>
        
    </div>

<?php require_once RACINE_SITE . "inc/footer.php"; ?>