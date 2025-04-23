<?php

error_reporting(E_ALL);
ini_set('display_errors', 1);

session_start();
require 'includes/database.php';

if (isset($_SERVER['REQUEST_METHOD']) && $_SERVER['REQUEST_METHOD'] === 'POST') {
    $email = $_POST['email'];
    $parola = $_POST['parola'];

    $stmt = $pdo->prepare("SELECT * FROM utilizatori WHERE email = ?");
    $stmt->execute([$email]);
    $user = $stmt->fetch();

    if ($user && password_verify($parola, $user['parola'])) {
        $_SESSION['user_id'] = $user['id'];
        $_SESSION['rol'] = $user['rol'];
        header('Location: index.php');
        exit;
    } else {
        $error = "Email sau parolă incorecte.";
    }
}
?>

<!DOCTYPE html>
<html>
<head><title>Login</title>
<link rel="stylesheet" href="css/style.css">

<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.5/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-SgOJa3DmI69IUzQ2PVdRZhwQ+dy64/BUtbMJw1MZ8t5HZApcHrRKUc4W0kG879m7" crossorigin="anonymous">


</head>





<body>

<div class="container-fluid" style="background-image: url('assets/img/login_back.jpg'); background-size: cover; height: 100vh; display: flex; align-items: center; justify-content: center;">

    <div class="wrapper">
        <div class="form-container login">
            <h2>Autentificare</h2>
            <?php if (isset($error)) echo "<p style='color:red;'>$error</p>"; ?>
            
            <form method="post">
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
                <button class="btnn" type="submit">Login</button>
            
            </form>
            
            <div class="regloginswitch">
                <p>Nu ai cont? <a href="register.php">Înregistrează-te</a></p>

            </div>






            
        </div>
    </div>

</div>









    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.5/dist/js/bootstrap.bundle.min.js" integrity="sha384-k6d4wzSIapyDyv1kpU366/PK5hCdSbCRGRCMv+eplOQJWyd1fbcAu9OCUj5zNLiq" crossorigin="anonymous"></script>

    <script type="module" src="https://unpkg.com/ionicons@7.1.0/dist/ionicons/ionicons.esm.js"></script>
    <script nomodule src="https://unpkg.com/ionicons@7.1.0/dist/ionicons/ionicons.js"></script>


</body>
</html>
