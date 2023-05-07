<?php
   session_start();
   if($_SESSION["autoriser"]!="oui"){
      header("location:login.php");
      exit();
   }
    $bienvenue="Bonjour et bienvenue ".
    $_SESSION["prenomNom"].
    " dans votre espace personnel";
?>
<!DOCTYPE html>
<html>
   <head>
      <meta charset="utf-8" />
      <style>
         *{
            font-family:arial;
         }
         body{
            margin:20px;
         }
         a{
            color:#EE6600;
            text-decoration:none;
         }
         a:hover{
            text-decoration:underline;
         }
      </style>
   </head>
   <body onLoad="document.fo.login.focus()">
      <h2><?php echo $bienvenue?></h2>
      [ <a href="deconnexion.php">Se déconnecter</a> ]
   </body>
</html>