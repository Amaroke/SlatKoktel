<?php
include("../Donnees.inc.php");

define( 'DB_NAME', 'coming_soon' );
$username = 'root';
$pwd = '';
$db = 'SlatKoktel';

// création de la requête sql
// on teste avant si elle existe ou non (par sécurité)
$sql = "CREATE DATABASE IF NOT EXISTS $db;
        ALTER DATABASE $db DEFAULT CHARACTER SET utf8 COLLATE utf8_general_ci;
        USE $db;
        CREATE TABLE Utilisateur (
          uti_nom VARCHAR(100) DEFAULT NULL,
          uti_prenom VARCHAR(100) DEFAULT NULL,
          uti_login VARCHAR(100) NOT NULL,
          uti_mdp CHAR(40) NOT NULL,
          uti_sexe VARCHAR(1) DEFAULT NULL,
          uti_adresse VARCHAR(100) DEFAULT NULL,
          uti_postal INT(5) DEFAULT NULL,
          uti_ville VARCHAR(100) DEFAULT NULL,
          uti_noTelephone CHAR(10) DEFAULT NULL,
          PRIMARY KEY (uti_login)
        );

        CREATE TABLE Recettes (
          rec_nom VARCHAR(100),
          rec_ingredients VARCHAR(200),
          rec_preparation VARCHAR(200),
          PRIMARY KEY (rec_nom)
        );

        CREATE TABLE Ingredients (
          ing_nomIngredient VARCHAR(100),
          PRIMARY KEY (ing_nomIngredient)
        );

        CREATE TABLE Liaison (
          lia_nomIngredient VARCHAR(100),
          lia_nomRecette VARCHAR(100),
          PRIMARY KEY (lia_nomIngredient, lia_nomRecette),
          CONSTRAINT FK_LiaisonIngredient FOREIGN KEY (lia_nomIngredient) REFERENCES Ingredients(ing_nomIngredient),
          CONSTRAINT FK_LiaisonRecette FOREIGN KEY (lia_nomRecette) REFERENCES Recettes(rec_nom)
        );

        CREATE TABLE SuperCategorie (
          spc_nom VARCHAR(100),
          spc_nomSuper VARCHAR(100),
          PRIMARY KEY (spc_nom, spc_nomSuper),
          CONSTRAINT FK_SuperCategorieNomCategorie FOREIGN KEY (spc_nom) REFERENCES Ingredients(ing_nomIngredient),
          CONSTRAINT FK_SuperCategorieNomSuperCategorie FOREIGN KEY (spc_nomSuper) REFERENCES Ingredients(ing_nomIngredient)
        );

        CREATE TABLE Panier (
          pan_utilisateur VARCHAR(100),
          pan_nomRecette VARCHAR(100),
          PRIMARY KEY (pan_utilisateur, pan_nomRecette),
          CONSTRAINT FK_PanierUtilisateur FOREIGN KEY (pan_utilisateur) REFERENCES Utilisateur(uti_login),
          CONSTRAINT FK_PanierRecette FOREIGN KEY (pan_nomRecette) REFERENCES Recettes(rec_nom)
        )";

try{
  $bdd = new PDO('mysql:host=localhost;charset=utf8', 'root', 'root');
}catch (Exception $e) {
  die('Erreur : ' . $e->getMessage());
}

foreach (explode(';',$sql) as $requete) {
  $bdd->exec($requete);
}
/*Remplissage de la table Recettes*/
$stmt = $bdd->prepare("INSERT INTO Recettes (rec_nom, rec_ingredients, rec_preparation) VALUES (:nom, :ingredients, :preparation)");
$stmt->bindParam(':nom', $nom);
$stmt->bindParam(':ingredients', $ingredients);
$stmt->bindParam(':preparation', $preparation);

foreach ($Recettes as $titre) {
  $nom = array_values($titre)[0];
  $ingredients = array_values($titre)[1];
  $preparation = array_values($titre)[2];
  $stmt->execute();
  // print array 
}

/*Remplissage de la table Ingredients*/
$stmt = $bdd->prepare("INSERT INTO Ingredients (ing_nomIngredient) VALUES (:nom)");
$stmt->bindParam(':nom', $nom);
foreach ($Hierarchie as $key => $aliment) {
    $nom = $key;
    $stmt->execute();
}

/*Remplissage de la table Liaison*/
$stmt = $bdd->prepare("INSERT INTO Liaison (lia_nomIngredient, lia_nomRecette) VALUES (:nomIng, :nomRec)");
$stmt->bindParam(':nomIng', $nomIng);
$stmt->bindParam(':nomRec', $nomRec);
foreach ($Recettes as $titre){
    $nomRec = array_values($titre)[0];
    foreach ($titre as $key => $value ){
        if(is_array($value)) {
            foreach ($value as $ing){
                $nomIng = $ing;
                $stmt->execute();
            }
        }
    }
}

/*Remplissage de la table SuperCategorie*/
$stmt = $bdd->prepare("INSERT INTO SuperCategorie (spc_nom, spc_nomSuper) VALUES (:nom, :nomSuper)");
$stmt->bindParam(':nom', $nom);
$stmt->bindParam(':nomSuper', $nomSuper);
foreach ($Hierarchie as $aliment => $tab){
    if(array_key_exists('super-categorie', $tab)){
        foreach ($tab['super-categorie'] as $super){
            $nom = $aliment;
            $nomSuper = $super;
            $stmt->execute();
        }
    }
}


?>
