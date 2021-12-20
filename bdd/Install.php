<?php

// Création des requêtes.
$bdd = new PDO('mysql:host=localhost;charset=utf8', 'slatkoktel', 'root2');
$creation = 'DROP DATABASE IF EXISTS SlatKoktel ;

					CREATE DATABASE IF NOT EXISTS SlatKoktel ;

					USE SlatKoktel ;

					CREATE TABLE Recettes (
						rec_idRecette INT(6) UNSIGNED AUTO_INCREMENT PRIMARY KEY,
						rec_titre VARCHAR(100) NOT NULL UNIQUE,
						rec_ingredients TEXT NOT NULL,
						rec_preparation TEXT NOT NULL
					) ;

					CREATE TABLE Aliments (
						al_idAliment INT(6) UNSIGNED AUTO_INCREMENT PRIMARY KEY,
						al_nomAliment VARCHAR(30) NOT NULL UNIQUE
					) ;

					CREATE TABLE SuperCategorie (
						spc_idSuperCategorie INT(6) UNSIGNED AUTO_INCREMENT PRIMARY KEY,
						spc_idAliment INT(6) UNSIGNED,
						spc_idAlimentSuperCategorie INT(6) UNSIGNED,
						FOREIGN KEY (spc_idAliment) REFERENCES Aliments(al_idAliment) ON UPDATE CASCADE ON DELETE CASCADE,
						FOREIGN KEY (spc_idAlimentSuperCategorie) REFERENCES Aliments(al_idAliment) ON UPDATE CASCADE ON DELETE CASCADE
					) ;

					CREATE TABLE Ingredients (
						ing_idIngredient INT(6) UNSIGNED AUTO_INCREMENT PRIMARY KEY,
						ing_idRecette INT(6) UNSIGNED,
						ing_idAliment INT(6) UNSIGNED,
						FOREIGN KEY (ing_idAliment) REFERENCES Aliments(al_idAliment) ON UPDATE CASCADE ON DELETE CASCADE,
						FOREIGN KEY (ing_idRecette) REFERENCES Recettes(rec_idRecette) ON UPDATE CASCADE ON DELETE CASCADE
					) ;
					
					CREATE TABLE Utilisateurs (
						uti_idUtilisateur INT(6) UNSIGNED AUTO_INCREMENT PRIMARY KEY,
						uti_pseudo VARCHAR(30) NOT NULL UNIQUE,
						uti_mdp VARCHAR(30) NOT NULL,
						uti_sexe VARCHAR(1),
						uti_prenom VARCHAR(30),
						uti_nom VARCHAR(30),
						uti_naissance DATE,
						uti_email VARCHAR(30),
						uti_telephone VARCHAR(30),
						uti_adresse VARCHAR(100),
						uti_codePostal VARCHAR(30),
						uti_ville VARCHAR(30)
					) ;
					
					CREATE TABLE Favoris (
						fav_idFavoris INT(6) UNSIGNED AUTO_INCREMENT PRIMARY KEY,
						fav_idUtilisateur INT(6) UNSIGNED NOT NULL,
						fav_idRecette INT(6) UNSIGNED NOT NULL,
						FOREIGN KEY (fav_idUtilisateur) REFERENCES Utilisateurs(uti_idUtilisateur) ON UPDATE CASCADE ON DELETE CASCADE,
						FOREIGN KEY (fav_idRecette) REFERENCES Recettes(rec_idRecette) ON UPDATE CASCADE ON DELETE CASCADE
					)';

// Initialisation des tables.
try {
  echo 'INITIALISATION :<br/>';
  // On exécute les requêtes une à une.
  foreach (explode(';', $creation) as $requete) {
    $bdd->prepare($requete)->execute();
  }
  echo '  - La base de données est créée.<br/>';
} catch (Exception $e) {
  die('Erreur : ' . $e->getMessage());
}

// Insertion dans les tables.
echo '<br/>INSERTION :<br/>';

