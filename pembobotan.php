<?php 
session_start();
require_once './config.php';

unset($_SESSION['active-menu']);
$_SESSION['active-menu'] = 'pembobotan';

$dataKriteria = $koneksi->query("SELECT * FROM kriteria");
?>
<?php require './header.php';?>
<!-- Section: Design Block -->
<section class="">
    <!-- Jumbotron -->
    <hr class="mt-5 pt-4">
    <div class="px-5 pt-5 px-md-5" style="background-color: hsl(0, 0%, 96%);">
        <form action="./hasil.php" method="post">
            <div class="container" style="min-height:100vh;">
                <h2 class="text-center">Masukkan Bobot Kriteria</h2>
                <div class="alert alert-warning tex-start mt-lg-5 col-lg-6" role="alert">
                    Keterangan <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor"
                        class="bi bi-exclamation-triangle" viewBox="0 0 16 16">
                        <path
                            d="M7.938 2.016A.13.13 0 0 1 8.002 2a.13.13 0 0 1 .063.016.15.15 0 0 1 .054.057l6.857 11.667c.036.06.035.124.002.183a.2.2 0 0 1-.054.06.1.1 0 0 1-.066.017H1.146a.1.1 0 0 1-.066-.017.2.2 0 0 1-.054-.06.18.18 0 0 1 .002-.183L7.884 2.073a.15.15 0 0 1 .054-.057m1.044-.45a1.13 1.13 0 0 0-1.96 0L.165 13.233c-.457.778.091 1.767.98 1.767h13.713c.889 0 1.438-.99.98-1.767z" />
                        <path
                            d="M7.002 12a1 1 0 1 1 2 0 1 1 0 0 1-2 0M7.1 5.995a.905.905 0 1 1 1.8 0l-.35 3.507a.552.552 0 0 1-1.1 0z" />
                    </svg>
                    <ol>
                        <li>Setiap Bobot memiliki nilai maksimal 100</li>
                        <li>Bobot yang memiliki nilai tertinggi adalah kriteria terpenting</li>
                    </ol>
                    <button type="button" class="btn btn-sm btn-primary" data-bs-toggle="modal"
                        data-bs-target="#exampleModal">
                        Baca panduan selengkapnya
                    </button>
                    <div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel"
                        aria-hidden="true">
                        <div class="modal-dialog">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h1 class="modal-title fs-5" id="exampleModalLabel">Panduan</h1>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal"
                                        aria-label="Close"></button>
                                </div>
                                <div class="modal-body">
                                    Panduan untuk mengisi bobot pada sistem ini :
                                    <ol>
                                        <li>
                                            Pilih Konsep Gedung : pada bagian ini anda diminta untuk memilih konsep
                                            Gedung sesuai dengan
                                            preferensi anda. Jika Anda ingin mempertimbangkan kedua konsep, biarkan opsi
                                            ini kosong.
                                        </li>
                                        <li>Berikan bobot pada setiap kriteria : setiap kriteria memiliki rentang bobot
                                            antara 0-100.
                                            Berikan bobot sesuai dengan seberapa penting kriteria tersebut dalam
                                            keputusan anda. Semakin
                                            tinggi bobot yang diberikan, semakin besar pengaruh kriteria tersebut dalam
                                            menentukan hasil
                                            akhir.
                                        </li>
                                        <li>Lihat Hasil perangkingan : setelah anda mengisi bobot kriteria, klik tombol
                                            "Hasil
                                            Perangkingan" untuk menampilkan paket resepsi pernikahan sesuai preferensi
                                            anda.
                                        </li>
                                    </ol>
                                </div>
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-secondary"
                                        data-bs-dismiss="modal">Tutup</button>
                                </div>
                            </div>
                        </div>
                    </div>

                </div>
                <div class="d-flex row mt-lg-5">
                    <div class="col-lg-4">
                        <h5>Apakah Anda menginginkan pernikahan di area Indoor atau Outdoor?</h5>
                        <div class="radio">
                            <div class="form-check">
                                <input class="form-check-input" type="radio" value="Indoor" name="konsep_gedung"
                                    id="indoor">
                                <label class="form-check-label" for="indoor">
                                    Indoor
                                </label>
                            </div>
                            <div class="form-check">
                                <input class="form-check-input" type="radio" value="Outdoor" name="konsep_gedung"
                                    id="outdoor">
                                <label class="form-check-label" for="outdoor">
                                    Outdoor
                                </label>
                            </div>
                        </div>
                    </div>
                    <!-- <div class="col-lg-4"> -->
                    <?php 
                        // foreach ($dataKriteria as $key => $kriteria):
                        ?>
                    <!-- <div class="mb-3">
                            <label for="<?=$kriteria['id_kriteria'];?>"
                                class="form-label"><?=$kriteria['nama_kriteria'];?></label>
                            <input type="number" class="form-control" id="<?=$kriteria['id_kriteria'];?>"
                                name="<?=$kriteria['id_kriteria'];?>" min="0" max="100">
                        </div> -->
                    <?php 
                        // endforeach
                        ?>
                    <!-- </div> -->
                    <div class="col-lg-4">
                        <?php foreach ($dataKriteria as $key => $kriteria): ?>
                        <div class="mb-3">
                            <label for="<?= $kriteria['id_kriteria']; ?>"
                                class="form-label"><?= $kriteria['nama_kriteria']; ?></label>
                            <select class="form-control" id="<?= $kriteria['id_kriteria']; ?>"
                                name="<?= $kriteria['id_kriteria']; ?>">
                                <option value="">-- Pilih --</option>
                                <option value="1">1 - Tidak Penting</option>
                                <option value="2">2 - Kurang Penting</option>
                                <option value="3">3 - Penting</option>
                                <option value="4">4 - Sangat Penting</option>
                            </select>
                        </div>
                        <?php endforeach; ?>
                    </div>
                    <div class="col-lg-12 d-flex justify-content-center mb-5 mt-lg-5">
                        <a class="btn btn-danger me-2" href="./index.php">Kembali</a>
                        <button type="submit" name="hasil-perengkingan" class="btn btn-primary">Hasil
                            Perangkingan</button>
                    </div>
                </div>
            </div>
        </form>
    </div>
    <!-- Jumbotron -->
</section>
<?php require 'footer.php'; ?>