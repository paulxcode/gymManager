<?php
session_start();  

if (!isset($_SESSION['user_id']) || $_SESSION['rol'] !== 'admin') {
    header('Location: index.php');  
    exit();
}

require 'includes/database.php';

// Preia cursurile disponibile
$stmt = $pdo->prepare("SELECT * FROM cursuri");
$stmt->execute();
$cursuri = $stmt->fetchAll();

// Preia programările și data dorită
$stmt_programari = $pdo->prepare("SELECT programari.id, cursuri.nume AS curs_nume, programari.data_ora, programari.capacitate_maxima, programari.data_dorita 
                                   FROM programari 
                                   JOIN cursuri ON programari.id_curs = cursuri.id");
$stmt_programari->execute();
$programari = $stmt_programari->fetchAll();

// Preia abonamentele disponibile
$stmt_abonamente = $pdo->prepare("SELECT * FROM abonamente");
$stmt_abonamente->execute();
$abonamente = $stmt_abonamente->fetchAll();
?>

<!DOCTYPE html>
<html lang="ro">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin - Sala de Sport</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.5/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-SgOJa3DmI69IUzQ2PVdRZhwQ+dy64/BUtbMJw1MZ8t5HZApcHrRKUc4W0kG879m7" crossorigin="anonymous">
    
    <link rel="stylesheet" href="css/style.css">
</head>
<body>

<div class="container-fluid">

<?php include 'includes/navbar.php'; ?>

<div class="admin-panel fade-in">

<h1>Panou Admin</h1>

<a href="toti_utilizatori.php" class="btn btn-danger">Vezi Toți Utilizatorii</a>

<h2>Cursuri Disponibile</h2>
<table class="table table-dark table-striped">
    <thead>
        <tr>
            <th>Nume Curs</th>
            <th>Descriere</th>
            <th>Durată (minute)</th>
            <th>Acțiuni</th>
        </tr>
    </thead>
    <tbody>
        <?php foreach ($cursuri as $curs): ?>
            <tr>
                <td><?php echo htmlspecialchars($curs['nume']); ?></td>
                <td><?php echo htmlspecialchars($curs['descriere']); ?></td>
                <td><?php echo htmlspecialchars($curs['durata_minute']); ?></td>
                <td><a class="btn btn-sm btn-primary" href="edit_curs.php?id=<?php echo $curs['id']; ?>">Editează</a> | 
                    <a class="btn btn-sm btn-danger" href="delete_curs.php?id=<?php echo $curs['id']; ?>">Șterge</a></td>
            </tr>
        <?php endforeach; ?>
    </tbody>
</table>

<a href="adauga_curs.php" class="btn btn-danger">Adaugă Curs Nou</a>

<h2>Programări</h2>
<table class="table table-dark table-striped">
    <thead>
        <tr>
            <th>Curs</th> 
            <th>Data</th>
            <th>Data Dorită</th> 
            <th>Capacitate Maximă</th>
            <th>Acțiuni</th>
        </tr>
    </thead>
    <tbody>
        <?php foreach ($programari as $programare): ?>
            <tr>
                <td><?php echo htmlspecialchars($programare['curs_nume']); ?></td>
                <td><?php echo htmlspecialchars($programare['data_ora']); ?></td>
                <td><?php echo htmlspecialchars($programare['data_dorita']); ?></td> 
                <td><?php echo htmlspecialchars($programare['capacitate_maxima']); ?></td>
                <td><a class="btn btn-sm btn-primary" href="edit_programare.php?id=<?php echo $programare['id']; ?>">Editează</a> | 
                    <a class="btn btn-sm btn-danger" href="delete_programare.php?id=<?php echo $programare['id']; ?>">Șterge</a></td>
            </tr>
        <?php endforeach; ?>
    </tbody>
</table>

<h2>Abonamente Disponibile</h2>
<table class="table table-dark table-striped">
    <thead>
        <tr>
            <th>Nume Abonament</th>
            <th>Descriere</th>
            <th>Preț (RON)</th>
            <th>Acțiuni</th>
        </tr>
    </thead>
    <tbody>
        <?php foreach ($abonamente as $abonament): ?>
            <tr>
                <td><?php echo htmlspecialchars($abonament['nume']); ?></td>
                <td><?php echo htmlspecialchars($abonament['descriere']); ?></td>
                <td><?php echo htmlspecialchars($abonament['pret']); ?></td>
                <td><a class="btn btn-sm btn-primary" href="edit_abonament.php?id=<?php echo $abonament['id']; ?>">Editează</a> | 
                    <a class="btn btn-sm btn-danger"href="delete_abonament.php?id=<?php echo $abonament['id']; ?>">Șterge</a></td>
            </tr>
        <?php endforeach; ?>
    </tbody>
</table>

<a href="adauga_abonament.php" class=" btn btn-danger">Adaugă Abonament Nou</a>
<a href="raport_abonamente.php" class="btn btn-primary">Vezi raportul abonamentelor</a>
</div>

<?php include 'includes/footer.php'; ?>

</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.5/dist/js/bootstrap.bundle.min.js" integrity="sha384-k6d4wzSIapyDyv1kpU366/PK5hCdSbCRGRCMv+eplOQJWyd1fbcAu9OCUj5zNLiq" crossorigin="anonymous"></script>

</body>
</html>
