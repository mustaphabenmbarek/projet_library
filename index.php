
<?php
session_start();

  // 
  require_once ('connect.php');

  $reqsql="select b.*, a.lastname from book b left join author a on a.id=b.author_id WHERE 1";
  
  if (!empty($_POST)) {
    if (!empty($_POST['title'])) {
      $reqsql .= " AND b.title LIKE :title";
    }

    if (!empty($_POST['author_id'])) {
      $reqsql .= " AND b.author_id = :author_id";
    }
  }

  $query = $db->prepare($reqsql);
  
  if (!empty($_POST)) {
    if (!empty($_POST['author_id'])) {
      $query->bindValue(':author_id', $_POST['author_id'], PDO::PARAM_INT);
    }

    if (!empty($_POST['title'])) {
      $query->bindValue(':title', '%'.$_POST['title'].'%', PDO::PARAM_STR);
    }
  }

  $query->execute();
  $books = $query->fetchAll(PDO::FETCH_ASSOC);

  $authorsSql = "SELECT * FROM  author";
  $authors = $db->query($authorsSql)->fetchAll();

  
  require_once ('deconnect.php');

  //var_dump($books);    //pour vérifier afficher les données
  //die();              //pour stoper le script

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
            <!-- <button class="btn btn-primary my-2"><a href="formulaire.php" class="text-light">Ajouter un livre</a></button> -->
            <form action="" method="post">
              <input type="text" value="<?php if (!empty($_POST['title'])) echo $_POST['title']; ?>" name="title" placeholder="Tire du livre"/>
              <button type="submit" class="btn btn-secondary my-3" name="submit">Filtrer</button>  
            <?php 
              
              ?>
              <div class="form-group my-3">
                <select name="author_id">
                <?php
                foreach ($authors as $author) {
                    echo '<option value="' . $author['id'] . '"';
                    
                    if(!empty($_POST['author_id']) && $_POST['author_id'] == $author['id']){
                      echo ' selected';
                    }
                    
                    echo '>' . $author['firstname'].' '. $author['lastname'] . '</option>';
                }
                ?>
                </select>
              </div>               
                
            </form>
            
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
                  <td><button class="btn btn-info"><a href="details.php?id=<?= $book['id'] ?>" class="text-light">Voir</a></td>
                  <td><button class="btn btn-primary"><a href="edit.php?id=<?= $book['id'] ?>" class="text-light">Modifier</a></td>
                    
                  <td><button class="btn btn-danger"><a href="delet.php?id=<?= $book['id'] ?>" class="text-light">Supprimer</a></td>
                  
                </tr>
               <?php 
              }
          ?>
          </tbody>
          </table>

          <button class="btn btn-primary my-2"><a href="formulaire.php" class="text-light">Ajouter un livre</a></button>  
        </div>

  </body>
</html>


