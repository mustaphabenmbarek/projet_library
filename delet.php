<?php
//CRUD   -- > delete

session_start();


if(isset($_GET['id']) && !empty($_GET['id'])) {
    require_once ('connect.php');

    $id = strip_tags($_GET['id']);

    $reqsql='SELECT * FROM book WHERE id = :id';

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

    $reqsql='DELETE FROM book WHERE id = :id';

    $query = $db->prepare($reqsql);
    $query->bindValue(':id',$id,PDO::PARAM_INT);

    $query->execute();

    $_SESSION ['message'] = "Livre supprimé";
    header('Location: index.php');

}else{
    $_SESSION ['erreur'] = "URL incorrecte";
    header('Location: index.php');

}

?>
