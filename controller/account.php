<?php

// On récupère les données saisies.
session_start();
$uti_pseudo = "";
if (isset($_SESSION["uti_connecte"])) {
    $uti_pseudo = $_SESSION["uti_connecte"];
}

// On utilise htmlspecialchars pour empêcher les failles de sécurité.
$uti_email = htmlspecialchars($_POST["uti_email"]);

$uti_prenom = htmlspecialchars($_POST["uti_prenom"]);
$uti_nom = htmlspecialchars($_POST["uti_nom"]);
$uti_naissance = htmlspecialchars($_POST["uti_naissance"]);
$uti_telephone = htmlspecialchars($_POST["uti_telephone"]);

$uti_adresse = htmlspecialchars($_POST["uti_adresse"]);
$uti_ville = htmlspecialchars($_POST["uti_ville"]);
$uti_codePostal = htmlspecialchars($_POST["uti_codePostal"]);

$uti_mdp = htmlspecialchars($_POST["uti_mdp"]);
$uti_mdp2 = htmlspecialchars($_POST["uti_mdp2"]);

$uti_oldmdp = htmlspecialchars($_POST["old_mdp"]);

// On vérifie ce qui a été saisie.
if (strlen($uti_oldmdp) > 1 && strlen($uti_mdp) > 1 && $uti_mdp == $uti_mdp2) {
    try {
        // On se connecte à la BDD.
        $bdd = new PDO('mysql:host=localhost;dbname=id18170749_slatkoktel;charset=utf8', 'id18170749_amaroke', '/]jptFa>FGDK-1vP');

        // On vérifie que l'email n'est pas déjà pris.
        $test_oldmdp = $bdd->prepare("SELECT uti_mdp FROM Utilisateurs WHERE uti_pseudo = '" . $uti_pseudo . "' AND uti_mdp = '" . $uti_oldmdp . "' ");
        $test_oldmdp->execute();
        $nb_res += $test_oldmdp->rowCount();

        // Si il le mot de passe saisie est bien celui lié à l'utilisateur.
        if ($nb_res == 1) {
            // On édite les informations de l'utilisateur dans la BDD.
            $udpateUser = 'UPDATE Utilisateurs SET uti_email=:uti_email, uti_telephone=:uti_telephone ,uti_codePostal=:uti_codePostal, uti_adresse=:uti_adresse, uti_ville=:uti_ville, uti_mdp=:uti_mdp';
            $udpateUserRequete = $bdd->prepare($udpateUser);

            $stmt = $bdd->prepare($udpateUser);
            $stmt->bindParam(':uti_email', $uti_email);
            $stmt->bindParam(':uti_telephone', $uti_telephone);
            $stmt->bindParam(':uti_codePostal', $uti_codePostal);
            $stmt->bindParam(':uti_adresse', $uti_adresse);
            $stmt->bindParam(':uti_ville', $uti_ville);
            $stmt->bindParam(':uti_mdp', $uti_mdp);
            $stmt->execute();

            // On ferme les requêtes.
            $test_oldmdp->closeCursor();
            $udpateUserRequete->closeCursor();

            // On retourne à l'accueil.
            header('Location: ../index.php');
        } else {
            echo "<script> alert('Problème dans la saisie.');history.back();</script>";
        }
    } catch (PDOException $e) {
        die('Erreur : ' . $e->getMessage());
    }
} else {
    echo "<script> alert('Formulaire incorrect.');history.back();</script>";
}
