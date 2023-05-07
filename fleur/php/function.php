<?php
//routes vers les differente pages :
//set routes par defaut
if (!isset($_SESSION['status'])) {
    $_SESSION['status'] = "deconnecter";
}
if (!isset($_SESSION['content'])) {
    $_SESSION['content'] = "index";
}
//lien vers les differente pages
if (array_key_exists('accueil', $_POST)) {
    $_SESSION['content'] = "index";
}
if (array_key_exists('bulbes', $_POST)) {
    $_SESSION['content'] = "bulbes";
}
if (array_key_exists('rosiers', $_POST)) {
    $_SESSION['content'] = "rosiers";
}
if (array_key_exists('massif', $_POST)) {
    $_SESSION['content'] = "massif";
}
if (array_key_exists('contact', $_POST)) {
    $_SESSION['content'] = "contact";
}
if (array_key_exists('register', $_POST)) {
    $_SESSION['content'] = "register";
}
if (array_key_exists('admin', $_POST)) {
    $_SESSION['content'] = "admin";
}
//deconnexion
if (array_key_exists('logOf', $_POST)) {
    $_SESSION['status'] = "deconnecter";
    session_destroy();
    header("Refresh:0");
}

//function :
//set nombre d'article par defaut
if (!isset($_SESSION['articles'])) {
    $_SESSION['articles'] = 0;
}
if (!isset($_SESSION['admin'])) {
    $_SESSION['admin'] = FALSE;
}
//set nombre d'article
if (array_key_exists('panier', $_POST)) {
    $_SESSION['facture'] = "";
    $catalogue = fopen("data/catalogue.csv", "r");
    $panier = fopen("php/panier.html", "w");
    $somme = 0;
    $newLine = "<div class='card'> \n";
    fwrite($panier, $newLine);
    if ($catalogue && $panier) {
        while (($line = fgets($catalogue)) !== false) {
            $tableau = explode(',', $line);
            if (isset($_SESSION[$tableau[2]])) {
                $nombre = $_SESSION[$tableau[2]][0];
                $prix = rtrim($_SESSION[$tableau[2]][2], "€") * $nombre * $tableau[6];
                if ($tableau[6] < 1) {
                    $promotion = "-" . (100 - $tableau[6] * 100) . "%";
                    $newLine = $nombre . " x " . $_SESSION[$tableau[2]][1] . " " . $promotion . " = " . $prix . " €";
                } else {
                    $newLine = $nombre . " x " . $_SESSION[$tableau[2]][1] . " = " . $prix . " €";
                }
                $_SESSION['facture'] .= $newLine;
                $newLine .= "<br> \n";
                $somme += $prix;
                fwrite($panier, $newLine);
            }
        }
    }
    $newLine = "Total = " . $somme . " €";
    $_SESSION['facture'] .= $newLine . "\n";
    fwrite($panier, $newLine);
    $newLine = "<br> \n<form action='' method='post'> <input type='submit' name='facture' value='facture'> </form>";
    fwrite($panier, $newLine);
    $newLine = '</div>';
    fwrite($panier, $newLine);
    fclose($catalogue);
    fclose($panier);
    if ($somme == 0) {
        echo '<script> alert("panier vide") </script>';
    } else {
        $_SESSION['content'] = "panier";
    }
}
//envoyer la facture
if (array_key_exists('facture', $_POST)) {
    if ($_SESSION['status'] == "connecter") {
        $fileName = "data/catalogue.csv";
        $catalogue = fopen($fileName, "r+");
        $stockSuffisant = true;
        $lines = -1;
        $change = [];
        $changeIndice = 0;
        if ($catalogue) {
            while (($line = fgets($catalogue)) !== false) {
                $lines++;
                $tableau = explode(',', $line);
                if (isset($_SESSION[$tableau[2]])) {
                    $newStock = $tableau[5] - $_SESSION[$tableau[2]][0];
                    if ($newStock < 0) {
                        echo '<script> alert("stock insuffisant") </script>';
                        $stockSuffisant = false;
                        break;
                    } else {
                        $lineChange = $tableau[0] . "," . $tableau[1] . "," . $tableau[2] . "," . $tableau[3] . "," . $tableau[4] . "," . $newStock . "," . $tableau[6] . ",";
                        $change[$changeIndice] = [$lines, $lineChange];
                        $changeIndice++;
                    }
                }
            }
        }
        fclose($catalogue);
        if ($stockSuffisant) {
            for ($i = 0; $i < $changeIndice; $i++) {
                $newline = file($fileName, FILE_IGNORE_NEW_LINES);
                $newline[$change[$i][0]] = $change[$i][1];
                file_put_contents($fileName, implode("\n", $newline));
            }
            $subject = "facture societe la fleur";
            mail("societelafleur5@gmail.com", $subject, $_SESSION['facture']);
            mail($_SESSION['email'], $subject, $_SESSION['facture']);
        }
    } else {
        echo "<script> alert('Vous devez être connecter pour envoyer la facture') </script>";
    }
}
//creation de compte
if (array_key_exists('createAccount', $_POST)) {
    $NewUser = True;
    $PwdCorrect = True;
    if (isset($_POST["Mdp"]) and isset($_POST["MdpConf"])) {
        if ($_POST["Mdp"] != $_POST["MdpConf"]) {
            echo "les deux mot de passe doivent etre identique";
            $PwdCorrect = False;
        }
    }
    if (isset($_POST["NomUtilisateur"]) and $PwdCorrect) {
        $handle = fopen("data/connexion.csv", "r");
        if ($handle) {
            while (($line = fgets($handle)) !== false) {
                $identifier = explode(',', $line);
                if ($_POST["NomUtilisateur"] == $identifier[0]) {
                    echo "Nom utilisateur deja utiliser";
                    $NewUser = False;
                    break;
                }
            }
        }
        fclose($handle);
        if ($NewUser) {
            $handle = fopen("data/connexion.csv", "a");
            $newLigne = $_POST["NomUtilisateur"] . "," . $_POST["Mdp"] . "," . $_POST["Email"] . "," . "client" . ",";
            fwrite($handle, $newLigne);
            fclose($handle);
        }
    }
}
//connexion
if (array_key_exists('Login', $_POST)) {
    $UserFind = False;
    if (isset($_POST["username"]) and isset($_POST["pwd"])) {
        $handle = fopen("data/connexion.csv", "r");
        if ($handle) {
            while (($line = fgets($handle)) !== false) {
                $identifier = explode(',', $line);
                if ($_POST["username"] == $identifier[0] and $_POST["pwd"] == $identifier[1]) {
                    $_SESSION['username'] = $_POST["username"];
                    $_SESSION['email'] = $identifier[2];
                    $UserFind = True;
                    if ("admin" == $identifier[3]) {
                        $_SESSION['admin'] = True;
                    }
                    break;
                }
            }
        }
        fclose($handle);
        if ($UserFind) {
            $_SESSION['status'] = "connecter";
        }
    }
}
//envoie de mail
if (array_key_exists('sendMail', $_POST)) {
    $body = "send by " . $_POST["nom"] . " " . $_POST["prenom"] . " le " . $_POST["date"] . " son adresse email est " . $_POST["email"] . " " . $_POST["body"];
    $subject = $_POST["sujet"];
    mail("societelafleur5@gmail.com", $subject, $body);
}
//ajout d'article au panier
if (array_key_exists('ajoutPanier', $_POST)) {
    $somme = 0;
    $handle = fopen("data/catalogue.csv", "r");
    if ($handle) {
        while (($line = fgets($handle)) !== false) {
            $identifier = explode(',', $line);
            if (isset($_POST[$identifier[2]])) {
                if ($_POST[$identifier[2]] > 0) {
                    $_SESSION[$identifier[2]] = [$_POST[$identifier[2]], $identifier[3], $identifier[4]];
                }
            }
            if (isset($_SESSION[$identifier[2]])) {
                $somme += $_SESSION[$identifier[2]][0];
            }
        }
    }
    $_SESSION['articles'] = $somme;
    fclose($handle);
}

