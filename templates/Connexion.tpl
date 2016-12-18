

        {if isset($connexion) AND $connexion == FALSE}
            <div class="alert alert-danger" role="alert">
                <strong>Le login / mot de passe est incorrecte !</strong>
            </div>
        {/if}
        
  

    

<form action="connexion.php" method="post" enctype="multipart/form-data" id="form_connexion" name="form_article">
                        <div class="clearfix" >
                        <label for="email">E-mail</label>
                             <div class="input"><input type="email" name="email" id="email" value=""></div>
                        </div>
                        
                        <div class="clearfix" >
                            <label for="mdp">Mot de passe</label>
                             <div class="input"><input type="text" name="mdp" id="mdp" value=""></div>
                        </div> 
    
                        <div class="form-actions" >
                            <input type="submit" name="connexion" id="connexion" value="Connexion" class="btn btn-large btn-primary ">
                        </div>
</form>