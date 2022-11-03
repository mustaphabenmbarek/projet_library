<?php
//CRUD   -- > update

//echo "<pre>";
//echo $_GET['id'];

session_start();

if(isset($_GET['id']) && !empty($_GET['id'])) {
  require_once ('connect.php');

  $id = strip_tags($_GET['id']);

  $reqsql='SELECT * FROM book WHERE `id` = :id;';

  $query = $db->prepare($reqsql);
  $query->bindValue(':id',$id,PDO::PARAM_INT);
  $query->execute();
  $book = $query->fetch();

  if(!$book) {
    $_SESSION ['erreur'] = "id n'existe pas dans la BD";
    header('Location: index.php');
}

}else{
$_SESSION ['erreur'] = "URL incorrecte";
header('Location: index.php');

}


if($_POST){
    if(isset($_POST['id']) && !empty($_POST['id'])
      && isset($_POST['title']) && !empty($_POST['litle'])
      && isset($_POST['date_publi']) && !empty($_POST['date_publi'])
      && isset($_POST['author_id']) && !empty($_POST['author_id'])){
  
        require_once ('connect.php');
  
        $title = strip_tags($_POST['id']);
        $title = strip_tags($_POST['title']);
        $date_publi = strip_tags($_POST['date_publi']);
        $author_id = strip_tags($_POST['author_id']);
  
        $reqsql='UPDATE book SET `title`=:title, `date_publi`=date_publi WHERE `id`=:id;';
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



?>


    <form action="" method="post">
        <label for="title">Titre du livre </label> : <input type="text" id="title" name="title"/><br/><br/>
        <label for="date_publi">Date publication </label> : <input type="date" id="date_publi" name="date_publi"/><br/><br/>

        <select name="author_id">
            <?php
            foreach ($authors as $author) {
                echo '<option value="' . $author['id'] . '"';
                
                if ($author['id'] === $book['author_id']) {
                    echo ' selected';
                }

                echo '>' . $author['firstname'] . '</option>';
                

               // <option value="3">Marc</option>
                //<option value="3" selected>Marc</option>

            
        }
        ?>
    </select>

       <button type="submit">Envoyer</button>
    </form>

