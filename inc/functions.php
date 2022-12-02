<?php

/**
 * Fonction d'affichage des données
 */
function debug($value){
    echo "<pre>";
        print_r($value);
    echo "</pre>";
}

function dataEscape(){
    foreach ($_POST as $key => $value) {
        $_POST[$key] = htmlspecialchars($value, ENT_QUOTES); // echappement des caractères
        $_POST[$key] = trim($value); // suppression des espaces avant et après la chaine de caractère
    }
}

function isConnected(){

    if( isset($_SESSION['membre']) ){
        return TRUE;
    }

    return FALSE;

}

function isAdmin(){

    if( isConnected() && $_SESSION['membre']['statut'] == "admin" ){
        return TRUE;
    }

    return FALSE;

}

function formData($data){

    $array = [];

    foreach ($data as $key => $value) {
        $array[$key] = $value;
    }

    return $array;

}

// ######## FONCTIONS MEMBRE

    function getMembreByPseudo($pseudo){

        global $bdd;
        
        $requete = $bdd->prepare("SELECT * FROM membre WHERE pseudo = :pseudo");
        $requete->execute(['pseudo' => $pseudo]);
        $membre = $requete->fetch();

        return $membre;

    }

    function getAllMembres(){

        global $bdd;
        
        $requete = $bdd->query("SELECT * FROM membre");
        $membres = $requete->fetchAll();

        return $membres;

    }

    function getMembreById($id_membre){

        global $bdd;
        
        $requete = $bdd->prepare("SELECT * FROM membre WHERE id_membre = :id_membre");
        $requete->execute(['id_membre' => $id_membre]);
        $membre = $requete->fetch();

        return $membre;

    }

    function updateMembre($id_membre, $data){
        
        global $bdd;

        $requete = $bdd->prepare("UPDATE membre 
                                SET pseudo = :pseudo, prenom = :prenom, nom = :nom, email = :email, civilite = :civilite, statut = :statut 
                                WHERE id_membre = :id_membre");

        return $requete->execute([
            'pseudo' => $data['pseudo'],
            'prenom' => $data['prenom'],
            'nom' => $data['nom'],
            'email' => $data['email'],
            'civilite' => $data['civilite'],
            'statut' => $data['statut'],
            'id_membre' => $id_membre
        ]);

    }

//

// ######## FONCTIONS AGENCES 

    function getAllAgences(){

        global $bdd; 

        $requete = $bdd->query("SELECT * FROM agence");
        $agences = $requete->fetchAll();
        return $agences;

        return $bdd->query("SELECT * FROM agence")->fetchAll();

    }

    function addAgence($data){
        
        global $bdd;

        $requete = $bdd->prepare("INSERT INTO agence VALUES (NULL, :titre_agence, :adresse, :ville, :cp, :description_agence, :photo_agence)");

        return $requete->execute([
            'titre_agence' => $data['titre_agence'], 
            'adresse' => $data['adresse'], 
            'ville' => $data['ville'], 
            'cp' => $data['cp'], 
            'description_agence' => $data['description_agence'], 
            'photo_agence' => $data['photo_agence']
        ]);

    }

    function getAgenceById($id_agence){

        global $bdd;

        $requete = $bdd->prepare("SELECT * FROM agence WHERE id_agence = :id_agence");
        $requete->execute(['id_agence' => $id_agence]);

        return $requete->fetch();

    }

    function updateAgence($id_agence, $data){

        global $bdd;

        $requete = $bdd->prepare("UPDATE agence SET titre_agence = :titre_agence, adresse = :adresse, ville = :ville, cp = :cp, description_agence = :description_agence, photo_agence = :photo_agence WHERE id_agence = :id_agence");
        return $requete->execute([
            'titre_agence' => $data['titre_agence'], 
            'adresse' => $data['adresse'], 
            'ville' => $data['ville'], 
            'cp' => $data['cp'],
            'description_agence' => $data['description_agence'],
            'photo_agence' => $data['photo_agence'],
            'id_agence' => $id_agence
        ]);

    }


//

// ######## FONCTIONS VEHICULES

    function addVehicule($data){

        global $bdd;

        $requete = $bdd->prepare("INSERT INTO vehicule VALUES (NULL, :titre_vehicule, :marque, :modele, :description_vehicule, :photo_vehicule, :prix_journalier, :id_agence, :date_enregistrement)");

        return $requete->execute([
            'titre_vehicule' => $data['titre_vehicule'],
            'marque' => $data['marque'],
            'modele' => $data['modele'],
            'description_vehicule' => $data['description_vehicule'],
            'photo_vehicule' => $data['photo_vehicule'],
            'prix_journalier' => $data['prix_journalier'],
            'id_agence' => $data['id_agence'],
            'date_enregistrement' => date("Y-m-d H:i:s")
        ]);

    }

    function getAllVehicules(){

        global $bdd;
                
        // $requete = $bdd->query("SELECT * FROM vehicule");
        $requete = $bdd->query("SELECT *
                                FROM vehicule 
                                LEFT JOIN agence ON vehicule.id_agence = agence.id_agence");
        $vehicules = $requete->fetchAll();

        return $vehicules;

        return $bdd->query("SELECT vehicule.*, agence.titre_agence FROM vehicule LEFT JOIN agence ON vehicule.id_agence = agence.id_agence")->fetchAll();
    }

    function getVehiculeById($id_vehicule){
        global $bdd;

        $requete = $bdd->prepare("SELECT * FROM vehicule WHERE id_vehicule = :id_vehicule");
        $requete->execute(['id_vehicule' => $id_vehicule]);
        return $requete->fetch();

    }

    function getVehiculesByCity($ville){
        global $bdd;

        $requete = $bdd->prepare("SELECT * 
                                FROM vehicule 
                                LEFT JOIN agence ON vehicule.id_agence = agence.id_agence
                                WHERE ville = :ville");
        $requete->execute(['ville' => $ville]);
        return $requete->fetchAll();

    }

    function updateVehicule($id_vehicule, $data){
        global $bdd;
        
        $requete = $bdd->prepare("UPDATE vehicule SET titre_vehicule = :titre_vehicule, marque = :marque, modele = :modele, description_vehicule = :description_vehicule, photo_vehicule = :photo_vehicule, prix_journalier = :prix_journalier, id_agence = :id_agence WHERE id_vehicule = :id_vehicule");

        return $requete->execute([
            'titre_vehicule' => $data['titre_vehicule'],    
            'marque' => $data['marque'],
            'modele' => $data['modele'],
            'description_vehicule' => $data['description_vehicule'],
            'photo_vehicule' => $data['photo_vehicule'],
            'prix_journalier' => $data['prix_journalier'],
            'id_agence' => $data['id_agence'],
            'id_vehicule' => $id_vehicule
        ]);
    }

//

// FONCTIONS COMMANDES
    function addCommande($data){

        global $bdd;

        $requete = $bdd->prepare("INSERT INTO commande VALUES (NULL, :id_membre, :id_vehicule, :date_heure_depart, :date_heure_fin, :prix_total, NOW() )");

        return $requete->execute([
            'id_membre' => $data['id_membre'],
            'id_vehicule' => $data['id_vehicule'],
            'date_heure_depart' => $data['date_heure_depart'],
            'date_heure_fin' => $data['date_heure_fin'],
            'prix_total' => $data['prix_total']
        ]);

    }

    function getCommandeByUser($id_membre){

        global $bdd;

        $requete = $bdd->prepare("SELECT * FROM commande 
                                    LEFT JOIN vehicule ON vehicule.id_vehicule = commande.id_vehicule
                                    INNER JOIN agence ON agence.id_agence = vehicule.id_agence
                                    LEFT JOIN membre ON membre.id_membre = commande.id_membre
                                    WHERE membre.id_membre = :id_membre"); 
        $requete->execute(['id_membre' => $id_membre]);
        return $requete->fetchAll();

    }

//

function deleteFrom($id, $table){

    global $bdd;

    $requete = $bdd->prepare("DELETE FROM $table WHERE id_$table = :id_$table");
    $result = $requete->execute(["id_$table" => $id]);

    return $result;
    /**
     * Pour choisir si on utilise prepare ou query il faut regarder la requête SQL. 
     *  Si dans ma requête j'ai des données qui peuvent être envoyées par l'utilisateur ($_POST ou $_GET) j'utilise le prepare/execute. 
     *  Si par contre ma requête n'a aucun paramètre dynamique alors je peux utiliser query()
     */

}