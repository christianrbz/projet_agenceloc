<?php 

require_once "inc/init.php";

if( !isConnected() ){
    header("location:connexion.php");
    exit;
}

$commandes = getCommandeByUser($_SESSION['membre']['id_membre']);
debug($commandes);

$title = "Profil";
require_once RACINE_SITE . "inc/header.php";

if( isset($_SESSION['success']) ){
    echo '<div class="alert alert-success col-md-6 mx-auto text-center">';
        echo $_SESSION['success'];
        unset($_SESSION['success']);
    echo '</div>';
}
?>

<div class="row d-flex justify-content-center mt-md-3">
    <div class="col-xl-8 col-md-12">
        <div class="card user-card-full">
            <div class="row m-l-0 m-r-0">
                <div class="col-sm-4 bg-c-lite-green user-profile">
                    <div class="card-block text-center text-white">
                        <div class="m-b-25">
                            <img src="https://img.icons8.com/bubbles/100/000000/user.png" class="img-radius" alt="User-Profile-Image">
                        </div>
                        <h6 class="f-w-600"><?= $_SESSION['membre']['prenom'] . " " . $_SESSION['membre']['nom'] ?></h6>
                        
                        <p><?= ucfirst($_SESSION['membre']['statut']) ?></p>
                        <i class=" mdi mdi-square-edit-outline feather icon-edit m-t-10 f-16"></i>
                    </div>
                </div>
                <div class="col-sm-8">
                    <div class="card-block">
                        <h6 class="m-b-20 p-b-5 b-b-default f-w-600">Information</h6>
                        <div class="row">
                            <div class="col-sm-6">
                                <p class="m-b-10 f-w-600">Email</p>
                                <h6 class="text-muted f-w-400"><?= $_SESSION['membre']['email'] ?></h6>
                            </div>
                            <div class="col-sm-6">
                                <p class="m-b-10 f-w-600">Pseudo</p>
                                <h6 class="text-muted f-w-400"><?= $_SESSION['membre']['pseudo'] ?></h6>
                            </div>
                        </div>
                        <hr class="col d-block mx-auto">

                        <h6 class="m-b-20 m-t-40 p-b-5 b-b-default f-w-600">Commandes</h6>
                        <div class="row">
                                <div class="row">
                                    <div class="col-sm-4">
                                        <img src="assets/images/vehicules/" alt="" width="100%">
                                    </div>
                                    <div class="col-sm-8">
                                        <p class="m-b-10 f-w-600">Peugoet 208</p>
                                        <h6 class="text-muted f-w-400">Départ : 10 Mar 2022 / Retour : 12 Mars 2023</h6>
                                        <h6 class="text-muted f-w-400">Agence de Paris : agence locea</h6>
                                        <h6 class="f-w-400 text-end fst-italic">100€</h6>
                                    </div>
                                    <hr class="col d-block mx-auto ms-4">
                                </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<?php
require_once RACINE_SITE . "inc/footer.php";