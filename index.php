<!DOCTYPE html>
<html>
    <head>
        <meta charset="UTF-8">
        <title></title>
    </head>
    <body>
        <?php
       include_once "config.inc.php";
        include 'db.php';
       
       include_once $classes['book'];
       echo "test";
       include_once $classes['user'] ;
       include_once $classes['episode'] ;
       /**
        * @$db Database connection
        */
       $db = new DB();
       $book = new Book($db); 
       $user = new User($db);
       $episode = new Episode($db, null);
       echo "<pre>";
        echo "</pre>";
        include_once ($forms['book']);
      
   
        ?>
    
    </body>
</html>
