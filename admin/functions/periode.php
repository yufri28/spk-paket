<?php 

    require_once '../config.php';
    
    class Periode{
        private $db;
        public function __construct()
        {
            $this->db = connectDatabase();
        }

       
        public function getPeriode(){
            return $this->db->query("SELECT * FROM `periode` WHERE id_periode!=-1");
        }

        public function tambahPeriode($dataPeriode)
        {
            // Cek apakah nama periode sudah ada
            $cek = $this->db->query("SELECT * FROM periode WHERE nama_periode='".$dataPeriode['nama_periode']."'");
            if (mysqli_num_rows($cek) > 0) {
                $_SESSION['error'] = 'Nama Periode sudah ada!';
                return;
            }

            // Jika status yang akan ditambahkan adalah "aktif", nonaktifkan semua periode lain yang saat ini aktif
            if ($dataPeriode['status'] == 'aktif') {
                $stmtDeactivateAll = $this->db->prepare("UPDATE periode SET status = 'nonaktif' WHERE status = 'aktif'");
                $stmtDeactivateAll->execute();
                $stmtDeactivateAll->close();
            }

            // Lanjutkan dengan menambahkan periode baru
            $stmtInsert = $this->db->prepare("INSERT INTO periode(nama_periode, deskripsi, kuota, status) VALUES (?, ?, ?, ?)");
            $stmtInsert->bind_param("ssis", $dataPeriode['nama_periode'], $dataPeriode['deskripsi'], $dataPeriode['kuota'], $dataPeriode['status']);
            $stmtInsert->execute();

            if ($stmtInsert->affected_rows > 0) {
                $_SESSION['success'] = 'Data berhasil ditambahkan!';
            } else {
                $_SESSION['error'] = 'Terjadi kesalahan dalam menyimpan data.';
            }

            $stmtInsert->close();
        }

        
        public function editPeriode($dataPeriode)
        {
            // Jika periode baru yang diedit memiliki status "aktif", nonaktifkan semua periode lain
            if ($dataPeriode['status'] == 'aktif') {
                $stmtDeactivateAll = $this->db->prepare("UPDATE periode SET status = 'nonaktif' WHERE status = 'aktif'");
                $stmtDeactivateAll->execute();
                $stmtDeactivateAll->close();
            }

            // Lanjutkan untuk mengupdate periode yang diedit
            $stmtUpdatePeriode = $this->db->prepare("UPDATE periode SET nama_periode=?, deskripsi=?, kuota=?, status=? WHERE id_periode=?");
            $stmtUpdatePeriode->bind_param("ssisi", $dataPeriode['nama_periode'], $dataPeriode['deskripsi'], $dataPeriode['kuota'], $dataPeriode['status'], $dataPeriode['id_periode']);
            $stmtUpdatePeriode->execute();

            if ($stmtUpdatePeriode->affected_rows > 0) {
                $_SESSION['success'] = 'Data berhasil diedit!';
            } else {
                $_SESSION['error'] = 'Terjadi kesalahan dalam mengedit data.';
            }

            $stmtUpdatePeriode->close();
        }

        public function hapusPeriode($idPeriode)
        {
            $stmtDelete = $this->db->prepare("DELETE FROM periode WHERE id_periode=?");
            $stmtDelete->bind_param("i",$idPeriode);
            $stmtDelete->execute();
            if ($stmtDelete->affected_rows > 0) {
                return $_SESSION['success'] = 'Data berhasil dihapus!';
            } else{
                return $_SESSION['error'] = 'Terjadi kesalahan dalam menghapus data.';
            }
            $stmtDelete->close();
            
        }
    }

    $Periode = new Periode();

?>