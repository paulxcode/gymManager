<?php
session_start();

if (!isset($_SESSION['user_id'])) {
    header('Location: login.php');
    exit();
}

require 'includes/database.php';



$user_id = $_SESSION['user_id'];
$stmt = $pdo->prepare("SELECT nume, prenume, email FROM utilizatori WHERE id = ?");
$stmt->execute([$user_id]);
$user = $stmt->fetch();

if (!$user) {
    header('Location: index.php'); 
    exit();
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $nume = trim($_POST['nume']);
    $prenume = trim($_POST['prenume']);
    $email = trim($_POST['email']);

    $stmt = $pdo->prepare("UPDATE utilizatori SET nume = ?, prenume = ?, email = ? WHERE id = ?");
    $stmt->execute([$nume, $prenume, $email, $user_id]);

    $message = "Profilul a fost actualizat cu succes!";
}

?>

<!DOCTYPE html>
<html lang="ro">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Modifică Profil - Sala de Sport</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.5/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-SgOJa3DmI69IUzQ2PVdRZhwQ+dy64/BUtbMJw1MZ8t5HZApcHrRKUc4W0kG879m7" crossorigin="anonymous">
    
    <link rel="stylesheet" href="css/style.css">
</head>
<body>

<div class="container-fluid">

<?php include 'includes/navbar.php'; ?>


    <h1>Modifică Profilul</h1>

    <?php if (isset($message)): ?>
        <div class="success-message"><?php echo htmlspecialchars($message); ?></div>
    <?php endif; ?>

    <form action="modifica_profil.php" method="POST">
        <div class="form-group">
            <label for="nume">Nume:</label>
            <input type="text" id="nume" name="nume" value="<?php echo htmlspecialchars($user['nume']); ?>" required>
        </div>
        <div class="form-group">
            <label for="prenume">Prenume:</label>
            <input type="text" id="prenume" name="prenume" value="<?php echo htmlspecialchars($user['prenume']); ?>" required>
        </div>
        <div class="form-group">
            <label for="email">Email:</label>
            <input type="email" id="email" name="email" value="<?php echo htmlspecialchars($user['email']); ?>" required>
        </div>
        <button type="submit" class="btn-submit">Actualizează Profilul</button>
    </form>



    <?php include 'includes/footer.php'; ?>

    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.5/dist/js/bootstrap.bundle.min.js" integrity="sha384-k6d4wzSIapyDyv1kpU366/PK5hCdSbCRGRCMv+eplOQJWyd1fbcAu9OCUj5zNLiq" crossorigin="anonymous"></script>
</body>
</html>
