<?php
require_once 'config.php';
$sql = "SELECT * FROM admin WHERE level='admin'";
$res = $koneksi->query($sql);
if($res->num_rows < 1){
    $password_hash = password_hash("admin",PASSWORD_BCRYPT);
    $sql2 = "INSERT INTO admin (id_admin,username,password,level) VALUES (null,'admin','$password_hash','admin')";
    $result2 = $koneksi->query($sql2);
}

$sqlkepala = "SELECT * FROM admin WHERE level='kepala'";
$reskepala = $koneksi->query($sqlkepala);
if($reskepala->num_rows < 1){
    $password_hash = password_hash("kepala",PASSWORD_BCRYPT);
    $sqlkepala2 = "INSERT INTO admin (id_admin,username,password,level) VALUES (null,'kepala','$password_hash','kepala')";
    $resultkepala2 = $koneksi->query($sqlkepala2);
}
// Mengambil URL yang dikirimkan melalui aturan rewriting
$url = isset($_GET['url']) ? $_GET['url'] : '';

// Mengonversi URL menjadi array dengan memisahkan setiap segment
$urlSegments = explode('/', rtrim($url, '/'));

// Menentukan halaman yang akan ditampilkan berdasarkan URL
if (empty($urlSegments[0])) {
    // Jika URL kosong, tampilkan halaman beranda
    require_once 'home.php';
} elseif ($urlSegments[0] === 'admin') {
    // Jika URL dimulai dengan "admin", arahkan ke halaman admin
    require_once 'admin/' . $urlSegments[1] . '.php';
} elseif ($urlSegments[0] === 'user') {
    // Jika URL dimulai dengan "user", arahkan ke halaman pengguna biasa
    require_once 'user/views/' . $urlSegments[1];
} else {
    // Jika URL tidak cocok dengan kondisi di atas, tampilkan halaman 404
    require_once '404.php';
}