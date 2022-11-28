<?php 

    require_once "inc/init.php";

    $title = "Connexion"; 
    require_once RACINE_SITE . "inc/header.php";
    
    if( isset($_SESSION['success']['subscribe']) ){
        echo '<div class="alert alert-success col-md-6 mx-auto text-center">';
            echo $_SESSION['success']['subscribe'];
            unset($_SESSION['success']);
        echo '</div>';
    }
    require_once RACINE_SITE . "inc/footer.php";

?>