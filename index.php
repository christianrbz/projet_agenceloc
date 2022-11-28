<?php require_once "inc/init.php"; ?>


<?php $title = "Accueil"; 
require_once RACINE_SITE . "inc/header.php"; ?>

    <header class="col-12 d-flex flex-column justify-content-between">
        <div class="text-center text-white d-flex flex-column justify-content-center align-items-center">
            <h1>Agence Loc</h1>
            <h2>Bienvenue à Bord</h2>
            <h4>Location de voiture 24h/24 et 7j/7</h4>
        </div>
    </header>

    <?php require_once RACINE_SITE . "inc/menu.php"; ?>

    <div class="d-flex mt-5 flex-wrap">
            <div class="card mb-3 mx-auto col-md-5 mt-3" style="max-width: 540px;">
                <div class="row g-0">
                    <div class="col-md-4">
                        <img src="assets/images/vehicules/" class="img-fluid rounded-start" alt="...">
                    </div>
                    <div class="col-md-8">
                        <div class="card-body">
                            <h5 class="card-title"></h5>
                            <p class="card-text"></p>
                            <p class="card-text">Agence de</p>
                            <p class="card-text"><small class="text-muted">50€ par jour</small></p>
                            <a 
                                href="?action=book&id_vehicule=" 
                                class="d-block btn btn-outline-primary btn-sm ms-auto"
                                >Réserver ce véhicule</a>
                        </div>
                    </div>
                </div>
            </div>
    </div>

<?php require_once RACINE_SITE . "inc/footer.php"; ?>