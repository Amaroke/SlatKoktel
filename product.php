<html>

<head>
	<?php include 'head.php' ?>
	<script> function change_aliment(){
			//alert(document.listes.aliments.value);
			document.listes.action = "product.php"; //dès qu'il choisi quelque chose on rappel la page (on rafraichi)
			document.listes.method = "POST";
			document.listes.submit();
	} </script>
	<?php
		session_start();
		//echo 'yyyyyy'.$_POST["aliments"];
		if(!empty($_POST["aliments"])){
			$_SESSION["choix1"] = $_POST["aliments"];
			if(!empty($_POST["sous_aliments"])){
				$_SESSION["choix2"] = $_POST["sous_aliments"];
				if(!empty($_POST["sous_sous_aliments"])){
					$_SESSION["choix3"] = $_POST["sous_sous_aliments"];
				} else {
					$_SESSION["choix3"] = NULL;
				}
			} else {
				$_SESSION["choix2"] = NULL;
			}
		}else {
			$_SESSION["choix1"] = NULL;
			$_SESSION["choix2"] = NULL;
			$_SESSION["choix3"] = NULL;
		}
		
		
	?>
</head>

<body>
	<?php include 'header.php'; ?>
	<?php echo $_SESSION["choix1"]."<br>" ?>
	<?php echo $_SESSION["choix2"]."<br>" ?>
	<?php echo $_SESSION["choix3"]."<br>" ?>
	<!--product start here-->
	<div class="product">
		<div class="container">
			<div class="product-main">
				<div class=" product-menu-bar">
					<div class="col-md-3 prdt-right">
						<div class="w_sidebar">
							<section class="sky-form">
								<h1>Catégories</h1>
								<div class="row1 scroll-pane">
									<form name="listes">
									<select name="aliments" onChange="change_aliment();">
										<option value="" selected></option>
										<option value="7" <?php if($_SESSION["choix1"] == 7){ echo "selected";}?>>Fruit</option>
										<option value="9" <?php if($_SESSION["choix1"] == 9){ echo "selected";}?>>Assaisonnement</option>
									</select>
									<br>
									<br>
									
									<?php

										
										$bdd = new PDO('mysql:host=localhost;dbname=SlatKoktel;charset=utf8;', 'slatkoktel', 'root2'); //creer un autre fichier, on l'utilise trop souvent



										// On vérifie que l'email n'est pas déjà pris.
										$sql = "SELECT a.al_idAliment, a.al_nomAliment 
										FROM Aliments a
										JOIN SuperCategorie sp ON sp.spc_idAliment = a.al_idAliment 
										WHERE sp.spc_idAlimentSuperCategorie = :choix1
										";
										
										$test = $bdd->prepare($sql);
										
										
										if(!$test->execute(['choix1'=>$_SESSION["choix1"]])){
											print_r($test->errorInfo());
										}
										
										if(strlen($_SESSION["choix1"]) > 0){ //si on a choisi dans le choix 1
											echo '
										<select name="sous_aliments" onChange="change_aliment();">
										<option value=""> ? </option>';
										while($row = $test->fetch()){
											if($_SESSION["choix2"] == $row['al_idAliment']){ $selection = "selected";} else { $selection = "";}
											echo '
											<option value="'.$row['al_idAliment'].'" '.$selection.'>'.$row['al_nomAliment'].'</option>
											';
										}
										
										echo '
										</select>
										';
										
										
										}
									?>





									<br>
									<br>
									
									<?php

										
										$bdd = new PDO('mysql:host=localhost;dbname=SlatKoktel;charset=utf8;', 'slatkoktel', 'root2'); //creer un autre fichier, on l'utilise trop souvent



										// On vérifie que l'email n'est pas déjà pris.
										$sql = "SELECT a.al_idAliment, a.al_nomAliment 
										FROM Aliments a
										JOIN SuperCategorie sp ON sp.spc_idAliment = a.al_idAliment 
										WHERE sp.spc_idAlimentSuperCategorie = :choix2
										";
										
										$test = $bdd->prepare($sql);
										
										
										if(!$test->execute(['choix2'=>$_SESSION["choix2"]])){
											
											print_r($test->errorInfo());
										}
										
										if(strlen($_SESSION["choix2"]) > 0){ //si on a choisi dans le choix 1
											echo '
										<select name="sous_sous_aliments" onChange="change_aliment();">
										<option value=""> ? </option>';
										while($row = $test->fetch()){
											if($_SESSION["choix3"] == $row['al_idAliment']){ $selection = "selected";} else { $selection = "";}
											echo '
											<option value="'.$row['al_idAliment'].'" '.$selection.'>'.$row['al_nomAliment'].'</option>
											';
										}
										
										echo '
										</select>
										';
										
										
										}
									?>


   									</form>
								</div>
							</section>
						</div>
					</div>
				</div>
				<div class="col-md-9 product-block">

					<!-- Ici pour la requete sql on regerdera tout les recettes qui ont l'id de l'aliment à l'intérieur (regarder la structure de la bdd Ingredients) -->

					<div class="col-md-4 home-grid">
						<div class="home-product-main">
							<div class="home-product-top">
								<a href="single.php"><img src="assets/images/Black_velvet.jpg" alt="" class="img-responsive"></a>
							</div>
							<div class="home-product-bottom">
								<h3><a href="single.php">Exemple</a></h3>
								<p>Regarder la recette → </p>
							</div>
						</div>
					</div>

					<div class="clearfix"> </div>
				</div>
			</div>
		</div>
	</div>
	<!--product end here-->

	<?php include 'footer.php'; ?>
</body>

</html>