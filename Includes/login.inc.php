<?php

include ($_SERVER['DOCUMENT_ROOT'] . 'Settings/db.inc.php');
/*
  Créer un fichier d'include qui s'appelle connexion.inc.php
  Tester la présence du cookie sidet s'assurer qu'il n'est pas vide
  Si condition OK :
  Requûete dans la table d'utilisateurs pour vérifir la correspendance du sid
  RowCount >0 alors créer une variable  $connecte = true

  Si RowCount == 0 : $connecte = false
  -------------------------------------------------
 * if (isset($_COOKIE['sid']) && !empty($_COOKIE['sid']))
 */
$connecte = false;
if (isset($_COOKIE['sid']) && !empty($_COOKIE['sid'])) {
    $sid = $_COOKIE['sid'];
    $sth = $db->prepare("SELECT sid FROM users");
    $sth->execute();
    $count = $sth->rowCount();

    while ($data = $sth->fetch()) {
        if ($count > 0) {
            if ($sid == $data["sid"]) {
                $connecte = true;
            }
        } elseif ($count == 0) {
            $connecte = false;
        }
    }
}
echo $connecte ? 'true' : 'false';
?>
