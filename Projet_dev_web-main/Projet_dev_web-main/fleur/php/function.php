<?php
session_start();
try{
    // $pdo=new PDO("mysql:host=localhost;dbname=mabase","root","Villirion@2802");
    $pdo=new PDO("mysql:host=localhost;dbname=projetdev","root","");
}
catch(PDOException $e){
    echo $e->getMessage();
}

//routes vers les differente pages :
//set routes par defaut
if (!isset($_SESSION['status'])) {
    $_SESSION['status'] = "connexion";
}
if (!isset($_SESSION['content'])) {
    $_SESSION['content'] = "index";
}

//lien vers les differente pages
if (array_key_exists('accueil', $_POST)) {
    $_SESSION['content'] = "index";
}
if (array_key_exists('contact', $_POST)) {
    $_SESSION['content'] = "contact";
}
if (array_key_exists('connexion', $_POST)) {
    $_SESSION['content'] = "login";
}
if (array_key_exists('recipes', $_POST)) {
    $_SESSION['content'] = "recipes";
}
if (array_key_exists('services', $_POST)) {
    $_SESSION['content'] = "services";
}
if (array_key_exists('inscription', $_POST)) {
    $_SESSION['content'] = "inscription";
}
if (array_key_exists('connexion', $_POST)) {
    $_SESSION['content'] = "connexion";
}

//deconnexion
if (array_key_exists('deconnexion', $_POST)) {
    $_SESSION['status'] = "connexion";
    session_destroy();
    header("Refresh:0");
}

//function:
//creation de compte
if (array_key_exists('createAccount', $_POST)) {
    $PwdCorrect = True;
    if (isset($_POST["Mdp"]) and isset($_POST["MdpConf"])) {
        if ($_POST["Mdp"] != $_POST["MdpConf"]) {
            echo "les deux mot de passe doivent etre identique";
            $PwdCorrect = False;
        }
    }
    if (isset($_POST["Prenom"]) and isset($_POST["Nom"]) and isset($_POST["Email"]) and $PwdCorrect) {
        @$Email=$_POST["Email"];
        $sel=$pdo->prepare("select id from utilisateurs where email=? limit 1");
        $sel->execute(array($Email));
        $tab=$sel->fetchAll();
        if(count($tab)>0)
            echo "Email existe déjà!";
        else{
            $ins=$pdo->prepare("insert into utilisateurs(email,prenom,nom,pass) values(?,?,?,?)");
            if($ins->execute(array($_POST["Email"],$_POST["Prenom"],$_POST["Nom"],$_POST["Mdp"])))
            $_SESSION['id'] = $tab[0]["id"];
            $_SESSION['status'] = "deconnexion";
            $_SESSION['content'] = "index";
        }
    }
}

//connexion
if (array_key_exists('login', $_POST)) {
    if (isset($_POST["Email"]) and isset($_POST["Mdp"])) {
        @$Email=$_POST["Email"];
        @$Mdp=$_POST["Mdp"];
        $sel=$pdo->prepare("select * from utilisateurs where email=? and pass=? limit 1");
        $sel->execute(array($Email,$Mdp));
        $tab=$sel->fetchAll();
        if(count($tab)>0){
            $_SESSION['id'] = $tab[0]["id"];
            $_SESSION['status'] = "deconnexion";
            $_SESSION['content'] = "index";
        }
        else{
            echo "Mauvais login ou mot de passe!";
        }
    }
}
