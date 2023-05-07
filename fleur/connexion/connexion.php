<?php
   try{
      $pdo=new PDO("mysql:host=localhost;dbname=mabase","user","1234");
   }
   catch(PDOException $e){
      echo $e->getMessage();
   }
?>