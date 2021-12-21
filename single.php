<html>

<head>
	<?php include 'head.php' ?>
</head>

<body>
	<?php include 'header.php'; ?>


	<div class="banner">
		<div class="container">
			<div class="banner-main">
				<?php
				$id = 84;
				if (isset($_GET["id_recette"])) {
					$id = $_GET["id_recette"];
				}

				$bdd = new PDO('mysql:host=localhost;dbname=SlatKoktel;charset=utf8;', 'slatkoktel', 'root2');

				$sql = "SELECT rec_titre, rec_ingredients, rec_preparation FROM Recettes WHERE rec_idRecette = :id";
				$stmt = $bdd->prepare($sql);
				$stmt->bindParam(':id', $id);
				$stmt->execute();

				$row = $stmt->fetch();
				$tab = explode("|", $row["rec_ingredients"]);
				echo("<h1>".$row["rec_titre"]."</h1><br>");
				echo("<h4>Ingrédients :</h4><br>");
				echo("<ul>");
				foreach ($tab as $value){
					echo("<li>".$value."</li>");
				}
				echo("</ul>");
				echo("<br><h4>Préparation :</h4><br>");
				echo($row["rec_preparation"]);
				?>
			</div>
		</div>
	</div>

	<?php include 'footer.php'; ?>
</body>

</html>