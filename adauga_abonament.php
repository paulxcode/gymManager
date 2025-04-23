<?php
session_start();
require 'includes/database.php';

$mesaj = '';

if (!isset($_SESSION['user_id']) || $_SESSION['rol'] !== 'admin') {
    header("Location: login.php");
    exit;
}

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['nume_abonament'])) {
    $nume = $_POST['nume_abonament'];
    $descriere = $_POST['descriere_abonament'];
    $pret = $_POST['pret_abonament'];

    if (empty($nume) || empty($descriere) || empty($pret)) {
        $mesaj = 'Toate câmpurile trebuie completate!';
    } else {
        $stmt_insert = $pdo->prepare("INSERT INTO abonamente (nume, descriere, pret) VALUES (?, ?, ?)");
        $stmt_insert->execute([$nume, $descriere, $pret]);

        header("Location: abonamente.php");
        exit;
    }
}
?>

<!DOCTYPE html>
<html lang="ro">
<head>
    <meta charset="UTF-8">
    <title>Adaugă abonament</title>
    <link rel="stylesheet" href="css/style.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.5/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-SgOJa3DmI69IUzQ2PVdRZhwQ+dy64/BUtbMJw1MZ8t5HZApcHrRKUc4W0kG879m7" crossorigin="anonymous">
</head>
<body>
<div class="container-fluid">

<?php include 'includes/navbar.php'; ?>

<div class="admin-section container">
    <div class="wrapper" style="margin: 20px auto; height: 550px">
        <div class="form-container">
            <h2>Adaugă abonament</h2>

            <?php if ($mesaj): ?>
                <div class="alert alert-danger"><?php echo htmlspecialchars($mesaj); ?></div>
            <?php endif; ?>

            <form method="POST" action="adauga_abonament.php">
                <div class="input-box">
                    <input type="text" name="nume_abonament" required>
                    <label for="nume_abonament">Nume abonament</label>
                </div>

                <div class="textarea-box">
                    <label for="descriere_abonament">Descriere</label>
                    <textarea name="descriere_abonament" rows="4" required></textarea>
                </div>

                <div class="input-box">
                    <input type="number" name="pret_abonament" step="0.01" required>
                    <label for="pret_abonament">Preț (RON)</label>
                </div>

                <button type="submit" class="btnn" style="background: rgb(155, 0, 0); color: white;">Adaugă</button>
            </form>
        </div>
    </div>
</div>

</div>
</body>
</html>
