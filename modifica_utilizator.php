<?php
session_start();

if (!isset($_SESSION['user_id']) || $_SESSION['rol'] !== 'admin') {
    header('Location: login.php');
    exit();
}

require 'includes/database.php';

if (isset($_GET['id'])) {
    $id_utilizator = $_GET['id'];

    $stmt = $pdo->prepare("SELECT u.id, u.nume, u.prenume, u.email, u.rol, a.id AS id_abonament, a.nume AS abonament
                           FROM utilizatori u
                           LEFT JOIN abonamente_utilizatori au ON u.id = au.id_utilizator
                           LEFT JOIN abonamente a ON au.id_abonament = a.id
                           WHERE u.id = ?");
    $stmt->execute([$id_utilizator]);
    $utilizator = $stmt->fetch();

    if (!$utilizator) {
        echo "Utilizatorul nu a fost găsit.";
        exit();
    }
} else {
    echo "ID-ul utilizatorului nu a fost specificat.";
    exit();
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $nume = $_POST['nume'];
    $prenume = $_POST['prenume'];
    $email = $_POST['email'];
    $rol = $_POST['rol'];
    $id_abonament = $_POST['abonament'];

    $stmt = $pdo->prepare("UPDATE utilizatori SET nume = ?, prenume = ?, email = ?, rol = ? WHERE id = ?");
    $stmt->execute([$nume, $prenume, $email, $rol, $id_utilizator]);

    if ($id_abonament) {
        $stmt = $pdo->prepare("REPLACE INTO abonamente_utilizatori (id_utilizator, id_abonament) VALUES (?, ?)");
        $stmt->execute([$id_utilizator, $id_abonament]);
    } else {
        $stmt = $pdo->prepare("DELETE FROM abonamente_utilizatori WHERE id_utilizator = ?");
        $stmt->execute([$id_utilizator]);
    }

    header('Location: toti_utilizatorii.php');
    exit();
}

$stmt = $pdo->prepare("SELECT id, nume FROM abonamente");
$stmt->execute();
$abonamente = $stmt->fetchAll();
?>

<!DOCTYPE html>
<html lang="ro">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Modifică Utilizator - Panou Admin</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.5/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="css/style.css">
</head>
<body>

<div class="container-fluid">
    <?php include 'includes/navbar.php'; ?>

    <div class="container pt-5">
        <h1>Modifică Utilizatorul</h1>

        <form action="modifica_utilizator.php?id=<?php echo $utilizator['id']; ?>" method="POST">
            <div class="mb-3">
                <label for="nume" class="form-label">Nume</label>
                <input type="text" class="form-control" id="nume" name="nume" value="<?php echo htmlspecialchars($utilizator['nume']); ?>" required>
            </div>

            <div class="mb-3">
                <label for="prenume" class="form-label">Prenume</label>
                <input type="text" class="form-control" id="prenume" name="prenume" value="<?php echo htmlspecialchars($utilizator['prenume']); ?>" required>
            </div>

            <div class="mb-3">
                <label for="email" class="form-label">Email</label>
                <input type="email" class="form-control" id="email" name="email" value="<?php echo htmlspecialchars($utilizator['email']); ?>" required>
            </div>

            <div class="mb-3">
                <label for="rol" class="form-label">Rol</label>
                <select class="form-select" id="rol" name="rol" required>
                    <option value="client" <?php if ($utilizator['rol'] === 'client') echo 'selected'; ?>>Client</option>
                    <option value="admin" <?php if ($utilizator['rol'] === 'admin') echo 'selected'; ?>>Admin</option>
                </select>
            </div>

            <div class="mb-3">
                <label for="abonament" class="form-label">Abonament</label>
                <select class="form-select" id="abonament" name="abonament">
                    <option value="">Fără Abonament</option>
                    <?php foreach ($abonamente as $abonament): ?>
                        <option value="<?php echo $abonament['id']; ?>" <?php if ($utilizator['id_abonament'] == $abonament['id']) echo 'selected'; ?>>
                            <?php echo htmlspecialchars($abonament['nume']); ?>
                        </option>
                    <?php endforeach; ?>
                </select>
            </div>

            <button type="submit" class="btn btn-danger">Salvează Modificările</button>
        </form>
    </div>

    <?php include 'includes/footer.php'; ?>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.5/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
