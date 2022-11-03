<?php

//CRUD   -- > Create
session_start();

if($_POST){
    if(isset($_POST['title']) && !empty($_POST['litle'])
    && isset($_POST['date_publi']) && !empty($_POST['date_publi'])
    && isset($_POST['author_id']) && !empty($_POST['author_id'])){

      require_once ('connect.php');

      $title = strip_tags($_POST['title']);
      $date_publi = strip_tags($_POST['date_publi']);
      $author_id = strip_tags($_POST['author_id']);

      $reqsql="INSERT INTO book (author_id, title, date_publi) VALUES ($author_id, '$title', '$date_publi')";
      $query = $db->prepare($reqsql);

      $query->bindValue(':title',$title,PDO::PARAM_STR);
      $query->bindValue(':date_publi',$date_publi,PDO::PARAM_STR);
      $query->bindValue(':author_id',$author_id,PDO::PARAM_INT);
      $query->execute();

      $_SESSION ['message'] = "Livre ajouté";

    //$book = $query->fetch();

      require_once ('deconnect.php');

      header('Location: index.php');

    }else{
      $_SESSION['erreur'] = " Le formulaire est incomplet";
    }

}


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

    </body>
</html>


