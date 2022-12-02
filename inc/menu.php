<nav class="navbar navbar-expand-lg bg-light sticky-md-top">
    <div class="container-fluid">
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarSupportedContent">
            <ul class="navbar-nav me-auto mb-2 mb-lg-0">
                <li class="nav-item">
                    <a class="nav-link active" aria-current="page" href="<?= URL ?>index.php">Accueil</a>
                </li>

                <?php if(isConnected()) : ?>
                    <li class="nav-item">
                        <a class="nav-link active" aria-current="page" href="<?= URL ?>profil.php">Profil</a>
                    </li>

                    <?php if(isAdmin()) : ?>
                        <li class="nav-item dropdown">
                            <a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                                Admin
                            </a>
                            <ul class="dropdown-menu">
                                <li><a class="dropdown-item" href="<?= URL ?>admin/gestion_vehicules.php">Gestion Vehicules</a></li>
                                <li><a class="dropdown-item" href="<?= URL ?>admin/gestion_membres.php">Gestion Membres</a></li>
                                <li><a class="dropdown-item" href="<?= URL ?>admin/gestion_commandes.php">Gestion Commandes</a></li>
                                <li><a class="dropdown-item" href="<?= URL ?>admin/gestion_agences.php">Gestion Agences</a></li>
                            </ul>
                        </li>
                    <?php endif; ?> 
                
                <?php endif; ?>    
            </ul>
            <ul class="navbar-nav ms-auto mb-2 mb-lg-0">
                <?php if( !isConnected() ) : ?>        
                    <li class="nav-item">
                        <a class="nav-link active text-success" href="<?= URL ?>inscription.php">Inscription</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link active text-warning" href="<?= URL ?>connexion.php">Connexion</a>
                    </li>
                <?php else : ?>
                    <li class="nav-item">
                        <a class="nav-link active text-danger" href="<?= URL ?>deconnexion.php">Deconnexion</a>
                    </li>
                <?php endif; ?>
            </ul>
        </div>
    </div>
</nav>  