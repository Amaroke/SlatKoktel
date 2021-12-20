<html>

<head>
	<title>Connexion</title>
	<?php include 'head.php' ?>
</head>

<body>
	<?php include 'header.php'; ?>

	<!--Connexion-->
	<div class="login">
		<div class="container">
			<div class="login-main">
				<h1>Connexion</h1>
				<div class="col-md-6 login-left">
					<h2>Utilisateur existant</h2>
					<form name="connexion" method="POST" action="login.php">
						<input type="text" name="uti_email" class="no-margin" placeholder="E-mail" required="" pattern="[aA0-zZ9]+[.]?[aA0-zZ9]*@[aA-zZ]*[.]{1}[aA-zZ]+">
						<input type="password" name="uti_mdp" placeholder="Mot de passe" required="" />
						<input type="submit" value="Envoyer">
					</form>
				</div>
				<div class="col-md-6 login-right">
					<h3>Nouvel utilisateur ? Crée un compte !</h3>
					<a href="signup.php" class="login-btn">Créer un compte</a>
				</div>
				<div class="clearfix"> </div>
			</div>
		</div>
	</div>
	<!--Fin de connexion-->

	<?php include 'footer.php'; ?>
</body>

</html>