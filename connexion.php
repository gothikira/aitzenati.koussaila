<?php
session_start();

include_once 'Includes/header.inc.php';
include_once 'Includes/menu.inc.php';
require_once 'Settings/db.inc.php';
require_once 'Settings/init.inc.php';

$email = $_POST['email'];
$pass = $_POST['mdp'];

$sql = "SELECT * FROM users WHERE email='$email' AND pass='$mdp'";
$result = $db->query($sql);

if(!$row = $result->fetch_assoc()){
    echo 'Your Login/Password is incorrect !';
}else{
    echo 'Your are logged in';
}

?>

<form method="POST" action="login.php">

    <center><legend><h1>Sign In</h1></legend></center>
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

<br/><br/><center><button type="submit" name="login" class="btn btn-primary">Login</button></center>
</form>


    </div>

    <?php
    include_once 'Includes/footer.inc.php';

?>  
