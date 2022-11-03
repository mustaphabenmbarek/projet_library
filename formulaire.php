<?php
session_start();
require_once ('connect.php');

$reqsql = "SELECT * FROM author";
//$authors = $db->query($reqsql);
//$reqsql="select b.*, a.lastname from book b left join author a on a.id=b.author_id";
$query = $db->prepare($reqsql);
$query->execute();
$authors = $query->fetchAll(PDO::FETCH_ASSOC);
//require_once ('deconnect.php'); 

?>

<!--// ajouter la partie entete html -->

<!doctype html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>CRUD creat</title>
    
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.2/dist/css/bootstrap.min.css" rel="stylesheet">

  </head>
    <body>

        <div class="container my-5">

            <?php
            if(!empty($_SESSION['erreur'])){
              echo '<div class="alert alert-danger" role="alert">
                '. $_SESSION['erreur'].'
                  </div>';
              $_SESSION['erreur'] = "";
            }

            ?>

    <h1>AJOUT UN LIVRE</h1>
    <form action="addbook.php" method="POST">

        <div class="form-group my-3">
            
            <label for="title">Titre livre</label>
            <input type="text" class="form-control" id="title" name="title" autocomplete="off">
        </div>

        <div class="form-group my-3">
            <label for='date_publi'>Date publication</label>
            <input type="date" class="form-control" id="date_publi" name="date_publi">
         </div>

         <div class="form-group my-3">
            <select name="author_id">
            <?php
                foreach ($authors as $author) {
                    echo '<option value="' . $author['id'] . '">'. $author['firstname'].' '. $author['lastname'] . '</option>';
            
                }
            ?>
            </select>
        </div>
        <div class="form-group my-3">
            <button type="submit" class="btn btn-primary my-3" name="submit">Ajouter un livre</button>
            <a href="index.php" class="btn btn-danger">Retour</a>
        </div>
    </form> 

    
  </div>
   
</body>
</html>
