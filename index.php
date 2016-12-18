   
<?php
session_start();
require_once 'Settings/init.inc.php';
require_once 'Settings/db.inc.php';
include_once 'Includes/header.inc.php';
include 'Includes/comment.inc.php';

if (isset($_SESSION['login'])) {
    if ($_SESSIONS['login'] = TRUE) { // On vérifie si la connexion a eu lieu
        echo '<div class="alert alert-success" role="alert">
                <strong>You\'re Logged in !</strong>
              </div>';
        //unset($_SESSION['login']);
    } else { // Sinon on affiche une erreur
        echo '<div class="alert alert-danger" role="alert">
                <strong>Login / Password incorrect !</strong>
              </div>';
        unset($_SESSION['login']);
    }
    //header("Location: index.php");
}
if (isset($_GET['p'])) {
    $currentPage = $_GET['p']; // On récupère le numéro de la page indiqué dans l'adresse (livredor.php?page=4)
} else { // La variable n'existe pas, c'est la première fois qu'on charge la page
    $currentPage = 1; // On se met sur la page 1 (par défaut)
    $_SERVER['REQUEST_URI'] = 'index.php?p=1';
}

$articlePerPage = 2;
$start = ($currentPage - 1) * $articlePerPage;

function returnIndex() { //calcul des éléments.
    return $start;
}
//Calculer le nombre d'articles publiés dans la table
$call = $db->prepare('SELECT COUNT(*) AS nArticles FROM articles WHERE published');
$call->bindValue(':published', 1, PDO::PARAM_INT);
$call->execute();
$result = $call->fetch();
$nArticles = $result ['nArticles'];
$pages = ceil($nArticles / $articlePerPage);
//echo '<b>Page :</b>' . $currentPage . '<br><b>index :</b>' . $start . "<br><b>Pages available: </b>" . $nbrpages . "<br><b>Articles available :</b>" . $nArticles;

include 'Includes/menu.inc.php';
?>

<div class="span8">
    <!-- notifications -->

    <!-- contenu -->   

<?php
$sth = $db->query("SELECT id, title, text, date FROM articles LIMIT $start, $articlePerPage");
while ($data = $sth->fetch()) {
    //echo $data['id'].'.jpg';
    echo '<div align="center"><img src="img/' . $data['id'] . '.jpg" height="300" width="250">' . '<br><h2>' . $data['title'] . '</h2>' . $data['text'] . '<br>' . $data['date'] . '<br><a href="article.php?id=' . $data['id'] . '">Modify</a><br><br></div>';
    
    //On affiche un formulaire pour recevoir les comms, l'action de form comporte une fonction que j'ai défini dans comment.inc.php
    echo "<center><form action='".setComments($db)."' method='POST'>
            <input type='text' name='name' required='' value='Your Name'><br>
            <input type='text' name='email' required='' value='Your Email'><br>
            <textarea class='form-control' required='' name='comment' cols='50' rows='2'>Enter your Comment</textarea><br>
            <button type='submit' name='commentSubmit' class='btn btn-medium'>Comment</button>
          </form></center><br><hr><br>";
    
//getComments($db);
    
}
?>
<div class ="pagination">   
    
    <ul>
        <li><a>Page : </a></li>
<?php
//echo $_SERVER['REQUEST_URI'];
for ($i = 1; $i <= $pages; $i++) {
    if ($_SERVER['REQUEST_URI'] == 'index.php?p=' . $i) {
        echo '<li class="active"><a href="index.php?p=' . $i . '">' . $i . '</a></li>';
    } else {
        echo '<li><a href="index.php?p=' . $i . '">' . $i . '</a></li>';
    }
}
?>
    </ul>
</di>
<?php
include 'Includes/footer.inc.php';
?>
        
