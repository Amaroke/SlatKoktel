<?php

// On récupère les données saisies.
$uti_pseudo = htmlspecialchars($_POST["uti_pseudo"]);
$uti_email = htmlspecialchars($_POST["uti_email"]);
$uti_prenom = htmlspecialchars($_POST["uti_prenom"]);
$uti_nom = htmlspecialchars($_POST["uti_nom"]);
$uti_age = htmlspecialchars($_POST["uti_age"]);
$uti_sexe = htmlspecialchars($_POST["uti_sexe"]);
$uti_telephone = htmlspecialchars($_POST["uti_telephone"]);
$uti_adresse = htmlspecialchars($_POST["uti_adresse"]);
$uti_ville = htmlspecialchars($_POST["uti_ville"]);
$uti_codePostal = htmlspecialchars($_POST["uti_codePostal"]);
$uti_mdp = htmlspecialchars($_POST["uti_mdp"]);
$uti_mdp2 = htmlspecialchars($_POST["uti_mdp2"]);
$mtn = date("Y-m-d");

// On vérifie ce qui a été saisie.
if (strlen($uti_pseudo) > 1 && strlen($uti_email) > 4 && strlen($uti_mdp) > 1 && $uti_mdp == $uti_mdp2) {
    try {
        // On se connecte à la BDD.
        $bdd = new PDO('mysql:host=localhost;dbname=SlatKoktel;charset=utf8;', 'root', 'root1');

        // On vérifie que l'email 'n'est pas déjà pris.
        $test_mail = $bdd->prepare("SELECT uti_email FROM Utilisateurs WHERE uti_email = '" . $uti_email . "' ");
        $test_mail->execute();
        $nb_res += $test_mail->rowCount();

        if ($nb_res == 0) {
            // On insère le nouvel utilisateur dans la BDD.
            $insertionUser = 'INSERT INTO Utilisateurs(uti_pseudo, uti_mdp, uti_sexe, uti_prenom, 
            uti_nom, uti_age, uti_email, uti_telephone, uti_adresse, uti_codePostal, uti_ville, uti_dateCreation) 
            VALUES (:uti_pseudo, :uti_mdp, :uti_sexe, :uti_prenom, 
            :uti_nom, :uti_age, :uti_email, :uti_telephone, :uti_adresse, :uti_codePostal, :uti_ville, :mtn);';
            $insertionUserRequete = $bdd->prepare($insertionUser);

            $stmt = $bdd->prepare($insertionUser);
            $stmt->bindParam(':uti_pseudo', $uti_pseudo);
            $stmt->bindParam(':uti_mdp', $uti_mdp);
            $stmt->bindParam(':uti_sexe', $uti_sexe);
            $stmt->bindParam(':uti_prenom', $uti_prenom);
            $stmt->bindParam(':uti_nom', $uti_nom);
            $stmt->bindParam(':uti_age', $uti_age);
            $stmt->bindParam(':uti_email', $uti_email);
            $stmt->bindParam(':uti_telephone', $uti_telephone);
            $stmt->bindParam(':uti_adresse', $uti_adresse);
            $stmt->bindParam(':uti_codePostal', $uti_codePostal);
            $stmt->bindParam(':uti_ville', $uti_ville);
            $stmt->bindParam(':mtn', $mtn);
            $stmt->execute();

            // On ferme les requêtes.
            $test_login->closeCursor();
            $test_mail->closeCursor();
            $insertionUserRequete->closeCursor();

            // On retourne à l'accueil.
            header('Location: ../index.php');
        }
        else {
            echo "<script> alert('Veuillez choisir un autre mail.');</script>";
        }
    } catch (PDOException $e) {
        die('Erreur : ' . $e->getMessage());
    }
} else {
    echo "<script> alert('Formulaire incorrect');history.back();</script>";
}
