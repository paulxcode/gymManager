<?php

session_start();

if (!isset($_SESSION['user_id'])) {
    header('Location: login.php'); 
    exit();
}


require 'includes/database.php';


$user_id = $_SESSION['user_id'];
$stmt = $pdo->prepare("SELECT u.id, u.nume, u.prenume, u.email FROM utilizatori u WHERE u.id = ?");
$stmt->execute([$user_id]);
$user = $stmt->fetch();



if (!$user) {
    header('Location: index.php'); 
    exit();
}

$stmt_programari = $pdo->prepare("SELECT programari.id, cursuri.nume AS curs_nume, programari.data_ora 
                                   FROM programari
                                   JOIN cursuri ON programari.id_curs = cursuri.id
                                   WHERE programari.id_utilizator = ?");
$stmt_programari->execute([$user_id]);
$programari = $stmt_programari->fetchAll();


$stmt_abonamente = $pdo->prepare("SELECT abonamente.nume, abonamente_utilizatori.data_expirare, abonamente_utilizatori.id AS abonament_id 
                                  FROM abonamente_utilizatori 
                                  JOIN abonamente ON abonamente_utilizatori.id_abonament = abonamente.id 
                                  WHERE abonamente_utilizatori.id_utilizator = ?");
$stmt_abonamente->execute([$user_id]);
$abonamente = $stmt_abonamente->fetchAll();

$abonamentActiv = false;
$abonamentId = null;
foreach ($abonamente as $abonament) {
    if (strtotime($abonament['data_expirare']) > time()) {
        $abonamentActiv = true;
        $abonamentId = $abonament['abonament_id'];
        break; 
    }
}

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['anulare_abonament'])) {
    $stmt_anulare = $pdo->prepare("DELETE FROM abonamente_utilizatori WHERE id = ?");
    $stmt_anulare->execute([$abonamentId]);

    header('Location: profil.php');
    exit();
}
?>

<!DOCTYPE html>
<html lang="ro">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Profil Utilizator - Sala de Sport</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.5/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-SgOJa3DmI69IUzQ2PVdRZhwQ+dy64/BUtbMJw1MZ8t5HZApcHrRKUc4W0kG879m7" crossorigin="anonymous">
    <link rel="stylesheet" href="css/style.css">
</head>
<body>

<div class="container-fluid">

<?php include 'includes/navbar.php'; ?>

<div class="container-fluid" style=" height: 80vh;">

    <div class="container fade-in pt-5">


        <h2>Salut, <?php echo htmlspecialchars($user['nume']); ?>!</h2>

        <div class="profil-info mb-5">
            <p><strong>Nume:</strong> <?php echo htmlspecialchars($user['nume']); ?></p>
            <p><strong>Prenume:</strong> <?php echo htmlspecialchars($user['prenume']); ?></p>
            <p><strong>Email:</strong> <?php  echo !empty($user['email']) ? htmlspecialchars($user['email']) : 'Email indisponibil'; ?></p>

            <!-- Afișăm abonamentele utilizatorului -->
            <p><strong>Abonament:</strong> 
                <?php 
                if (count($abonamente) > 0) {
                    foreach ($abonamente as $abonament) {
                        echo htmlspecialchars($abonament['nume']) . ' - Expiră pe: ' . date("d.m.Y", strtotime($abonament['data_expirare'])) . '<br>';
                    }
                } else {
                    echo 'Nu ai niciun abonament activ.';
                }
                ?>
            </p>

            <div class="mt-3">
                <a href="modifica_profil.php" class="btn-delete">Modifică Datele</a>
                <a href="logout.php" class="btn-delete">Deconectare</a>
            </div>

        </div>

        <!-- Verificăm dacă utilizatorul are un abonament activ și îl informăm despre cumpărarea unui altul -->
        <div class="mt-3">
            <?php if (!$abonamentActiv): ?>
                <a href="abonamente.php" class="btn-submit">Cumpără Abonament</a>
            <?php else: ?>
                <p>Ai deja un abonament activ. Nu poți cumpăra un altul până când acesta nu expiră.</p>
                <form method="POST">
                    <button type="submit" name="anulare_abonament" class="btn-delete">Anulează Abonamentul</button>
                </form>
            <?php endif; ?>
        </div>


        
        <!-- Programările utilizatorului -->
        <div class="mt-3 container">
            <h2>Programările Tale</h2>
            <?php if (count($programari) > 0): ?>
                <table class="table table-bordered table-dark">
                    <thead>
                        <tr>
                            <th>Curs</th>
                            <th>Data Programării</th>
                            <th>Acțiuni</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($programari as $programare): ?>
                            <tr>
                                <td><?php echo htmlspecialchars($programare['curs_nume']); ?></td>
                                <td><?php echo htmlspecialchars($programare['data_ora']); ?></td>
                                <td><a class="btn-delete" href="cancelare_programare.php?id=<?php echo $programare['id']; ?>">Anulează</a></td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            <?php else: ?>
                <p>Nu ai nicio programare.</p>
            <?php endif; ?>
        </div>
    </div>
</div>

<?php include 'includes/footer.php'; ?>

</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.5/dist/js/bootstrap.bundle.min.js" integrity="sha384-k6d4wzSIapyDyv1kpU366/PK5hCdSbCRGRCMv+eplOQJWyd1fbcAu9OCUj5zNLiq" crossorigin="anonymous"></script>

</body>
</html>
