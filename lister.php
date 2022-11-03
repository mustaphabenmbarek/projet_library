<?php
//CRUD   -- > afficher les détails d'un livre

session_start();


if(isset($_GET['id']) && !empty($_GET['id'])) {
    require_once ('connect.php');

    $id = strip_tags($_GET['id']);

    $reqsql='SELECT * FROM book WHERE `id` = :id;';
    //$reqsql="select b.*, a.lastname from book b left join author a on a.id=b.author_id"; 

    $query = $db->prepare($reqsql);
    $query->bindValue(':id',$id,PDO::PARAM_INT);
    $query->execute();
    $book = $query->fetch();
    //var_dump($book);
    //die();

    if(!$book) {
        $_SESSION ['erreur'] = "id n'existe pas dans la BD";
        header('Location: index.php');
    }

}else{
    $_SESSION ['erreur'] = "URL incorrecte";
    header('Location: index.php');

}

?>


<!doctype html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Détails du livre</title>
    
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.2/dist/css/bootstrap.min.css" rel="stylesheet">

  </head>
    <body>
        <div class="container">
            <div class="row">
                <section class="col-12">
                    <h1> Détails du livre : </h1>
                    <p>ID : <?=$book['id'] ?></p>
                    <p>Titre du livre : <?=$book['title'] ?></p>
                    <p>Date publication : <?=$book['date_publi'] ?></p>       
                    
                    <select name="author_id">
                    <?php
                
                    foreach ($authors as $author) {
                        echo '<option value="' . $author['id'] . '"';
                        
                        if ($author['id'] === $book['author_id']) {
                            echo ' selected';
                        }
        
                        echo '>' . $author['firstname'] . '</option>';
                        
                    }
                    ?>
                    <p>Nom auteur : <?=$author['lastname'] ?></p>
                    </select>
                    
                    <p><a href="index.php"></a></p>
                </section>
            </div>

        </div>
    
    </body>
</html>
