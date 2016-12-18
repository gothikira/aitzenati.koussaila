
<?php
session_start();

require 'Settings/db.inc.php';

if (isset($_POST['add'])) {
    //print_r($_FILES);
    //exit();
    $date_add = date("Y-m-d"); // Préparation de la date
    $_POST['date_add'] = $date_add;

    //On vérifie si la case Publier est cochée avec une condition
    if (isset($_POST['published'])) {
        $_POST["published"] = 1;
    } else {
        $_POST["published"] = 0;
    } //CONDITION SIMPLE
    // print_r($_POST);
    //$_POST["published"] = isset($_POST["published"]) ? 1 : 0; //Condition ternaire
    if ($_FILES["image"]["error"] == 0) {

        //On insert les infos entrées par le user dans notre bdd
        $sth = $db->prepare("INSERT INTO articles (title, text, date, published) VALUES (:title, :text, :date, :published)");
        //On bind les valeurs contenues dans la bdd avec les valeurs entrées par le user
        $sth->bindValue(':title', $_POST['title'], PDO::PARAM_STR);
        $sth->bindValue(':text', $_POST['text'], PDO::PARAM_STR);
        $sth->bindValue(':date', $_POST['date_add'], PDO::PARAM_STR);
        $sth->bindValue(':published', $_POST['published'], PDO::PARAM_INT);
        $sth->execute();
        $id = $db->lastInsertId();
        //echo '<br><b>' . $id . '</b><br/>';
        echo '<h2>Image Upoladed !<h2>';
        //On déplace l'image téléchargée vers le dossier img en lui attribuant un id unique
        move_uploaded_file($_FILES['image']['tmp_name'], dirname(__FILE__) . "/img/$id.jpg");
        $_SESSION['add_article'] = TRUE;

        header("Location: article.php");
        $sth->closeCursor();
    } else {
        echo '<h2>Image Error<h2>';
        exit();
    }
} else {
    include 'Includes/header.inc.php';
    if (isset($_SESSION['add_article'])) {
        //header("Location: article.php");
        echo '<div class="alert alert-success" role="alert">
    <strong>Great !</strong> Your article has been added
</div>';
        unset($_SESSION['add_article']);
    } else {
        if (isset($_GET['id'])) {
            $service = $db->prepare("SELECT id, title, text, date FROM articles WHERE id=:id");
            $service->bindValue(':id', $_GET['id'], PDO::PARAM_STR);
            $service->execute();
        }
    }
    ?>

    <form action="article.php" method="post" enctype="multipart/form-data" id="form_article" name="form_article">

        <?php
        $date_add = date("Y-m-d");
        if (isset($_GET['id'])) {
            while ($rcv_data = $service->fetch()) {

                // echo '<img src="img/'. $rcv_data['id'].'.jpg" height="300" width="250">' . '<br>' . $rcv_data['title'] . '<br>' . $rcv_data['text'] . '<br>' . $rcv_data['date'] . '<br><a href="article.php?id='. $rcv_data['id'] .'">Modify</a><br><br>';
                echo '
                        <div class="clearfix" >
                            <label for="title">Title</label>
                            <div class="input"><input type="text" name="title" id="title" value="' . $rcv_data["title"] . '"></div>
                        </div>
                        
                        <div class="clearfix" >
                            <label for="texte">Texte</label>
                            <div class="input"><input type="text" name="text" id="text" value="' . $rcv_data["text"] . '"></div>
                        </div>
    
                        <div class="clearfix" >
                            <label for="image">Image</label>
                            <div class="input"><input type="file" name="image" id="image" value=""></div>
                        </div>
    
                        <div class="clearfix" >
                            <label for="publie">Publish</label>
                            <div class="input"><input type="checkbox" name="published" id="published"></div>
                        </div>
                            <br/><input type="submit" name="modify" id="modify" value="Modify" class="btn btn-large btn-primary">
                            <input type="hidden" name="date" id ="date" value="' . $date_add . '">
                            <input type="hidden" name="ide" id ="ide" value="' . $_GET["id"] . '">  
                        <div class="form-actions" >
                             ';
            }
            $service->closeCursor();
        } else {
            echo '      <div class="clearfix" >
                               <label for="title">Title</label>
                               <div class="input"><input type="text" name="title" id="title" value=""></div>
                        </div>
                        
                        <div class="clearfix" >
                            <label for="text">Text</label>
                             <div class="input"><input type="text" name="text" id="text" value=""></div>
                        </div>
    
                        <div class="clearfix" >
                               <label for="image">Image</label>
                               <div class="input"><input type="file" name="image" id="image" value=""></div>
                        </div>
    
                        <div class="clearfix" >
                               <label for="publie">Publish</label>
                               <div class="input"><input type="checkbox" name="published" id="published"></div>
                        </div>
                             <br/><input type="submit" name="add" id="add" value="Add" class="btn btn-large btn-primary">    
                        <div class="form-actions" >
                             ';
        }
        ?>


        <?php
        /*if ($_SERVER['REQUEST_URI'] == "article.php") {
            echo '<input type="submit" name="add" id="add" value="Save" class="btn btn-large btn-primary ">';
        } else {
            echo '<input type="submit" name="add" id="add" value="Save" class="btn btn-large btn-primary ">';
        }*/
        //Condition pour modification d'article
        if (isset($_POST['modify'])) {

            if (isset($_POST['published'])) {
                $_POST["published"] = 1;
            } else {
                $_POST["published"] = 0;
            }
            // print_r($_POST);
            var_dump($_POST['title']);

            $id = $_POST['ide'];
            $sth = $db->prepare("UPDATE articles SET title =:title, text=:text, date=:date, published=:published WHERE id=:id");
            $sth->bindValue(':title', $_POST['title'], PDO::PARAM_STR);
            $sth->bindValue(':text', $_POST['text'], PDO::PARAM_STR);
            $sth->bindValue(':date', $_POST['date'], PDO::PARAM_STR);
            $sth->bindValue(':published', $_POST['published'], PDO::PARAM_INT);
            $sth->bindValue(':id', $id, PDO::PARAM_INT);
            $sth->execute();
            $base_directory = 'img/'; //Répertoire des images uploadées
            if (unlink($base_directory . $id . '.jpg')){
                //echo "File Deleted !";
                move_uploaded_file($_FILES['image']['tmp_name'], dirname(__FILE__) . "/img/$id.jpg");
                header("Location: article.php");

                $sth->closeCursor();
            }
        }
        ?>
    </div>
    </form>   
    <?php
    include 'Includes/menu.inc.php';
    include 'Includes/footer.inc.php';
}
?>