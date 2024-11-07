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

// Aktifkan error reporting
error_reporting(E_ALL);
ini_set('display_errors', 1);

// Fungsi untuk menangkap kesalahan
function errorHandler($errno, $errstr, $errfile, $errline) {
    // Log kesalahan
    error_log("Error [$errno]: $errstr in $errfile on line $errline");
    echo "<script>alert('Terjadi kesalahan. Kesalahan tersebut disebabkan oleh data alternatif yang belum lengkap / konsep gedung yang anda pilih tidak tersedia!'); window.location.href = './index.php';</script>";
    exit;
}

set_error_handler('errorHandler');


if (isset($_POST['hasil-perengkingan'])) {
  ob_start();
  try {
      $konsep_gedung = null;  
      $dataBobotKriteria = [];
      $w = [];
      // Sanitize and cast inputs
      if(isset($_POST['konsep_gedung'])){
        $konsep_gedung = htmlspecialchars($_POST['konsep_gedung']);
      }
      foreach ($data_kriteria as $key => $value) {
          $dataBobotKriteria[$value['id_kriteria']] = $_POST[$value['id_kriteria']];
      }

      for ($i=1; $i <= count($dataBobotKriteria); $i++) { 
        array_push($w, $dataBobotKriteria['C'.$i] / array_sum($dataBobotKriteria));
      }

    
    //-- inisialisasi variabel array alternatif , dan jumlah alternatif
    $alternatif = array();
    $detail = array();
    
    $sql = "SELECT * FROM alternatif ";
    
    if($konsep_gedung != null){
      $sql .= "WHERE konsep_gedung ='".$konsep_gedung."'";
    }
    
    $data = $koneksi->query($sql);  
    while ($row = $data->fetch_assoc()) {
        // Store alternative names
        $alternatif[] = $row['nama_alternatif'];
        
        // Store entire row data as details
        $detail[] = $row;
    }

    
    // $n_subject = count($alternatif);
    $n_subject = $data->num_rows;
    
    // print_r($n_subject);
    //-- inisialisasi variabel array kriteria dan bobot (W), dan jumlah kriteria
    $kriteria = array();
    $sql_kriteria = 'SELECT * FROM kriteria';
    $data = $koneksi->query($sql_kriteria);
    while ($row = $data->fetch_object()) {
      $id_kriteria[] = $row->id_kriteria;
      $kriteria[] = $row->nama_kriteria;
      $type[] = $row->jenis_kriteria;
    }

    // $w = [0.2125, 0.225 , 0.2, 0.175];
    
    $n_criteria = count($kriteria);

    // -- ambil nilai dari tabel
    $value = array();
    $sql = "SELECT a.id_alternatif, b.id_kriteria, 
          IFNULL(c.bobot_sub_kriteria, 0) AS nilai
          FROM alternatif a 
          CROSS JOIN kriteria b 
          CROSS JOIN sub_kriteria c ON b.id_kriteria = c.f_id_kriteria 
          CROSS JOIN kec_alt_kriteria kac ON a.id_alternatif = kac.f_id_alternatif 
                                          AND b.id_kriteria = kac.f_id_kriteria 
                                          AND c.id_sub_kriteria = kac.f_id_sub_kriteria ";
    if($konsep_gedung != null){
        $sql .= "WHERE a.konsep_gedung = '".$konsep_gedung."' ";
    }

    $sql .= "ORDER BY a.id_alternatif, b.id_kriteria, c.id_sub_kriteria;";

    $data = $koneksi->query($sql);
    while ($row = $data->fetch_object()) {
      $value[] = $row->nilai;
    
    }
    

    // --normalisasi matriks
    $limit = array();
    $limitmin = array();
    $limitmax = array();
    $Q = array();
    // a.)mencari nilai min-max sesuai tipe
    for ($i = 0; $i < $n_criteria; $i++) {

      $max0 =  $value[$i];

      for ($j = 0; $j < $n_subject * $n_criteria; $j += $n_criteria) {
        $index = $j + $i;
        if ($max0 < $value[$index]) {
          $max0 = $value[$index];
        }
      }
      $limitmax[$i] = $max0;


      $min0 =  $value[$i];


        for ($j = 0; $j < $n_subject * $n_criteria; $j += $n_criteria) {
          $index = $j + $i;
          if ($min0 > $value[$index]) {
            $min0 = $value[$index];
            
          }
        }
        
        $limitmin[$i] = $min0;   

      // nilai max/benefit
      if ($type[$i] == "Benefit") {
        $max =  $value[$i];

        for ($j = 0; $j < $n_subject * $n_criteria; $j += $n_criteria) {
          $index = $j + $i;
          if ($max < $value[$index]) {
            $max = $value[$index];
          }
        }
        $limit[$i] = $max;
      }

      // nilai min/cost
      if ($type[$i] == "Cost") {
        $min =  $value[$i];


        for ($j = 0; $j < $n_subject * $n_criteria; $j += $n_criteria) {
          $index = $j + $i;
          if ($min > $value[$index]) {
            $min = $value[$index];
            
          }
        }
        
        $limit[$i] = $min;      
      }
    }

    


    for ($i = 0; $i < $n_criteria; $i++) {
      if ($type[$i] == "Benefit") {
        for ($j = 0; $j < $n_subject * $n_criteria; $j += $n_criteria) {
          $index = $j + $i;

          $denominator = $value[$index];
          if ($denominator != 0) {
            $value[$index] = ($value[$index] - $limitmin[$i]) / ($limitmax[$i] - $limitmin[$i]);
          } else {
            $value[$index] = 0;
          }
        }
      } else if ($type[$i] == "Cost") {
        for ($j = 0; $j < $n_subject * $n_criteria; $j += $n_criteria) {
          $index = $j + $i;

          $denominator = $value[$index];
          if ($denominator != 0) {
            $value[$index] = ($limitmax[$i] - $value[$index]) / ($limitmax[$i]-$limitmin[$i]);
          } else {
            $value[$index] = 0;
          }
        }
      }
    }  

    $hasil = [];

    for($i=0; $i < $n_subject; $i++){
      $total = 0;
      for($j=0; $j < $n_criteria; $j++){
        $index = $j + ($i * $n_criteria);
        $total += $value[$index] * $w[$j];
      }
      $Q[$i] = $total;
    }

      // d.) Mengurutkan berdasarkan nilai terbesar
      for ($i = 0; $i < $n_subject; $i++) {
          $Q[$i] = array($Q[$i], $alternatif[$i], $detail[$i]);
      }
      // sort($wsm);
      // sort($wpm);
      sort($Q);
      

      // -------------------------------------------------------------------------------
      // -rumus untuk matriks keputusan
      //-- inisialisasi variabel array id_alternatif+alternatif untuk matriks keputusan
      $alternatif1 = array();
      $sql = "SELECT * FROM alternatif ";
      if($konsep_gedung != null){
        $sql .= "WHERE konsep_gedung ='".$konsep_gedung."'";
      }
      $data = $koneksi->query($sql);
      while ($row = $data->fetch_object()) {
        $alternatif1[$row->id_alternatif] = $row->nama_alternatif;
      }
      //-- inisialisasi variabel array id_kriteria+kriteria untuk matriks keputusan
      $kriteria1 = array();
      $sql = 'SELECT * FROM kriteria';
      $data = $koneksi->query($sql);
      while ($row = $data->fetch_object()) {
        $kriteria1[$row->id_kriteria] = array($row->nama_kriteria, $row->jenis_kriteria);
      }
      //-- ambil nilai dari tabel_nilai untuk matriks keputusan
      $nilai1 = array();
      $sql = "SELECT kac.*,sk.*, a.konsep_gedung, sk.bobot_sub_kriteria AS nilai 
              FROM kec_alt_kriteria kac JOIN sub_kriteria sk
              ON sk.id_sub_kriteria=kac.f_id_sub_kriteria 
              JOIN alternatif a ON a.id_alternatif=kac.f_id_alternatif ";
              
      if($konsep_gedung != null){
        $sql .= "WHERE konsep_gedung ='".$konsep_gedung."' ";
      }

      $sql .= "ORDER BY kac.f_id_alternatif, kac.f_id_kriteria";
      
      $data = $koneksi->query($sql);
      while ($row = $data->fetch_object()) {
        $i = $row->f_id_alternatif;
        $j = $row->f_id_kriteria;
        $aij = $row->nilai;

        $nilai1[$i][$j] = $aij;
      }
      // // Mengurutkan berdasarkan peringkat (dari besar ke kecil)
      // usort($Q, function($a, $b) {
      //   return $b[0] <=> $a[0];
      // });

      usort($Q, function($a, $b) use ($w) {
        // Urutkan berdasarkan bobot total (posisi 0 dalam $Q)
        $result = $b[0] <=> $a[0];
    
        // Jika sama, urutkan berdasarkan bobot kriteria yang lebih tinggi
        if ($result === 0) {
            // Ambil nilai bobot kriteria dari posisi yang tepat (misalnya, $w[1], $w[2], dsb.)
            for ($i = 1; $i < count($w); $i++) {
                // Membandingkan berdasarkan bobot kriteria
                if ($a[$i] !== $b[$i]) {
                    return $b[$i] <=> $a[$i];
                }
            }
        }
    
        return $result;
    });
    

    } catch (Throwable $e) {
      // Menangkap semua jenis kesalahan
      echo "<script>alert('Terjadi kesalahan: {$e->getMessage()}'). Kesalahan tersebut disebabkan oleh data alternatif yang belum lengkap. Silahkan hubungi admin untuk melengkapi!; window.location.href = './index.php';</script>";
      exit;
  }

  ob_end_flush();
}
?>

