<?php 
session_start();
unset($_SESSION['menu']);
$_SESSION['menu'] = 'sub-kriteria';
require_once './header.php';
require_once './functions/sub_kriteria.php';

if(isset($_POST['tambah'])){
    $id_kriteria = $_POST['id_kriteria'];
    $nama_sub_kriteria = $_POST['nama_sub_kriteria'];
    $bobot_sub_kriteria = $_POST['bobot_sub_kriteria'];
    $spesifikasi = $_POST['spesifikasi'];
    $dataSubKriteria = [
       "id_kriteria" => $id_kriteria,
       "nama_sub_kriteria" => $nama_sub_kriteria,
       "bobot_sub_kriteria" => $bobot_sub_kriteria,
       "spesifikasi" => $spesifikasi
    ];
    $Sub_Kriteria->tambahSubKriteria($dataSubKriteria);
}

$data_SubKriteria = $Sub_Kriteria->getSubKriteria();
$data_Kriteria = $Sub_Kriteria->getKriteria();
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
        window.location.href = './sub_kriteria.php';
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
                <h4 class="m-0 font-weight-bold text-primary ml-3">Data Sub Kriteria</h4>
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb bg-light pl-n5">
                        <li class="breadcrumb-item"><a href="./index.php">Home</a></li>
                        <li class="breadcrumb-item" aria-current="page"><a href="./sub_kriteria.php">Data
                                Sub Kriteria</a>
                        </li>
                        <li class="breadcrumb-item active" aria-current="page">Tambah Sub Kriteria</li>
                    </ol>
                </nav>
            </div>
            <div class="card-body">
                <!-- DataTales Example -->
                <div class="card shadow mb-4">
                    <form method="post" action="">
                        <div class="modal-body">
                            <div class="card-body">
                                <small class="text-danger">(*) Wajib</small>
                                <div class="d-lg-flex">
                                    <label for="nama_sub_kriteria" class="form-label col-lg-2">Subkriteria <small
                                            class="text-danger">*</small></label>
                                    <input class="form-control" required name="nama_sub_kriteria" type="text"
                                        placeholder="Subkriteria" aria-label="default input example">
                                </div>
                            </div>
                            <div class="card-body">
                                <div class="d-lg-flex">
                                    <label for="spesifikasi" class="form-label col-lg-2">Spesifikasi
                                        <small class="text-danger">*</small></label>
                                    <input class="form-control" required name="spesifikasi" type="text"
                                        placeholder="Spesifikasi" aria-label="default input example">
                                </div>
                            </div>
                            <div class="card-body">
                                <div class="d-lg-flex">
                                    <label for="bobot_sub_kriteria" class="form-label col-lg-2">Bobot
                                        <small class="text-danger">*</small></label>
                                    <input class="form-control" required name="bobot_sub_kriteria" type="number"
                                        placeholder="Bobot" aria-label="default input example">
                                </div>
                            </div>
                            <div class="card-body">
                                <div class="d-lg-flex">
                                    <label for="id_kriteria" class="form-label col-lg-2">Nama Kriteria <small
                                            class="text-danger">*</small></label>
                                    <select class="form-control" required id="id_kriteria" name="id_kriteria"
                                        aria-label="Default select example">
                                        <option value="">-- Pilih Kriteria --</option>
                                        <?php foreach ($data_Kriteria as $key => $kriteria): ?>
                                        <option value="<?=$kriteria['id_kriteria'];?>"><?=$kriteria['nama_kriteria'];?>
                                        </option>
                                        <?php endforeach;?>
                                    </select>
                                </div>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <a href="./sub_kriteria.php" class="btn btn-secondary">Kembali</a>
                            <button type="submit" name="tambah" class="btn btn-primary">Simpan</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
<?php require_once './footer.php';?>