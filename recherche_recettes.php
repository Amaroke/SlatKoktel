<html>

<head>
    <title>Recherche recettes</title>
    <?php 
    session_start();
    include 'head.php' ?>

    <style type="text/css">
        .result p{
            margin: 0;
            padding: 10px 10px;
            border: 2px solid #CCCCCC;
            border-top: none;
            cursor: pointer;
        }
        .result p:hover{
            background: #f2f2f2;
        }
    </style>


    <script>
        function rechercher() {
            document.rechercher_aliments.action = "recherche_recettes.php";
            document.rechercher_aliments.method="POST";
            document.rechercher_aliments.submit();
        }

        function valide_aliment(le_type){
            // on doit vérifier qu'il y a un aliment de choisi
            if (document.getElementById("ingredient").value.length>0) {
                document.rechercher_aliments.action = "recherche_recettes.php";
                document.getElementById("le_type").value = le_type;
                document.rechercher_aliments.method="POST";
                document.rechercher_aliments.submit();
            } else {
                document.getElementById("ingredient").focus();
            }
        }
    </script>


    <script src="assets/js/jquery-1.12.4.min.js"></script>
        <script>
            $(document).ready(function(){
            $('#search-box input[type="text"]').on("keyup input", function(){
                /* Get input value on change */
                var inputVal = $(this).val(); //ce que je recherche     
                var resultDropdown = $(this).siblings(".result"); //appel de la Class result (identifié par un ., #pour un id )
                if(inputVal.length){ // 
                    $.get("recherche_backend.php", {term: inputVal}).done(function(data){ //syntaxe ajax (appel de code php)
                        // Display the returned data in browser
                        resultDropdown.html(data); // création de la liste pour chaque éléments 
                    });
                } else{
                    resultDropdown.empty(); //sinon on ne cree rien.
                }
            });
            
            // POUR LE BOUTON DE RECHERCHE
            $(document).on("click", ".result p", function(){
                $(this).parents("#search-box").find('input[type="text"]').val($(this).text());
                $(this).parent(".result").empty();
                document.getElementById('ing1').focus();
            });
        });
    </script>


</head>

<body>
    <?php include 'header.php';
    
    if(strlen($_POST["rechercher"]) <1){
        $_SESSION["aliment_choisi"] = NULL;
    } else {
        if($_POST["le_type"] == 1){
            if (stripos($_SESSION["aliment_banni"],$_POST["rechercher"]) == false) {

                if($_SESSION["aliment_choisi"] == NULL){
                    $_SESSION["aliment_choisi"] = " ".$_POST["rechercher"];
                } else {
                    // si cet aliment n'a pas été déjà ajouté
                    if (stripos($_SESSION["aliment_choisi"],$_POST["rechercher"]) == false) {
                        $_SESSION["aliment_choisi"] = $_SESSION["aliment_choisi"]." / ".$_POST["rechercher"];
                    }
                }
            }
        } else {
            if (stripos($_SESSION["aliment_choisi"],$_POST["rechercher"]) == false) {
                if($_SESSION["aliment_banni"] == NULL){
                    $_SESSION["aliment_banni"] = " ".$_POST["rechercher"];
                } else {
                    if (stripos($_SESSION["aliment_banni"],$_POST["rechercher"]) == false) {
                        $_SESSION["aliment_banni"] = $_SESSION["aliment_banni"]." / ".$_POST["rechercher"];
                    }   
                }
            }
        }
    }
    
    ?>


    <div class="banner">
        <div class="container">
            <div class="col-9 banner-main" id="search-box">
                <p> Aliments choisis: 
                <?php
                echo $_SESSION["aliment_choisi"];
                ?>
                </p>

                <p> Aliments bannis: 
                <?php
                echo $_SESSION["aliment_banni"];
                ?>
                </p>
                <form name="rechercher_aliments">
                    <input type="hidden" name="le_type" id="le_type" />
                    <h4>Ajoutez/Bannissez des aliments à inclure à la recette :  
                        <input type="text" name="rechercher" id="ingredient" autofocus></input>   
                        <div class="result"></div> <!-- Zone de résultat de l'appel de code php-->
                    </h4>
                    <br>
            </div>
            <div class="col-2">
                <input type="button" value="Ajouter l'aliment" onClick="valide_aliment(1)"></input> <!-- faire un peu de css -->
            </div>

            <div class="col-2">
                <input type="button" value="Bannir l'aliment" onClick="valide_aliment(2)"></input> <!-- faire un peu de css -->
            </div>
            </form>
        </div>

            <br><br>
            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                <h2 style="align:center;">
                    <strong>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Les recettes <span id="nbr"></span></strong>&nbsp;&nbsp;&nbsp;
                </h2>

                <div class="table-responsive">
                        <table class="table table-bordered table-striped table-hover save-stage dataTable" style="width:100%;">
                        <thead>
                            <tr>
                            <th style="width='30px;'">&nbsp;&nbsp;&nbsp;</th>
                            <th style="text-align:left;">Recettes</th>
                            <th style="text-align:left;">Ingrédients</th>
                            </tr>
                        </thead>
                        <tbody>

                                <?php
                                    include("config.php");
                                    $conn = new mysqli($servername, $username, $password, $dbname);
                                    if ($conn->connect_error) {
                                        echo("Connection failed: " . $conn->connect_error);
                                    } 
                                    mysqli_set_charset($conn,"utf8");

                                    if (strlen($_SESSION["aliment_choisi"])<1) {$sql="";} 
                                    else {
                                        $_SESSION["aliment_choisi"]="xx".trim($_SESSION["aliment_choisi"])."xx";
                                        $lesingredients="contenu like \"%".$_SESSION["aliment_choisi"]."%\"";
                                        // Citron / Herbe / Fraise
                                        $lesingredients = str_replace(" / ","%\" and contenu like \"xx%", $lesingredients);
                                        //'Citron','Herbe','Fraise'                                            
                                        echo($_SESSION["aliment_choisi"]);
                                        echo("<br>".$lesingredients);

                                        $sql="
                                        SELECT rec_titre,contenu FROM (
                                        SELECT
                                            rec_titre,GROUP_CONCAT(al_nomAliment,\"xx\") contenu
                                        FROM
                                            Recettes
                                        LEFT JOIN Ingredients ON rec_idRecette = ing_idRecette
                                        LEFT JOIN Aliments ON al_idAliment = ing_idAliment
                                        where al_nomAliment is not null
                                        GROUP BY rec_titre) a
                                        where ".$lesingredients."    
                                    ";
                                    }


                                    echo("<br>".$sql);
                                    $result = $conn->query($sql);
                                    
                                    if ($result->num_rows > 0) {
                                        while($row = $result->fetch_assoc()) {
                                            echo("       
                                            <tr>
                                            <td>&nbsp;&nbsp;&nbsp;</td>
                                            <td>".$row["rec_titre"]."</td>
                                            <td>".$row["contenu"]."</td>
                                            </tr>

                                            ");
                                        }
                                        echo("<script>
                                            document.getElementById('nbr').innerHTML='(".($result->num_rows).")';
                                        </script>");
                                    } else {
                                        echo("<script>
                                        document.getElementById('nbr').innerHTML='';
                                    </script>");  
                                    }

                                    $conn -> close();
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