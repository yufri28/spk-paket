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
$dataSubC5 = $Alternatif->getSubC5();
$dataSubC6 = $Alternatif->getSubC6();
$dataSubC7 = $Alternatif->getSubC7();
$dataSubC8 = $Alternatif->getSubC8();
$dataSubC9 = $Alternatif->getSubC9();

$usulkanDataAlt = [];
$usulkanDataAltKriteria = [];
$subC1 = 0;
$subC2 = 0;
$subC3 = 0;
$subC4 = 0;

// edit alternatif
if(isset($_POST['edit'])){
    $id_alternatif = htmlspecialchars($_POST['id_alternatif']);
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
            // Hapus file gambar lama jika ada
            $gambarLama = $_POST['gambar_lama'];
            $pathGambarLama = $targetDir . $gambarLama;
            if (file_exists($pathGambarLama) && is_file($pathGambarLama)) {
                unlink($pathGambarLama); // Hapus file gambar lama
            }

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
                'id_alternatif' => $id_alternatif,
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

            
            $Alternatif->editDataAlternatif($dataAlternatif,$dataKecAltKrit);
        } else {
            return $_SESSION['error'] = 'Tidak ada data yang dikirim!';
        }
    } else {
        
        $C1 = cleanRupiah(htmlspecialchars($_POST['harga_sewa']));
        $C2 = cleanRupiah(htmlspecialchars($_POST['fasilitas']));
        $C3 = cleanRupiah(htmlspecialchars($_POST['kapasitas_tamu']));
        $C4 = cleanRupiah(htmlspecialchars($_POST['kapasitas_parkir']));
        $gambarLama = $_POST['gambar_lama'];

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
            'id_alternatif' => $id_alternatif,
            'nama_alternatif' => $nama_alternatif,
            'gambar' => $gambarLama,
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
        
        $Alternatif->editDataAlternatif($dataAlternatif,$dataKecAltKrit);
    }
}

