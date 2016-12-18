<?php
require_once 'Settings/db.inc.php';

function setComments($db){ // Fonction permettant de vérifier la soumission du commentaire et de récupérer les infos et les insérer dans la bdd
    if(isset($_POST['commentSubmit'])){
        $name = $_POST['name']; // Pour récupérer le nom
        $email = $_POST['email']; // Pour récupérer l'email
        $comment = $_POST['comment']; //Pour récupérer le commentaire
        
        $sql = $db->query("INSERT INTO comments (name, email, comment) VALUES('$name', '$email', '$comment')");
        
    }
}

/*function getComments($db){ //Fonction pour afficher les comms
    $sql = "SELECT * FROM comments";
    $result = $db->query($sql);
    
    while($row = $result->fetch_assoc()){ // Une boucle while pour avoir tous les comms disponibles
        echo '<div>';
            echo $row['name']."<br>";
            echo $row['email']."<br>";
            echo $row['comment'];
        echo '</div>';
        
    }
    
}*/

