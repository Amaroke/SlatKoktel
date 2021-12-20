<html>

<head>
	<?php include 'head.php' ?>
	<script>
		function change_aliment() {
			// Dès qu'il choisit quelque chose on rappel la page.
			document.listes.action = "product.php";
			document.listes.method = "POST";
			document.listes.submit();
		}
	</script>
	<?php
	session_start();
	if (!empty($_POST["aliments"])) {
		$_SESSION["choix1"] = $_POST["aliments"];
		if (!empty($_POST["sous_aliments"])) {
			$_SESSION["choix2"] = $_POST["sous_aliments"];
			if (!empty($_POST["sous_sous_aliments"])) {
				$_SESSION["choix3"] = $_POST["sous_sous_aliments"];
			} else {
				$_SESSION["choix3"] = NULL;
			}
		} else {
			$_SESSION["choix2"] = NULL;
			$_SESSION["choix3"] = NULL;
		}
	} else {
		$_SESSION["choix1"] = NULL;
		$_SESSION["choix2"] = NULL;
		$_SESSION["choix3"] = NULL;
	}
	?>
</head>

<body>
	<?php include 'header.php'; ?>
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
									<?php include 'menu_categorie.php' ?>
								</div>
							</section>
						</div>
					</div>
				</div>
				<div class="col-md-9 product-block">

					<?php
					if (strlen($_SESSION["choix1"]) > 0) {
						$bdd = new PDO('mysql:host=localhost;dbname=SlatKoktel;charset=utf8;', 'slatkoktel', 'root2');

						$sql = "SELECT ing_idRecette FROM Ingredients WHERE	ing_idAliment = :choix1";
						$stmt = $bdd->prepare($sql);
						$stmt->bindParam(':choix1', $_SESSION["choix2"]);
						$stmt->execute();

						while ($row = $stmt->fetch()) {
							$sql2 = "SELECT rec_titre FROM Recettes WHERE rec_idRecette = :choix1";
							$stmt2 = $bdd->prepare($sql2);
							$stmt2->bindParam(':choix1', $row['ing_idRecette']);
							$stmt2->execute();
							$row2 = $stmt2->fetch();
							echo($row2["rec_titre"]);
							echo("<br>");
						}
					}
					?>

					<!-- Ici pour la requete sql on regerdera tout les recettes qui ont l'id de l'aliment à l'intérieur (regarder la structure de la bdd Ingredients) -->

					<!-- Ici on aura la liste -->

				</div>
			</div>
		</div>
	</div>
	<!--product end here-->

	<?php include 'footer.php'; ?>
</body>

</html>