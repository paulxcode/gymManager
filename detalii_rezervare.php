<?php
session_start();
if (!isset($_SESSION['user_id'])) {
    header('Location: login.php');
    exit();
}

require 'includes/database.php';

if (isset($_GET['curs_id']) && isset($_GET['data_dorita'])) {
    $curs_id = $_GET['curs_id'];
    $data_dorita = $_GET['data_dorita'];

    $stmt = $pdo->prepare("SELECT * FROM cursuri WHERE id = ?");
    $stmt->execute([$curs_id]);
    $curs = $stmt->fetch();

    if (!$curs) {
        echo "Cursul selectat nu există.";
        exit();
    }
} else {
    echo "Nu a fost selectat niciun curs sau nu a fost aleasă o dată.";
    exit();
}

?>

<!DOCTYPE html>
<html lang="ro">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Detalii Rezervare - <?php echo htmlspecialchars($curs['nume']); ?></title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.5/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="css/style.css">
</head>
<body>

<div class="container-fluid">
    <?php include 'includes/navbar.php'; ?>

    <div class="container py-5 fade-in bg-black">
        <div class="mx-auto redborder" style="max-width: 700px; border-radius: 12px;">
            <div class="card text-white shadow-lg p-4 rounded-4 bg-black">
                <h1 class="text-center mb-4">Detalii Rezervare</h1>

                <div class="mb-4 ">
                    <h2 class="text-danger"><?php echo htmlspecialchars($curs['nume']); ?></h2>
                    <p class="text-white"><strong>Descriere:</strong> <?php echo nl2br(htmlspecialchars($curs['descriere'])); ?></p>
                    <p class="text-white"><strong>Durata:</strong> <?php echo htmlspecialchars($curs['durata_minute']); ?> minute</p>
                    <p class="text-white"><strong>Data dorită:</strong> <?php echo htmlspecialchars($data_dorita); ?></p>
                </div>

                <form action="confirmare_rezervare.php" method="POST">
                    <input type="hidden" name="curs_id" value="<?php echo $curs['id']; ?>">
                    <input type="hidden" name="data_dorita" value="<?php echo $data_dorita; ?>">
                    <button type="submit" class="btn-delete">Confirmă Rezervarea</button>
                </form>

                <a href="rezervari.php" class="btn btn-secondary"><i class="fas fa-arrow-left"></i> Înapoi la selecția cursurilor</a>
            </div>
        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.5/dist/js/bootstrap.bundle.min.js"></script>

</body>
</html>
