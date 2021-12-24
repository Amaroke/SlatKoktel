<?php

// On récupère l'email et le mot de passe saisie.
$uti_pseudo = htmlspecialchars($_POST["uti_pseudo"]);
$uti_mdp = htmlspecialchars($_POST["uti_mdp"]);

// On vérifie ce qui a été saisie.
try {
    // On se connecte à la BDD.
    $bdd = new PDO('mysql:host=localhost;dbname=id18170749_slatkoktel;charset=utf8', 'id18170749_amaroke', '/]jptFa>FGDK-1vP');

    // On vérifie si les champs saisies correspondent à un utilisateur de la BDD.
    $test_connexion = $bdd->prepare("SELECT uti_pseudo, uti_idUtilisateur FROM Utilisateurs WHERE uti_pseudo = '" . $uti_pseudo . "' AND uti_mdp = '" . $uti_mdp . "' ");
    $test_connexion->execute();
    $uti_id = $test_connexion->fetch()["uti_idUtilisateur"];
    $nb_res = $test_connexion->rowCount(); // Le nombre de résultat obtenu.
    $test_connexion->closeCursor();
    session_start();

    // On crée une session et on revient à l'accueil si l'on a bien récupré un unique utilisateur.
    if ($nb_res == 1) {
        $_SESSION['uti_connecte'] = $uti_pseudo;
        $_SESSION['uti_connecte_id'] = $uti_id;
    }

    $str = "";
    if (isset($_SESSION["favoris"])) {
        $str = $_SESSION["favoris"];
    }
    $tab = explode(" ", $str);

    // On se connecte à la BDD.
    $bdd = new PDO('mysql:host=localhost;dbname=id18170749_slatkoktel;charset=utf8', 'id18170749_amaroke', '/]jptFa>FGDK-1vP');

    // On ajoute les favoris temporaires à l'utilisateur.
    for ($i = 1; $i < count($tab); ++$i) {
        $sql = 'INSERT INTO Favoris(fav_idUtilisateur, fav_idRecette) VALUES (:fav_idUtilisateur, :fav_idRecette);';

        $stmt = $bdd->prepare($sql);
        $stmt->bindParam(':fav_idUtilisateur', $_SESSION["uti_connecte_id"]);
        $stmt->bindParam(':fav_idRecette', $tab[$i]);
        $stmt->execute();
    }

    // Je récupère les favoris de l'utilisateur lorsqu'il se connecte.
    $_SESSION["favoris"] = "";
    if(!isset($_SESSION['uti_connecte_id'] )){
        $_SESSION['uti_connecte_id'] = "";
    }
    $recup_recette = 'SELECT fav_idRecette FROM Favoris WHERE fav_idUtilisateur="' . $_SESSION['uti_connecte_id'] . '"';

    $stmt2 = $bdd->prepare($recup_recette);
    $stmt2->execute();

    // On les ajoute à la variables de session.
    while ($row = $stmt2->fetch()) {
        $str = $_SESSION["favoris"];
        $tab = explode(" ", $str);
        if (!in_array($row["fav_idRecette"], $tab)) {
            $str = $str . " " . $row["fav_idRecette"];
            $_SESSION["favoris"] = $str;
        }
    }

    header('Location: ../index.php');
} catch (PDOException $e) {
    die('Erreur : ' . $e->getMessage());
}
