<?php 
session_start();
unset($_SESSION['menu']);
$_SESSION['menu'] = 'sub-kriteria';
require_once './header.php';
require_once './functions/sub_kriteria.php';

if(isset($_POST['edit'])){
    $id_kriteria = $_POST['id_kriteria'];
    $id_sub_kriteria = $_POST['id_sub_kriteria'];
    $nama_sub_kriteria = $_POST['nama_sub_kriteria'];
    $bobot_sub_kriteria = $_POST['bobot_sub_kriteria'];
    $spesifikasi = $_POST['spesifikasi'];
    $dataSubKriteria = [
       "id_kriteria" => $id_kriteria,
       "id_sub_kriteria" => $id_sub_kriteria,
       "nama_sub_kriteria" => $nama_sub_kriteria,
       "spesifikasi" => $spesifikasi,
       "bobot_sub_kriteria" => $bobot_sub_kriteria
    ];
    $Sub_Kriteria->editSubKriteria($dataSubKriteria);
}
if(isset($_POST['hapus'])){
    $id_sub_kriteria = $_POST['id_sub_kriteria'];
    $Sub_Kriteria->hapusSubKriteria($id_sub_kriteria);
}
$data_SubKriteria = $Sub_Kriteria->getSubKriteria();
$data_Kriteria = $Sub_Kriteria->getKriteria();
?>
<?php if (isset($_SESSION['success'])): ?>
<script>
Swal.fire({
    title: 'Sukses!',
    text: '<?php echo $_SESSION['success']; ?>',
    icon: 'success',
    confirmButtonText: 'OK'
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
});
</script>
<?php unset($_SESSION['error']); // Menghapus session setelah ditampilkan ?>
<?php endif; ?>
<div class="row mb-5">
    <div class="col-lg-12">
        <div class="card">
            <div class="card-header">
                <h4 class="m-0 font-weight-bold text-primary ml-3">Data Subkriteria</h4>
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb bg-light pl-n5">
                        <li class="breadcrumb-item"><a href="./index.php">Home</a></li>
                        <li class="breadcrumb-item active" aria-current="page">Data Subkriteria</li>
                    </ol>
                </nav>
            </div>
            <div class="card-body">
                <div class="card shadow mb-4">
                    <div class="card-header py-3 d-flex">
                        <a href="./add_subkriteria.php" class="btn btn-primary mb-3">
                            + Tambah Subkriteria
                        </a>
                    </div>
                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table table-striped table-bordered nowrap" style="width:100%" id="table">
                                <thead>
                                    <tr>
                                        <th scope="col">No</th>
                                        <th scope="col">Kode</th>
                                        <th scope="col">Subkriteria</th>
                                        <th scope="col">Spesifikasi</th>
                                        <th scope="col">Bobot</th>
                                        <th scope="col">Kriteria</th>
                                        <th scope="col">Aksi</th>
                                    </tr>
                                </thead>
                                <tbody class="table-group-divider">

                                    <?php foreach ($data_SubKriteria as $key => $sub_kriteria):?>
                                    <tr>
                                        <th scope="row"><?=($key+1);?>.</th>
                                        <td>SK<?=$key+1;?></td>
                                        <td><?= $sub_kriteria['nama_sub_kriteria'];?></td>
                                        <td><?= $sub_kriteria['spesifikasi'];?></td>
                                        <td><?= $sub_kriteria['bobot_sub_kriteria'];?></td>
                                        <td><?= $sub_kriteria['nama_kriteria'];?></td>
                                        <td>
                                            <button type="button" class="btn btn-sm btn-primary" data-toggle="modal"
                                                data-target="#edit<?= $sub_kriteria['id_sub_kriteria'];?>">
                                                Edit
                                            </button>
                                            <button type="button" class="btn btn-sm btn-danger" data-toggle="modal"
                                                data-target="#hapus<?= $sub_kriteria['id_sub_kriteria'];?>">
                                                Hapus
                                            </button>
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
<?php foreach ($data_SubKriteria as $key => $sub_kriteria):?>
<div class="modal fade" id="edit<?=$sub_kriteria['id_sub_kriteria'];?>" tabindex="-1"
    aria-labelledby="exampleModalLabel" aria-hidden="true">
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
                        <input class="form-control" name="id_sub_kriteria"
                            value="<?=$sub_kriteria['id_sub_kriteria'];?>" required type="hidden"
                            aria-label="default input example">
                        <div class="">
                            <label for="nama_sub_kriteria" class="form-label">Nama SubKriteria <small
                                    class="text-danger">*</small></label>
                            <input class="form-control" required name="nama_sub_kriteria" type="text"
                                placeholder="SubKriteria" value="<?=$sub_kriteria['nama_sub_kriteria'];?>"
                                aria-label="default input example">
                        </div>
                    </div>
                    <div class="card-body">
                        <div class="">
                            <label for="spesifikasi" class="form-label2">Spesifikasi
                                <small class="text-danger">*</small></label>
                            <input class="form-control" required name="spesifikasi" type="text"
                                placeholder="Spesifikasi" value="<?=$sub_kriteria['spesifikasi'];?>"
                                aria-label="default input example">
                        </div>
                    </div>
                    <div class="card-body">
                        <div class="">
                            <label for="bobot_sub_kriteria" class="form-label">Bobot SubKriteria <small
                                    class="text-danger">*</small></label>
                            <select class="form-control" required id="bobot_sub_kriteria" name="bobot_sub_kriteria"
                                aria-label="Default select example">
                                <option value="">-- Pilih Bobot --</option>
                                <option <?=$sub_kriteria['bobot_sub_kriteria'] == 1 ? "selected":"";?> value="1">1
                                </option>
                                <option <?=$sub_kriteria['bobot_sub_kriteria'] == 2 ? "selected":"";?> value="2">2
                                </option>
                                <option <?=$sub_kriteria['bobot_sub_kriteria'] == 3 ? "selected":"";?> value="3">3
                                </option>
                                <option <?=$sub_kriteria['bobot_sub_kriteria'] == 4 ? "selected":"";?> value="4">4
                                </option>
                                <option <?=$sub_kriteria['bobot_sub_kriteria'] == 5 ? "selected":"";?> value="5">5
                                </option>
                            </select>
                        </div>
                    </div>
                    <div class="card-body">
                        <div class="">
                            <label for="id_kriteria" class="form-label">Nama Kriteria <small
                                    class="text-danger">*</small></label>
                            <select class="form-control" required id="id_kriteria" name="id_kriteria"
                                aria-label="Default select example">
                                <option value="">-- Pilih Kriteria --</option>
                                <?php foreach ($data_Kriteria as $key => $kriteria): ?>
                                <option <?=$kriteria['id_kriteria'] == $sub_kriteria['id_kriteria'] ? "selected":"";?>
                                    value="<?=$kriteria['id_kriteria'];?>"><?=$kriteria['nama_kriteria'];?>
                                </option>
                                <?php endforeach;?>
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
<?php foreach ($data_SubKriteria as $sub_kriteria):?>
<div class="modal fade" id="hapus<?=$sub_kriteria['id_sub_kriteria'];?>" tabindex="-1"
    aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <form method="post" action="">
                <div class="modal-header">
                    <h5 class="modal-title fs-5" id="exampleModalLabel">Hapus SubKriteria</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <input type="hidden" name="id_sub_kriteria" value="<?=$sub_kriteria['id_sub_kriteria'];?>">
                <div class="modal-body">
                    <p>Anda yakin ingin menghapus subkriteria <strong>
                            <?=$sub_kriteria['nama_sub_kriteria'];?></strong> ?</p>
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
<?php 
    require_once './footer.php';
?>