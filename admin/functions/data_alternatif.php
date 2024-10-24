<?php 

    require_once '../config.php';
    class Alternatif{
        private $db;
        public function __construct()
        {
            $this->db = connectDatabase();
        }

        public function getAlternatif(){
           
            return $this->db->query("SELECT a.nama_alternatif, a.id_alternatif, a.gambar, a.latitude, a.longitude, a.konsep_gedung, a.alamat, kak.id_alt_kriteria, a.harga_sewa, a.fasilitas, a.kapasitas_tamu, a.kapasitas_parkir,
                MAX(CASE WHEN k.id_kriteria = 'C1' THEN kak.id_alt_kriteria END) AS id_alt_C1,
                MIN(CASE WHEN k.id_kriteria = 'C2' THEN kak.id_alt_kriteria END) AS id_alt_C2,
                MIN(CASE WHEN k.id_kriteria = 'C3' THEN kak.id_alt_kriteria END) AS id_alt_C3,
                MAX(CASE WHEN k.id_kriteria = 'C4' THEN kak.id_alt_kriteria END) AS id_alt_C4,
                MAX(CASE WHEN k.id_kriteria = 'C1' THEN k.id_kriteria END) AS id_kriteria_C1,
                MIN(CASE WHEN k.id_kriteria = 'C2' THEN k.id_kriteria END) AS id_kriteria_C2,
                MIN(CASE WHEN k.id_kriteria = 'C3' THEN k.id_kriteria END) AS id_kriteria_C3,
                MAX(CASE WHEN k.id_kriteria = 'C4' THEN k.id_kriteria END) AS id_kriteria_C4,
                MAX(CASE WHEN k.id_kriteria = 'C1' THEN kak.f_id_sub_kriteria END) AS id_sub_C1,
                MIN(CASE WHEN k.id_kriteria = 'C2' THEN kak.f_id_sub_kriteria END) AS id_sub_C2,
                MIN(CASE WHEN k.id_kriteria = 'C3' THEN kak.f_id_sub_kriteria END) AS id_sub_C3,
                MAX(CASE WHEN k.id_kriteria = 'C4' THEN kak.f_id_sub_kriteria END) AS id_sub_C4,
                MAX(CASE WHEN k.id_kriteria = 'C1' THEN sk.spesifikasi END) AS nama_C1,
                MIN(CASE WHEN k.id_kriteria = 'C2' THEN sk.spesifikasi END) AS nama_C2,
                MIN(CASE WHEN k.id_kriteria = 'C3' THEN sk.spesifikasi END) AS nama_C3,
                MAX(CASE WHEN k.id_kriteria = 'C4' THEN sk.spesifikasi END) AS nama_C4
                FROM alternatif a
                JOIN kec_alt_kriteria kak ON a.id_alternatif = kak.f_id_alternatif
                JOIN sub_kriteria sk ON kak.f_id_sub_kriteria = sk.id_sub_kriteria
                JOIN kriteria k ON kak.f_id_kriteria = k.id_kriteria
                GROUP BY a.nama_alternatif ORDER BY a.id_alternatif ASC;
            ");

        }

        public function getSubC1()
        {
           return $this->db->query(
                "SELECT * FROM sub_kriteria WHERE f_id_kriteria = 'C1'"
           );
        }
        public function getSubC2()
        {
           return $this->db->query(
                "SELECT * FROM sub_kriteria WHERE f_id_kriteria = 'C2'"
           );
        }
        public function getSubC3()
        {
           return $this->db->query(
                "SELECT * FROM sub_kriteria WHERE f_id_kriteria = 'C3'"
           );
        }

        public function getSubC4()
        {
           return $this->db->query(
                "SELECT * FROM sub_kriteria WHERE f_id_kriteria = 'C4'"
           );
        }

        // CRUD
        public function addDataAlternatif($dataAlternatif = [], $dataKecAltKrit = [])
        {
            if (empty($dataAlternatif) && empty($dataKecAltKrit)) {
                return $_SESSION['error'] = 'Tidak ada data yang dikirim!';
            }

            $nama_alternatif = $dataAlternatif['nama_alternatif'];
            $gambar = $dataAlternatif['gambar'];
            $alamat = $dataAlternatif['alamat'];
            $latitude = $dataAlternatif['latitude'];
            $longitude = $dataAlternatif['longitude'];
            $konsep_gedung = $dataAlternatif['konsep_gedung'];
            $harga_sewa = $dataAlternatif['harga_sewa'];
            $fasilitas = $dataAlternatif['fasilitas'];
            $kapasitas_tamu = $dataAlternatif['kapasitas_tamu'];
            $kapasitas_parkir = $dataAlternatif['kapasitas_parkir'];

            $cekData = $this->db->query("SELECT * FROM `alternatif` WHERE LOWER(nama_alternatif) = '" . strtolower($dataAlternatif['nama_alternatif']) . "'");
            if ($cekData->num_rows > 0) {
                return $_SESSION['error'] = 'Data sudah ada!';
            }

            $insertAlternatif = $this->db->query(
                "INSERT INTO alternatif (nama_alternatif, gambar, alamat, latitude, longitude, konsep_gedung, harga_sewa, fasilitas, kapasitas_tamu, kapasitas_parkir) VALUES ('$nama_alternatif', '$gambar', '$alamat', '$latitude', '$longitude', '$konsep_gedung', '$harga_sewa','$fasilitas','$kapasitas_tamu','$kapasitas_parkir')"
            );

            if ($insertAlternatif) {
                $id_alternatif = $this->db->insert_id;
              
                foreach ($dataKecAltKrit as $key => $id_sub_kriteria) {
                    $insertKecAltKrit = $this->db->query("INSERT INTO kec_alt_kriteria (id_alt_kriteria, f_id_alternatif, f_id_kriteria, f_id_sub_kriteria) VALUES (NULL, '$id_alternatif', '$key', '$id_sub_kriteria')");
                }
                if ($insertKecAltKrit && $this->db->affected_rows > 0) {
                    return $_SESSION['success'] = 'Data berhasil disimpan!';
                } else {
                    $this->db->query("DELETE FROM alternatif WHERE id_alternatif='$id_alternatif'");
                    return $_SESSION['error'] = 'Data gagal disimpan!';
                }
            } else {
                return $_SESSION['error'] = 'Data gagal disimpan!';
            }
        }

        public function editDataAlternatif($dataAlternatif = [], $dataKecAltKrit = [])
        {
            if (empty($dataAlternatif) && empty($dataKecAltKrit)) {
                return $_SESSION['error'] = 'Tidak ada data yang dikirim!';
            }
            $id_alternatif = $dataAlternatif['id_alternatif'];
            $nama_alternatif = $dataAlternatif['nama_alternatif'];
            $gambar = $dataAlternatif['gambar'];
            $alamat = $dataAlternatif['alamat'];
            $latitude = $dataAlternatif['latitude'];
            $longitude = $dataAlternatif['longitude'];
            $konsep_gedung = $dataAlternatif['konsep_gedung'];
            $harga_sewa = $dataAlternatif['harga_sewa'];
            $fasilitas = $dataAlternatif['fasilitas'];
            $kapasitas_tamu = $dataAlternatif['kapasitas_tamu'];
            $kapasitas_parkir = $dataAlternatif['kapasitas_parkir'];
            
            $updateAlternatif = $this->db->query(
                "UPDATE alternatif SET nama_alternatif = '$nama_alternatif',gambar='$gambar',alamat='$alamat', latitude='$latitude', longitude='$longitude', konsep_gedung='$konsep_gedung', harga_sewa='$harga_sewa', fasilitas='$fasilitas', kapasitas_tamu='$kapasitas_tamu', kapasitas_parkir='$kapasitas_parkir' WHERE id_alternatif = $id_alternatif"
            );

            if ($updateAlternatif) {
                // Update data kec_alt_kriteria
                foreach ($dataKecAltKrit as $key => $id_sub_kriteria) {
                    $updateKecAltKrit = $this->db->query("UPDATE kec_alt_kriteria SET f_id_sub_kriteria = '$id_sub_kriteria' WHERE f_id_alternatif = '$id_alternatif' AND f_id_kriteria = '$key'");
                }
                if ($updateKecAltKrit || $this->db->affected_rows > 0) {
                    return $_SESSION['success'] = 'Data berhasil diupdate!';
                } 
                else {
                    return $_SESSION['error'] = 'Data gagal diupdate!';
                }
            } else {
                return $_SESSION['error'] = 'Data gagal diupdate!';
            }
        }

        public function hapusDataAlternatif($id_alternatif)
        {
            $stmtSelect = $this->db->prepare("SELECT gambar FROM alternatif WHERE id_alternatif=?");
            $stmtSelect->bind_param("i", $id_alternatif);
            $stmtSelect->execute();
            $result = $stmtSelect->get_result();
            
            if ($result->num_rows > 0) {
                $row = $result->fetch_assoc();
                $gambar = $row['gambar'];
                     
                // Langkah 2: Hapus file gambar jika ada
                if (!empty($gambar)) {
                    $filePath = './../images/' . $gambar;  // Sesuaikan path folder upload
                    if (file_exists($filePath)) {
                        unlink($filePath);  // Hapus file dari server
                    }
                }

                $stmtSelect->close();

                // Langkah 3: Hapus data dari tabel alternatif
                $stmtDelete = $this->db->prepare("DELETE FROM alternatif WHERE id_alternatif=?");
                $stmtDelete->bind_param("i", $id_alternatif);
                $stmtDelete->execute();

                if ($stmtDelete->affected_rows > 0) {
                    $_SESSION['success'] = 'Data berhasil dihapus!';
                } else {
                    $_SESSION['error'] = 'Terjadi kesalahan dalam menghapus data.';
                }
                $stmtDelete->close();
            } else {
                $_SESSION['error'] = 'Data tidak ditemukan.';
            }
        }
    }

    $Alternatif = new Alternatif();

?>