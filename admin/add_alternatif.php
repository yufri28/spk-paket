<?php 
session_start();
unset($_SESSION['menu']);
$_SESSION['menu'] = 'alternatif';
require_once './header.php';
require_once './functions/data_alternatif.php';

$dataAlternatif = $Alternatif->getAlternatif();
$dataSubC1 = $Alternatif->getSubC1();
$dataSubC2 = $Alternatif->getSubC2();
$dataSubC3 = $Alternatif->getSubC3();
$dataSubC4 = $Alternatif->getSubC4();

$usulkanDataAlt = [];
$usulkanDataAltKriteria = [];

$subC1 = 0;
$subC2 = 0;
$subC3 = 0;
$subC4 = 0;

// tambah alternatif
if(isset($_POST['tambah'])){
    $nama_alternatif = htmlspecialchars($_POST['nama_alternatif']);
    $alamat = htmlspecialchars($_POST['alamat']);
    $konsep_gedung = htmlspecialchars($_POST['konsep_gedung']);
    $latitude = htmlspecialchars($_POST['latitude']);
    $longitude = htmlspecialchars($_POST['longitude']);
    
    // Pastikan ada file gambar yang diunggah
    if (isset($_FILES['gambar']) && $_FILES['gambar']['error'] === UPLOAD_ERR_OK) {
        $namaFile = $_FILES['gambar']['name'];
        $lokasiSementara = $_FILES['gambar']['tmp_name'];
        
        // Tentukan lokasi tujuan penyimpanan
        $targetDir = '../images/';
        $targetFilePath = $targetDir . $namaFile;

        // Cek apakah nama file sudah ada dalam direktori target
        if (file_exists($targetFilePath)) {
            $fileInfo = pathinfo($namaFile);
            $baseName = $fileInfo['filename'];
            $extension = $fileInfo['extension'];
            $counter = 1;

            // Loop hingga menemukan nama file yang unik
            while (file_exists($targetFilePath)) {
                $namaFile = $baseName . '_' . $counter . '.' . $extension;
                $targetFilePath = $targetDir . $namaFile;
                $counter++;
            }
        }

        // Pindahkan file gambar dari lokasi sementara ke lokasi tujuan
        if (move_uploaded_file($lokasiSementara, $targetFilePath)) {
            $C1 = cleanRupiah(htmlspecialchars($_POST['harga_sewa']));
            $C2 = cleanRupiah(htmlspecialchars($_POST['fasilitas']));
            $C3 = cleanRupiah(htmlspecialchars($_POST['kapasitas_tamu']));
            $C4 = cleanRupiah(htmlspecialchars($_POST['kapasitas_parkir']));
            
            // Harga sewa
            foreach ($dataSubC1 as $value) {
                switch (true) {
                    case $C1 > 148000 && $value['bobot_sub_kriteria'] == 5:
                        $subC1 = $value['id_sub_kriteria'];
                        break;
                    case $C1 > 112000 && $C1 <= 148000 && $value['bobot_sub_kriteria'] == 4:
                        $subC1 = $value['id_sub_kriteria'];
                        break;
                    case $C1 > 76000 && $C1 <= 112000 && $value['bobot_sub_kriteria'] == 3:
                        $subC1 = $value['id_sub_kriteria'];
                        break;
                    case $C1 > 40000 && $C1 <= 76000 && $value['bobot_sub_kriteria'] == 2:
                        $subC1 = $value['id_sub_kriteria'];
                        break;
                    case $C1 <= 40000 && $value['bobot_sub_kriteria'] == 1:
                        $subC1 = $value['id_sub_kriteria'];
                        break;
                }
            }

            // Fasilitas
            foreach ($dataSubC2 as $value) {
                switch (true) {
                    case $C2 > 12 && $value['bobot_sub_kriteria'] == 5:
                        $subC2 = $value['id_sub_kriteria'];
                        break;
                    case $C2 >= 10 && $C2 <= 12 && $value['bobot_sub_kriteria'] == 4:
                        $subC2 = $value['id_sub_kriteria'];
                        break;
                    case $C2 >= 7 && $C2 <= 9 && $value['bobot_sub_kriteria'] == 3:
                        $subC2 = $value['id_sub_kriteria'];
                        break;
                    case $C2 >= 4 && $C2 <= 6 && $value['bobot_sub_kriteria'] == 2:
                        $subC2 = $value['id_sub_kriteria'];
                        break;
                    case $C2 <= 3 && $value['bobot_sub_kriteria'] == 1:
                        $subC2 = $value['id_sub_kriteria'];
                        break;
                }
            }

            // Kapasitas Tamu
            foreach ($dataSubC3 as $value) {
                switch (true) {
                    case $C3 > 1323 && $value['bobot_sub_kriteria'] == 5:
                        $subC3 = $value['id_sub_kriteria'];
                        break;
                    case $C3 >= 983 && $C3 <= 1323 && $value['bobot_sub_kriteria'] == 4:
                        $subC3 = $value['id_sub_kriteria'];
                        break;
                    case $C3 >= 642 && $C3 <= 982 && $value['bobot_sub_kriteria'] == 3:
                        $subC3 = $value['id_sub_kriteria'];
                        break;
                    case $C3 >= 301 && $C3 <= 641 && $value['bobot_sub_kriteria'] == 2:
                        $subC3 = $value['id_sub_kriteria'];
                        break;
                    case $C3 <= 300 && $value['bobot_sub_kriteria'] == 1:
                        $subC3 = $value['id_sub_kriteria'];
                        break;
                }
            }
            // Kapasitas Parkir
            foreach ($dataSubC4 as $value) {
                switch (true) {
                    case $C4 > 143 && $value['bobot_sub_kriteria'] == 5:
                        $subC4 = $value['id_sub_kriteria'];
                        break;
                    case $C4 >= 113 && $C4 <= 143 && $value['bobot_sub_kriteria'] == 4:
                        $subC4 = $value['id_sub_kriteria'];
                        break;
                    case $C4 >= 82 && $C4 <= 112 && $value['bobot_sub_kriteria'] == 3:
                        $subC4 = $value['id_sub_kriteria'];
                        break;
                    case $C4 >= 51 && $C4 <= 81 && $value['bobot_sub_kriteria'] == 2:
                        $subC4 = $value['id_sub_kriteria'];
                        break;
                    case $C4 <= 50 && $value['bobot_sub_kriteria'] == 1:
                        $subC4 = $value['id_sub_kriteria'];
                        break;
                }
            }


            $dataAlternatif = [
                'nama_alternatif' => $nama_alternatif,
                'gambar' => $namaFile,
                'alamat' => $alamat,
                'latitude' => $latitude,
                'longitude' => $longitude,
                'konsep_gedung' => $konsep_gedung,
                'harga_sewa' => $C1,
                'fasilitas' => $C2,
                'kapasitas_tamu' => $C3,
                'kapasitas_parkir' => $C4
            ];
            
            $dataKecAltKrit = [
                'C1' => $subC1,
                'C2' => $subC2,
                'C3' => $subC3,
                'C4' => $subC4
            ];
            $Alternatif->addDataAlternatif($dataAlternatif,$dataKecAltKrit);
        } else {
            return $_SESSION['error'] = 'Tidak ada data yang dikirim!';
        }
    } else {
        return $_SESSION['error'] = 'Tidak ada data yang dikirim!';
    }    
}


