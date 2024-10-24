<?php 
session_start();
unset($_SESSION['menu']);
$_SESSION['menu'] = 'kriteria';
require_once './header.php';
require_once './functions/kriteria.php';

// tambah alternatif
if(isset($_POST['tambah'])){
    $id_kriteria = $_POST['id_kriteria'];
    $nama_kriteria = $_POST['nama_kriteria'];
    $jenis_kriteria = $_POST['jenis_kriteria'];
    $dataKriteria = [
       "id_kriteria" => $id_kriteria,
       "nama_kriteria" => $nama_kriteria,
       "jenis_kriteria" => $jenis_kriteria
    ];
    $Kriteria->tambahKriteria($dataKriteria);
}

$data_Kriteria = $Kriteria->getKriteria();
?>
<?php if (mysqli_num_rows($data_Kriteria) == 4): ?>
<script>
var successfuly = 'Hanya menerima <?=mysqli_num_rows($data_Kriteria)?> kriteria!';
Swal.fire({
    title: 'Warning!',
    text: successfuly,
    icon: 'warning',
    confirmButtonText: 'OK'
}).then(function(result) {
    if (result.isConfirmed) {
        window.location.href = './kriteria.php';
    }
});
</script>
<?php endif; ?>

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
        window.location.href = './kriteria.php';
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
                <h4 class="m-0 font-weight-bold text-primary ml-3">Data Kriteria</h4>
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb bg-light pl-n5">
                        <li class="breadcrumb-item"><a href="./index.php">Home</a></li>
                        <li class="breadcrumb-item" aria-current="page"><a href="./kriteria.php">Data
                                Kriteria</a>
                        </li>
                        <li class="breadcrumb-item active" aria-current="page">Tambah Kriteria</li>
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
                                    <label for="id_kriteria" class="form-label col-lg-2">Kode Kriteria
                                        <small class="text-danger">*</small></label>
                                    <input class="form-control" required name="id_kriteria" id="id_kriteria" type="text"
                                        placeholder="Kode Kriteria" aria-label="default input example" maxlength="2">
                                </div>
                            </div>
                            <div class="card-body">
                                <div class="d-lg-flex">
                                    <label for="nama_kriteria" class="form-label col-lg-2">Kriteria <small
                                            class="text-danger">*</small></label>
                                    <input class="form-control" required name="nama_kriteria" type="text"
                                        placeholder="Kriteria" aria-label="default input example">
                                </div>
                            </div>
                            <div class="card-body">
                                <div class="d-lg-flex">
                                    <label for="jenis_kriteria" class="form-label col-lg-2">Jenis Kriteria <small
                                            class="text-danger">*</small></label>
                                    <select class="form-control" name="jenis_kriteria" required
                                        aria-label="Default select example">
                                        <option value="">-- Pilih Jenis Kriteria --</option>
                                        <option value="Cost">Cost</option>
                                        <option value="Benefit">Benefit</option>
                                    </select>
                                </div>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <a href="./kriteria.php" class="btn btn-secondary">Kembali</a>
                            <button type="submit" name="tambah" class="btn btn-primary">Simpan</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
<?php require_once './footer.php';?>