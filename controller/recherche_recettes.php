<?php

	$term = $_GET['term'];

    $bdd = new PDO('mysql:host=localhost;dbname=SlatKoktel;charset=utf8;', 'slatkoktel', 'root2');

	$rechercheRecettes = 'SELECT * 
	FROM Recettes 
    WHERE LOWER(rec_titre) LIKE LOWER(:term) ;' ;

	$requete = $bdd->prepare($rechercheRecettes);
	$requete->execute(array('term' => '%'.$term.'%'));
	$array = array(); // on crée le tableau
	while($donnee = $requete->fetch()) // on effectue une boucle pour obtenir les données
	{
	    array_push($array, $donnee['titre']); // et on ajoute celles-ci à notre tableau
	}


	$rechercheAliments = 'SELECT * 
                                FROM Aliments
                                WHERE LOWER(al_nomAliment) LIKE LOWER(:term) ;' ;
    $requete = $bdd->prepare($rechercheAliments);
	$requete->execute(array('term' => '%'.$term.'%'));
	while($donnee = $requete->fetch())
	{
	    array_push($array, $donnee['nomAliment']);
	}                   

	echo json_encode($array); // il n'y a plus qu'à convertir en JSON

?>