
<!--Author: W3layouts
Author URL: http://w3layouts.com
License: Creative Commons Attribution 3.0 Unported
License URL: http://creativecommons.org/licenses/by/3.0/
-->
<!DOCTYPE HTML>
<html>

<head>
	<title>Créer un compte</title>
	<link href="css/bootstrap.css" rel="stylesheet" type="text/css" media="all">
	<script src="js/jquery-1.11.0.min.js"></script>
	<link href="css/style.css" rel="stylesheet" type="text/css" media="all" />
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
	<script
		type="application/x-javascript"> addEventListener("load", function() { setTimeout(hideURLbar, 0); }, false); function hideURLbar(){ window.scrollTo(0,1); } </script>
	<link href='//fonts.googleapis.com/css?family=Hind:400,500,300,600,700' rel='stylesheet' type='text/css'>
	<link href='//fonts.googleapis.com/css?family=Oswald:400,700,300' rel='stylesheet' type='text/css'>
	<script type="text/javascript" src="js/move-top.js"></script>
	<script type="text/javascript" src="js/easing.js"></script>
	<script type="text/javascript">
		jQuery(document).ready(function ($) {
			$(".scroll").click(function (event) {
				event.preventDefault();
				$('html,body').animate({ scrollTop: $(this.hash).offset().top }, 1000);
			});
		});
	</script>
	<script src="js/simpleCart.min.js"> </script>
	<script src="js/bootstrap.min.js"></script>
</head>

<body>
	<!--Début du header de la page-->
	<div class="header">
		<div class="container">
			<div class="header-main">
				<div class="top-nav">
					<div class="content white">
						<nav class="navbar navbar-default" role="navigation">
							<div class="navbar-header">
								<button type="button" class="navbar-toggle" data-toggle="collapse"
									data-target="#bs-example-navbar-collapse-1">
									<span class="sr-only">Toggle navigation</span>
									<span class="icon-bar"></span>
									<span class="icon-bar"></span>
									<span class="icon-bar"></span>
								</button>
								<div class="navbar-brand logo">
									<a href="index.html"><img src="images/logo1.png" alt=""></a>
								</div>
							</div>
							<div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
								<ul class="nav navbar-nav">
									<li><a href="index.html">Accueil</a></li>
									<li><a href="product.html">Nos cocktails</a></li>
								</ul>
							</div>
						</nav>
					</div>
				</div>
				<div class="header-right">
					<div class="search">
						<div class="head-signin">
							<h5><a href="login.html"><i class="hd-dign"></i> Connexion</a></h5>
						</div>
						<div class="clearfix"> </div>
					</div>
				</div>
				<div class="clearfix"> </div>
			</div>
		</div>
	</div>
	<!--Fin du header de la page-->

	
	<!--Création de compte-->
	<div class="signin">
		<div class="container">
			<div class="signin-main">
				<h1>Créer un compte</h1>
				<h2>Informations</h2>
				<?php
					if(isset($_POST["submit"])){
						

					}
					if($donnees = $results->fetch())?>
					
				<form>
					<input type="text" placeholder="Nom d'utilisateur">
					<input type="text" class="no-margin" placeholder="E-mail">
					<input type="password" placeholder="Mot de passe" required="" />
					<input type="password" class="no-margin" placeholder="Confirmation du mot de passe" required="" />
					<input type="submit" value="Envoyer">
				</form>
			</div>
		</div>
	</div>
	<!--Fin de création de compte-->

	<!-- Footer de la page -->
	<div class="footer">
		<div class="container">
			<div class="copy-rights">
				<p>© 2021 SlatKoktel. Tous droits réservés | Créé par <a href="http://w3layouts.com/"
						target="_blank">W3layouts</a> et modifié par ZIMOL Guillaume & MATHIEU
					STEINBACH Hugo</a> </p>
			</div>
		</div>
	</div>
	<!-- Fin du footer de la page -->
</body>

</html>
