<?php
// File: PendaftaranPrestasi.php
require_once 'Pendaftaran.php';

class PendaftaranPrestasi extends Pendaftaran {
    private $jenisPrestasi;
    private $tingkatPrestasi;

    // Constructor untuk menginisialisasi properti induk dan anak
    public function __construct($id_pendaftaran, $nama_calon, $asal_sekolah, $nilai_ujian, $biayaPendaftaranDasar, $jenisPrestasi, $tingkatPrestasi) {
        parent::__construct($id_pendaftaran, $nama_calon, $asal_sekolah, $nilai_ujian, $biayaPendaftaranDasar);
        $this->jenisPrestasi = $jenisPrestasi;
        $this->tingkatPrestasi = $tingkatPrestasi;
    }

    // Getter untuk properti spesifik
    public function getJenisPrestasi() { return $this->jenisPrestasi; }
    public function getTingkatPrestasi() { return $this->tingkatPrestasi; }

    // Metode Query Spesifik (Mengambil semua kolom untuk jalur Prestasi)
    public static function getDaftarPrestasi($db) {
        $query = "SELECT * FROM tabel_pendaftaran WHERE jalur_pendaftaran = 'Prestasi'";
        $stmt = $db->prepare($query);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    // --- METHOD OVERRIDING LOGIKA PRESTASI (TAHAP 5) ---
    // Mendapatkan potongan/insentif apresiasi prestasi sebesar Rp50.000 dari biaya dasar
    public function hitungTotalBiaya() {
        return $this->biayaPendaftaranDasar - 50000;
    }

    // Implementasi metode abstrak dari induk untuk menampilkan informasi jalur
    public function tampilkanInfoJalur() {
        return "Jalur Prestasi - Jenis: " . $this->jenisPrestasi . " Tingkat " . $this->tingkatPrestasi;
    }
}
?>