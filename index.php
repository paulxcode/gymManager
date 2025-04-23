<?php
require 'includes/auth.php'; 
require 'includes/database.php';

$user_id = $_SESSION['user_id'];
$rol = $_SESSION['rol'];
?>

<!DOCTYPE html>
<html>
<head>
    <title>Dashboard – Sala de Sport</title>
  


    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.5/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-SgOJa3DmI69IUzQ2PVdRZhwQ+dy64/BUtbMJw1MZ8t5HZApcHrRKUc4W0kG879m7" crossorigin="anonymous">
  
    <link rel="stylesheet" href="css/style.css">


</head>
<body>
    <div class="container-fluid" style="width: 100vw; min-height: 2000px;">

    <?php include 'includes/navbar.php'; ?>

    <div class="p-0 carousel-imgs">
        <div id="fitnessCarousel" class="carousel slide" data-bs-ride="carousel">
            <div class="carousel-inner">
                <div class="carousel-caption-overlay fade-in">
                    <h1>Bine ai venit la <span class="text-danger">GymManager</span></h1>
                    <p>Unde fiecare antrenament contează!</p>
                </div>

                <div class="carousel-item active">
                    <img src="assets/img/car2.jpg" class="d-block w-100" alt="Fitness 1">
                </div>
                <div class="carousel-item">
                    <img src="assets/img/car3.jpeg" class="d-block w-100" alt="Fitness 2">
                </div>
                <div class="carousel-item">
                    <img src="assets/img/car1.jpg" class="d-block w-100" alt="Fitness 3">
                </div>
            </div>
        </div>
    </div>

    <div class="container-fluid py-5 aboutus" style="background-color: black;">
        <div class="container">
            <div class="row align-items-center">
                <!-- Text -->
                <div class="col-lg-6 mb-4 mb-lg-0">
                    <h2 class="mb-4">Despre sala noastră</h2>
                    <p style="font-size: 1.1rem;">
                        Bine ai venit la <strong>GymManager</strong> – locul în care pasiunea pentru fitness prinde viață!
                        Dotată cu echipamente moderne, antrenori certificați și o atmosferă motivantă, sala noastră
                        este alegerea ideală pentru oricine își dorește să își atingă obiectivele personale într-un
                        mediu profesionist și prietenos.
                    </p>
                </div>
                <!-- Imagine -->
                <div class="col-lg-6">
                    <img src="assets/img/descimg.jpg" alt="Imagine sală" class="img-fluid rounded shadow">
                </div>
            </div>
        </div>
    </div>


    <div class="container-fluid py-5" style="background-color: darkred;">
        <div class="container">
            <h2 class="text-center text-white mb-5">Locațiile noastre</h2>
            <div class="row text-center">

                <!-- Locația 1 -->
                <div class="col-md-4 mb-4">
                    <div class="p-4 rounded shadow-sm h-100 card-locatie text-white">
                        <img src="assets/img/locatii/vaslui_centrul.jpg" alt="Vaslui Centru" class="mb-3">
                        <ion-icon name="location-sharp" class="text-primary" style="font-size: 2rem;"></ion-icon>
                        <h5 class="mt-3">Vaslui - Centru</h5>
                        <p>Str. Ștefan cel Mare nr. 45, Vaslui</p>
                    </div>
                </div>

                <!-- Locația 2 -->
                <div class="col-md-4 mb-4">
                    <div class="p-4 rounded shadow-sm h-100 card-locatie text-white">
                        <img src="assets/img/locatii/vaslui_est.jpg" alt="Vaslui Est" class="mb-3">
                        <ion-icon name="location-sharp" class="text-success" style="font-size: 2rem;"></ion-icon>
                        <h5 class="mt-3">Vaslui - Est</h5>
                        <p>Str. Traian nr. 12, Vaslui</p>
                    </div>
                </div>

                <!-- Locația 3 -->
                <div class="col-md-4 mb-4">
                    <div class="p-4 rounded shadow-sm h-100 card-locatie text-white">
                        <img src="assets/img/locatii/barlad.jpg" alt="Bârlad" class="mb-3">
                        <ion-icon name="location-sharp" class="text-warning" style="font-size: 2rem;"></ion-icon>
                        <h5 class="mt-3">Bârlad</h5>
                        <p>Str. Republicii nr. 78, Bârlad</p>
                    </div>
                </div>

            </div>
        </div>
    </div>

    <div class="container-fluid py-5 bg-black text-white">
        <div class="container">
            <h2 class="text-center mb-5">Programul locațiilor</h2>
            <div class="row text-center">

                <!-- Program Vaslui Centru -->
                <div class="col-md-4 mb-4">
                    <div class="p-4 rounded shadow card-program h-100" style="background-color: darkred;">
                        <ion-icon name="time-sharp" class="text-primary mb-2" style="font-size: 2rem;"></ion-icon>
                        <h5 class="mb-3">Vaslui - Centru</h5>
                        <p class="mb-1">Luni - Vineri: <span class="text-black">06:00 - 22:00</span></p>
                        <p class="mb-1">Sâmbătă: <span class="text-black">08:00 - 20:00</span></p>
                        <p>Duminică: <span class="text-black">08:00 - 18:00</span></p>
                    </div>
                </div>

                <!-- Program Vaslui Est -->
                <div class="col-md-4 mb-4">
                    <div class="p-4 rounded shadow card-program h-100" style="background-color: darkred;">
                        <ion-icon name="time-sharp" class="text-success mb-2" style="font-size: 2rem;"></ion-icon>
                        <h5 class="mb-3">Vaslui - Est</h5>
                        <p class="mb-1">Luni - Vineri: <span class="text-black">07:00 - 21:00</span></p>
                        <p class="mb-1">Sâmbătă: <span class="text-black">09:00 - 19:00</span></p>
                        <p>Duminică: <span class="text-black">09:00 - 17:00</span></p>
                    </div>
                </div>

                <!-- Program Bârlad -->
                <div class="col-md-4 mb-4">
                    <div class="p-4 rounded shadow card-program h-100" style="background-color: darkred;">
                        <ion-icon name="time-sharp" class="text-warning mb-2" style="font-size: 2rem;"></ion-icon>
                        <h5 class="mb-3">Bârlad</h5>
                        <p class="mb-1">Luni - Vineri: <span class="text-black">06:30 - 22:30</span></p>
                        <p class="mb-1">Sâmbătă: <span class="text-black">08:00 - 20:00</span></p>
                        <p>Duminică: <span class="text-black">08:00 - 18:00</span></p>
                    </div>
                </div>

            </div>
        </div>
    </div>


    <?php include 'includes/footer.php'; ?>


    <!-- end of page -->
    </div> 


    <script type="module" src="https://unpkg.com/ionicons@7.1.0/dist/ionicons/ionicons.esm.js"></script>
    <script nomodule src="https://unpkg.com/ionicons@7.1.0/dist/ionicons/ionicons.js"></script>

</body>
</html>
