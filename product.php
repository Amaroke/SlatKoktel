<html>

<head>
	<?php include 'head.php'; ?>
	<script>
		function change_aliment(dernier_choix) {
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
					<h4>Ici, apparaissent les recettes correspondantes à la dernière sélection d'aliment à gauche.</h4><br>
					<h5>Vous pouvez cliquer sur la flèche <a>→</a> à droite du nom d'une recette pour y accéder.</h5><br>
					<?php
					if (isset($_GET["dernier_choix"])) {
						$dernier_choix = $_GET["dernier_choix"];
					} else {
						$dernier_choix = 0;
					}

					if ((strlen($_SESSION["choix" . $dernier_choix]) > 0)) {
						$bdd = new PDO('mysql:host=localhost;dbname=SlatKoktel;charset=utf8;', 'slatkoktel', 'root2');

						$sql = "SELECT ing_idRecette FROM Ingredients WHERE	ing_idAliment = :choix";
						$stmt = $bdd->prepare($sql);
						$stmt->bindParam(':choix', $_SESSION["choix" . ($dernier_choix)]);
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
					?>

				</div>
			</div>
		</div>
	</div>

	<?php include 'footer.php'; ?>
</body>

</html>