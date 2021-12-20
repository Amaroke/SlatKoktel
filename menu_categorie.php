<form name="listes">
    <select name="aliments" onchange="change_aliment()">
        <option value="" selected></option>
        <option value="7" <?php if ($_SESSION["choix1"] == 7) {
                                echo "selected";
                            } ?>>Fruit</option>
        <option value="9" <?php if ($_SESSION["choix1"] == 9) {
                                echo "selected";
                            } ?>>Assaisonnement</option>
        <option value="10" <?php if ($_SESSION["choix1"] == 10) {
                                echo "selected";
                            } ?>>Légume</option>
        <option value="13" <?php if ($_SESSION["choix1"] == 13) {
                                echo "selected";
                            } ?>>Liquide</option>
        <option value="19" <?php if ($_SESSION["choix1"] == 19) {
                                echo "selected";
                            } ?>>Noix et graine oléagineuse</option>
        <option value="21" <?php if ($_SESSION["choix1"] == 21) {
                                echo "selected";
                            } ?>>Oeuf</option>
        <option value="33" <?php if ($_SESSION["choix1"] == 33) {
                                echo "selected";
                            } ?>>Aliments divers</option>
        <option value="88" <?php if ($_SESSION["choix1"] == 88) {
                                echo "selected";
                            } ?>>Produit laitier</option>
    </select>
    <br><br>

    <?php

    $bdd = new PDO('mysql:host=localhost;dbname=SlatKoktel;charset=utf8;', 'slatkoktel', 'root2');

    $sql = "SELECT a.al_idAliment, a.al_nomAliment FROM Aliments a JOIN SuperCategorie sp ON sp.spc_idAliment = a.al_idAliment WHERE sp.spc_idAlimentSuperCategorie = :choix1";

    $test = $bdd->prepare($sql);

    if (!$test->execute(['choix1' => $_SESSION["choix1"]])) {
        print_r($test->errorInfo());
    }

    if (strlen($_SESSION["choix1"]) > 0) {
        echo '<select name="sous_aliments" onchange="change_aliment()"><option value=""><option>';
        while ($row = $test->fetch()) {
            if ($_SESSION["choix2"] == $row['al_idAliment']) {
                $selection = "selected";
            } else {
                $selection = "";
            }
            echo '<option value="' . $row['al_idAliment'] . '" ' . $selection . '>' . $row['al_nomAliment'] . '</option>';
        }
        echo '</select>';
    }

    ?>

    <br><br>

    <?php

    $bdd = new PDO('mysql:host=localhost;dbname=SlatKoktel;charset=utf8;', 'slatkoktel', 'root2');

    $sql = "SELECT a.al_idAliment, a.al_nomAliment FROM Aliments a JOIN SuperCategorie sp ON sp.spc_idAliment = a.al_idAliment WHERE sp.spc_idAlimentSuperCategorie = :choix2";

    $test = $bdd->prepare($sql);

    if (!$test->execute(['choix2' => $_SESSION["choix2"]])) {
        print_r($test->errorInfo());
    }

    if (strlen($_SESSION["choix2"]) > 0) {
        echo '<select name="sous_sous_aliments" onchange="change_aliment()"><option value=""></option>';
        while ($row = $test->fetch()) {
            if ($_SESSION["choix3"] == $row['al_idAliment']) {
                $selection = "selected";
            } else {
                $selection = "";
            }
            echo '<option value="' . $row['al_idAliment'] . '" ' . $selection . '>' . $row['al_nomAliment'] . '</option>';
        }
        echo '</select>';
    }
    ?>

</form>