$arr_id_kriteria = [];
$arr_id_sub_kriteria = [];
?>
<?php if (isset($_SESSION['success'])): ?>
<script>
var successfuly = '<?php echo $_SESSION["success"]; ?>';
Swal.fire({
    title: 'Sukses!',
    text: successfuly,
    icon: 'success',
    confirmButtonText: 'OK'
}).then(function(result) {
    if (result.isConfirmed) {
        // window.location.href = '';
        window.location.href = window.location.href;
    }
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
}).then(function(result) {
    if (result.isConfirmed) {
        // window.location.href = '';
        window.location.href = window.location.href;
    }
});
</script>
<?php unset($_SESSION['error']); // Menghapus session setelah ditampilkan ?>
<?php endif; ?>
<div class="row">
    <!-- Area Chart -->
    <!-- Button trigger modal -->
    <div class="col-lg-12">
        <div class="card">
            <div class="card-header">
                <h4 class="m-0 font-weight-bold text-primary ml-3">Data Alternatif</h4>
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb bg-light pl-n5">
                        <li class="breadcrumb-item"><a href="./index.php">Home</a></li>
                        <li class="breadcrumb-item" aria-current="page"><a href="./data_alternatif.php">Data
                                Alternatif</a>
                        </li>
                        <li class="breadcrumb-item active" aria-current="page">Tambah Alternatif</li>
                    </ol>
                </nav>
            </div>
            <div class="card-body">
                <!-- DataTales Example -->
                <div class="card shadow mb-4">
                    <form method="post" action="" enctype="multipart/form-data">
                        <div class="modal-body">
                            <div class="card-body">
                                <small class="text-danger">(*) Wajib</small>
                                <div class="d-lg-flex">
                                    <label for="exampleFormControlInput1" class="form-label col-lg-2">Nama Alternatif
                                        <small class="text-danger">*</small></label>
                                    <input type="text" class="form-control" required name="nama_alternatif"
                                        id="exampleFormControlInput1" placeholder="Nama Alternatif" />
                                </div>
                            </div>
                            <div class="card-body">
                                <div class="d-lg-flex">
                                    <label for="alamat" class="form-label col-lg-2">Alamat <small
                                            class="text-danger">*</small></label>
                                    <textarea name="alamat" id="alamat" class="form-control"
                                        id="exampleFormControlTextarea1" rows="3"></textarea>
                                </div>
                            </div>
                            <div class="card-body">
                                <div class="d-lg-flex">
                                    <label for="latitude" class="form-label col-lg-2">Latitude <small
                                            class="text-danger">*</small></label>
                                    <input type="text" class="form-control" name="latitude" id="latitude" required
                                        placeholder="Latitude" />
                                </div>
                            </div>
                            <div class="card-body">
                                <div class="d-lg-flex">
                                    <label for="longitude" class="form-label col-lg-2">Longitude <small
                                            class="text-danger">*</small></label>
                                    <input type="text" class="form-control" name="longitude" id="longitude" required
                                        placeholder="Longitude" />
                                </div>
                            </div>
                            <div class="card-body">
                                <div class="d-lg-flex">
                                    <label for="harga_sewa" class="form-label col-lg-2">Harga Sewa <small
                                            class="text-danger">*</small></label>
                                    <input type="text" class="form-control" name="harga_sewa" id="harga_sewa" required
                                        placeholder="Harga Sewa" />
                                </div>
                            </div>
                            <div class="card-body">
                                <div class="d-lg-flex">
                                    <label for="fasilitas" class="form-label col-lg-2">Fasilitas <small
                                            class="text-danger">*</small></label>
                                    <input type="text" class="form-control" name="fasilitas" id="fasilitas" required
                                        placeholder="Fasilitas" />
                                </div>
                            </div>
                            <div class="card-body">
                                <div class="d-lg-flex">
                                    <label for="kapasitas_tamu" class="form-label col-lg-2">Kapasitas Tamu <small
                                            class="text-danger">*</small></label>
                                    <input type="text" class="form-control" name="kapasitas_tamu" id="kapasitas_tamu"
                                        required placeholder="Kapasitas Tamu" />
                                </div>
                            </div>
                            <div class="card-body">
                                <div class="d-lg-flex">
                                    <label for="kapasitas_parkir" class="form-label col-lg-2">Kapasitas Parkir <small
                                            class="text-danger">*</small></label>
                                    <input type="text" class="form-control" name="kapasitas_parkir"
                                        id="kapasitas_parkir" required placeholder="Kapasitas Parkir" />
                                </div>
                            </div>
                            <div class="card-body">
                                <div class="d-lg-flex">
                                    <label for="konsep_gedung" class="form-label col-lg-2">Konsep Gedung <small
                                            class="text-danger">*</small></label>
                                    <select class="form-control" name="konsep_gedung" required
                                        aria-label="Default select example">
                                        <option value="">-- Pilih Konsep Gedung --</option>
                                        <option value="Indoor">Indoor</option>
                                        <option value="Outdoor">Outdoor</option>
                                    </select>
                                </div>
                            </div>
                            <div class="card-body">
                                <div class="d-lg-flex">
                                    <label for="gambar" class="form-label col-lg-2">Gambar <small
                                            class="text-danger">*</small></label>
                                    <input type="file" accept=".jpg, .jpeg, .png" class="form-control" name="gambar"
                                        id="gambar" required placeholder="Gambar" />
                                </div>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <a href="./data_alternatif.php" class="btn btn-secondary">Kembali</a>
                            <button type="submit" name="tambah" class="btn btn-primary">Simpan</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
