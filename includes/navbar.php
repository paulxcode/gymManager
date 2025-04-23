<?php
if (isset($_SESSION['user_id'])) {
    require 'includes/database.php';

    $user_id = $_SESSION['user_id'];
    $stmt = $pdo->prepare("SELECT nume, prenume, rol FROM utilizatori WHERE id = ?");
    $stmt->execute([$user_id]);
    $user = $stmt->fetch();

    $nume = $user['nume'];
    $rol = $user['rol']; 
} else {
    $nume = 'Utilizator necunoscut';
    $rol = 'Invitat';
}
?>

<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.5/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-SgOJa3DmI69IUzQ2PVdRZhwQ+dy64/BUtbMJw1MZ8t5HZApcHrRKUc4W0kG879m7" crossorigin="anonymous">

<div class="container-fluid mb-5">
    <header> 
        <a href="index.php" class="logo">GymManager</a>

        <nav class="navigation">
            <a href="rezervari.php">Rezerva un curs</a>
            <?php if ($rol == 'admin'): ?>
                <a href="admin.php">Admin</a>
            <?php endif; ?>
            <a href="profil.php">Profil</a>
            <a href="abonamente.php">Abonamente</a>
        </nav>
    </header>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.5/dist/js/bootstrap.bundle.min.js" integrity="sha384-k6d4wzSIapyDyv1kpU366/PK5hCdSbCRGRCMv+eplOQJWyd1fbcAu9OCUj5zNLiq" crossorigin="anonymous"></script>
