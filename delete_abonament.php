<?php
session_start();

if (!isset($_SESSION['user_id']) || $_SESSION['rol'] !== 'admin') {
    header('Location: index.php');  
    exit();
}

require 'includes/database.php';

if (isset($_GET['id'])) {
    $id_abonament = $_GET['id'];

    $stmt = $pdo->prepare("DELETE FROM abonamente WHERE id = ?");
    $stmt->execute([$id_abonament]);

    header('Location: admin.php');
    exit();
} else {
    header('Location: admin.php');
    exit();
}
?>
