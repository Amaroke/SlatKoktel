<?php
if (isset($_GET["id_recette"]) && isset($_GET["add"])) {
    session_start();

    $id = $_GET["id_recette"];
    $add = $_GET["add"];

    $str = "";
    $str = $_SESSION["favoris"];
    $tab = explode(" ", $str);

    $utilisateur = $_SESSION["uti_connecte"];

    if ($add == "true") {
        if ($utilisateur == "") {
            if (!in_array($id, $tab)) {
                $str = $str . " " . $id;
            }
        } else {
            if (!in_array($id, $tab)) {
                $str = $str . " " . $id;
                // On se connecte à la BDD.
                $bdd = new PDO('mysql:host=localhost;dbname=SlatKoktel;charset=utf8;', 'slatkoktel', 'root2');

                $sql = 'INSERT INTO Favoris(fav_idUtilisateur, fav_idRecette) VALUES (:fav_idUtilisateur, :fav_idRecette);';

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
            $bdd = new PDO('mysql:host=localhost;dbname=SlatKoktel;charset=utf8;', 'slatkoktel', 'root2');

            // On insère le nouvel utilisateur dans la BDD.
            $sql = 'DELETE FROM Favoris WHERE fav_idUtilisateur="'.$_SESSION["uti_connecte_id"].'" AND fav_idRecette="'.$id.'"';

            $stmt = $bdd->prepare($sql);
            $stmt->execute();
        }
    }
    $_SESSION["favoris"] = $str;
    echo "<script>history.back();</script>";
} else {
    header('Location: ../index.php');
}
