<?php
session_start();

if (!isset($_SESSION['user_id']) || $_SESSION['rol'] !== 'admin') {
    header('Location: index.php');  // Dacă nu este admin, redirecționăm spre index
    exit();
}

require 'includes/database.php';

if (isset($_GET['id'])) {
    $id_programare = $_GET['id'];

    $stmt = $pdo->prepare("DELETE FROM programari WHERE id = ?");
    $stmt->execute([$id_programare]);

    header('Location: admin.php');
    exit();
} else {
    header('Location: admin.php');
    exit();
}
?>
