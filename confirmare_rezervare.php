<?php
session_start();
if (!isset($_SESSION['user_id'])) {
    header('Location: login.php');
    exit();
}

require 'includes/database.php';

if (isset($_POST['curs_id']) && isset($_POST['data_dorita'])) {
    $user_id = $_SESSION['user_id'];
    $curs_id = $_POST['curs_id'];
    $data_dorita = $_POST['data_dorita'];

    $stmt = $pdo->prepare("SELECT * FROM cursuri WHERE id = ?");
    $stmt->execute([$curs_id]);
    $curs = $stmt->fetch();

    if (!$curs) {
        echo "Cursul selectat nu există.";
        exit();
    }

    $data_ora_programare = date('Y-m-d H:i:s'); 

    $stmt = $pdo->prepare("INSERT INTO programari (id_curs, id_utilizator, data_ora, data_dorita) VALUES (?, ?, ?, ?)");
    $stmt->execute([$curs_id, $user_id, $data_ora_programare, $data_dorita]);

    $_SESSION['message'] = 'Programarea a fost efectuată cu succes!';
    header('Location: profil.php');
    exit();
} else {
    echo "Date incomplete pentru programare.";
}
?>
