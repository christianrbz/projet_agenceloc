<?php 

    $requete = $bdd->query("SELECT DISTINCT ville FROM agence ORDER BY ville");
    $villes = $requete->fetchAll();
?>

<form id="headerForm" action="" class=" mx-auto d-flex" method="post">
    <div class="form-floating">
        <select class="form-select" id="ville" name="ville" aria-label="Floating label select example">
            <option disabled selected>Ville</option>
            <?php foreach($villes as $ville) : ?>
                <?php $selected = isset($formData['ville']) && $formData['ville'] === $ville['ville'] ? "selected" : "" ?>
                <option <?= $selected ?> value="<?= $ville['ville'] ?>"><?= ucfirst($ville['ville']) ?></option>
            <?php endforeach; ?>
        </select>
        <label for="ville">Adresse de départ</label>
    </div>

    <div class="form-floating">
        <input type="datetime-local" class="form-control <?= isset($_SESSION['error']['filter']['date_heure_depart']) ? "is-invalid" : "" ?>" id="date_heure_depart" name="date_heure_depart" placeholder="Début de location" value="<?= $formData['date_heure_depart'] ?? "" ?>">
        <label for="date_heure_depart"><i class="fa-regular fa-calendar-days"></i> Début de location</label>
        <div class="invalid-feedback bg-white mt-0 text-center border border-danger border-top-0">
                <?= $_SESSION['error']['filter']['date_heure_depart'] ?? "" ?>
        </div>
    </div>
    
    <div class="form-floating">
        <input type="datetime-local" class="form-control  <?= isset($_SESSION['error']['filter']['date_heure_fin']) ? "is-invalid" : "" ?>" id="date_heure_fin" name="date_heure_fin" placeholder="Fin de location" value="<?= $formData['date_heure_fin'] ?? "" ?>">
        <label for="date_heure_fin"><i class="fa-regular fa-calendar-days"></i> Fin de location</label>
        <div class="invalid-feedback bg-white mt-0 text-center border border-danger border-top-0">
            <?= $_SESSION['error']['filter']['date_heure_fin'] ?? "" ?>
        </div>
    </div>

    <button class="btn btn-success" name="filterResult">Valider</button>
</form>