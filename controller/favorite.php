<?php
if (isset($_GET["id_recette"]) && isset($_GET["add"])) {
    session_start();

    $id = $_GET["id_recette"];
    $add = $_GET["add"];

    $str = "";
    $str = $_SESSION["favoris"];
    $tab = explode(" ", $str);

    if ($add == "true") {
        if (!in_array($id, $tab)) {
            $str = $str . " " . $id;
        }
    } else {
        unset($tab[array_search($id, $tab)]);
        $str = implode(" ", $tab);
    }
    $_SESSION["favoris"] = $str;
    echo "<script>history.back();</script>";
} else {
    header('Location: ../index.php');
}
