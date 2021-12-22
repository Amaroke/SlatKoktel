<html>

<head>
	<?php include 'head.php' ?>
</head>

<body>
	<?php include 'header.php'; ?>

	<?php
	function recuperer_nom_image($str)
	{
		$newStr = $str;
		$newStr = preg_replace('#Ç#', 'C', $newStr);
		$newStr = preg_replace('#ç#', 'c', $newStr);
		$newStr = preg_replace('#è|é|ê|ë#', 'e', $newStr);
		$newStr = preg_replace('#È|É|Ê|Ë#', 'E', $newStr);
		$newStr = preg_replace('#à|á|â|ã|ä|å#', 'a', $newStr);
		$newStr = preg_replace('#@|À|Á|Â|Ã|Ä|Å#', 'A', $newStr);
		$newStr = preg_replace('#ì|í|î|ï#', 'i', $newStr);
		$newStr = preg_replace('#Ì|Í|Î|Ï#', 'I', $newStr);
		$newStr = preg_replace('#ð|ò|ó|ô|õ|ö#', 'o', $newStr);
		$newStr = preg_replace('#Ò|Ó|Ô|Õ|Ö#', 'O', $newStr);
		$newStr = preg_replace('#ù|ú|û|ü#', 'u', $newStr);
		$newStr = preg_replace('#Ù|Ú|Û|Ü#', 'U', $newStr);
		$newStr = preg_replace('#ý|ÿ#', 'y', $newStr);
		$newStr = preg_replace('#Ý#', 'Y', $newStr);
		$newStr = preg_replace('#ń|ǹ|ň|ñ#', 'n', $newStr);
		$newStr = preg_replace('#Ñ|Ń|Ǹ|Ň|ň#', 'N', $newStr);
		$newStr = str_replace(' ', '_', $newStr);
		$newStr = str_replace("'", '', $newStr);

		return ($newStr);
	} ?>

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
				echo ("<h1>" . $row["rec_titre"] . "</h1><br>");
				echo ("<h4>Ingrédients :</h4><br>");
				echo ("<ul>");
				foreach ($tab as $value) {
					echo ("<li>" . $value . "</li>");
				}
				echo ("</ul>");
				echo ("<br><h4>Préparation :</h4><br>");
				echo ($row["rec_preparation"]);
				if (file_exists('assets/images/' . recuperer_nom_image(ucfirst(strtolower($row["rec_titre"]))) . '.jpg')) {
					echo ("<br><br><h4>Voici une image de la boisson :</h4>");
					echo ('<img class="img-responsive" src="assets/images/' . recuperer_nom_image(ucfirst(strtolower($row["rec_titre"]))) . '.jpg" />');
				}
				$str = $_SESSION["favoris"];
				$tab = explode(" ", $str);
				if (!in_array($id, $tab)) {
					echo ('<form name="favorite" method="POST" action="controller/favorite.php?add=true&id_recette=' . $id . '">');
					echo ('<br><br><input type="submit" value="Ajouter aux recettes préférées"></form>');
				} else {
					echo ('<form name="favorite" method="POST" action="controller/favorite.php?add=false&id_recette=' . $id . '">');
					echo ('<br><br><input type="submit" value="Retirer des recettes préférées"></form>');
				}

				?>
			</div>
		</div>
	</div>

	<?php include 'footer.php'; ?>
</body>

</html>