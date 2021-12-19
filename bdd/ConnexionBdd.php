<?php
//On essaye de se connecter 
try {
	$bdd = new PDO('mysql:host=localhost;dbname=SlatKoktel;charset=utf8', 'root', 'root');

} catch(Exception $e) {
	die('Erreur : '.$e->getMessage());
}

?>