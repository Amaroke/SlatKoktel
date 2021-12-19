<?php

//echo 'INITIALISATION :<br/>';
/*
* Ici on récupère les informations du form de la page signup.html
*/
$uti_pseudo = htmlspecialchars($_POST["uti_pseudo"]);
$uti_email = htmlspecialchars($_POST["uti_email"]);
$uti_prenom = htmlspecialchars($_POST["uti_prenom"]);
$uti_nom = htmlspecialchars($_POST["uti_nom"]);
$uti_age = htmlspecialchars($_POST["uti_age"]);
$uti_sexe = htmlspecialchars($_POST["uti_sexe"]);
$uti_telephone = htmlspecialchars($_POST["uti_telephone"]);
$uti_adresse = htmlspecialchars($_POST["uti_adresse"]);
$uti_ville = htmlspecialchars($_POST["uti_ville"]);
$uti_codePostal = htmlspecialchars($_POST["uti_codePostal"]);
$uti_mdp = htmlspecialchars($_POST["uti_mdp"]);
$uti_mdp2 = htmlspecialchars($_POST["uti_mdp2"]);
$mtn = date("Y-m-d");

/*
echo 'VERIFICATION :<br/>';
echo $uti_pseudo;
echo "<br>".$uti_email;
echo "<br>".$uti_prenom;
echo "<br>".$uti_mdp;
echo "<br>".$uti_mdp2;
echo "<br>".$uti_age;
echo "<br>".$uti_sexe;
echo "<br>".$uti_telephone;
echo "<br>".$uti_adresse;
echo "<br>".$uti_ville;
echo "<br>".$uti_codePostal;
echo "<br>".$mtn;
echo "<br>";
echo "<br>";
*/
if(strlen($uti_pseudo) > 0 && strlen($uti_email) > 0 && strlen($uti_mdp) > 0 && strlen($uti_mdp2) > 0 && $uti_mdp == $uti_mdp2){
    //on fait la connexion à la base de données 
    /* Envoi des requêtes dans la base de données */
    //echo 'TRY :<br/>';
    try
    {
        //echo 'TENTATIVE DE CONNEXION BDD :<br/>';
        $bdd = new PDO('mysql:host=localhost;dbname=SlatKoktel;charset=utf8;', 'root', 'root1');
        
        //echo 'LOGIN EXISTE :<br/>';
        //tester si le login existe ou non
        $test_login = $bdd->prepare("SELECT uti_pseudo FROM Utilisateurs WHERE uti_pseudo = '".$uti_pseudo."' "); 
        
        $test_login->execute(); //execute
        $nb_login = $test_login->rowCount(); //nombre de resultats

        //echo 'nb_login :'.$nb_login.'<br/>';
        //echo 'MAIL EXISTE :<br/>';
        //tester si le login existe ou non
        $test_mail = $bdd->prepare("SELECT uti_email FROM Utilisateurs WHERE uti_email = '".$uti_email."' "); 
        
        $test_mail->execute(); //execute
        $nb_mail = $test_mail->rowCount(); //nombre de resultats
        
        //echo 'INSERTION :<br/>';
        /*
        echo $nb_login;
        echo $nb_mail; 
        */
        if($nb_login == 0 && $nb_mail == 0){
            //echo 'RENTRE DANS LE IF DE INSERTION :<br/>';
            // $insertionUser = 'INSERT INTO Utilisateurs(uti_pseudo) 
            // VALUES(:uti_pseudo);'; 
            $insertionUser = 'INSERT INTO Utilisateurs(uti_pseudo, uti_mdp, uti_sexe, uti_prenom, 
            uti_nom, uti_age, uti_email, uti_telephone, uti_adresse, uti_codePostal, uti_ville, uti_dateCreation) 
            VALUES (:uti_pseudo, :uti_mdp, :uti_sexe, :uti_prenom, 
            :uti_nom, :uti_age, :uti_email, :uti_telephone, :uti_adresse, :uti_codePostal, :uti_ville, :mtn);'; 
            //echo 'APRES REQUETE :<br/>';
            $insertionUserRequete = $bdd->prepare($insertionUser);  

            //echo 'APRES EXECUTION:<br/>';
            //insère les données dans la bdd

            $stmt = $bdd->prepare($insertionUser); 
            $stmt -> bindParam(':uti_pseudo',$uti_pseudo);
            $stmt -> bindParam(':uti_mdp',$uti_mdp);
            $stmt -> bindParam(':uti_sexe',$uti_sexe);
            $stmt -> bindParam(':uti_prenom',$uti_prenom);
            $stmt -> bindParam(':uti_nom',$uti_nom);
            $stmt -> bindParam(':uti_age',$uti_age);
            $stmt -> bindParam(':uti_email',$uti_email);
            $stmt -> bindParam(':uti_telephone',$uti_telephone);
            $stmt -> bindParam(':uti_adresse',$uti_adresse);
            $stmt -> bindParam(':uti_codePostal',$uti_codePostal);
            $stmt -> bindParam(':uti_ville',$uti_ville);
            $stmt -> bindParam(':mtn',$mtn);
            $stmt -> execute();

            header('Location: index.html'); //reviens au menu




            //echo 'APRES INSERTION DES DATAS :<br/>';

        }
        
        $test_login->closeCursor();

        //echo 'REDIRECTION :<br/>';
    } catch(PDOException $e) {
        die('Erreur : ' . $e->getMessage());
    }     
} else {
    echo "<script> alert('Formulaire incorrect');history.back();</script>"; //script incorrect / history.go permet de revenir à la page 
}


?>