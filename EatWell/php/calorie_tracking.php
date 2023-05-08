<?php
$sel=$pdo->prepare("SELECT food_date, SUM(food_calories) AS food_calories FROM repas WHERE user_id=? GROUP BY food_date ORDER BY food_date");
$sel->execute(array($_SESSION["id"]));
$tab=$sel->fetchAll();

$dates = array();
$calories = array();
if (!empty($tab)) {
  foreach ($tab as $row) {
    $dates[] = $row['food_date'];
    $calories[] = $row['food_calories'];
  }
}

//ligne BMR
$redLine = array_fill(0, count($dates), $_SESSION["BMR"]);

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
echo "<div class='graph-container'>
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
            }, {
                label: 'Limite de calories',
                type: 'line',
                data: " . json_encode($redLine) . ",
                backgroundColor: 'rgba(255, 99, 132, 0.2)',
                borderColor: 'rgba(255, 99, 132, 1)',
                borderWidth: 1
              }]
          },
          options: " . json_encode($options) . "
        });
      </script>";
?>