// On inclut le script PHP qui contient les tableaux $Recettes et $Hierarchie.
include('../assets/Donnees.inc.php');

// On vérifie qu'on à bien récupérer $Recettes et $Hierarchie.
if (!empty($Recettes) && !empty($Hierarchie)) {
  // Insertion dans la table Recettes.
  try {
    foreach ($Recettes as $cocktail) {
      $insertionRecettes = 'INSERT INTO Recettes (rec_titre, rec_ingredients, rec_preparation) VALUES (:titre, :ingredients, :preparation);';
      $insertionRecettesRequete = $bdd->prepare($insertionRecettes);
      $insertionRecettesRequete->execute(array(
        'titre' => $cocktail['titre'],
        'ingredients' => $cocktail['ingredients'],
        'preparation' => $cocktail['preparation']
      ));
      // On ferme la requête.
      $insertionRecettesRequete->closeCursor();
    }
  } catch (PDOException $pdoErr) {
    die('Erreur insertion recettes : ' . $pdoErr->getMessage());
  }
  echo '  - Table Recettes remplie.<br/>';

  // Insertion dans la table Aliments.
  try {
    foreach ($Hierarchie as $nomAliment => $aliment) {

      $insertionAliments = 'INSERT INTO Aliments (al_nomAliment) VALUES (:nomAliment);';
      $insertionAlimentsRequete = $bdd->prepare($insertionAliments);
      $insertionAlimentsRequete->execute(array('nomAliment' => $nomAliment));
      // On ferme la requête.
      $insertionAlimentsRequete->closeCursor();
    }
  } catch (PDOException $pdoErr) {
    die('Erreur : ' . $pdoErr->getMessage());
  }
  echo '  - Table Aliments remplie.<br/>';

  // Insertion dans la table SuperCategorie.
  try {
    foreach ($Hierarchie as $nomAliment => $aliment) {
      // On ignore l'aliment "Aliment".
      if (!empty($aliment['super-categorie'])) {
        $insertionSupCat = 'INSERT INTO SuperCategorie (spc_idAliment, spc_idAlimentSuperCategorie)
										VALUES (
										(SELECT al_idAliment
											FROM Aliments
											WHERE al_nomAliment = :nomA),
										(SELECT al_idAliment
											FROM Aliments
											WHERE al_nomAliment = :nomSC));';
        $insertionSupCatRequete = $bdd->prepare($insertionSupCat);

        foreach ($aliment['super-categorie'] as $superCategorie) {
          $insertionSupCatRequete->execute(array('nomA' => $nomAliment, 'nomSC' => $superCategorie));
          // On ferme la requête.
          $insertionSupCatRequete->closeCursor();
        }
      }
    }
  } catch (PDOException $pdoErr) {
    die('Erreur : ' . $pdoErr->getMessage());
  }
  echo '  - Table SuperCategories remplie.<br/>';

  // Insertion dans la table Ingredients.
  try {
    foreach ($Recettes as $cocktail) {
      $insertionConstitution = 'INSERT INTO Ingredients (ing_idRecette, ing_idAliment)
											VALUES (
												(SELECT rec_idRecette
													FROM Recettes
													WHERE rec_titre = :nomRecette),
												(SELECT al_idAliment
													FROM Aliments
													WHERE al_nomAliment = :nomAliment));';
      $insertionConstitutionRequete = $bdd->prepare($insertionConstitution);

      foreach ($cocktail['index'] as $nomIndex) {
        $insertionConstitutionRequete->execute(array('nomRecette' => $cocktail['titre'], 'nomAliment' => $nomIndex));
        // On ferme la requête.
        $insertionConstitutionRequete->closeCursor();
      }
    }
  } catch (PDOException $pdoErr) {
    die('Erreur : ' . $pdoErr->getMessage());
  }
  echo ' - Table Ingrédients remplie.<br/>';
}

?>