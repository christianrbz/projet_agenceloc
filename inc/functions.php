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