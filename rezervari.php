<?php
session_start();
if (!isset($_SESSION['user_id'])) {
    header('Location: login.php');
    exit();
}

require 'includes/database.php';

$stmt = $pdo->prepare("SELECT * FROM cursuri");
$stmt->execute();
$cursuri = $stmt->fetchAll();
?>

<!DOCTYPE html>
<html lang="ro">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Rezervă un Curs</title>
 
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.5/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-SgOJa3DmI69IUzQ2PVdRZhwQ+dy64/BUtbMJw1MZ8t5HZApcHrRKUc4W0kG879m7" crossorigin="anonymous">
    <link rel="stylesheet" href="css/style.css">

    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/flatpickr/dist/flatpickr.min.css">
</head>
<body>

<div class="container-fluid">
    <?php include 'includes/navbar.php'; ?>

<div class="container-fluid pt-5" style=" height: 80vh;">

    <div class="container mt-5 fade-in redborder" style="max-width: 600px; border-radius:12px">
        <div class="card shadow-lg p-4 bg-black text-white">
            <h2 class="mb-4 text-center text-white">Rezervă un Curs</h2>
            
            <form action="detalii_rezervare.php" method="GET">
                <div class="mb-3">
                    <label for="curs" class="form-label">Alege cursul:</label>
                    <select name="curs_id" id="curs" class="form-select bg-black text-white" required>
                        <option value="" disabled selected>-- Selectează un curs --</option>
                        <?php foreach ($cursuri as $curs): ?>
                            <option value="<?php echo $curs['id']; ?>">
                                <?php echo htmlspecialchars($curs['nume']); ?> (<?php echo $curs['durata_minute']; ?> min)
                            </option>
                        <?php endforeach; ?>
                    </select>
                </div>

                <div class="mb-3 bg-black text-white">
                    <label for="data" class="form-label bg-black text-white">Alege data și ora:</label>
                    <input type="text" name="data_dorita" id="data" class="form-control bg-black text-white" required>
                </div>

                <?php if (!empty($cursuri)): ?>
                    <div class="form-text mb-3 text-white">
                        Selectează un curs din listă și o dată pentru a continua rezervarea.
                    </div>
                <?php else: ?>
                    <div class="alert alert-warning text-white" role="alert">
                        Nu există cursuri disponibile în acest moment.
                    </div>
                <?php endif; ?>

                <button type="submit" class="btn btn-danger">Rezervă acum</button>
            </form>
        </div>
    </div>
</div>

<?php include 'includes/footer.php'; ?>

</div>


<script src="https://cdn.jsdelivr.net/npm/flatpickr"></script>
<script>
    flatpickr("#data", {
        enableTime: true, 
        dateFormat: "Y-m-d H:i", 
        minDate: "today", 
    });
</script>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.5/dist/js/bootstrap.bundle.min.js" integrity="sha384-k6d4wzSIapyDyv1kpU366/PK5hCdSbCRGRCMv+eplOQJWyd1fbcAu9OCUj5zNLiq" crossorigin="anonymous"></script>

</body>
</html>
