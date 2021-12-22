<html>

<head>
	<?php include 'head.php' ?>
</head>

<body>
	<?php include 'header.php'; ?>

	<div class="banner">
		<div class="container">
			<div class="banner-main">
				<h4>Ici, apparaissent les recettes que vous avez ajouté en favoris</h4><br>
				<h5>Vous pouvez cliquer sur la flèche <a>→</a> à droite du nom d'une recette pour y accéder.</h5><br>
				<?php
				session_start();
				$str = "";
				$str = $_SESSION["favoris"];
				$tab = explode(" ", $str);

				$bdd = new PDO('mysql:host=localhost;dbname=SlatKoktel;charset=utf8;', 'slatkoktel', 'root2');

				for ($i = 1; $i < count($tab); ++$i) {
					$sql = "SELECT rec_titre, rec_idRecette FROM Recettes WHERE rec_idRecette = :choix";
					$stmt = $bdd->prepare($sql);
					$stmt->bindParam(':choix', $tab[$i]);
					$stmt->execute();
					$row = $stmt->fetch();
					echo ("<ul>");
					echo ("<li>" . $row["rec_titre"] . '<a href="single.php?id_recette=' . $row["rec_idRecette"] . '"> →</a></li>');
					echo ("</ul>");
				}
				?>

			</div>
		</div>
	</div>

	<?php include 'footer.php'; ?>
</body>

</html>