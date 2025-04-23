<?php
session_start();

// Verificăm dacă utilizatorul este administrator
if (!isset($_SESSION['user_id']) || $_SESSION['rol'] !== 'admin') {
    header('Location: login.php');
    exit();
}

require 'includes/database.php';

$stmt = $pdo->prepare("
    SELECT u.id, u.nume, u.prenume, u.email, u.rol, a.nume AS abonament
    FROM utilizatori u
    LEFT JOIN abonamente_utilizatori au ON u.id = au.id_utilizator
    LEFT JOIN abonamente a ON au.id_abonament = a.id
    ORDER BY u.id ASC
");
$stmt->execute();
$utilizatori = $stmt->fetchAll();
?>

<!DOCTYPE html>
<html lang="ro">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Toți Utilizatorii - Panou Admin</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.5/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="css/style.css">
</head>
<body>

<div class="container-fluid">
    <?php include 'includes/navbar.php'; ?>

    <div class="container-fluid" style="height: 80vh;">
        <div class="container pt-5 fade-in">
            <h1>Toți Utilizatorii</h1>

            <table class="table table-dark table-bordered table-hover">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Nume</th>
                        <th>Prenume</th>
                        <th>Email</th>
                        <th>Rol</th>
                        <th>Abonament</th>
                        <th>Acțiuni</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($utilizatori as $utilizator): ?>
                        <tr>
                            <td><?php echo htmlspecialchars($utilizator['id']); ?></td>
                            <td><?php echo htmlspecialchars($utilizator['nume']); ?></td>
                            <td><?php echo htmlspecialchars($utilizator['prenume']); ?></td>
                            <td><?php echo htmlspecialchars($utilizator['email']); ?></td>
                            <td><?php echo htmlspecialchars($utilizator['rol']); ?></td>
                            <td>
                                <?php echo $utilizator['abonament'] ? htmlspecialchars($utilizator['abonament']) : 'Fără abonament'; ?>
                            </td>
                            <td>
                                <a href="modifica_utilizator.php?id=<?php echo $utilizator['id']; ?>" class="btn btn-sm btn-primary">Modifică</a>
                                <a href="sterge_utilizator.php?id=<?php echo $utilizator['id']; ?>" class="btn btn-sm btn-danger">Șterge</a>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    </div>

    <?php include 'includes/footer.php'; ?>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.5/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
