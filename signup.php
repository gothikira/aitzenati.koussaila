<?php
session_start();
include_once 'Includes/header.inc.php';
include_once 'Includes/menu.inc.php';
require_once 'Settings/db.inc.php';
//require_once 'Settings/init.inc.php';
require 'debug.php';


if (!empty($_POST)){
    
    $errors = array(); // Création d'un tableau contenant les erreurs potentielles
    
        if(empty($_POST['nom'])){
           $errors ['l_name'] = "Your last name field is empty !";  
        }
        
        if(empty($_POST['prenom'])){
           $errors ['f_name'] = "Your first name field is empty !";  
        }
        
        if(empty($_POST['email']) || !filter_var($_POST['email'], FILTER_VALIDATE_EMAIL)){ // Pour filtrer les emails et n'accepter que le bon format
           $errors ['email'] = "Your email field is empty !";  
        }else{
            $req = $db->prepare("SELECT id FROM users WHERE email = ?");
            $req->execute([$_POST['email']]);
            $user = $req->fetch(); // Vérification de l'obtention de résultats avec la méthode 'fetch'
            
            if($user){ // Vérification de l'existence de l'email dans la bdd, si TRUE affiche erreur
                $errors['email'] = 'This email address already exists !';
            }
        }
        
        if(empty($_POST['mdp']) || $_POST['mdp'] != $_POST['mdp_confirm']){
           $errors ['pwd'] = "Your should enter a valid password !";  
        }
                       
        //debug($errors);
        
        if(empty($errors)){ // Si y a pas d'erreurs je me connecte à ma bdd et je prépare ma requête
            
        $req = $db->prepare("INSERT INTO users SET nom = ?, prenom = ?, email = ?, mdp = ?");
        $mdp = password_hash($_POST['mdp'], PASSWORD_BCRYPT); //Pour hasher le mot de passe
        $req->execute([$_POST['nom'], $_POST['prenom'], $_POST['email'], $mdp]); // execute la requête préparée
        die("Thank you for creating an account on our site<br/><br/>We now invite you to login !");
                
        }       
            
                
    /*$sql = $db->prepare("INSERT INTO users WHERE nom = :nom AND prenom = :prenom AND email = :email AND mdp = :mdp");
    $sql->bindValue(':nom', $_POST['nom'], PDO::PARAM_STR);
    $sql->bindValue(':prenom', $_POST['prenom'], PDO::PARAM_STR);
    $sql->bindValue(':email', $_POST['email'], PDO::PARAM_STR);
    $sql->bindValue(':mdp', $_POST['mdp'], PDO::PARAM_STR);
    //$sql->execute();
    
    $sth = $db->query($sql);
    header("Location: index.php");*/
}

?>
<!--Une condition entre des balises php pour vérifier que le formulaire est rempli correctement -->
<?php if(!empty($errors)): ?>

<div class="alert alert-danger">
    <p>The form has not been filled appropriately !</p>
    <ul>
        <?php foreach($errors as $error): ?>
            <li><?= $error; ?></li> <!--On affiche les erreurs avec un foreach -->
        <?php endforeach; ?>
    </ul>
</div>

<?php endif; ?>

<div class="span8">
    <!-- notifications -->

    <!-- contenu -->   

    <center><form method="POST" action="signup.php">

        <center><legend><h1>Sign Up</h1></legend></center><br/>

        <div class="form-group">
            <div class="col-lg-10">
                <input type="text" class="form-control" name="nom" required="" placeholder="Enter your last name">
            </div>
        </div><br/>

        <div class="form-group">
            <div class="col-lg-10">
                <input type="text" class="form-control" name="prenom" required="" placeholder="Enter your first name">
            </div>
        </div><br/>

        <div class="form-group">
            <div class="col-lg-10">
                <input type="email" class="form-control" name="email" required="" placeholder="Enter your e-mail ">
            </div>
        </div><br/>

        <div class="form-group">
            <div class="col-lg-10">
                <input type="password" class="form-control" name="mdp" required="" placeholder="Enter your password">
            </div>
        </div><br/>
        
        <div class="form-group">
            <div class="col-lg-10">
                <input type="password" class="form-control" name="mdp_confirm" required="" placeholder="Re-enter your password">
            </div>
        </div><br/>

        <br/><button type="submit" name="signup" class="btn btn-primary">Sign up</button>
    </form></center>


</div>
</div>

<?php
include_once 'Includes/footer.inc.php';
?>  