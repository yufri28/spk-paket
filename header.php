<!DOCTYPE html>
<html>

<head>
    <title>SPK Paket Resepsi</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-9ndCyUaIbzAi2FUVXJi0CjmCapSmO7SnpJef0486qhLnuZ2cdeRhO02iuK6FUUVM" crossorigin="anonymous" />
    <link rel="preconnect" href="https://fonts.googleapis.com" />
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin />
    <link
        href="https://fonts.googleapis.com/css2?family=Manrope:wght@400;700;800&family=Prompt&family=Righteous&family=Roboto:wght@500&display=swap"
        rel="stylesheet" />
    <link rel="stylesheet" href="https://unpkg.com/aos@next/dist/aos.css" />
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <style>
    .carousel-inner img {
        height: 450px;
        object-fit: cover;
        filter: brightness(50%);
    }
    </style>
</head>

<body>
    <nav class="navbar navbar-expand-lg fixed-top bg-body-tertiary">
        <div class="container-fluid p-4">
            <a class="navbar-brand" style="font-family: 'Roboto', sans-serif;" href="#">SPK Paket Resepsi</a>
            <img class="img-fluid me-auto" style="width:30px; height: auto" src="./assets/img/icon.svg" alt="">
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav"
                aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav ms-auto">
                    <li class="nav-item">
                        <a class="nav-link <?=$_SESSION['active-menu'] == 'home'?'active':'';?>"
                            href="./index.php">Beranda</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link <?=$_SESSION['active-menu'] == 'pembobotan'?'active':'';?>"
                            href="./pembobotan.php">Pembobotan</a>
                    </li>
                    <li class="nav-item">
                        <?php if(isset($_SESSION['login'])):?>
                        <a class="nav-link" href="./auth/logout.php">Logout</a>
                        <?php else:?>
                        <a class="nav-link" href="./auth/login.php">Login</a>
                        <?php endif;?>
                    </li>
                </ul>
            </div>
        </div>
    </nav>