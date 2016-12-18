<div class="span8">
    
    {if (isset($_SESSION['login']) AND $_SESSION['login'] == FALSE)}
    
    {* On reprend la variable statut_connexion qu'on avait assigné à partir de la variable $_SESSION *}
    {if isset($login) AND $login == FALSE}
        
        <div class="alert alert-error"> role="alert">
            <strong>Error !</strong> Login / password incorrect(s) </div>
    {/if}    
            unset($_SESSION['login']);
    {/if}

<form method="post" action="connexion.php" enctype="multipart/form-data" id="form_connexion" name="form_connexion">

    <center><legend><h1>Sign In</h1></legend></center>

    <div class="form-group">
      <center><label class="col-lg-2 control-label">E-mail</label></center>
      <div class="col-lg-10">
        <center><input type="text" class="form-control" name="email" placeholder="E-mail"></center>
      </div>
    </div><br/>

    <div class="form-group">
      <center><label class="col-lg-2 control-label">Password</label></center>
      <div class="col-lg-10">
        <center><input type="password" class="form-control" name="password" placeholder="Mot de passe"></center>
      </div>
    </div>

<br/><br/><center><button type="submit" name="submit" class="btn btn-primary">Login</button></center>
</form>