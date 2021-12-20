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
				<h3>Attention les champs laissés vide effaceront les données précédentes.</h3>
				</br>
				<form name="changer" method="POST" action="controller/account.php">
					<!-- Ajout des différentes champs de saisie-->
					<input type="password" name="uti_mdp" placeholder="Nouveau mot de passe" class="no-margin" required="" />
					<input type="password" name="uti_mdp2" placeholder="Confirmation du nouveau mot de passe" required="" />
					<input type="text" name="uti_email" placeholder="E-mail" pattern="[aA0-zZ9]+[.]?[aA0-zZ9]*@[aA-zZ]*[.]{1}[aA-zZ]+" class="no-margin">
					<input type="text" name="uti_adresse" placeholder="Nouvelle adresse" />
					<input type="text" name="uti_codePostal" placeholder="Nouveau code Postal" class="no-margin" />
					<input type="text" name="uti_ville" placeholder="Nouvelle ville" />
					<input type="text" name="uti_telephone" placeholder="Nouveau numéro de mobile" minlength="10" maxlength="10" />
					<input type="password" name="old_mdp" placeholder="Ancien mot de passe" required="" />
					<p>Il est obligatoire de modifier votre mot de passe et de renseigner le précédent pour enregistrer les modifications.</p>
					<input type="submit" value="Envoyer">
				</form>
			</div>
		</div>
	</div>

	<?php include 'footer.php'; ?>
</body>

</html>