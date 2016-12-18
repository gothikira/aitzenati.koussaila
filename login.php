<?php
session_start();

include_once 'Includes/header.inc.php';
include_once 'Includes/menu.inc.php';
require_once 'Settings/db.inc.php';
require_once 'Settings/init.inc.php';

/* echo '<h1>Connexion</h1>';
  if ($id!=0) error(ERR_IS_CO); // Pour s'assurer que le visiteur qui arrive sur cette page n'est pas déjà connecté */
//if (isset($_POST['Login'])) {

if (isset($_POST['login'])) {

    $sql = $db->prepare("SELECT * FROM users WHERE email = :email AND mdp = :mdp"); //Verification des champs postés
    $sql->bindValue(':email', $_POST['email'], PDO::PARAM_STR);
    $sql->bindValue(':mdp', $_POST['mdp'], PDO::PARAM_STR);
    $sql->execute();
    $count = $sql->rowCount(); // Retourne le nombre de lignes affectées par la requête SQL

    if ($count > 0) {
        while ($rcv_data = $sql->fetch()) {

            if (($_POST['email'] == $rcv_data['email']) AND ( $_POST['mdp'] == $rcv_data['mdp'])) {
                $sql->closeCursor(); //libère la connexion au serveur, permettant ainsi à d'autres requêtes SQL d'être exécutées
                #echo 'Connexion established !';
                #$sid = md5($tab[0] ['email'] . time());
                $sth = md5($_POST['email'] . time());
                $sth = $db->prepare("UPDATE users SET sid=:sid WHERE email=:email"); // Une requête de mise à jour pour introduire le sid
                $sth->bindValue(':email',$_POST['email'], PDO::PARAM_STR);
                $sth->bindValue(':sid',$sid, PDO::PARAM_STR);
                $sth->execute();

                setcookie('sid', $sid, time() + 30, NUL, NULL, FALSE, TRUE);  // Contruire un cookie en activant le mode httpOnly et en laiisant les autres param désactivés.

                if (!isset($_COOKIE['sid'])) {
                    echo "Cookie Named '" . 'sid' . "' is not set !";
                } else {
                    echo "Cookie '" . 'sid' . "' is set!<br>";
                    echo "Value is: " . $_COOKIE['sid'];
                }

                $_SESSION['login'] = TRUE;
                $sth->closeCursor();
                header("Location:index.php");
            }
        }
    } else {
        $_SESSION['login'] = FALSE;
        //header("Location: login.php");
    }
}
?>
<div class="span8">
    <!-- notifications -->

    <!-- contenu -->   

    <form method="POST" action="login.php">

        <center><legend><h1>Sign In</h1></legend></center><br/>
        <div class="form-group">
            <center><label class="col-lg-2 control-label">E-mail</label></center>
            <div class="col-lg-10">
                <center><input type="text" class="form-control" name="email" placeholder="Enter your e-mail"></center>
            </div>
        </div><br/>

        <div class="form-group">
            <center><label class="col-lg-2 control-label">Password</label></center>
            <div class="col-lg-10">
                <center><input type="password" class="form-control" name="mdp" placeholder="Enter your password"></center>
            </div>
        </div>

        <br/><center><button type="submit" name="login" class="btn btn-primary">Login</button></center>
    </form>


</div>
</div>

<?php
include_once 'Includes/footer.inc.php';
?>  
