<div class="card">
  <form
    action=""
    method="post"
    name="mailForm"
    onsubmit="return validateForm()"
  >
    <h1>Ajouté un plat</h1>
    <input
      type="date"
      name="date"
      placeholder="Date du contact"
      required
    /><br />
    <input
      type="text"
      name="plat"
      placeholder="Entrez votre plat"
      required
    /><br />
    <input
      type="number"
      name="calorie"
      placeholder="Entrez votre calorie"
      required
    /><br />
    <input type="submit" name="addMeal" value="Ajouté un plat" />
  </form>
</div>

<script>
  function validateForm() {
    let plat = document.forms["mailForm"]["plat"].value.replace(/\s+/g, "");
    let calorie = document.forms["mailForm"]["calorie"].value.replace(/\s+/g, "");
    let date = document.forms["mailForm"]["date"].value.replace(/\s+/g, "");
    if (plat == "" || calorie == "" || date == "") {
      alert("Everything must be filled out");
      return false;
    }
  }
</script>
<?php
//function:
//creation de compte
if (array_key_exists('addMeal', $_POST)) {
    $ins=$pdo->prepare("insert into repas(food_name,food_calories,date,user_id) values(?,?,?,?)");
    if($ins->execute(array($_POST["plat"],$_POST["calorie"],$_POST["date"],$_SESSION["id"])));
}

// Historiqque
$sel=$pdo->prepare("select * from repas where user_id=?");
$sel->execute(array($_SESSION["id"]));
$tab=$sel->fetchAll();
if(count($tab)>0){
    echo "<ul>";
    foreach ($tab as $row) {
        echo "<li>" . $row['food_name'] . " " .  $row['food_calories'] . "calorie le " .  $row['date'] . "</li>";
    }
    echo "</ul>";
}
else{
    echo "<p>Aucun repas enregistré</p>";
}

?>