if (array_key_exists('promo', $_POST)) {
    $lines = -1;
    $catalogue = fopen("data/catalogue.csv", "r");
    while (($line = fgets($catalogue)) !== false) {
        $lines++;
        $tableau = explode(',', $line);
        if ($tableau[2] == $_POST["ref"]) {
            $lineChange = $tableau[0] . "," . $tableau[1] . "," . $tableau[2] . "," . $tableau[3] . "," . $tableau[4] . "," . $tableau[5] . "," . $_POST["facteur"] . ",";
            $article = $tableau[3];
            break;
        }
    }
    fclose($catalogue);
    $newline = file("data/catalogue.csv", FILE_IGNORE_NEW_LINES);
    $newline[$lines] = $lineChange;
    file_put_contents("data/catalogue.csv", implode("\n", $newline));
    $connexion = fopen("data/connexion.csv", "r");
    $subject = "promotion";
    $promotion = "-" . (100 - $_POST["facteur"] * 100) . "%";
    $body = "promotion de " . $promotion . " sur l'article " . $article;
    while (($line = fgets($connexion)) !== false) {
        $tableau = explode(',', $line);
        if ($tableau[3] == "client") {
            mail($tableau[2], $subject, $body);
        }
    }
    fclose($connexion);
}

if (array_key_exists('changeStock', $_POST)) {
    $fileName = "data/catalogue.csv";
    $catalogue = fopen($fileName, "r");
    $lines = -1;
    if ($catalogue) {
        while (($line = fgets($catalogue)) !== false) {
            $lines++;
            $tableau = explode(',', $line);
            if ($tableau[2] == $_POST["ref"]) {
                $lineChange = $tableau[0] . "," . $tableau[1] . "," . $tableau[2] . "," . $tableau[3] . "," . $tableau[4] . "," . $_POST["newStock"] . "," .  $tableau[6] . ",";
                break;
            }
        }
    }
    fclose($catalogue);
    $newline = file($fileName, FILE_IGNORE_NEW_LINES);
    $newline[$lines] = $lineChange;
    file_put_contents($fileName, implode("\n", $newline));
}
