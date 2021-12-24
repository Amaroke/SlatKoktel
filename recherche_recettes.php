<html>

<head>
    <title>Recherche recettes</title>
    <?php
    session_start();
    include 'head.php' ?>

    <script>
        // Fonction qui recharge la page en récupérant les données précédentes.
        function rechercher() {
            document.rechercher_aliments.action = "recherche_recettes.php";
            document.rechercher_aliments.method = "POST";
            document.rechercher_aliments.submit();
        }

        // Fonction qui recharge en mode score.
        function recherche_score() {
            document.rechercher_aliments.action = "recherche_recettes.php";
            document.getElementById("le_score").value = 1;
            document.rechercher_aliments.method = "POST";
            document.rechercher_aliments.submit();
        }

        // On vérifie la validité de l'aliment avant de lancer le rechargement.
        function valide_aliment(le_type) {
            // On doit vérifier qu'il y a un aliment de choisi.
            if (document.getElementById("ingredient").value.length > 0 || le_type == 3) {
                document.rechercher_aliments.action = "recherche_recettes.php";
                document.getElementById("le_type").value = le_type;
                document.rechercher_aliments.method = "POST";
                document.rechercher_aliments.submit();
            } else {
                document.getElementById("ingredient").focus();
            }
        }
    </script>

    <!-- On utilise ce script pour utiliser ajax -->
    <script src="assets/js/jquery-1.12.4.min.js"></script>
    <script>
        $(document).ready(function() {
            $('#search-box input[type="text"]').on("keyup input", function() {
                // On récupère l'input.
                var inputVal = $(this).val();
                // On fait référence au div qui est de la classe résult.   
                var resultDropdown = $(this).siblings(".result");
                if (inputVal.length) {
                    // On utilise ajax pour éditer les choix disponnibles en direct.
                    $.get("recherche_backend.php", {
                        term: inputVal
                    }).done(function(data) {
                        // On affiche la liste générée.
                        resultDropdown.html(data);
                    });
                } else {
                    // Sinon on créé rien.
                    resultDropdown.empty();
                }
            });

            // Création du bouton de recherche.
            $(document).on("click", ".result p", function() {
                $(this).parents("#search-box").find('input[type="text"]').val($(this).text());
                $(this).parent(".result").empty();
                document.getElementById('ing1').focus();
            });
        });
    </script>


</head>

