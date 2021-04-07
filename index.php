<?php

/**
 * Commencez par importer le fichier sql live.sql via PHPMyAdmin.
 * 1. Sélectionnez tous les utilisateurs.
 * 2. Sélectionnez tous les articles.
 * 3. Sélectionnez tous les utilisateurs qui parlent de poterie dans un article.
 * 4. Sélectionnez tous les utilisateurs ayant au moins écrit deux articles.
 * 5. Sélectionnez l'utilisateur Jane uniquement s'il elle a écris un article ( le résultat devrait être vide ! ).
 *
 * ( PS: Sélectionnez, mais affichez le résultat à chaque fois ! ).
 */
try {
    $server = "localhost";
    $db = "exo_206";
    $user = "root";
    $password = "";

    $pdo = new PDO("mysql:host=$server;dbname=$db;charset=utf8", $user, $password);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    $pdo->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_ASSOC);

    // Exo 1

    echo "exo 1" . "<br>";

   $request = $pdo->prepare("
        SELECT * FROM user;  
   ");
   $request->execute();

   echo "<pre>";
   print_r($request->fetchAll());
   echo "</pre>";


    // Exo 2

    echo "exo 2" . "<br>";

    $request2 = $pdo->prepare("
        SELECT * FROM article;  
   ");
    $request2->execute();

    echo "<pre>";
    print_r($request2->fetchAll());
    echo "</pre>";

    //Exo 3

    echo "exo 3" . "<br>";

    $request3 = $pdo->prepare("
        SELECT username FROM user
        WHERE id = ANY (SELECT user_fk FROM article WHERE contenu LIKE '%poterie%');  
   ");
    $request3->execute();

    echo "<pre>";
    print_r($request3->fetchAll());
    echo "</pre>";

    //Exo 4

    echo "exo 4" . "<br>";

    $request4 = $pdo->prepare("
        SELECT username FROM user
        WHERE id = ANY (SELECT user_fk FROM article HAVING COUNT(user_fk = user.id) > 1);  
   ");
    $request4->execute();

    echo "<pre>";
    print_r($request4->fetchAll());
    echo "</pre>";


    //Exo 5

    echo "exo 5" . "<br>";

    $request5 = $pdo->prepare("
        SELECT * FROM article
        WHERE article.user_fk = ANY (SELECT user.id FROM user WHERE user.username LIKE '%Jane%');  
   ");
    $request5->execute();

    echo "<pre>";
    print_r($request5->fetchAll());
    echo "</pre>";


} catch (PDOException $exception) {
    echo $exception->getMessage();
}
