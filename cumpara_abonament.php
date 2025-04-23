<?php
session_start();
require 'includes/database.php';

if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

$user_id = $_SESSION['user_id'];

$stmt = $pdo->prepare("SELECT * FROM abonamente_utilizatori WHERE id_utilizator = ? AND data_expirare > NOW()");
$stmt->execute([$user_id]);
$abonament_activ = $stmt->fetch();

$mesaj = '';

if ($abonament_activ) {
    $mesaj = "Ai deja un abonament activ până la data de " . date("d.m.Y", strtotime($abonament_activ['data_expirare'])) . ". Nu poți cumpăra un nou abonament până la expirarea celui actual.";
} else {
    if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['id_abonament'])) {
        $id_abonament = $_POST['id_abonament'];

        $stmt_abonament = $pdo->prepare("SELECT * FROM abonamente WHERE id = ?");
        $stmt_abonament->execute([$id_abonament]);
        $abonament = $stmt_abonament->fetch();

        if ($abonament) {
            $data_expirare = date("Y-m-d", strtotime("+30 days"));

            $stmt_insert = $pdo->prepare("INSERT INTO abonamente_utilizatori (id_utilizator, id_abonament, data_achizitie, data_expirare) VALUES (?, ?, NOW(), ?)");
            $stmt_insert->execute([$user_id, $abonament['id'], $data_expirare]);

            $mesaj = "Abonamentul tău a fost cumpărat cu succes! Acesta va expira pe data de " . date("d.m.Y", strtotime($data_expirare)) . ".";
        } else {
            $mesaj = "Abonamentul selectat nu există.";
        }
    }
}
?>

<!DOCTYPE html>
<html lang="ro">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cumpără Abonament</title>
    <link rel="stylesheet" href="css/style.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.5/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>

<div class="container-fluid">
<?php include 'includes/navbar.php'; ?>

<div class="container text-center" style="height:100vh;">

    <h2 class="mt-4">Cumpără Abonament</h2>

    <?php if (!empty($mesaj)): ?>
        <div class="alert alert-<?php echo $abonament_activ ? 'warning' : 'success'; ?>">
            <?php echo htmlspecialchars($mesaj); ?>
        </div>
    <?php endif; ?>

    <div class="abonament-cumpărare">
        <?php
        if (!$abonament_activ && isset($_GET['id_abonament'])) {
            $id_abonament = $_GET['id_abonament'];

            $stmt_abonament = $pdo->prepare("SELECT * FROM abonamente WHERE id = ?");
            $stmt_abonament->execute([$id_abonament]);
            $abonament = $stmt_abonament->fetch();

            if ($abonament):
        ?>
                <div class="abonament-details">
                    <h3><?php echo htmlspecialchars($abonament['nume']); ?></h3>
                    <p><?php echo htmlspecialchars($abonament['descriere']); ?></p>
                    <p><strong>Preț: </strong><?php echo $abonament['pret']; ?> RON</p>

                    <form method="POST" action="cumpara_abonament.php">
                        <input type="hidden" name="id_abonament" value="<?php echo $abonament['id']; ?>">
                        <button type="submit" class="btn btn-primary">Cumpără</button>
                    </form>
                </div>
        <?php
            endif;
        }
        ?>
    </div>

    <a href="abonamente.php" class="btn btn-secondary">Înapoi la Abonamente</a>
    </div>

    <?php include 'includes/footer.php'; ?>

</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.5/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