<?php require_once './footer.php';?>

<script>
/* Dengan Rupiah */
var harga_sewa = document.getElementById('harga_sewa');
harga_sewa.addEventListener('keyup', function(e) {
    harga_sewa.value = formatRupiah(this.value, 'Rp');
});

var fasilitas = document.getElementById('fasilitas');
fasilitas.addEventListener('keyup', function(e) {
    fasilitas.value = formatAngka(this.value);
});

var kapasitas_tamu = document.getElementById('kapasitas_tamu');
kapasitas_tamu.addEventListener('keyup', function(e) {
    kapasitas_tamu.value = formatAngka(this.value);
});
var kapasitas_parkir = document.getElementById('kapasitas_parkir');
kapasitas_parkir.addEventListener('keyup', function(e) {
    kapasitas_parkir.value = formatAngka(this.value);
});

/* Fungsi */
function formatRupiah(angka, prefix) {
    var number_string = angka.replace(/[^,\d]/g, '').toString(),
        split = number_string.split(','),
        sisa = split[0].length % 3,
        rupiah = split[0].substr(0, sisa),
        ribuan = split[0].substr(sisa).match(/\d{3}/gi);

    if (ribuan) {
        separator = sisa ? '.' : '';
        rupiah += separator + ribuan.join('.');
    }

    rupiah = split[1] != undefined ? rupiah + ',' + split[1] : rupiah;
    return prefix == undefined ? rupiah : (rupiah ? 'Rp' + rupiah : '');
}

function formatAngka(angka, prefix = '') {
    // Ensure the input is a string and remove any non-digit characters except for commas and periods
    var number_string = angka.toString().replace(/[^,\d]/g, ''),
        split = number_string.split(','),
        sisa = split[0].length % 3,
        rupiah = split[0].substr(0, sisa),
        ribuan = split[0].substr(sisa).match(/\d{3}/gi);

    // Add thousands separator if there are groups of thousands
    if (ribuan) {
        var separator = sisa ? '.' : '';
        rupiah += separator + ribuan.join('.');
    }

    // If there's a decimal part, add it after a comma
    rupiah = split[1] !== undefined ? rupiah + ',' + split[1] : rupiah;

    // Return the formatted number, with or without the prefix
    return prefix + rupiah;
}
</script>