<html>

<head>
	<title>Mon compte</title>
	<?php include 'head.php' ?>
</head>

<body>
	<?php include 'header.php'; ?>

	<div class="signin">
		<div class="container">
			<div class="signin-main">
				<h1>Modifier les informations de mon compte</h1>
				</br>
				<h3>Laissez les champs vide s'il n'y a pas de modifications.</h3>
				</br>
				<form name="inscription" method="POST" action="controller/account.php">
					<input type="text" name="uti_pseudo" placeholder="Nouveau pseudo">
					<input type="text" name="uti_age" placeholder="Votre âge" />
					<input type="text" name="uti_telephone" placeholder="Nouveau numéro de téléphone" />
					<input type="text" name="uti_codePostal" class="no-margin" placeholder="Nouveau code postal" />
					<input type="text" name="uti_adresse" placeholder="Nouvelle adresse" />
					<input type="text" name="uti_ville" class="no-margin" placeholder="Nouvelle ville" />
					<input type="password" name="uti_mdp" placeholder="Nouveau mot de passe" />
					<input type="password" name="uti_mdp2" placeholder="Confirmation nouveau mot de passe" class="no-margin" />
					*<input type="password" name="old_mdp" placeholder="Ancien mot de passe" required="" />
					<p>* Obligatoire pour enregistrer les modifications.</p>
					<input type="submit" value="Envoyer">
				</form>
			</div>
		</div>
	</div>

	<?php include 'footer.php'; ?>
</body>

</html>