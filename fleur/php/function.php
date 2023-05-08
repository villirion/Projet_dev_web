<?php
session_start();
try{
    $pdo=new PDO("mysql:host=localhost;dbname=mabase","root","Villirion@2802");
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
    $_SESSION['content'] = "index.html";
}

//lien vers les differente pages
if (array_key_exists('accueil', $_POST)) {
    $_SESSION['content'] = "index.html";
}
if (array_key_exists('contact', $_POST)) {
    $_SESSION['content'] = "contact.html";
}
if (array_key_exists('connexion', $_POST)) {
    $_SESSION['content'] = "login.html";
}
if (array_key_exists('recipes', $_POST)) {
    $_SESSION['content'] = "recipes.html";
}
if (array_key_exists('services', $_POST)) {
    $_SESSION['content'] = "services.html";
}
if (array_key_exists('inscription', $_POST)) {
    $_SESSION['content'] = "inscription.html";
}
if (array_key_exists('BMR', $_POST)) {
    $_SESSION['content'] = "BMR.php";
}
if (array_key_exists('calorie_tracking', $_POST)) {
    if ($_SESSION['status'] == "connexion" ) {
        $_SESSION['content'] = "login.html";
    }
    else{
        $_SESSION['content'] = "calorie_tracking.php";
    }
}
if (array_key_exists('add_meal', $_POST)) {
    if ($_SESSION['status'] == "connexion" ) {
        $_SESSION['content'] = "login.html";
    }
    else{
        $_SESSION['content'] = "add_meal.php";
    }
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
    if (isset($_POST["Prenom"]) and isset($_POST["Nom"]) and isset($_POST["Email"]) and isset($_POST["BMR"]) and $PwdCorrect) {
        @$Email=$_POST["Email"];
        $sel=$pdo->prepare("select 1 from utilisateurs where email=?");
        $sel->execute(array($Email));
        $tab=$sel->fetchAll();
        if(count($tab)>0)
            echo "Email existe déjà!";
        else{
            $ins=$pdo->prepare("insert into utilisateurs(email,prenom,nom,pass,BMR) values(?,?,?,?,?)");
            if($ins->execute(array($_POST["Email"],$_POST["Prenom"],$_POST["Nom"],$_POST["Mdp"],$_POST["BMR"])))
            $sel=$pdo->prepare("select id, BMR from utilisateurs where email=? limit 1");
            $sel->execute(array($Email));
            $tab=$sel->fetchAll();
            $_SESSION['id'] = $tab[0]["id"];
            $_SESSION['BMR'] = $tab[0]["BMR"];
            $_SESSION['status'] = "deconnexion";
            $_SESSION['content'] = "index.html";
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
            $_SESSION['BMR'] = $tab[0]["BMR"];
            $_SESSION['status'] = "deconnexion";
            $_SESSION['content'] = "index.html";
        }
        else{
            echo "Mauvais login ou mot de passe!";
        }
    }
}
