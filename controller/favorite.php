<?php
// Si on a bien précisé le mode de modification et l'id de la recette.
if (isset($_GET["id_recette"]) && isset($_GET["add"])) {
    session_start();

    $id = $_GET["id_recette"];
    $add = $_GET["add"];

    $str = "";
    if (isset($_SESSION["favoris"])) {
        $str = $_SESSION["favoris"];
    }
    // On récupère la liste des favoris actuels.
    $tab = explode(" ", $str);

    // Si il est connecté on récupère l'utilisateur.
    $utilisateur = "";
    if (isset($_SESSION["uti_connecte"])) {
        $utilisateur = $_SESSION["uti_connecte"];
    }

    // Si on est en mode ajout.
    if ($add == "true") {
        if ($utilisateur == "") {
            if (!in_array($id, $tab)) {
                $str = $str . " " . $id;
            }
        } else {
            if (!in_array($id, $tab)) {
                $str = $str . " " . $id;
                // On se connecte à la BDD.
                $bdd = new PDO('mysql:host=localhost;dbname=id18170749_slatkoktel;charset=utf8', 'id18170749_amaroke', '/]jptFa>FGDK-1vP');
                // On ajoute à ses favoris
                $sql = 'INSERT INTO Favoris(fav_idUtilisateur, fav_idRecette) VALUES (:fav_idUtilisateur, :fav_idRecette);';
                // On prépare et on lance la requête.
                $stmt = $bdd->prepare($sql);
                $stmt->bindParam(':fav_idUtilisateur', $_SESSION["uti_connecte_id"]);
                $stmt->bindParam(':fav_idRecette', $id);
                $stmt->execute();
            }
        }
    } else {
        if ($utilisateur == "") {
            unset($tab[array_search($id, $tab)]);
            $str = implode(" ", $tab);
        } else {
            unset($tab[array_search($id, $tab)]);
            $str = implode(" ", $tab);

            // On se connecte à la BDD.
            $bdd = new PDO('mysql:host=localhost;dbname=id18170749_slatkoktel;charset=utf8', 'id18170749_amaroke', '/]jptFa>FGDK-1vP');

            // On delete le favoris de la BDD.
            $sql = 'DELETE FROM Favoris WHERE fav_idUtilisateur="' . $_SESSION["uti_connecte_id"] . '" AND fav_idRecette="' . $id . '"';

            $stmt = $bdd->prepare($sql);
            $stmt->execute();
        }
    }
    // On met à jour la variable de session des favoris.
    $_SESSION["favoris"] = $str;
    echo "<script>history.back();</script>";
} else {
    header('Location: ../index.php');
}
