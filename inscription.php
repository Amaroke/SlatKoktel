<?php

echo 'INITIALISATION :<br/>';
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

/*
echo 'VERIFICATION :<br/>';
echo $uti_pseudo;
echo "<br>".$uti_email;
echo "<br>".$uti_prenom;
echo $uti_mdp;
echo $uti_mdp2;
exit;
*/
if(strlen($uti_pseudo) > 0 && strlen($uti_email) > 0 && strlen($uti_mdp) > 0 && strlen($uti_mdp2) > 0 && $uti_mdp == $uti_mdp2){
    //on fait la connexion à la base de données 
    /* Envoi des requêtes dans la base de données */
    echo 'TRY :<br/>';
    try
    {
        echo 'TENTATIVE DE CONNEXION BDD :<br/>';
        $bdd = new PDO('mysql:host=localhost;dbname=SlatKoktel;charset=utf8;charset=utf8', 'root', 'root1');
        
        echo 'LOGIN EXISTE :<br/>';
        //tester si le login existe ou non
        $test_login = $bdd->prepare("SELECT uti_pseudo FROM Utilisateurs WHERE uti_pseudo = '".$login."' "); 
        
        $test_login->execute(); //execute
        $nb_login = $test_login->rowCount(); //nombre de resultats

        echo 'MAIL EXISTE :<br/>';
        //tester si le login existe ou non
        $test_mail = $bdd->prepare("SELECT uti_email FROM Utilisateurs WHERE uti_email = '".$uti_email."' "); 
        
        $test_mail->execute(); //execute
        $nb_mail = $test_mail->rowCount(); //nombre de resultats
        
        echo 'INSERTION :<br/>';
        /*
        echo $nb_login;
        echo $nb_mail; 
        */
        if($nb_login == 0 && $nb_mail == 0){
            echo 'RENTRE DANS LE IF DE INSERTION :<br/>';
            $insertionUser = 'INSERT INTO Utilisateurs(uti_pseudo, uti_mdp, uti_sexe, uti_prenom, uti_nom, uti_age, uti_email, uti_telephone, uti_adresse, uti_codePostal, uti_ville, uti_dateCreation) 
            VALUES (:uti_pseudo, :uti_mdp, :uti_sexe, :uti_prenom, :uti_nom, :uti_age, :uti_email, :uti_tel, :uti_adresse, :uti_codePostal, :uti_ville, NOW());'; 
            echo 'APRES REQUETE :<br/>';
            $insertionUserRequete = $bdd->prepare($insertionUser);  //le programme s'arrete ici, je ne sais pas pq 

            echo 'APRES EXECUTION REQUETES :<br/>';
            //insère les données dans la bdd
            $insertionData->execute([
                'uti_pseudo'=> $uti_pseudo,
                'uti_mdp'=>$uti_mdp,
                'uti_email' =>$uti_email,
                'uti_age' =>$uti_age,
                'uti_prenom' =>$uti_prenom,
                'uti_nom' =>$uti_nom,
                'uti_telephone' =>$uti_telephone,
                'uti_adresse' =>$uti_adresse,
                'uti_codePostal' =>$uti_codePostal,
                'uti_ville' =>$uti_ville,
                'uti_dateCreation'=>NULL, //pour le moment 
            ]);

            echo 'APRES INSERTION DES DATAS :<br/>';

        }
        
        $test_login->closeCursor();

        echo 'REDIRECTION :<br/>';
        header('index.html'); //une fois insérer on revient à la page de départ
    } catch(PDOException $e) {
        die('Erreur : ' . $e->getMessage());
    }     
} else {
    echo "<script> alert('Formulaire incorrect');history.back();</script>"; //script incorrect / history.go permet de revenir à la page 
}


?>