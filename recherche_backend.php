<?php

include('config.php');
// echo("yyyy");
$conn = new mysqli($servername, $username, $password, $dbname);
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
} 
mysqli_set_charset($conn,"utf8");
 
// Check connection
if($conn === false){
    die("ERROR: Could not connect. " . mysqli_connect_error());
}

if(isset($_REQUEST["term"])){ //$_REQUEST -> AJAX permettant d'obtenir les données en temps reel (pas besoin de recargement de page)
    // Prepare a select statement
    $sql = "SELECT al_nomAliment FROM Aliments WHERE al_nomAliment LIKE ?
            order by al_nomAliment";
    if($stmt = mysqli_prepare($conn, $sql)){
        
        $param_term = $_REQUEST["term"] .'%';
        // Bind variables to the prepared statement as parameters
        mysqli_stmt_bind_param($stmt, "s", $param_term);
                
        // Attempt to execute the prepared statement
        if(mysqli_stmt_execute($stmt)){
            $result = mysqli_stmt_get_result($stmt);
            
            // Check number of rows in the result set
            if(mysqli_num_rows($result) > 0){
                // Fetch result rows as an associative array
                while($row = mysqli_fetch_array($result, MYSQLI_ASSOC)){
                    echo "<p>" . $row["al_nomAliment"] ."</p>";
                }
            } else{
                echo "<p>Aucun résultat pour: <b>".$_REQUEST["term"]."</b> .</p>";
            }
        }
    }
     
    // Close statement
    mysqli_stmt_close($stmt);
}
 
// close connection
mysqli_close($conn);
?>