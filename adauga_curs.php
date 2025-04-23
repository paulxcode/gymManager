<?php
session_start();
if (!isset($_SESSION['user_id']) || $_SESSION['rol'] !== 'admin') {
    header('Location: index.php'); // Redirecționăm dacă nu este admin
    exit();
}

require 'includes/database.php';
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $nume_curs = $_POST['nume'];
    $descriere_curs = $_POST['descriere'];
    $durata_curs = $_POST['durata'];

    $stmt = $pdo->prepare("INSERT INTO cursuri (nume, descriere, durata_minute) VALUES (?, ?, ?)");
    $stmt->execute([$nume_curs, $descriere_curs, $durata_curs]);

    header('Location: admin.php');
    exit();
}
?>

<!DOCTYPE html>
<html lang="ro">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Adaugă Curs - Admin</title>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css" rel="stylesheet">
    <link rel="stylesheet" href="css/style.css">
</head>
<body>

<div class="container-fluid">

<?php include 'includes/navbar.php'; ?>

<div class="admin-section container">

<div class="wrapper" style="margin: 20px auto; height: 550px">

    <div class="form-container">
    <h2>Adaugă curs</h2>

        <form action="adauga_curs.php" method="POST">
            <div class="input-box">
                <input type="text" id="nume" name="nume" required>
                <label for="nume">Nume Curs</label>
            </div>

            <div class="textarea-box">
                <label for="descriere">Descriere</label>
                <textarea id="descriere" name="descriere" rows="4" required></textarea>
            </div>

            <div class="input-box">
                <input type="number" id="durata" name="durata" required>
                <label for="durata">Durata (minute)</label>
            </div>

            <button type="submit" class="btnn" style="background: rgb(155, 0, 0); color: white;">Adaugă Curs</button>
        </form>
    </div>
    </div>
    </div>



</div>




<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.5/dist/js/bootstrap.bundle.min.js" integrity="sha384-k6d4wzSIapyDyv1kpU366/PK5hCdSbCRGRCMv+eplOQJWyd1fbcAu9OCUj5zNLiq" crossorigin="anonymous"></script>
</body>
</html>
