<?php 
session_start();
unset($_SESSION['menu']);
$_SESSION['menu'] = 'index';
?>
<?php 
require './header.php';
require_once './functions/data_alternatif.php';
require_once './functions/kriteria.php';
require_once './functions/sub_kriteria.php';

$dataAlternatif = $Alternatif->getAlternatif();
$data_Kriteria = $Kriteria->getKriteria();
$data_SubKriteria = $Sub_Kriteria->getSubKriteria();

?>
<div class="row">
    <!-- Area Chart -->
    <div class="col-lg-12 mb-3">
        <div class="row">
            <div class="col-lg-10 welcome mb-lg-3">
                <h3>Selamat datang di Halaman Admin SPK Pemilihan Paket Resepsi Pernikahan!</h3>
            </div>
            <div class="col-lg-4">
                <div class="card">
                    <div class="card-body">
                        <h1 class="card-title"><?=mysqli_num_rows($dataAlternatif);?></h1>
                        <p class="card-text">Alternatif</p>
                    </div>
                </div>
            </div>
            <div class="col-lg-4">
                <div class="card">
                    <div class="card-body">
                        <h1 class="card-title"><?=mysqli_num_rows($data_Kriteria);?></h1>
                        <p class="card-text">Kriteria</p>
                    </div>
                </div>
            </div>
            <div class="col-lg-4">
                <div class="card">
                    <div class="card-body">
                        <h1 class="card-title"><?=mysqli_num_rows($data_SubKriteria);?></h1>
                        <p class="card-text">Subkriteria</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<?php require './footer.php';?>