<html>

<head>
	<?php include 'head.php'; ?>
	<script>
		function change_aliment(dernier_choix) {
			console.log(dernier_choix);
			// Dès qu'il choisit quelque chose on rappel la page.
			document.listes.action = "product.php?dernier_choix=".concat(dernier_choix);
			document.listes.method = "POST";
			document.listes.submit();
		}
	</script>
</head>

<body>
	<?php include 'header.php'; ?>
	<div class="product">
		<div class="container">
			<div class="product-main">
				<div class=" product-menu-bar">
					<div class="col-md-3 prdt-right">
						<div class="w_sidebar">
							<section class="sky-form">
								<h1>Catégories</h1>
								<div class="row1 scroll-pane">
									<?php require 'menu_categorie.php'; ?>
								</div>
							</section>
						</div>
					</div>
				</div>
				<div class="col-md-9 product-block">
					<h4>Sélectionnez des aliments sur la Gauche pour faire apparaitre les recettes correspondantes ci-dessous.</h4><br>
					<h5>Vous pourrez ensuite cliquer sur la flèche <a>→</a> à droite d'une recette pour y accéder.</h5><br>
					<?php
					for ($i = 1; $i < 9; ++$i) {
						if ((strlen($_SESSION["choix" . $i]) > 0)) {
							$bdd = new PDO('mysql:host=localhost;dbname=SlatKoktel;charset=utf8;', 'slatkoktel', 'root2');

							$sql = "SELECT ing_idRecette FROM Ingredients WHERE	ing_idAliment = :choix";
							$stmt = $bdd->prepare($sql);
							$stmt->bindParam(':choix', $_SESSION["choix" . ($i + 1)]);
							$stmt->execute();

							while ($row = $stmt->fetch()) {
								$sql2 = "SELECT rec_titre, rec_idRecette FROM Recettes WHERE rec_idRecette = :choix";
								$stmt2 = $bdd->prepare($sql2);
								$stmt2->bindParam(':choix', $row['ing_idRecette']);
								$stmt2->execute();
								$row2 = $stmt2->fetch();
								echo ("<ul>");
								echo ("<li>" . $row2["rec_titre"] . '<a href="single.php?id_recette=' . $row2["rec_idRecette"] . '"> →</a></li>');
								echo ("</ul>");
							}
						}
					}

					?>

				</div>
			</div>
		</div>
	</div>

	<?php include 'footer.php'; ?>
</body>

</html>