<?php

// On récupère l'email et le mot de passe saisie.
$uti_pseudo = htmlspecialchars($_POST["uti_pseudo"]);
$uti_mdp = htmlspecialchars($_POST["uti_mdp"]);

// On vérifie ce qui a été saisie.
try {
    // On se connecte à la BDD.
    $bdd = new PDO('mysql:host=localhost;dbname=SlatKoktel;charset=utf8;', 'slatkoktel', 'root2');

    // On vérifie si les champs saisies correspondent à un utilisateur de la BDD.
    $test_connexion = $bdd->prepare("SELECT uti_pseudo FROM Utilisateurs WHERE uti_pseudo = '" . $uti_pseudo . "' AND uti_mdp = '" . $uti_mdp . "' ");
    $test_connexion->execute();
    $nb_res = $test_connexion->rowCount(); // Le nombre de résultat obtenu.
    $test_connexion->closeCursor();

    // On crée une session et on revient à l'accueil si l'on a bien récupré un unique utilisateur.
    if ($nb_res == 1) {
        session_start();
        $_SESSION['uti_connecte'] = $uti_pseudo;
        header('Location: ../index.php');
    }
} catch (PDOException $e) {
    die('Erreur : ' . $e->getMessage());
}
