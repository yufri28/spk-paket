<?php 
session_start();
unset($_SESSION['menu']);
$_SESSION['menu'] = 'kriteria';
require_once './header.php';
require_once './functions/kriteria.php';
?>
<?php 
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

if(isset($_POST['edit'])){
    $id_kriteria = $_POST['id_kriteria'];
    $nama_kriteria = $_POST['nama_kriteria'];
    $jenis_kriteria = $_POST['jenis_kriteria'];
    $dataKriteria = [
       "id_kriteria" => $id_kriteria,
       "nama_kriteria" => $nama_kriteria,
       "jenis_kriteria" => $jenis_kriteria
    ];
    $Kriteria->editKriteria($dataKriteria);
}
if(isset($_POST['hapus'])){
    $id_kriteria = $_POST['id_kriteria'];
    $Kriteria->hapusKriteria($id_kriteria);
}

$data_Kriteria = $Kriteria->getKriteria();
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
        window.location.href = '';
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
        window.location.href = '';
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
                        <li class="breadcrumb-item active" aria-current="page">Data Kriteria</li>
                    </ol>
                </nav>
            </div>
            <div class="card-body">
                <!-- DataTales Example -->
                <div class="card shadow mb-4">
                    <div class="card-header py-3">
                        <a href="./add_kriteria.php" class="btn btn-primary mb-3">
                            + Tambah Kriteria
                        </a>
                    </div>
                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                                <thead>
                                    <tr>
                                        <th>No</th>
                                        <th>Kode</th>
                                        <th>Nama</th>
                                        <th>Jenis Kriteria</th>
                                        <th>Aksi</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php foreach ($data_Kriteria as $key => $kriteria):?>
                                    <tr>
                                        <th scope="row"><?=$key+1;?></th>
                                        <th scope="row"><?=$kriteria['id_kriteria'];?></th>
                                        <td><?=$kriteria['nama_kriteria'];?></td>
                                        <td><?=$kriteria['jenis_kriteria'];?></td>
                                        <td>
                                            <button data-toggle="modal"
                                                data-target="#edit<?=$kriteria['id_kriteria'];?>" type="button"
                                                class="btn btn-sm btn-primary">Edit</button>
                                            <button data-toggle="modal"
                                                data-target="#hapus<?=$kriteria['id_kriteria'];?>" type="button"
                                                class="btn btn-sm btn-danger">Hapus</button>
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

<!-- Modal -->
<div class="modal fade" id="tambah" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <form method="post" action="">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Tambah Data</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="card-body">
                        <small class="text-danger">(*) Wajib</small>
                        <div class="mt-2">
                            <label for="id_kriteria" class="form-label">Kode Kriteria <small
                                    class="text-danger">*</small></label>
                            <input class="form-control" required name="id_kriteria" type="text"
                                placeholder="Kode Kriteria" aria-label="default input example" maxlength="2">
                        </div>
                    </div>
                    <div class="card-body">
                        <div class="">
                            <label for="nama_kriteria" class="form-label">Nama Kriteria <small
                                    class="text-danger">*</small></label>
                            <input class="form-control" required name="nama_kriteria" type="text"
                                placeholder="Nama Kriteria" aria-label="default input example">
                        </div>
                    </div>
                    <div class="card-body">
                        <div class="">
                            <label for="jenis_kriteria" class="form-label">Bobot Kriteria <small
                                    class="text-danger">*</small></label>
                            <input class="form-control" required name="jenis_kriteria" type="number"
                                placeholder="Bobot Kriteria" max="100" aria-label="default input example">
                        </div>
                    </div>

                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Kembali</button>
                        <button type="submit" name="tambah" class="btn btn-outline-primary">
                            Simpan
                        </button>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>
<?php foreach ($data_Kriteria as $key => $kriteria):?>
<div class="modal fade" id="edit<?=$kriteria['id_kriteria'];?>" tabindex="-1" aria-labelledby="exampleModalLabel"
    aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <form method="post" action="">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Edit Data</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="card-body">
                        <small class="text-danger">(*) Wajib</small>
                        <input class="form-control" name="id_kriteria" value="<?=$kriteria['id_kriteria'];?>" required
                            type="hidden" aria-label="default input example">
                        <div class="">
                            <label for="nama_kriteria" class="form-label">Nama Kriteria <small
                                    class="text-danger">*</small></label>
                            <input class="form-control" required name="nama_kriteria" type="text" placeholder="Kriteria"
                                value="<?=$kriteria['nama_kriteria'];?>" aria-label="default input example">
                        </div>
                    </div>
                    <div class="card-body">
                        <div class="">
                            <label for="jenis_kriteria" class="form-label">Jenis Kriteria <small
                                    class="text-danger">*</small></label>
                            <select class="form-control" name="jenis_kriteria" required
                                aria-label="Default select example">
                                <option value="">-- Pilih Jenis Kriteria --</option>
                                <option <?=$kriteria['jenis_kriteria'] == 'Cost' ?'selected':'';?> value="Cost">Cost
                                </option>
                                <option <?=$kriteria['jenis_kriteria'] == 'Benefit' ?'selected':'';?> value="Benefit">
                                    Benefit</option>
                            </select>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Kembali</button>
                        <button type="submit" name="edit" class="btn btn-outline-primary">
                            Simpan
                        </button>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>
<?php endforeach;?>
<?php foreach ($data_Kriteria as $kriteria):?>
<div class="modal fade" id="hapus<?=$kriteria['id_kriteria'];?>" tabindex="-1" aria-labelledby="exampleModalLabel"
    aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <form method="post" action="">
                <div class="modal-header">
                    <h5 class="modal-title fs-5" id="exampleModalLabel">Hapus Kriteria</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <input type="hidden" name="id_kriteria" value="<?=$kriteria['id_kriteria'];?>">
                <div class="modal-body">
                    <p>Anda yakin ingin menghapus kriteria <strong>
                            <?=$kriteria['nama_kriteria'];?></strong> ?</p>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                    <button type="submit" name="hapus" class="btn btn-outline-primary">
                        Hapus
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
<?php endforeach;?>
<?php require_once './footer.php';?>