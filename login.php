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
					<form name="connexion" method="POST" action="controller/login.php">
						<input type="text" name="uti_pseudo" class="no-margin" placeholder="Pseudo" required="">
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