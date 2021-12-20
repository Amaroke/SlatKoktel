<html>

<head>
	<?php include 'head.php' ?>
</head>

<body>
	<?php include 'header.php'; ?>

	<!--Création de compte-->
	<div class="signin">
		<div class="container">
			<div class="signin-main">
				<h1>Créer un compte</h1>
				<h2>Informations</h2>
				<form name="inscription" method="POST" action="signup.php">
					<!-- method POST permet de camoufler les informations dans l'url / action nom du fichier qui sera exec lors du submit -->
					<input type="text" name="uti_pseudo" placeholder="Pseudo" required="" value="Stalh"> <!-- Ajout d'un champ name dans input-->
					<input type="text" name="uti_email" class="no-margin" placeholder="E-mail" required="" value="stalh@gmail.com" pattern="[aA0-zZ9]+[.]?[aA0-zZ9]*@[aA-zZ]*[.]{1}[aA-zZ]+">
					<input type="text" name="uti_prenom" placeholder="Eric" value="Martin" />
					<input type="text" name="uti_nom" class="no-margin" placeholder="Dupont" value="Dupont" />
					<input type="text" name="uti_age" placeholder="18" value="54" />
					<input type="text" name="uti_telephone" class="no-margin" placeholder="0601020304" value="0698765432" />
					<input type="text" name="uti_sexe" placeholder="F" value="M" />
					<input type="text" name="uti_codePostal" class="no-margin" placeholder="54150" value="54657" />
					<input type="text" name="uti_adresse" placeholder="12 rue de Mance" value="12 rue de Lardon" />
					<input type="text" name="uti_ville" class="no-margin" placeholder="Lantefontaine" value="Briey" />
					<input type="password" name="uti_mdp" placeholder="Mot de passe" required="" value="test" />
					<input type="password" name="uti_mdp2" class="no-margin" placeholder="Confirmation du mot de passe" required="" value="test" />
					<input type="submit" value="Envoyer">
				</form>
			</div>
		</div>
	</div>
	<!--Fin de création de compte-->

	<?php include 'footer.php'; ?>
</body>

</html>