<?php

// On récupère les données saisies.
$uti_pseudo = htmlspecialchars($_POST["uti_pseudo"]);
$uti_email = htmlspecialchars($_POST["uti_email"]);
$uti_prenom = htmlspecialchars($_POST["uti_prenom"]);
$uti_nom = htmlspecialchars($_POST["uti_nom"]);
$uti_naissance = htmlspecialchars($_POST["uti_naissance"]);
$uti_sexe = htmlspecialchars($_POST["uti_sexe"]);
$uti_telephone = htmlspecialchars($_POST["uti_telephone"]);
$uti_adresse = htmlspecialchars($_POST["uti_adresse"]);
$uti_ville = htmlspecialchars($_POST["uti_ville"]);
$uti_codePostal = htmlspecialchars($_POST["uti_codePostal"]);
$uti_mdp = htmlspecialchars($_POST["uti_mdp"]);
$uti_mdp2 = htmlspecialchars($_POST["uti_mdp2"]);

// On vérifie ce qui a été saisie.
if (strlen($uti_pseudo) > 1 && strlen($uti_mdp) > 1 && $uti_mdp == $uti_mdp2) {
    try {
        // On se connecte à la BDD.
        $bdd = new PDO('mysql:host=localhost;dbname=id18170749_slatkoktel;charset=utf8', 'id18170749_amaroke', '/]jptFa>FGDK-1vP');

        // On vérifie que l'email n'est pas déjà pris.
        $test_login = $bdd->prepare("SELECT uti_pseudo FROM Utilisateurs WHERE uti_pseudo = '" . $uti_pseudo . "' ");
        $test_login->execute();
        $nb_res=0;
        $nb_res += $test_login->rowCount();

        if ($nb_res == 0) {
            // On insère le nouvel utilisateur dans la BDD.
            $insertionUser = 'INSERT INTO Utilisateurs(uti_pseudo, uti_mdp, uti_sexe, uti_prenom, 
            uti_nom, uti_naissance, uti_email, uti_telephone, uti_adresse, uti_codePostal, uti_ville) 
            VALUES (:uti_pseudo, :uti_mdp, :uti_sexe, :uti_prenom, 
            :uti_nom, :uti_naissance, :uti_email, :uti_telephone, :uti_adresse, :uti_codePostal, :uti_ville);';
            $insertionUserRequete = $bdd->prepare($insertionUser);

            // On charge les paramètres.
            $stmt = $bdd->prepare($insertionUser);
            $stmt->bindParam(':uti_pseudo', $uti_pseudo);
            $stmt->bindParam(':uti_mdp', $uti_mdp);
            $stmt->bindParam(':uti_sexe', $uti_sexe);
            $stmt->bindParam(':uti_prenom', $uti_prenom);
            $stmt->bindParam(':uti_nom', $uti_nom);
            $stmt->bindParam(':uti_naissance', $uti_naissance);
            $stmt->bindParam(':uti_email', $uti_email);
            $stmt->bindParam(':uti_telephone', $uti_telephone);
            $stmt->bindParam(':uti_adresse', $uti_adresse);
            $stmt->bindParam(':uti_codePostal', $uti_codePostal);
            $stmt->bindParam(':uti_ville', $uti_ville);
            $stmt->execute();

            // On ferme les requêtes.
            $test_login->closeCursor();
            $insertionUserRequete->closeCursor();

            // On retourne à l'accueil.
            header('Location: ../index.php');
        } else {
            echo "<script> alert('Veuillez choisir un autre pseudo et saisir des mots de passe similaire.');history.back();</script>";
        }
    } catch (PDOException $e) {
        die('Erreur : ' . $e->getMessage());
    }
} else {
    echo "<script> alert('Formulaire incorrect');history.back();</script>";
}
