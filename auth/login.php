<?php 
session_start();
if(isset($_SESSION['login']) && $_SESSION['login'] == true && $_SESSION['level'] == "kepala"){
    header("Location: ../user/index.php");
}else if(isset($_SESSION['login']) && $_SESSION['login'] == true && $_SESSION['level'] == "admin") {
    header("Location: ../admin/index.php");
}
require_once '../config.php';

// Memproses inputan dari form login
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = $_POST["username"];
    $password = $_POST["password"];
    $result = $koneksi->query("SELECT * FROM admin WHERE username='$username'");
    if(mysqli_num_rows($result) > 0){
        $fetch = mysqli_fetch_assoc($result);
        $password_hash = password_verify($password, $fetch['password']);
       
        if ($password_hash && $fetch['level'] == "kepala") {
                $_SESSION['login'] = true;
                $_SESSION['username'] = $username;
                $_SESSION['level'] = $fetch['level']; 
                $_SESSION['id_admin'] = $fetch['id_admin']; 
                // Jika level nya admin, redirect ke halaman index.php
                header("Location: ../kepala/index.php");
                exit();
        }
        else if ($password_hash && $fetch['level'] == "admin") {
            $_SESSION['login'] = true;
            $_SESSION['username'] = $username;
            $_SESSION['level'] = $fetch['level']; 
            $_SESSION['id_admin'] = $fetch['id_admin']; 
            // Jika level nya admin, redirect ke halaman index.php
            header("Location: ../admin/index.php");
            exit();
            die;
        } 
        else {
            $_SESSION['error'] = 'Login Gagal';
        }
    }
    else {
        $_SESSION['error'] = 'Login Gagal';
    }
}

?>


<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-9ndCyUaIbzAi2FUVXJi0CjmCapSmO7SnpJef0486qhLnuZ2cdeRhO02iuK6FUUVM" crossorigin="anonymous" />
    <link rel="preconnect" href="https://fonts.googleapis.com" />
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin />
    <link
        href="https://fonts.googleapis.com/css2?family=Manrope:wght@400;700;800&family=Prompt&family=Righteous&family=Roboto:wght@500&display=swap"
        rel="stylesheet" />
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.min.css">
    <link href="../assets/DataTables/datatables.min.css" rel="stylesheet" />
</head>

<body>
    <?php if (isset($_SESSION['success'])): ?>
    <script>
    Swal.fire({
        title: 'Sukses!',
        text: '<?php echo $_SESSION['success']; ?>',
        icon: 'success',
        confirmButtonText: 'OK'
    });
    </script>
    <?php unset($_SESSION['success']); // Menghapus session setelah ditampilkan ?>
    <?php endif; ?>

    <?php if (isset($_SESSION['error'])): ?>
    <script>
    Swal.fire({
        title: 'Error!',
        text: '<?php echo $_SESSION['error']; ?>',
        icon: 'error',
        confirmButtonText: 'OK'
    });
    </script>
    <?php unset($_SESSION['error']); // Menghapus session setelah ditampilkan ?>
    <?php endif; ?>
    <!-- Section: Design Block -->
    <section class="">
        <!-- Jumbotron -->
        <div class="px-4 py-5 px-md-5 text-center text-lg-start" style="background-color: hsl(0, 0%, 96%)">
            <div class="container" style="height:100vh;">
                <div class="row gx-lg-5 align-items-center">
                    <h4 class="my-3 mt-4 text-center display-6 fw-bolder ls-tight">
                        SPK Pemilihan Paket Resepsi Pernikahan <br />
                    </h4>
                    <div class="d-flex justify-content-center">
                        <div class="col-lg-5 col-12 mb-5 mb-lg-0">
                            <div class="card position-relative mt-4">
                                <!-- Tambah posisi relatif pada card -->
                                <div class="icon-container position-absolute bg-light"
                                    style="top: -30px; left: 50%; transform: translateX(-50%);">
                                    <!-- Ikon orang -->
                                    <svg xmlns="http://www.w3.org/2000/svg" width="60" height="60" fill="currentColor"
                                        class="bi bi-person-circle" viewBox="0 0 16 16">
                                        <path d="M11 6a3 3 0 1 1-6 0 3 3 0 0 1 6 0" />
                                        <path fill-rule="evenodd"
                                            d="M0 8a8 8 0 1 1 16 0A8 8 0 0 1 0 8m8-7a7 7 0 0 0-5.468 11.37C3.242 11.226 4.805 10 8 10s4.757 1.225 5.468 2.37A7 7 0 0 0 8 1" />
                                    </svg>
                                </div>
                                <div class="card-body py-3 pt-5 px-md-5">
                                    <h2 class="mt-2 text-center mb-5">Login Admin</h2>
                                    <form method="post" action="">
                                        <!-- Email input -->
                                        <div class="form-outline mb-4">
                                            <label class="form-label" for="username">Username</label>
                                            <input type="text" id="username" required name="username"
                                                class="form-control" />
                                        </div>

                                        <!-- Password input -->
                                        <div class="form-outline mb-4">
                                            <label class="form-label" for="password">Password</label>
                                            <input type="password" id="password" required name="password"
                                                class="form-control" />
                                        </div>
                                        <!-- Submit button -->
                                        <button type="submit" name="login"
                                            class="btn px-2 py-2 col-12 btn-primary btn-block mb-2">
                                            Login
                                        </button>
                                        <div class="col-12 d-flex justify-content-center">
                                            <a href="">Kembali ke Beranda</a>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Jumbotron -->
    </section>
    <!-- Section: Design Block -->
    <footer class="bg-white text-center text-lg-start">
        <!-- Copyright -->
        <div class="text-center p-3" style="background-color: #F0F0F0;">
            © 2024. Copyright:
            SuperDodot
        </div>
        <!-- Copyright -->
    </footer>
</body>


</html>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"
    integrity="sha384-geWF76RCwLtnZ8qwWowPQNguL3RmwHVBC9FhGdlKrxdiJJigb/j/68SIy3Te4Bkz" crossorigin="anonymous">
</script>

<script src="../assets/DataTables/jquery.js"></script>
<script src="../assets/DataTables/datatables.min.js"></script>
<!-- Sweet Alert -->
<script>