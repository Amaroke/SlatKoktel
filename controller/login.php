<?php

// On récupère l'email et le mot de passe saisie.
$uti_email = htmlspecialchars($_POST["uti_email"]);
$uti_mdp = htmlspecialchars($_POST["uti_mdp"]);

// On vérifie ce qui a été saisie.
if (strlen($uti_email) > 4 && strlen($uti_mdp) > 1) {
    try {
        // On se connecte à la BDD.
        $bdd = new PDO('mysql:host=localhost;dbname=SlatKoktel;charset=utf8;', 'root', 'root1');

        // On vérifie si les champs saisies correspondent à un utilisateur de la BDD.
        $test_connexion = $bdd->prepare("SELECT uti_email FROM Utilisateurs WHERE uti_email = '" . $uti_email . "' AND uti_mdp = '" . $uti_mdp . "' ");
        $test_connexion->execute();
        $nb_res = $test_connexion->rowCount(); // Le nombre de résultat obtenu.
        $test_connexion->closeCursor();

        // On crée une session et on revient à l'accueil si l'on a bien récupré un unique utilisateur.
        if ($nb_res == 1) {
            session_start();
            $_SESSION['uti_connecte'] = $uti_email;
            header('Location: ../index.php');
        }
    } catch (PDOException $e) {
        die('Erreur : ' . $e->getMessage());
    }
} else {
    // Si on saisie des informations incorrectes history.back permet de revenir à la page précedente.
    echo "<script> alert('Formulaire incorrect.');history.back();</script>";
}
