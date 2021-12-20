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
				<!-- method POST permet de camoufler les informations dans l'url, action nom du fichier qui sera exec lors du submit -->
				<form name="inscription" method="POST" action="controller/signup.php">
					<!-- Ajout des différentes champs de saisie-->
					<input type="text" name="uti_pseudo" placeholder="Pseudo" required="" class="no-margin">
					<input type="text" name="uti_sexe" placeholder="Sexe H/F" maxlength="1" />
					<input type="password" name="uti_mdp" placeholder="Mot de passe" required="" class="no-margin" />
					<input type="password" name="uti_mdp2" placeholder="Confirmation du mot de passe" required="" />
					<input type="text" name="uti_nom" placeholder="Nom de famille" class="no-margin" />
					<input type="text" name="uti_prenom" placeholder="Prénom" />
					<input type="text" name="uti_email" placeholder="E-mail" pattern="[aA0-zZ9]+[.]?[aA0-zZ9]*@[aA-zZ]*[.]{1}[aA-zZ]+" class="no-margin">
					&nbsp&nbspDate de naissance : <input type="date" name="uti_naissance" placeholder="Date de naissance jj/mm/aaaa" minlength="10" maxlength="10" /></br></br>
					<input type="text" name="uti_adresse" placeholder="Adresse" class="no-margin" />
					<input type="text" name="uti_codePostal" placeholder="Code Postal" />
					<input type="text" name="uti_ville" placeholder="Ville" class="no-margin" />
					<input type="text" name="uti_telephone" placeholder="Numéro de mobile" minlength="10" maxlength="10"/>
					<input type="submit" value="Envoyer">
				</form>
			</div>
		</div>
	</div>
	<!--Fin de création de compte-->

	<?php include 'footer.php'; ?>
</body>

</html>