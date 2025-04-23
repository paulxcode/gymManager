<?php
session_start();

// Verificăm dacă utilizatorul este administrator
if (!isset($_SESSION['user_id']) || $_SESSION['rol'] !== 'admin') {
    header('Location: login.php'); // Dacă nu este admin, redirecționăm la login
    exit();
}

require 'includes/database.php';

$stmt = $pdo->prepare("SELECT a.nume, COUNT(*) as numar_abonamente
                       FROM abonamente_utilizatori au
                       JOIN abonamente a ON a.id = au.id_abonament
                       WHERE au.data_expirare > NOW() OR au.data_expirare IS NULL
                       GROUP BY a.nume");
$stmt->execute();
$abonamente = $stmt->fetchAll();

$labels = [];
$data = [];

foreach ($abonamente as $abonament) {
    $labels[] = $abonament['nume'];
    $data[] = $abonament['numar_abonamente'];}
?>

<!DOCTYPE html>
<html lang="ro">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Raport Abonamente - Panou Admin</title>

<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.5/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-SgOJa3DmI69IUzQ2PVdRZhwQ+dy64/BUtbMJw1MZ8t5HZApcHrRKUc4W0kG879m7" crossorigin="anonymous">
    <link rel="stylesheet" href="css/style.css">
</head>
<body>

<div class="container-fluid">

    <?php include 'includes/navbar.php'; ?>

    <div class="container pt-5">

        <h1>Raport Abonamente</h1>

        <p>Acest raport arată numărul de utilizatori activi pentru fiecare tip de abonament.</p>

        <div class="container">

            <canvas id="abonamenteChart" width="400" height="200"></canvas>



        </div>

    </div>

    <?php include 'includes/footer.php'; ?>
</div>


<script>
            var ctx = document.getElementById('abonamenteChart').getContext('2d');
            var abonamenteChart = new Chart(ctx, {
                type: 'bar', 
                data: {
                    labels: <?php echo json_encode($labels); ?>, 
                    datasets: [{
                        label: 'Număr Abonamente Active',
                        data: <?php echo json_encode($data); ?>, 
                        backgroundColor: '#4CAF50',
                        borderColor: '#388E3C',
                        borderWidth: 1
                    }]
                },
                options: {
                    scales: {
                        y: {
                            beginAtZero: true
                        }
                    }
                }
            });
        </script>


<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.5/dist/js/bootstrap.bundle.min.js" integrity="sha384-k6d4wzSIapyDyv1kpU366/PK5hCdSbCRGRCMv+eplOQJWyd1fbcAu9OCUj5zNLiq" crossorigin="anonymous"></script>

</body>
</html>
