<html>

<head>
	<?php include 'head.php'; ?>
	<script>
		function change_aliment() {
			// Dès qu'il choisit quelque chose on rappel la page.
			document.listes.action = "product.php";
			document.listes.method = "POST";
			document.listes.submit();
		}
	</script>
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
									<?php require 'menu_categorie.php'; ?>
								</div>
							</section>
						</div>
					</div>
				</div>
				<div class="col-md-9 product-block">

					<?php
					if (strlen($_SESSION["choix2"]) > 0) {
						$bdd = new PDO('mysql:host=localhost;dbname=SlatKoktel;charset=utf8;', 'slatkoktel', 'root2');

						$sql = "SELECT ing_idRecette FROM Ingredients WHERE	ing_idAliment = :choix2";
						$stmt = $bdd->prepare($sql);
						$stmt->bindParam(':choix2', $_SESSION["choix3"]);
						$stmt->execute();

						while ($row = $stmt->fetch()) {
							$sql2 = "SELECT rec_titre FROM Recettes WHERE rec_idRecette = :choix2";
							$stmt2 = $bdd->prepare($sql2);
							$stmt2->bindParam(':choix2', $row['ing_idRecette']);
							$stmt2->execute();
							$row2 = $stmt2->fetch();
							echo ($row2["rec_titre"]);
							echo ("<br>");
						}
					}
					?>

				</div>
			</div>
		</div>
	</div>
	<!--product end here-->

	<?php include 'footer.php'; ?>
</body>

</html>