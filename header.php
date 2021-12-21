<!-- Ce fichier PHP permet de générer le header de toutes les pages du site -->

<div class="header">
	<div class="container">
		<div class="header-main">
			<div class="top-nav">
				<div class="content white">
					<nav class="navbar navbar-default" role="navigation">
						<div class="navbar-header">
							<button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1">
								<span class="sr-only">Toggle navigation</span>
								<span class="icon-bar"></span>
								<span class="icon-bar"></span>
								<span class="icon-bar"></span>
							</button>

						</div>
						<div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
							<ul class="nav navbar-nav">
								<div class="navbar-brand logo">
									<a href="index.php"><img src="assets/images/logo1.png" alt=""></a>
								</div>
								<li><a href="product.php">Cocktails</a></li>
								<li><a href="recherche_recettes.php">Recherche</a></li>
								<li><a href="#">Mes recettes préférées</a></li>
							</ul>
						</div>
					</nav>
				</div>
			</div>
			<div class="header-right">
				<div class="search">
					<div class="head-signin">
						<?php
						session_start();
						$var = $_SESSION["uti_connecte"];
						if ($var == "") {
							echo ('<h5><a href="login.php"><i class="hd-dign"></i>  Connexion</a></h5>');
						} else {
							echo ('<h5><a href="account.php"><i class="hd-dign"></i></a><a href="controller/deconnexion.php">  Déconnexion</a></h5>');
						}
						?>
					</div>
					<div class="clearfix"> </div>
				</div>
			</div>
			<div class="clearfix"> </div>
		</div>
	</div>
</div>