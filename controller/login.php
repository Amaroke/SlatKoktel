<?php

// On récupère l'email et le mot de passe saisie.
$uti_pseudo = htmlspecialchars($_POST["uti_pseudo"]);
$uti_mdp = htmlspecialchars($_POST["uti_mdp"]);

// On vérifie ce qui a été saisie.
try {
    // On se connecte à la BDD.
    $bdd = new PDO('mysql:host=localhost;dbname=SlatKoktel;charset=utf8;', 'slatkoktel', 'root2');

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
    $str = $_SESSION["favoris"];
    $tab = explode(" ", $str);

    $bdd = new PDO('mysql:host=localhost;dbname=SlatKoktel;charset=utf8;', 'slatkoktel', 'root2');

    for ($i = 1; $i < count($tab); ++$i) {
        $sql = 'INSERT INTO Favoris(fav_idUtilisateur, fav_idRecette) VALUES (:fav_idUtilisateur, :fav_idRecette);';

        $stmt = $bdd->prepare($sql);
        $stmt->bindParam(':fav_idUtilisateur', $_SESSION["uti_connecte_id"]);
        $stmt->bindParam(':fav_idRecette', $tab[$i]);
        $stmt->execute();
    }

    $_SESSION["favoris"] = "";
    $recup_recette = 'SELECT fav_idRecette FROM Favoris WHERE fav_idUtilisateur="' . $_SESSION['uti_connecte_id'] . '"';

    $stmt2 = $bdd->prepare($recup_recette);
    $stmt2->execute();

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
