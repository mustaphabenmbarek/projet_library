<?php

// Constantes d'environnement
  define("DBHOST", "localhost");
  define("DBUSER", "root");
  define("DBPASS", "");
  define("DBNAME", "projet_library");

  $dsn = "mysql:host=".DBHOST.";dbname=".DBNAME;
// ajouter test de connexion avec try

    // $connectdb = new PDO ($dsn,DBUSER, DBPASS);

    //   if (!$connectdb) {
    //     echo "Connection OK "

    //   } else {
    //     die(error($connectdb));
    //   }


  try {
    $db = new PDO ($dsn,DBUSER, DBPASS);

  } catch (PDOException $ex) {
    echo 'Erreur connection :'. $ex;
    die();

  }
?>
