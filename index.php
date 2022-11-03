
<?php
session_start();

  // cette fonction permet d'inclure un fichier une seule fois
  require_once ('connect.php');

  $reqsql="select b.*, a.lastname from book b left join author a on a.id=b.author_id";
  
  $query = $db->prepare($reqsql);
  $query->execute();
  $books = $query->fetchAll(PDO::FETCH_ASSOC);
  require_once ('deconnect.php');
   
  // var_dump($books);    pour vérifier afficher les données
  // die();        pour stoper le script

?>

<!doctype html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>CRUD</title>
    
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.2/dist/css/bootstrap.min.css" rel="stylesheet">

  </head>
  <body>
    
        <div class="container">
            <button class="btn btn-primary my-5"><a href="formulaire.php" class="text-light">Ajouter un livre</a>
            </button>

          <?php
          if(!empty($_SESSION['erreur'])){
              echo '<div class="alert alert-danger" role="alert">
                '. $_SESSION['erreur'].'
                  </div>';
              $_SESSION['erreur'] = "";
          }

          ?>
          <?php
          if(!empty($_SESSION['message'])){
              echo '<div class="alert alert-success" role="alert">
                '. $_SESSION['message'].'
                  </div>';
              $_SESSION['message'] = "";
          }

          ?>
          <h1>Liste des livres</h1>
          <table class="table">
            <thead>
                <tr>
                <th scope="col">Id</th>
                <th scope="col">Titre</th>
                <th scope="col">Date publication</th>
                <th scope="col">Nom auteur</th>
                <th scope="col">Action</th>
                </tr>
            </thead>
          <tbody>

          <?php
      
              foreach ($books as $book) {
                ?>
                <tr>
                  <td><?= $book['id'] ?></td>
                  <td><?= $book['title'] ?></td>
                  <td><?= $book['date_publi'] ?></td>
                  <td><?= $book['lastname'] ?></td>
                  <td><a href="lister.php?id=<?= $book['id'] ?>">Voir</a></td>
                  <td><a href="edit.php?id=<?= $book['id'] ?>">Modifier</a></td>
                  <td><a href="delet.php?id=<?= $book['id'] ?>">Supprimer</a></td>
                </tr>
               <?php 
              }
          ?>
          </tbody>
          </table>
            
        </div>

  </body>
</html>


