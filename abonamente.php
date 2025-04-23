<?php
session_start();
require 'includes/database.php';

$mesaj = '';

if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit;
}

$user_id = $_SESSION['user_id'];

$stmt = $pdo->prepare("SELECT * FROM abonamente_utilizatori WHERE id_utilizator = ? AND data_expirare > NOW()");
$stmt->execute([$user_id]);
$abonament_activ = $stmt->fetch();

if ($abonament_activ) {
    $mesaj = "Ai deja un abonament activ până la data de " . date("d.m.Y", strtotime($abonament_activ['data_expirare'])) . ".";
}

$stmt = $pdo->query("SELECT * FROM abonamente");
$abonamente = $stmt->fetchAll();
?>

<!DOCTYPE html>
<html lang="ro">
<head>
    <meta charset="UTF-8">
    <title>Abonamente disponibile</title>

    <script src="https://kit.fontawesome.com/2b9c4ef431.js" crossorigin="anonymous"></script>
    <link rel="stylesheet" href="css/style.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.5/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-SgOJa3DmI69IUzQ2PVdRZhwQ+dy64/BUtbMJw1MZ8t5HZApcHrRKUc4W0kG879m7" crossorigin="anonymous">
</head>
<body>
<div class="container-fluid">

<?php include 'includes/navbar.php'; ?>

<div class="container-fluid pt-5" style="height:80vh">

<div class="container-fluid text-center">
    <h2>Abonamente disponibile</h2>

    <?php if ($mesaj): ?>
        <p style="color: green;"><?php echo htmlspecialchars($mesaj); ?></p>
    <?php endif; ?>
</div>

<div class="abonamente-cards fade-in">
    <?php foreach ($abonamente as $ab): ?>
        <?php
        $is_active = $abonament_activ && $abonament_activ['id_abonament'] == $ab['id'];
        ?>
        <div class="abonament-card">
            <h3><?php echo htmlspecialchars($ab['nume']); ?></h3>
            <p><?php echo htmlspecialchars($ab['descriere']); ?></p>
            <p><strong>Preț: </strong><?php echo $ab['pret']; ?> RON</p>
            <form method="POST" action="cumpara_abonament.php">
                <input type="hidden" name="id_abonament" value="<?php echo $ab['id']; ?>">
                <button type="submit" class="btn <?php echo $is_active ? 'btn-success' : 'btn-primary'; ?>" <?php echo $is_active ? 'disabled' : ''; ?>>
                    <?php echo $is_active ? 'Abonament activ' : 'Cumpără'; ?>
                </button>
            </form>
        </div>
    <?php endforeach; ?>
</div>
</div>
<?php include 'includes/footer.php'; ?>

</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.5/dist/js/bootstrap.bundle.min.js" integrity="sha384-k6d4wzSIapyDyv1kpU366/PK5hCdSbCRGRCMv+eplOQJWyd1fbcAu9OCUj5zNLiq" crossorigin="anonymous"></script>
</body>
</html>