<!-- Section: Design Block -->
<section class="">
    <!-- Jumbotron -->
    <hr class="mt-5 pt-4">
    <div class="px-5 py-5 px-md-5 text-center" style="background-color: hsl(0, 0%, 96%);">
        <div class="container" style="min-height:100vh;">
            <!-- List of Cards -->
            <div class="col-12">
                <a class="btn btn-danger" href="./pembobotan.php">Kembali Pembobotan</a>
                <h2 class="text-center"> Hasil
                    Perangkingan
                    Paket Resepsi Pernikahan</h2>
            </div>
            <div class="row row-cols-1 row-cols-md-3 g-4">
                <?php $j = 0;?>
                <?php foreach ($Q as $value): ?>
                <div class="col" data-aos="fade-up" data-aos-duration="3000" data-aos-anchor-placement="center-bottom">
                    <div class="card h-100">
                        <img src="./images/<?=$value[2]['gambar'];?>" class="card-img-top" alt="Card Image">
                        <div class="card-body">
                            <h5 class="card-title"><?=$value[2]['nama_alternatif'];?></h5>
                            <p class="card-text">Rangking ke - <?= ++$j;?> (<?= number_format($value[0], 3); ?>)</p>
                            <button type="button" class="btn btn-primary" data-bs-toggle="modal"
                                data-bs-target="#exampleModal<?=$value[2]['id_alternatif'];?>">
                                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor"
                                    class="bi bi-layout-text-sidebar-reverse" viewBox="0 0 16 16">
                                    <path
                                        d="M12.5 3a.5.5 0 0 1 0 1h-5a.5.5 0 0 1 0-1zm0 3a.5.5 0 0 1 0 1h-5a.5.5 0 0 1 0-1zm.5 3.5a.5.5 0 0 0-.5-.5h-5a.5.5 0 0 0 0 1h5a.5.5 0 0 0 .5-.5m-.5 2.5a.5.5 0 0 1 0 1h-5a.5.5 0 0 1 0-1z" />
                                    <path
                                        d="M16 2a2 2 0 0 0-2-2H2a2 2 0 0 0-2 2v12a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2zM4 1v14H2a1 1 0 0 1-1-1V2a1 1 0 0 1 1-1zm1 0h9a1 1 0 0 1 1 1v12a1 1 0 0 1-1 1H5z" />
                                </svg>
                            </button>
                            <a target="_blank"
                                href="https://www.google.com/maps/dir/?api=1&destination=<?=$value[2]['latitude'];?>,<?=$value[2]['longitude'];?>"
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
                <?php endforeach; ?>

            </div>
            <!-- End List of Cards -->
        </div>
    </div>
    <!-- Jumbotron -->
