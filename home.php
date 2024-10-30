<?php 
session_start();
require_once './config.php';
unset($_SESSION['active-menu']);
$_SESSION['active-menu'] = 'home';

$alternatif = $koneksi->query("SELECT * FROM alternatif");
$dataKriteria = $koneksi->query("SELECT * FROM kriteria");
$getKecAltKrit = $koneksi->query("SELECT *
                FROM kec_alt_kriteria kac 
                JOIN sub_kriteria sk ON sk.id_sub_kriteria=kac.f_id_sub_kriteria 
                JOIN kriteria k ON k.id_kriteria=kac.f_id_kriteria
                ORDER BY kac.f_id_alternatif, kac.f_id_kriteria;");

while ($row = $getKecAltKrit->fetch_object()) {
    $i = $row->f_id_alternatif;
    $j = $row->f_id_kriteria;
    $aij = $row->spesifikasi;
  
    $nilai1[$i][$j] = $aij;
  }
?>

<?php require './header.php';?>
<!-- Section: Design Block -->
<section class="">
    <!-- Jumbotron -->
    <hr class="mt-5 pt-4">
    <div class="px-5 py-5 px-md-5 text-center" style="background-color: hsl(0, 0%, 96%);">
        <div class="container" style="min-height:100vh;">
            <!-- Slider -->
            <div class="row gx-lg-5 align-items-center mb-5">
                <div id="carouselExampleAutoplaying" class="carousel slide" data-bs-ride="carousel">
                    <div class="carousel-inner">
                        <div class="carousel-item active">
                            <h4 class="display-6">Selamat Datang di </h4>
                            <h4 class="lead">Sistem Pendukung Keputusan Pemilihan Paket Resepsi Pernikahan di Kota
                                Kupang</h4>
                        </div>
                        <div class="carousel-item">
                            <h4 class="display-6">Metode yang digunakan.</h4>
                            <h4 class="lead">Sistem Pendukung Keputusan Pemilihan Paket Resepsi Pernikahan ini
                                menggunakan metode SMART</h4>
                        </div>
                        <div class="carousel-item">
                            <h4 class="display-6">Apa itu Metode SMART?</h4>
                            <h4 class="lead">Metode SMART adalah salah satu metode pengambilan keputusan multi
                                atribut yang pertama kali diperkenalkan oleh Edward pada tahun 1977 (Filho, 2005).
                            </h4>
                        </div>
                    </div>
                    <!-- Kontrol sebelumnya dan berikutnya -->
                    <button class="carousel-control-prev" type="button" data-bs-target="#carouselExampleAutoplaying"
                        data-bs-slide="prev">
                        <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                        <span class="visually-hidden">Previous</span>
                    </button>
                    <button class="carousel-control-next" type="button" data-bs-target="#carouselExampleAutoplaying"
                        data-bs-slide="next">
                        <span class="carousel-control-next-icon" aria-hidden="true"></span>
                        <span class="visually-hidden">Next</span>
                    </button>
                </div>
            </div>
            <!-- End Slider -->
            <hr>
            <!-- List of Cards -->
            <div class="col-12">
                <h3 class="text-start">Daftar Paket Resepsi Pernikahan</h3>
            </div>
            <div class="row row-cols-1 row-cols-md-3 g-4">
                <?php foreach ($alternatif as $key => $value):?>
                <div class="col" data-aos="fade-up" data-aos-duration="3000" data-aos-anchor-placement="center-bottom">
                    <div class="card h-100">
                        <img src="./images/<?=$value['gambar'];?>" class="card-img-top" alt="Card 1">
                        <div class="card-body">
                            <h5 class="card-title"><?=$value['nama_alternatif'];?></h5>
                            <ul class="list-group">
                                <li class="list-group-item"><strong>Konsep Gedung:</strong>
                                    <?=$value['konsep_gedung'];?></li>
                                <?php foreach ($dataKriteria as $key => $kriteria):?>
                                <li class="list-group-item"><strong><?=$kriteria['nama_kriteria'];?>:</strong>
                                    <?=$nilai1[$value['id_alternatif']][$kriteria['id_kriteria']]??'-';?></li>
                                <?php endforeach;?>
                            </ul>
                        </div>
                    </div>
                </div>
                <?php endforeach;?>
            </div>
            <!-- End List of Cards -->
        </div>
    </div>
    <!-- Jumbotron -->
</section>
<?php require 'footer.php'; ?>