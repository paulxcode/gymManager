<?php
session_start();
if (!isset($_SESSION['user_id'])) {
    header('Location: login.php');
    exit();
}

require 'includes/database.php';

if (isset($_GET['id'])) {
    $user_id = $_SESSION['user_id'];
    $rezervare_id = $_GET['id'];

    $stmt = $pdo->prepare("SELECT * FROM rezervari WHERE id = ? AND id_utilizator = ?");
    $stmt->execute([$rezervare_id, $user_id]);
    $rezervare = $stmt->fetch();

    if ($rezervare) {
        $stmt = $pdo->prepare("DELETE FROM rezervari WHERE id = ?");
        $stmt->execute([$rezervare_id]);

        $_SESSION['message'] = 'Rezervarea a fost anulată cu succes!';
    } else {
        $_SESSION['message'] = 'Rezervarea nu a fost găsită sau nu îți aparține.';
    }

    header('Location: profil.php');
    exit();
} else {
    header('Location: profil.php');
    exit();
}
