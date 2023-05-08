<?php
$_SESSION["id"] = 1;
$sel=$pdo->prepare("select date, food_calorie from repas where user_id=?");
$sel->execute(array($_SESSION["id"]));
$tab=$sel->fetchAll();

$dates = array();
$calories = array();
if (!empty($tab)) {
  foreach ($tab as $row) {
    $dates[] = $row['date'];
    $calories[] = $row['food_calorie'];
  }
}

// Définir les options du graphique
$options = array(
  'responsive' => true,
  'maintainAspectRatio' => false,
  'scales' => array(
    'yAxes' => array(
      array(
        'ticks' => array(
          'beginAtZero' => true
        )
      )
    )
  )
);

// Construire le graphique
echo "<h1 class='graph-title'>Suivi de votre consommation en calories</h1>
      <div class='graph-container'>
        <canvas id='calories-graph'></canvas>
      </div>
      <script src='https://cdn.jsdelivr.net/npm/chart.js'></script>
      <script>
        var ctx = document.getElementById('calories-graph').getContext('2d');
        var myChart = new Chart(ctx, {
          type: 'line',
          data: {
            labels: " . json_encode($dates) . ",
            datasets: [{
              label: 'Calories consommées',
              data: " . json_encode($calories) . ",
              backgroundColor: 'rgba(54, 162, 235, 0.2)',
              borderColor: 'rgba(54, 162, 235, 1)',
              borderWidth: 1
            }]
          },
          options: " . json_encode($options) . "
        });
      </script>";
?>

