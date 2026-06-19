<?php
// File: Pendaftaran.php.
abstract class Pendaftaran {
    // Properti/Atribut Terenkapsulasi (protected)
    protected $id_pendaftaran;
    protected $nama_calon;
    protected $asal_sekolah;
    protected $nilai_ujian;
    protected $biayaPendaftaranDasar;

    // Constructor untuk memetakan nilai dari kolom tabel database
    public function __construct($id_pendaftaran, $nama_calon, $asal_sekolah, $nilai_ujian, $biayaPendaftaranDasar) {
        $this->id_pendaftaran = $id_pendaftaran;
        $this->nama_calon = $nama_calon;
        $this->asal_sekolah = $asal_sekolah;
        $this->nilai_ujian = $nilai_ujian;
        $this->biayaPendaftaranDasar = $biayaPendaftaranDasar;
    }

    // Metode Getter (Opsional, berguna untuk mengakses properti protected di kelas luar/main)
    public function getIdPendaftaran() { return $this->id_pendaftaran; }
    public function getNamaCalon() { return $this->nama_calon; }
    public function getAsalSekolah() { return $this->asal_sekolah; }
    public function getNilaiUjian() { return $this->nilai_ujian; }
    public function getBiayaPendaftaranDasar() { return $this->biayaPendaftaranDasar; }

    // --- Langkah 4: Deklarasi Metode Abstrak (Tanpa Isi/Body) ---
    
    /**
     * Menghitung total biaya pendaftaran berdasarkan aturan spesifik masing-masing jalur.
     * Wajib diimplementasikan oleh class anak (Reguler, Prestasi, Kedinasan).
     */
    abstract public function hitungTotalBiaya();

    /**
     * Menampilkan informasi spesifik mengenai jalur pendaftaran yang dipilih.
     * Wajib diimplementasikan oleh class anak (Reguler, Prestasi, Kedinasan).
     */
    abstract public function tampilkanInfoJalur();
}
?>