<body>
    <?php include 'header.php';
    if (!isset($_POST["rechercher"])) {
        $_POST["rechercher"] = NULL;
    }
    if (!isset($_POST["le_type"])) {
        $_POST["le_type"] = NULL;
    }
    // Si une recherche est en cours.
    if ($_POST["le_type"] == 3) {
        // On reset les aliments choisi et banni quand on appuie sur reset.
        $_SESSION["aliment_choisi"] = "";
        $_SESSION["aliment_banni"] = "";
    } else {
        if (strlen($_POST["rechercher"]) < 1) {
        } else {
            // Si le type est 1, on choisit l'aliment.
            if ($_POST["le_type"] == 1) {
                if (stripos($_SESSION["aliment_banni"], $_POST["rechercher"]) === false) {
                    // Si il n'est pas déjà présent.
                    if ($_SESSION["aliment_choisi"] == NULL) {
                        $_SESSION["aliment_choisi"] = $_POST["rechercher"];
                    } else {
                        if (stripos($_SESSION["aliment_choisi"], $_POST["rechercher"]) === false) {
                            $_SESSION["aliment_choisi"] = $_SESSION["aliment_choisi"] . " / " . $_POST["rechercher"];
                        }
                    }
                }
                // Sinon, on le bannit.
            } else {
                if (stripos($_SESSION["aliment_choisi"], $_POST["rechercher"]) === false) {
                    // Si il n'est pas déjà présent.
                    if ($_SESSION["aliment_banni"] == NULL) {
                        $_SESSION["aliment_banni"] = $_POST["rechercher"];
                    } else {
                        if (stripos($_SESSION["aliment_banni"], $_POST["rechercher"]) === false) {
                            $_SESSION["aliment_banni"] = $_SESSION["aliment_banni"] . " / " . $_POST["rechercher"];
                        }
                    }
                }
            }
        }
    }
    ?>

    <!-- On affiche les aliments choisis et bannis -->
    <div class="banner">
        <div class="container">
            <div class="col-9 banner-main" id="search-box">
                <h3>Votre recherche est actuellement composée des aliments suivants :</h3><br>
                <p> Aliments choisis :
                    <?php
                    $str = "";
                    $tab = explode(" / ", $_SESSION["aliment_choisi"]);
                    for ($i = 0; $i < count($tab) - 1; ++$i) {
                        $tab2 = explode(", ", $str);
                        if (!in_array($tab[$i], $tab2)) {
                            $str = $str . $tab[$i] . ", ";
                        }
                    }
                    $tab2 = explode(", ", $str);
                    if (!in_array($tab[$i], $tab2)) {
                        $str = $str . $tab[$i] . ".";
                    }
                    echo ($str);
                    ?>
                </p>
                <p> Aliments bannis :
                    <?php
                    $str = "";
                    $tab = explode(" / ", $_SESSION["aliment_banni"]);
                    for ($i = 0; $i < count($tab) - 1; ++$i) {
                        $tab2 = explode(", ", $str);
                        if (!in_array($tab[$i], $tab2)) {
                            $str = $str . $tab[$i] . ", ";
                        }
                    }
                    $tab2 = explode(", ", $str);
                    if (!in_array($tab[$i], $tab2)) {
                        $str = $str . $tab[$i] . ".";
                    }
                    echo ($str);
                    ?>
                </p>
                <br>
                <form name="rechercher_aliments" style="display: inline;">
                    <input type="hidden" name="le_type" id="le_type" />
                    <input type="hidden" name="le_score" id="le_score" />
                    <h4>Ajoutez/Bannissez d'autres aliments :</h4>
                    <input type="text" name="rechercher" id="ingredient" autofocus></input>
                    <input type="button" style="width:75px;height:35px;margin:3px;" value="Ajouter" onClick="valide_aliment(1)"></input>
                    <input type="button" style="width:75px;height:35px;" value="Bannir" onClick="valide_aliment(2)"></input>
                    <input type="button" style="width:75px;height:35px;" value="Reset" onClick="valide_aliment(3)"></input>
                    <br>
                    <!-- Zone de résultat de l'appel de code php-->
                    <div class="result"></div>
                </form>

                <!-- On affiche la liste des recettes correspondantes. -->
                <br><br>
                <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                    <h3>Voici la liste des recettes <span id="score"></span>correspondantes à votre recherche : <span id="nbr"></span></h3>
                    <h5>Vous pouvez cliquer sur la flèche <a>→</a> à droite du nom d'une recette pour y accéder.</h5><br>
                    <div class="table-responsive">
                        <table class="table table-bordered table-striped table-hover save-stage dataTable" style="width:100%;">
                            <thead>
                                <tr>
                                    <th></th>
                                    <th style="text-align:left;">Recettes</th>
                                    <th style="text-align:left;">Ingrédients</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                include("config.php");
                                $conn = new mysqli($servername, $username, $password, $dbname);
                                if ($conn->connect_error) {
                                    echo ("Connection failed: " . $conn->connect_error);
                                }
                                mysqli_set_charset($conn, "utf8");
                                if (!isset($_SESSION["aliment_choisi"])) {
                                    $_SESSION["aliment_choisi"] = "";
                                }
                                if (!isset($_SESSION["aliment_banni"])) {
                                    $_SESSION["aliment_banni"] = "";
                                }
                                if ((strlen($_SESSION["aliment_choisi"]) < 1) && (strlen($_SESSION["aliment_banni"]) < 1)) {
                                    $sql = "";
                                } else {
                                    // Si on est en mode score on met en rouge.
                                    if ($_POST["le_score"] == 1) {
                                        $score = "or";
                                        echo ("<script>
                                            document.getElementById('score').innerHTML=' <span style=\"color:red;font-weight:800;\">mode SCORE</span> ';
                                        </script>");
                                    } else {
                                        $score = "and";
                                        echo ("<script>
                                            document.getElementById('score').innerHTML='';
                                        </script>");
                                    }

                                    // On retire les espaces pour traiter les str.
                                    $_SESSION["aliment_choisi"] = trim($_SESSION["aliment_choisi"]);
                                    $_SESSION["aliment_banni"] = trim($_SESSION["aliment_banni"]);

                                    // Insère des /.
                                    $lesingredients_banni = "contenu like \"%  " . $_SESSION["aliment_banni"] . "  %\"";
                                    $lesingredients = "contenu like \"%  " . $_SESSION["aliment_choisi"] . "  %\"";

                                    // On les replace par des ,.
                                    $lesingredients = str_replace(" / ", "  %\" " . $score . " contenu like \"  %  ", $lesingredients);
                                    $lesingredients_banni = str_replace(" / ", "  %\" or contenu like \"%  ", $lesingredients_banni);

                                    // Requête qui récupère les recettes avec aliment choisi.
                                    $sql = "
                                        SELECT rec_titre,contenu,rec_idRecette FROM (
                                        SELECT
                                            rec_titre,GROUP_CONCAT(concat('  ', al_nomAliment,'  ')) contenu,rec_idRecette
                                        FROM
                                            Recettes
                                        LEFT JOIN Ingredients ON rec_idRecette = ing_idRecette
                                        LEFT JOIN Aliments ON al_idAliment = ing_idAliment
                                        where al_nomAliment is not null
                                        GROUP BY rec_titre) a
                                        where " . $lesingredients . "   
                                    ";

                                    // Requête qui récupère celle avec les bannis.
                                    $sql2 = "
                                        SELECT rec_titre FROM (
                                        SELECT
                                            rec_titre,GROUP_CONCAT(concat('  ', al_nomAliment,'  ')) contenu
                                        FROM
                                            Recettes
                                        LEFT JOIN Ingredients ON rec_idRecette = ing_idRecette
                                        LEFT JOIN Aliments ON al_idAliment = ing_idAliment
                                        where al_nomAliment is not null
                                        GROUP BY rec_titre) b
                                        where " . $lesingredients_banni . "   
                                    ";

                                    // Jonction des deux requêtes.
                                    $sql3 = "
                                        SELECT rec_titre,contenu,rec_idRecette FROM (
                                        " . $sql . " AND rec_titre NOT IN (" . $sql2 . ")
                                        ) c
                                    ";
                                }

                                if (isset($sql3)) {
                                    $result = $conn->query($sql3);
                                    if (isset($result->num_rows)) {
                                        // On affiche les recettes et les ingrédients.
                                        if ($result->num_rows > 0) {
                                            while ($row = $result->fetch_assoc()) {
                                                echo ("       
                                            <tr>
                                            <td>&nbsp;&nbsp;&nbsp;</td>
                                            <td>" . $row["rec_titre"] . "</td>
                                            <td>" . $row["contenu"] . "</td>
                                            </tr>
                                            ");
                                            }
                                            echo ("<script>
                                            document.getElementById('nbr').innerHTML='(" . ($result->num_rows) . ")';
                                        </script>");
                                        } else {
                                            if (strlen($_SESSION["aliment_choisi"]) > 0) {
                                                echo ("<script>
                                            document.getElementById('nbr').innerHTML='<br>Aucun résultat veuillez cliquer ici:<button style=\"width:225px;height:35px;margin:3px;\" onclick=\"recherche_score();\"> Recherche Score </button>';
                                        </script>");
                                            }
                                        }
                                    }
                                }
                                $conn->close();
                                ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <?php include 'footer.php'; ?>
</body>

</html>