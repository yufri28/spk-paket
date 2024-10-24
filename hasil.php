<?php 
session_start();
require_once './config.php';

unset($_SESSION['active-menu']);
$_SESSION['active-menu'] = 'pembobotan';
require './header.php';
$data_kriteria = $koneksi->query("SELECT * FROM `kriteria`");

if (!isset($_POST['hasil-perengkingan'])) {
    echo "
    <script>
        Swal.fire({
            icon: 'error',
            title: 'Oops...',
            text: 'Harap mengisi bobot kriteria terlebih dahulu!',
            confirmButtonText: 'OK'
        }).then(function(result) {
            if (result.isConfirmed) {
                window.location.href = './pembobotan.php';
            }
        });
    </script>
    ";
    exit;
}


$data_alternatif = $koneksi->query(
    "SELECT a.nama_alternatif, a.id_alternatif, a.gambar, 
        a.alamat, a.latitude, a.longitude,a.konsep_gedung,a.harga_sewa,a.fasilitas,
        a.kapasitas_tamu, a.kapasitas_parkir,
        MAX(CASE WHEN k.id_kriteria = 'C1' THEN sk.bobot_sub_kriteria END) AS C1,
        MAX(CASE WHEN k.id_kriteria = 'C2' THEN sk.bobot_sub_kriteria END) AS C2,
        MAX(CASE WHEN k.id_kriteria = 'C3' THEN sk.bobot_sub_kriteria END) AS C3,
        MAX(CASE WHEN k.id_kriteria = 'C4' THEN sk.bobot_sub_kriteria END) AS C4,
        MAX(CASE WHEN k.id_kriteria = 'C1' THEN sk.nama_sub_kriteria END) AS nama_C1,
        MAX(CASE WHEN k.id_kriteria = 'C2' THEN sk.nama_sub_kriteria END) AS nama_C2,
        MAX(CASE WHEN k.id_kriteria = 'C3' THEN sk.nama_sub_kriteria END) AS nama_C3,
        MAX(CASE WHEN k.id_kriteria = 'C4' THEN sk.nama_sub_kriteria END) AS nama_C4
        FROM alternatif a
        JOIN kec_alt_kriteria kak ON a.id_alternatif = kak.f_id_alternatif
        JOIN sub_kriteria sk ON kak.f_id_sub_kriteria = sk.id_sub_kriteria
        JOIN kriteria k ON kak.f_id_kriteria = k.id_kriteria
        GROUP BY a.nama_alternatif
        UNION ALL
        SELECT 'min', NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,
        MIN(CASE WHEN k.id_kriteria = 'C1' THEN sk.bobot_sub_kriteria END) AS C1,
        MIN(CASE WHEN k.id_kriteria = 'C2' THEN sk.bobot_sub_kriteria END) AS C2,
        MIN(CASE WHEN k.id_kriteria = 'C3' THEN sk.bobot_sub_kriteria END) AS C3,
        MIN(CASE WHEN k.id_kriteria = 'C4' THEN sk.bobot_sub_kriteria END) AS C4,
        NULL AS nama_C1,
        NULL AS nama_C2,
        NULL AS nama_C3,
        NULL AS nama_C4
        FROM alternatif a
        JOIN kec_alt_kriteria kak ON a.id_alternatif = kak.f_id_alternatif
        JOIN sub_kriteria sk ON kak.f_id_sub_kriteria = sk.id_sub_kriteria
        JOIN kriteria k ON kak.f_id_kriteria = k.id_kriteria
        UNION ALL
        SELECT 'max', NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,
        MAX(CASE WHEN k.id_kriteria = 'C1' THEN sk.bobot_sub_kriteria END) AS C1,
        MAX(CASE WHEN k.id_kriteria = 'C2' THEN sk.bobot_sub_kriteria END) AS C2,
        MAX(CASE WHEN k.id_kriteria = 'C3' THEN sk.bobot_sub_kriteria END) AS C3,
        MAX(CASE WHEN k.id_kriteria = 'C4' THEN sk.bobot_sub_kriteria END) AS C4,
        NULL AS nama_C1,
        NULL AS nama_C2,
        NULL AS nama_C3,
        NULL AS nama_C4
        FROM alternatif a
        JOIN kec_alt_kriteria kak ON a.id_alternatif = kak.f_id_alternatif
        JOIN sub_kriteria sk ON kak.f_id_sub_kriteria = sk.id_sub_kriteria
        JOIN kriteria k ON kak.f_id_kriteria = k.id_kriteria;
");

$konsep_gedung = null;
$normalized_harga_sewa = 0;
$normalized_fasilitas = 0;
$normalized_kapasitas_tamu = 0;
$normalized_kapasitas_parkir = 0;
$C1_min = 0; 
$C1_max = 0; 
$C2_min = 0; 
$C2_max = 0; 
$C3_min = 0; 
$C3_max = 0; 
$C4_min = 0;
$C4_max = 0;

if (isset($_POST['hasil-perengkingan'])) {
    // Sanitize and cast inputs
    $konsep_gedung = htmlspecialchars($_POST['konsep_gedung']);
    $harga_sewa = floatval($_POST['harga_sewa']);
    $fasilitas = floatval($_POST['fasilitas']);
    $kapasitas_tamu = floatval($_POST['kapasitas_tamu']);
    $kapasitas_parkir = floatval($_POST['kapasitas_parkir']);
    
    // Calculate the total sum once to avoid repetition
    $total = $harga_sewa + $fasilitas + $kapasitas_tamu + $kapasitas_parkir;

    if ($total > 0) {
        // Normalize each criterion
        $normalized_harga_sewa = $harga_sewa / $total;
        $normalized_fasilitas = $fasilitas / $total;
        $normalized_kapasitas_tamu = $kapasitas_tamu / $total;
        $normalized_kapasitas_parkir = $kapasitas_parkir / $total;
    } else {
       
        echo "
        <script>
            Swal.fire({
                icon: 'error',
                title: 'Oops...',
                text: 'Harap periksa kembali inputan anda!',
                confirmButtonText: 'OK'
            }).then(function(result) {
                if (result.isConfirmed) {
                    window.location.href = './pembobotan.php';
                }
            });
        </script>
        ";
    }
}


// Fetch all rows into an array first
$data_alternatif_rows = [];
while ($row = mysqli_fetch_assoc($data_alternatif)) {
    if($row['nama_alternatif'] != 'min' && $row['nama_alternatif'] != 'max'){
        if($konsep_gedung != null){
            if($row['konsep_gedung'] == $konsep_gedung){
                $data_alternatif_rows[] = $row;
            }
        }else{
            $data_alternatif_rows[] = $row;
        }
    }
}

if(empty($data_alternatif_rows)){
    echo "
        <script>
            Swal.fire({
                icon: 'error',
                title: 'Oops...',
                text: 'Konsep gedung yang anda cari tidak ada!',
                confirmButtonText: 'OK'
            }).then(function(result) {
                if (result.isConfirmed) {
                    window.location.href = './pembobotan.php';
                }
            });
        </script>
        ";
}

// Bobot untuk tiap kriteria
$bobot = ['C1' => $normalized_harga_sewa, 'C2' => $normalized_fasilitas, 'C3' => $normalized_kapasitas_tamu, 'C4' => $normalized_kapasitas_parkir];

// Normalisasi data berdasarkan tipe kriteria (Cost atau Benefit)
$C1_values = $C2_values = $C3_values = $C4_values = [];

foreach ($data_alternatif_rows as $alternatif) {
    if($alternatif['nama_alternatif'] != 'min' && $alternatif['nama_alternatif'] != 'max'){
        $C1_values[] = $alternatif['C1']; 
        $C2_values[] = $alternatif['C2']; 
        $C3_values[] = $alternatif['C3']; 
        $C4_values[] = $alternatif['C4'];
    }
}

$C1_min = min($C1_values); 
$C1_max = max($C1_values); 
$C2_min = min($C2_values); 
$C2_max = max($C2_values); 
$C3_min = min($C3_values); 
$C3_max = max($C3_values); 
$C4_min = min($C4_values);
$C4_max = max($C4_values);

// foreach ($data_alternatif_rows as &$alternatif) {
//     if($alternatif['nama_alternatif'] != 'min' || $alternatif['nama_alternatif'] != 'max'){
//         // Normalisasi untuk Cost (Semakin kecil semakin baik)
//         $alternatif['N_C1'] = $C1_minmax / $alternatif['C1'];
        
//         // Normalisasi untuk Benefit (Semakin besar semakin baik)
//         $alternatif['N_C2'] = $alternatif['C2'] / $C2_minmax;
//         $alternatif['N_C3'] = $alternatif['C3'] / $C3_minmax;
//         $alternatif['N_C4'] = $alternatif['C4'] / $C4_minmax;

//         // Hitung nilai utilitas (nilai normalisasi dikali bobot)
//         $alternatif['total'] = (
//             $alternatif['N_C1'] * $bobot['C1'] +
//             $alternatif['N_C2'] * $bobot['C2'] +
//             $alternatif['N_C3'] * $bobot['C3'] +
//             $alternatif['N_C4'] * $bobot['C4']
//         );
//     }
// }

foreach ($data_alternatif_rows as &$alternatif) {
        // Normalisasi untuk Cost (Semakin kecil semakin baik)
        $alternatif['N_C1'] = ($C1_max - $alternatif['C1']) / ($C1_max - $C1_min);
        
        // Normalisasi untuk Benefit (Semakin besar semakin baik)
        $alternatif['N_C2'] = ($alternatif['C2'] - $C2_min) / ($C2_max - $C2_min);
        $alternatif['N_C3'] = ($alternatif['C3'] - $C3_min) / ($C3_max - $C3_min);
        $alternatif['N_C4'] = ($alternatif['C4'] - $C4_min) / ($C4_max - $C4_min);

        // Hitung nilai utilitas (nilai normalisasi dikali bobot)
        $alternatif['total'] = (
            $alternatif['N_C1'] * $bobot['C1'] +
            $alternatif['N_C2'] * $bobot['C2'] +
            $alternatif['N_C3'] * $bobot['C3'] +
            $alternatif['N_C4'] * $bobot['C4']
        );
    
}


// Urutkan berdasarkan nilai total
usort($data_alternatif_rows, function ($a, $b) {
    return $b['total'] <=> $a['total'];
});

$i = 0;
?>

<!-- Section: Design Block -->
<section class="">
    <!-- Jumbotron -->
    <hr class="mt-5 pt-4">
    <div class="px-5 py-5 px-md-5 text-center" style="background-color: hsl(0, 0%, 96%);">
        <div class="container" style="min-height:100vh;">
            <!-- List of Cards -->
            <div class="col-12">
                <h2 class="text-center">Hasil Perangkingan Paket Resepsi Pernikahan</h2>
            </div>
            <div class="row row-cols-1 row-cols-md-3 g-4">
                <?php foreach ($data_alternatif_rows as $key => $value):?>
                <div class="col" data-aos="fade-up" data-aos-duration="3000" data-aos-anchor-placement="center-bottom">
                    <div class="card h-100">
                        <img src="./images/<?=$value['gambar'];?>" class="card-img-top" alt="Card 1">
                        <div class="card-body">
                            <h5 class="card-title"><?=$value['nama_alternatif'];?></h5>
                            <p class="card-text">Rangking ke - <?= ++$i;?> (<?= number_format($value['total'], 3); ?>)
                            </p>
                            <button type="button" class="btn btn-primary" data-bs-toggle="modal"
                                data-bs-target="#exampleModal<?=$value['id_alternatif'];?>">
                                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor"
                                    class="bi bi-layout-text-sidebar-reverse" viewBox="0 0 16 16">
                                    <path
                                        d="M12.5 3a.5.5 0 0 1 0 1h-5a.5.5 0 0 1 0-1zm0 3a.5.5 0 0 1 0 1h-5a.5.5 0 0 1 0-1zm.5 3.5a.5.5 0 0 0-.5-.5h-5a.5.5 0 0 0 0 1h5a.5.5 0 0 0 .5-.5m-.5 2.5a.5.5 0 0 1 0 1h-5a.5.5 0 0 1 0-1z" />
                                    <path
                                        d="M16 2a2 2 0 0 0-2-2H2a2 2 0 0 0-2 2v12a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2zM4 1v14H2a1 1 0 0 1-1-1V2a1 1 0 0 1 1-1zm1 0h9a1 1 0 0 1 1 1v12a1 1 0 0 1-1 1H5z" />
                                </svg>
                            </button>
                            <a target="_blank"
                                href="https://www.google.com/maps/dir/?api=1&destination=<?=$value['latitude'];?>,<?=$value['longitude'];?>"
                                class="btn btn-success">
                                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor"
                                    class="bi bi-geo-alt" viewBox="0 0 16 16">
                                    <path
                                        d="M12.166 8.94c-.524 1.062-1.234 2.12-1.96 3.07A32 32 0 0 1 8 14.58a32 32 0 0 1-2.206-2.57c-.726-.95-1.436-2.008-1.96-3.07C3.304 7.867 3 6.862 3 6a5 5 0 0 1 10 0c0 .862-.305 1.867-.834 2.94M8 16s6-5.686 6-10A6 6 0 0 0 2 6c0 4.314 6 10 6 10" />
                                    <path d="M8 8a2 2 0 1 1 0-4 2 2 0 0 1 0 4m0 1a3 3 0 1 0 0-6 3 3 0 0 0 0 6" />
                                </svg>
                            </a>
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

<?php foreach ($data_alternatif_rows as $key => $value): ?>
<div class="modal fade" id="exampleModal<?=$value['id_alternatif'];?>" tabindex="-1" aria-labelledby="exampleModalLabel"
    aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h1 class="modal-title fs-5" id="exampleModalLabel">Detail <?=$value['nama_alternatif'];?>
                </h1>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div class="text-center mb-3">
                    <img src="./images/<?=$value['gambar'];?>" alt="Gambar <?=$value['nama_alternatif'];?>"
                        class="img-fluid" style="max-height: 200px;">
                </div>
                <ul class="list-group">
                    <li class="list-group-item"><strong>Nama Alternatif:</strong> <?=$value['nama_alternatif'];?></li>
                    <li class="list-group-item"><strong>Konsep Gedung:</strong> <?=$value['konsep_gedung'];?></li>
                    <li class="list-group-item"><strong>Harga Sewa:</strong>
                        Rp<?=number_format($value['harga_sewa'], 0, ',', '.');?></li>
                    <li class="list-group-item"><strong>Fasilitas:</strong> <?=$value['fasilitas'];?> Fasilitas</li>
                    <li class="list-group-item"><strong>Kapasitas Tamu:</strong> <?=$value['kapasitas_tamu'];?> orang
                    </li>
                    <li class="list-group-item"><strong>Kapasitas Parkir:</strong> <?=$value['kapasitas_parkir'];?>
                        kendaraan</li>
                </ul>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>
<?php endforeach; ?>