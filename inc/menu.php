<nav class="navbar navbar-expand-lg bg-light sticky-md-top">
    <div class="container-fluid">
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarSupportedContent">
            <ul class="navbar-nav me-auto mb-2 mb-lg-0">
                <li class="nav-item">
                    <a class="nav-link active" aria-current="page" href="index.php">Accueil</a>
                </li>


                    <li class="nav-item">
                        <a class="nav-link active" aria-current="page" href="profil.php">Profil</a>
                    </li>


                        <li class="nav-item dropdown">
                            <a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                                Admin
                            </a>
                            <ul class="dropdown-menu">
                                <li><a class="dropdown-item" href="admin/gestion_vehicules.php">Gestion Vehicules</a></li>
                                <li><a class="dropdown-item" href="admin/gestion_membres.php">Gestion Membres</a></li>
                                <li><a class="dropdown-item" href="admin/gestion_commandes.php">Gestion Commandes</a></li>
                                <li><a class="dropdown-item" href="admin/gestion_agences.php">Gestion Agences</a></li>
                            </ul>
                        </li>

            </ul>
            <ul class="navbar-nav ms-auto mb-2 mb-lg-0">
                    <li class="nav-item">
                        <a class="nav-link active text-success" href="inscription.php">Inscription</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link active text-warning" href="connexion.php">Connexion</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link active text-danger" href="?action=deconnexion">Deconnexion</a>
                    </li>
            </ul>
        </div>
    </div>
</nav>