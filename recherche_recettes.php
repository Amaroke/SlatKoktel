<html>

<head>
    <title>Recherche recettes</title>
    <?php include 'head.php' ?>

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
            document.recherche_recettes.action = "recherche_recettes.php";
            document.recherche_recettes.method="POST;"
            document.recherche_recettes.submit();
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
                $(this).parents(".search-box").find('input[type="text"]').val($(this).text());
                $(this).parent(".result").empty();
                document.getElementById('ing1').focus();
            });
        });
    </script>


</head>

<body>
    <?php include 'header.php'; ?>

    <div class="banner">
        <div class="container">
            <div class="col-9 banner-main" id="search-box">
                <form action="recherche_recettes.php" method="POST" name="recherche_recettes">
                    <h4>Ajoutez des aliments à inclure à la recette :  
                        <input type="text" name="rechercher" id="ing1" autofocus></input>   
                        <div class="result"></div> <!-- Zone de résultat de l'appel de code php-->
                    </h4>
                    <br>
                </form>
            </div>
            <div class="col-2">
                <input type="button" value="Ajoutez l'aliment"></input>
            </div>

        </div>
    </div>

    <?php include 'footer.php'; ?>
</body>

</html>