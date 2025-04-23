<?php
session_start();
require 'includes/database.php';

$eroare = '';
$succes = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $nume = trim($_POST['nume']);
    $prenume = trim($_POST['prenume']);
    $email = trim($_POST['email']);
    $parola = $_POST['parola'];
    $confirmare = $_POST['confirmare'];

    if (empty($nume) || empty($prenume) || empty($email) || empty($parola) || empty($confirmare)) {
        $eroare = "Toate câmpurile sunt obligatorii.";
    } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $eroare = "Email invalid.";
    } elseif ($parola !== $confirmare) {
        $eroare = "Parolele nu coincid.";
    } elseif (!preg_match("/^(?=.*[A-Za-z])(?=.*\d)(?=.*[!@#$%^&*])[A-Za-z\d!@#$%^&*]{8,}$/", $parola)) {
        $eroare = "Parola trebuie să conțină cel puțin 8 caractere, o literă mare, o literă mică și un simbol special (!@#$%^&*).";
    } else {
        $stmt = $pdo->prepare("SELECT id FROM utilizatori WHERE email = ?");
        $stmt->execute([$email]);

        if ($stmt->fetch()) {
            $eroare = "Emailul este deja folosit.";
        } else {
            $parola_hash = password_hash($parola, PASSWORD_DEFAULT);

            $stmt = $pdo->prepare("INSERT INTO utilizatori (nume, prenume, email, parola) VALUES (?, ?, ?, ?)");
            $stmt->execute([$nume, $prenume, $email, $parola_hash]);
            $succes = "Cont creat cu succes! Poți să te autentifici.";
        }
    }
}
?>

<!DOCTYPE html>
<html>
<head><title>Înregistrare</title>

<link rel="stylesheet" href="css/style.css">

<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.5/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-SgOJa3DmI69IUzQ2PVdRZhwQ+dy64/BUtbMJw1MZ8t5HZApcHrRKUc4W0kG879m7" crossorigin="anonymous">

</head>
<body>

<div class="container-fluid" style="background-image: url('assets/img/login_back.jpg'); background-size: cover; height: 100vh; display: flex; align-items: center; justify-content: center;">



<div class="wrapper" style="height:700px">
        <div class="form-container login">
            <h2>Inregistrare</h2>
            <?php if ($eroare): ?>
                <p style="color:red;"><?php echo $eroare; ?></p>
            <?php elseif ($succes): ?>
                <p style="color:green;"><?php echo $succes; ?></p>
            <?php endif; ?>
            <form method="post">

                <div class="input-box">
                    <span class="icon"><ion-icon name="person-outline"></ion-icon></span>
                    <input type="text" name="nume" required>
                    <Label>Nume</Label>
                </div>
                    <div class="input-box">
                    <span class="icon"><ion-icon name="person-outline"></ion-icon></span>
                    <input type="text" name="prenume" required>
                    <Label>Prenume</Label>
                </div>
                <div class="input-box">
                    <span class="icon"><ion-icon name="mail-outline"></ion-icon></span>
                    <input type="email" name="email" required>
                    <Label>Email</Label>
                </div>

                    <div class="input-box">
                    <span class="icon"><ion-icon name="lock-closed-outline"></ion-icon></span>
                    <input type="password" name="parola" required>
                    <Label>Parola</Label>
                </div>
                    <div class="input-box">
                    <span class="icon"><ion-icon name="lock-closed-outline"></ion-icon></span>
                    <input type="password" name="confirmare" required>
                    <Label>Confirma parola</Label>
                </div>
                <button class="btnn" type="submit">Înregistrare</button>
            
            </form>
            
            <div class="regloginswitch">
                <p>Ai cont? <a href="login.php">Autentifică-te</a></p>

            </div>






            
        </div>
    </div>



    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.5/dist/js/bootstrap.bundle.min.js" integrity="sha384-k6d4wzSIapyDyv1kpU366/PK5hCdSbCRGRCMv+eplOQJWyd1fbcAu9OCUj5zNLiq" crossorigin="anonymous"></script>
    <script type="module" src="https://unpkg.com/ionicons@7.1.0/dist/ionicons/ionicons.esm.js"></script>
    <script nomodule src="https://unpkg.com/ionicons@7.1.0/dist/ionicons/ionicons.js"></script>
</body>
</html>
