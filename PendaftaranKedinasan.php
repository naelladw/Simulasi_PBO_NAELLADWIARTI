<?php
// File: PendaftaranKedinasan.php
require_once 'Pendaftaran.php';

class PendaftaranKedinasan extends Pendaftaran {
    private $skIkatanDinas;
    private $instansiSponsor;

    // Constructor untuk menginisialisasi properti induk dan anak
    public function __construct($id_pendaftaran, $nama_calon, $asal_sekolah, $nilai_ujian, $biayaPendaftaranDasar, $skIkatanDinas, $instansiSponsor) {
        parent::__construct($id_pendaftaran, $nama_calon, $asal_sekolah, $nilai_ujian, $biayaPendaftaranDasar);
        $this->skIkatanDinas = $skIkatanDinas;
        $this->instansiSponsor = $instansiSponsor;
    }

    // Getter untuk properti spesifik
    public function getSkIkatanDinas() { return $this->skIkatanDinas; }
    public function getInstansiSponsor() { return $this->instansiSponsor; }

    // Metode Query Spesifik (Mengambil semua kolom untuk jalur Kedinasan)
    public static function getDaftarKedinasan($db) {
        $query = "SELECT * FROM tabel_pendaftaran WHERE jalur_pendaftaran = 'Kedinasan'";
        $stmt = $db->prepare($query);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    // --- METHOD OVERRIDING LOGIKA KEDINASAN (TAHAP 5) ---
    // Dikenakan surcharge/biaya tambahan administrasi khusus kemitraan dinas sebesar 25%
    public function hitungTotalBiaya() {
        return $this->biayaPendaftaranDasar * 1.25;
    }

    // Implementasi metode abstrak dari induk untuk menampilkan informasi jalur
    public function tampilkanInfoJalur() {
        return "Jalur Kedinasan - Sponsor: " . $this->instansiSponsor . " (No SK: " . $this->skIkatanDinas . ")";
    }
}
?>