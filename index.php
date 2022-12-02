<?php require_once "inc/init.php"; ?>

<?php 

    // Récupération de tous les véhicules
    $vehicules = getAllVehicules();
    // debug($_POST);

    // Vérification du filtre
        if(isset($_POST['filterResult'])){

            $formData = formData($_POST);

            if(isset($_POST['ville'])){

                $vehicules = getVehiculesByCity($_POST['ville']);

            }

            // SI j'ai indiqué une date de départ ET une date de retour alors je fais les vérifications et j'affiche le tarif total du séjour
            if( !empty($_POST['date_heure_depart']) && !empty($_POST['date_heure_fin']) ){

                // Je transforme mes dates en timestamp pour pouvoir mieux les manipuler
                $timestamp_jour = strtotime(date("Y-m-d"));
                // debug($timestamp_jour);
                
                $timestamp_depart = strtotime($_POST['date_heure_depart']);
                // debug($timestamp_depart);

                $timestamp_fin = strtotime($_POST['date_heure_fin']);
                // debug($timestamp_fin);

                // Vérification des données
                    if( $timestamp_depart < $timestamp_jour ){
                        $_SESSION['error']['filter']['date_heure_depart'] = "Merci de sélectionner une date de départ après le " . date('d M Y');
                    }

                    if($timestamp_depart > $timestamp_fin ){
                        $_SESSION['error']['filter']['date_heure_fin'] = "La date de fin ne peut pas être avant la date de départ";
                    }

                //

                // Calcul du temps de location
                if(!isset($_SESSION['error'])){
                    // La fonction la ceil permet d'arrondir à l'entier supèrieur 
                    $total_days = ceil(($timestamp_fin - $timestamp_depart)/60/60/24);

                    $_SESSION['data']['date_heure_depart'] = $_POST['date_heure_depart'];
                    $_SESSION['data']['date_heure_fin'] = $_POST['date_heure_fin'];
                    $_SESSION['data']['total_days'] = $total_days;

                }
            }

        }
    //

    // Réservation du véhicule
        if(isConnected() && isset($_GET['action']) && $_GET['action'] == 'book'){

            // Si le nombre de jour est définie alors c'est que je suis passé par toutes les vérifications faites plus haut
            if(isset($_SESSION['data']['total_days'])){
                // debug("OK CA FONCTIONNE");

                // id_membre => $_SESSION['membre']['id_membre'];
                // id_vehicule => $_GET['id_vehicule'];
                // date_heure_depart => $_SESSION['data']['date_heure_depart'];
                // date_heure_fin => $_SESSION['data']['date_heure_fin'];
                // prix_total => ... Récupération du véhicule sélectionner

                $data = [];
                $data['id_vehicule'] = $_GET['id_vehicule'];
                $data['id_membre'] = $_SESSION['membre']['id_membre'];
                $data['date_heure_depart'] = $_SESSION['data']['date_heure_depart'];
                $data['date_heure_fin'] = $_SESSION['data']['date_heure_fin'];

                
                $vehicule = getVehiculeById($data['id_vehicule']);
                $data['prix_total'] = $vehicule['prix_journalier'] * $_SESSION['data']['total_days'];
                
                // debug($data);

                // Insertion de la commande
                    $success = addCommande($data);

                    if($success){
                        $_SESSION['success'] = "Commande enregistré";
                        unset($_SESSION['data']);

                        header("location:profil.php");
                        exit;
                    } else {
                        $_SESSION['error'] = "Erreur lors de la commande";
                    }
                //

            } else {
                $_SESSION['error']['filter']['date_heure_depart'] = "Merci de sélectionner une date de départ et de retour";
            }

        }
    //
?>

<?php $title = "Accueil"; 
require_once RACINE_SITE . "inc/header.php"; ?>

    <header class="col-12 d-flex flex-column justify-content-between">
        <div class="text-center text-white d-flex flex-column justify-content-center align-items-center">
            <h1>Agence Loc</h1>
            <h2>Bienvenue à Bord</h2>
            <h4>Location de voiture 24h/24 et 7j/7</h4>
        </div>
        <?php require_once RACINE_SITE . "inc/formHeader.php"; ?>
    </header>

    <?php require_once RACINE_SITE . "inc/menu.php"; ?>

    <div class="d-flex mt-5 flex-wrap" style="margin-bottom:50px;">
        <?php foreach($vehicules as $vehicule){ ?>
            <div class="card mb-3 mx-auto col-md-5 mt-3" style="max-width: 540px;">
                <div class="row g-0">
                    <div class="col-md-4">
                        <img src="<?= URL ?>assets/images/vehicules/<?= $vehicule['photo_vehicule'] ?>" class="img-fluid rounded-start" alt="...">
                    </div>
                    <div class="col-md-8">
                        <div class="card-body">
                            <h5 class="card-title"><?= $vehicule['titre_vehicule'] ?></h5>
                            <p class="card-text"><?= $vehicule['description_vehicule'] ?></p>
                            <p class="card-text">Agence de <?= ucfirst($vehicule['ville']) ?> : <?= $vehicule['titre_agence'] ?></p>
                            <p class="card-text">
                                <small class="text-muted">
                                    <?= isset($total_days) 
                                        ? $total_days * $vehicule['prix_journalier'] . "€ - pour $total_days jours" 
                                        : $vehicule['prix_journalier'] . "€ par jour" 
                                    ?> 
                                </small>
                            </p>

                            <?php if(isConnected()) : ?>
                                <a 
                                    href="?action=book&id_vehicule=<?= $vehicule['id_vehicule'] ?>" 
                                    class="d-block btn btn-outline-primary btn-sm ms-auto"
                                >
                                    Réserver ce véhicule
                                </a>
                            <?php endif; ?>

                        </div>
                    </div>
                </div>
            </div>
        <?php } ?>
    </div>

    <?php if( !isConnected() ) : ?>
        <div class="col-12 bg-warning position-fixed fixed-bottom bg-opacity-25 text-center text-danger" style="height: 50px; line-height: 50px;">
            <a href="<?= URL ?>connexion.php">Connectez-vous</a> pour réserver un véhicule
        </div>
    <?php endif; ?>

    <?php unset($_SESSION['error']); ?>

<?php require_once RACINE_SITE . "inc/footer.php"; ?>

