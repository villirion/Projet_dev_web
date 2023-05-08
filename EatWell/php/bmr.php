<div class="card">
  <form
    action=""
    method="post"
    name="BMRForm"
    onsubmit="return validateForm()"
  >
    <h1>Calcul BMR</h1>
    <input
      type="number"
      name="age"
      placeholder="Entrez votre age"
      required
    /><br />
    <input
      type="number"
      name="poid"
      step="any"
      placeholder="Entrez votre poid (en kg)"
      required
    /><br />
    <input
      type="number"
      name="taille"
      step="any"
      placeholder="Entrez votre taille (en m)"
      required
    /><br />
    <select id="sexe" name="sexe">
        <option value="homme">Homme</option>
        <option value="femme">Femme</option>
    </select><br />
    <input type="submit" name="BMR" value="Calcul BMR" />
  </form>
  <?php
//function:
//calcul BMR
if (array_key_exists('BMR', $_POST)) {
    if (isset($_POST["age"]) and isset($_POST["poid"]) and isset($_POST["sexe"]) and isset($_POST["taille"])) {
        if ($_POST["sexe"] == "homme") {
            $BMR = 13.397 * $_POST["poid"]  + 4.799 * $_POST["taille"] - 5.677 * $_POST["age"] + 88.362;
        }
        else {
            $BMR = 9.247 * $_POST["poid"]  +  3.098 * $_POST["taille"] - 4.330 * $_POST["age"] + 447.593;
        }
        echo "<div class='bmr'><p>Votre BMR (Basal Metabolic Rate) est " . $BMR . "</p></div>";
    }
}
?>
</div>

<div class="card">
  <form
    action=""
    method="post"
    name="patchBMRForm"
    onsubmit="return validateForm2()"
  >
    <h1>Changer mon BMR</h1>
    <input
      type="number"
      name="BMR"
      step="any"
      placeholder="Entrez votre BMR"
      required
    /><br />
    <input type="submit" name="patchBMR" value="Changer mon BMR" />
  </form>

</div>


<script>
  function validateForm() {
    let age = document.forms["BMRForm"]["age"].value.replace(/\s+/g, "");
    let poid = document.forms["BMRForm"]["poid"].value.replace(/\s+/g, "");
    let taille = document.forms["BMRForm"]["taille"].value.replace(/\s+/g, "");
    if (age == "" || poid == "" || taille == "") {
      alert("Everything must be filled out");
      return false;
    }
  }
  function validateForm2() {
    let BMR = document.forms["patchBMRForm"]["BMR"].value.replace(/\s+/g, "");
    if (BMR == "") {
      alert("Everything must be filled out");
      return false;
    }
  }
</script>

<?php
//patch BMR db
if (array_key_exists('patchBMR', $_POST)) {
    if ($_SESSION['status'] == "connexion" ) {
        echo "<div class='bmr'><p>Vous devez etre connecter pour changer votre BMR</p></div>";
    }
    else {
        if (isset($_POST["BMR"])) {
            $ins=$pdo->prepare("UPDATE utilisateurs SET BMR=? where utilisateurs.id=?");
            if($ins->execute(array($_POST["BMR"],$_SESSION["id"])));
            $_SESSION['BMR'] = $_POST["BMR"];
        }
    }
}
?>