</section>
<?php require 'footer.php'; ?>

<?php foreach ($Q as $value): ?>
<div class="modal fade" id="exampleModal<?=$value[2]['id_alternatif'];?>" tabindex="-1"
    aria-labelledby="exampleModalLabel" aria-hidden="true">
    <?php 
      $spesifikasi = $koneksi->query("SELECT sk.spesifikasi, kac.detail, k.nama_kriteria  FROM kec_alt_kriteria kac 
                                      JOIN kriteria k ON k.id_kriteria=kac.f_id_kriteria 
                                      JOIN sub_kriteria sk ON sk.id_sub_kriteria=kac.f_id_sub_kriteria 
                                      WHERE kac.f_id_alternatif='".$value[2]['id_alternatif']."';");
    ?>
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h1 class="modal-title fs-5" id="exampleModalLabel">Detail <?=$value[2]['nama_alternatif'];?></h1>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div class="text-center mb-3">
                    <img src="./images/<?=$value[2]['gambar'];?>" alt="Gambar <?=$value[2]['nama_alternatif'];?>"
                        class="img-fluid" style="max-height: 200px;">
                </div>
                <ul class="list-group">
                    <li class="list-group-item"><strong>Konsep Gedung:</strong> <?=$value[2]['konsep_gedung'];?></li>
                    <li class="list-group-item"><strong>Nama Alternatif:</strong> <?=$value[2]['nama_alternatif'];?>
                    </li>
                    <?php foreach ($spesifikasi as $key => $values):?>
                    <li class="list-group-item"><strong><?=$values['nama_kriteria'];?>:</strong>
                        <?=$values['detail']??'-';?></li>
                    <?php endforeach?>
                </ul>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>
<?php endforeach; ?>