if(isset($_POST['hapus'])){
    $id_alternatif = htmlspecialchars($_POST['id_alternatif']);
    $Alternatif->hapusDataAlternatif($id_alternatif);
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
                        <li class="breadcrumb-item active" aria-current="page">Data Alternatif</li>
                    </ol>
                </nav>
            </div>
            <div class="card-body">
                <!-- DataTales Example -->
                <div class="card shadow mb-4">
                    <div class="card-header py-3 d-flex">
                        <a href="./add_alternatif.php" class="btn btn-primary mb-3">
                            + Tambah Alternatif
                        </a>
                    </div>
                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table table-bordered nowrap" id="dataKepalaKeluarga" style="width:100%"
                                cellspacing="0">
                                <thead>
                                    <tr>
                                        <th>No</th>
                                        <th>Kode</th>
                                        <th>Gambar</th>
                                        <th>Nama</th>
                                        <th>Alamat</th>
                                        <th>Harga Sewa</th>
                                        <th>Fasilitas</th>
                                        <th>Kapasitas Tamu</th>
                                        <th>Kapasitas Parkir</th>
                                        <th>Konsep Gedung</th>
                                        <th>Aksi</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php $i = 0;?>
                                    <?php foreach ($dataAlternatif as $key => $data_alternatif):?>
                                    <tr>
                                        <td><?=(++$i);?></td>
                                        <td>A<?=($i);?></td>
                                        <td><a href="../images/<?=$data_alternatif['gambar'];?>" data-lightbox="image-1"
                                                data-title="<?=$data_alternatif['nama_alternatif'];?>">
                                                <img style="width: 50px; height: 50px;"
                                                    src="../images/<?=$data_alternatif['gambar'];?>"
                                                    alt="Gambar <?=$data_alternatif['nama_alternatif'];?>">
                                            </a>
                                        </td>
                                        <td><?=$data_alternatif['nama_alternatif']??'-';?></td>
                                        <td><?=$data_alternatif['alamat']??'-';?></td>
                                        <td><?=formatRupiah($data_alternatif['harga_sewa']??0);?></td>
                                        <td><?=$data_alternatif['fasilitas']??'-';?></td>
                                        <td><?=$data_alternatif['kapasitas_tamu']??'-';?></td>
                                        <td><?=$data_alternatif['kapasitas_parkir']??'-';?></td>
                                        <td><?=$data_alternatif['konsep_gedung']??'-';?></td>
                                        <td>
                                            <button data-toggle="modal"
                                                data-target="#edit<?=$data_alternatif['id_alternatif'];?>" type="button"
                                                class="btn btn-sm btn-primary">Edit</button>
                                            <button data-toggle="modal"
                                                data-target="#hapus<?=$data_alternatif['id_alternatif'];?>"
                                                type="button" class="btn btn-sm btn-danger">Hapus</button>
                                        </td>
                                    </tr>
                                    <?php endforeach;?>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<?php foreach ($dataAlternatif as $alternatif):?>
<div class="modal fade" id="edit<?=$alternatif['id_alternatif'];?>" tabindex="-1" aria-labelledby="exampleModalLabel"
    aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <form method="post" action="" enctype="multipart/form-data">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Edit Data</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <input type="hidden" name="id_alternatif" value="<?=$alternatif['id_alternatif'];?>">
                <div class="modal-body">
                    <div class="card-body">
                        <small class="text-danger">(*) Wajib</small>
                        <div class="">
                            <label for="exampleFormControlInput1" class="form-label">Nama Alternatif
                                <small class="text-danger">*</small></label>
                            <input type="text" class="form-control" required name="nama_alternatif"
                                id="exampleFormControlInput1" value="<?=$alternatif['nama_alternatif'];?>"
                                placeholder="Nama Alternatif" />
                        </div>
                    </div>
                    <div class="card-body">
                        <div class="">
                            <label for="alamat" class="form-label">Alamat <small class="text-danger">*</small></label>
                            <textarea name="alamat" id="alamat" class="form-control" id="exampleFormControlTextarea1"
                                rows="3"><?=$alternatif['alamat'];?></textarea>
                        </div>
                    </div>
                    <div class="card-body">
                        <div class="">
                            <label for="latitude" class="form-label">Latitude <small
                                    class="text-danger">*</small></label>
                            <input type="text" class="form-control" value="<?=$alternatif['latitude'];?>"
                                name="latitude" id="latitude" required placeholder="Latitude" />
                        </div>
                    </div>
                    <div class="card-body">
                        <div class="">
                            <label for="longitude" class="form-label">Longitude <small
                                    class="text-danger">*</small></label>
                            <input type="text" class="form-control" value="<?=$alternatif['longitude'];?>"
                                name="longitude" id="longitude" required placeholder="Longitude" />
                        </div>
                    </div>
                    <div class="card-body">
                        <div class="">
                            <label for="harga_sewa" class="form-label">Harga Sewa <small
                                    class="text-danger">*</small></label>
                            <input type="text" class="form-control" value="<?=$alternatif['harga_sewa'];?>"
                                name="harga_sewa" id="harga_sewa" required placeholder="Harga Sewa" />
                        </div>
                    </div>
                    <div class="card-body">
                        <div class="">
                            <label for="fasilitas" class="form-label">Fasilitas <small
                                    class="text-danger">*</small></label>
                            <input type="text" class="form-control" value="<?=$alternatif['fasilitas'];?>"
                                name="fasilitas" id="fasilitas" required placeholder="Fasilitas" />
                        </div>
                    </div>
                    <div class="card-body">
                        <div class="">
                            <label for="kapasitas_tamu" class="form-label">Kapasitas Tamu <small
                                    class="text-danger">*</small></label>
                            <input type="text" class="form-control" value="<?=$alternatif['kapasitas_tamu'];?>"
                                name="kapasitas_tamu" id="kapasitas_tamu" required placeholder="Kapasitas Tamu" />
                        </div>
                    </div>
                    <div class="card-body">
                        <div class="">
                            <label for="kapasitas_parkir" class="form-label">Kapasitas Parkir <small
                                    class="text-danger">*</small></label>
                            <input type="text" class="form-control" value="<?=$alternatif['kapasitas_parkir'];?>"
                                name="kapasitas_parkir" id="kapasitas_parkir" required placeholder="Kapasitas Parkir" />
                        </div>
                    </div>
                    <div class="card-body">
                        <div class="">
                            <label for="konsep_gedung" class="form-label">Konsep Gedung <small
                                    class="text-danger">*</small></label>
                            <select class="form-control" name="konsep_gedung" required
                                aria-label="Default select example">
                                <option value="">-- Pilih Konsep Gedung --</option>
                                <option <?=$alternatif['konsep_gedung'] == 'Indoor'?'selected':'';?> value="Indoor">
                                    Indoor</option>
                                <option <?=$alternatif['konsep_gedung'] == 'Outdoor'?'selected':'';?> value="Outdoor">
                                    Outdoor</option>
                            </select>
                        </div>
                    </div>
                    <div class="card-body">
                        <div class="">
                            <label for="gambar" class="form-label">Gambar</label>
                            <input type="file" accept=".jpg, .jpeg, .png" class="form-control" name="gambar" id="gambar"
                                placeholder="Gambar" />
                            <input type="hidden" value="<?=$alternatif['gambar'];?>" class="form-control"
                                name="gambar_lama" id="gambar_lama" />
                            <small><i>Tidak perlu diisi jika tidak ingin mengubah foto yang sudah diupload
                                    sebelumnya.</i></small>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Kembali</button>
                    <button type="submit" name="edit" class="btn btn-primary">Simpan</button>
                </div>
            </form>
        </div>
    </div>
</div>
<?php endforeach;?>
<?php foreach ($dataAlternatif as $alternatif):?>
<div class="modal fade" id="hapus<?=$alternatif['id_alternatif'];?>" tabindex="-1" aria-labelledby="exampleModalLabel"
    aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <form method="post" action="">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Hapus Data</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <input type="hidden" name="id_alternatif" value="<?=$alternatif['id_alternatif'];?>">
                <div class="modal-body">
                    <p>Anda yakin ingin menghapus alternatif <strong>
                            <?=$alternatif['nama_alternatif'];?></strong> ?</p>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Kembali</button>
                    <button type="submit" name="hapus" class="btn btn-primary">Hapus</button>
                </div>
            </form>
        </div>
    </div>
</div>
<?php endforeach;?>
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

// Fungsi untuk format ulang input saat modal ditampilkan
function formatInputs() {
    var harga_sewa = document.getElementById('harga_sewa');
    var fasilitas = document.getElementById('fasilitas');
    var kapasitas_tamu = document.getElementById('kapasitas_tamu');
    var kapasitas_parkir = document.getElementById('kapasitas_parkir');

    // Format angka pada saat modal ditampilkan
    if (harga_sewa) {
        harga_sewa.value = formatRupiah(harga_sewa.value, 'Rp');
    }

    if (fasilitas) {
        fasilitas.value = formatAngka(fasilitas.value);
    }

    if (kapasitas_tamu) {
        kapasitas_tamu.value = formatAngka(kapasitas_tamu.value);
    }

    if (kapasitas_parkir) {
        kapasitas_parkir.value = formatAngka(kapasitas_parkir.value);
    }
}

<?php foreach ($dataAlternatif as $alternatif): ?>
$('#edit<?=$alternatif['id_alternatif'];?>').on('shown.bs.modal', function() {
    formatInputs('edit<?=$alternatif['id_alternatif'];?>');
});
<?php endforeach; ?>

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