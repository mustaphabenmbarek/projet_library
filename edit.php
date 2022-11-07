<?php
//CRUD   -- > update

//echo "<pre>";
//echo $_GET['id'];

session_start();


if($_POST){
  if(isset($_POST['id']) && !empty($_POST['id'])
    && isset($_POST['title']) && !empty($_POST['title'])
    && isset($_POST['date_publi']) && !empty($_POST['date_publi'])
    && isset($_POST['author_id']) && !empty($_POST['author_id'])){

      require_once ('connect.php');

      $id = strip_tags($_POST['id']);
      $title = strip_tags($_POST['title']);
      $date_publi = strip_tags($_POST['date_publi']);
      $author_id = strip_tags($_POST['author_id']);

      $reqsql='UPDATE book SET `title`=:title, `date_publi`=:date_publi, `author_id`=:author_id WHERE `id`=:id';
      $query = $db->prepare($reqsql);

      $query->bindValue(':id',$id,PDO::PARAM_INT);
      $query->bindValue(':title',$title,PDO::PARAM_STR);
      $query->bindValue(':date_publi',$date_publi,PDO::PARAM_STR);
      $query->bindValue(':author_id',$author_id,PDO::PARAM_INT);
      $query->execute();

      $_SESSION ['message'] = "Livre modifié";

    //$book = $query->fetch();

      require_once ('deconnect.php');

      header('Location: index.php');

    }else{
      $_SESSION['erreur'] = " Le formulaire est incomplet";
    }

}



if(isset($_GET['id']) && !empty($_GET['id'])) {
  require_once ('connect.php');

  $id = strip_tags($_GET['id']);

  //$reqsql='SELECT * FROM book WHERE `id` = :id;';
  //$reqsql= 'select b.*, author.lastname as lastname from book b left join author on `author_id` = :id;';
  //$reqsql='select b.*, a.lastname from book b left join author a on a.id=b.author_id';
  $reqsql='select * from book WHERE `id`= :id';

  $query = $db->prepare($reqsql);
  $query->bindValue(':id',$id,PDO::PARAM_INT);
  $query->execute();
  $book = $query->fetch();

  if(!$book) {
    $_SESSION ['erreur'] = "id n'existe pas dans la BD";
    header('Location: index.php');
}

$reqsql = "SELECT * FROM author";
//$authors = $db->query($reqsql);
//$reqsql='select b.*, a.lastname from book b left join author a on a.id=b.author_id';
$query = $db->prepare($reqsql);
$query->execute();
$authors = $query->fetchAll(PDO::FETCH_ASSOC);

}else{
$_SESSION ['erreur'] = "URL incorrecte";
header('Location: index.php');

}


?>


    <!-- <form action="" method="post">
        <label for="title">Titre du livre </label>
        <input type="text" id="title" name="title" value="<?= $book['title']?>"/><br/><br/>
        <label for="date_publi">Date publication </label>
        <input type="date" id="date_publi" name="date_publi" value="<?= $book['date_publi']?>"/><br/><br/> -->

        <!-- ==================== -->

  <!doctype html>
  <html lang="en">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>CRUD updatee</title>
    
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

    <h1>MODIFIER LE LIVRE</h1>
    <form action="" method="POST">

        <div class="form-group my-3">
            
            <label for="title">Titre livre</label>
            <input type="text" class="form-control" id="title" name="title" value="<?= $book['title']?>" autocomplete="off">
        </div>

        <div class="form-group my-3">
            <label for='date_publi'>Date publication</label>
            <input type="date" class="form-control" id="date_publi" name="date_publi" value="<?= $book['date_publi']?>">
         </div>
         
         <div class="form-group my-3">
         <label for='author_id'>Auteur</label>
         <select name="author_id" id="author_id">
            <?php
                foreach ($authors as $author) {
                    echo '<option value="' . $author['id'] . '">'. $author['firstname'].' '. $author['lastname'] . '</option>';
            
                }
            ?>
            </select>
            </div>

         

         
        <div>
          <input type="hidden" value="<?= $book['id'] ?>" name="id">
        </div>
        <div class="form-group my-3">
            <button type="submit" class="btn btn-primary my-3" name="submit">Modifier le livre</button>
            <a href="index.php" class="btn btn-danger">Retour</a>
        </div>
    </form> 

  </div>
   
</body>
</html>

     <!-- ==================== -->   
        