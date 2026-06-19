<?php
// File: index.php

// 1. Import file koneksi dan semua kelas yang diperlukan
require_once 'koneksi/database.php';
require_once 'PendaftaranReguler.php';
require_once 'PendaftaranPrestasi.php';
require_once 'PendaftaranKedinasan.php';

// 2. Inisialisasi koneksi database
$database = new Database();
$db = $database->getConnection();

// 3. Ambil data mentah dari database menggunakan metode query spesifik (Tahap 4)
$dataRegulerMurni   = PendaftaranReguler::getDaftarReguler($db);
$dataPrestasiMurni  = PendaftaranPrestasi::getDaftarPrestasi($db);
$dataKedinasanMurni = PendaftaranKedinasan::getDaftarKedinasan($db);

/**
 * Fungsi pembantu untuk memformat angka ke dalam bentuk Rupiah
 */
function formatRupiah($angka) {
    return "Rp " . number_format($angka, 0, ',', '.');
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Simulasi PBO - Daftar Pendaftaran Mahasiswa Baru</title>
    <style>
        body { font-family: Arial, sans-serif; margin: 30px; background-color: #f4f6f9; color: #333; }
        h1 { text-align: center; color: #2c3e50; }
        h2 { margin-top: 40px; color: #2980b9; border-bottom: 2px solid #2980b9; padding-bottom: 8px; }
        table { width: 100%; border-collapse: collapse; margin-top: 15px; background: #fff; box-shadow: 0 2px 5px rgba(0,0,0,0.1); }
        th, td { padding: 12px 15px; text-align: left; border: 1px solid #ddd; }
        th { background-color: #34495e; color: #fff; }
        tr:nth-child(even) { background-color: #f9f9f9; }
        tr:hover { background-color: #f1f1f1; }
        .text-right { text-align: right; }
        .badge { background-color: #e74c3c; color: white; padding: 4px 8px; border-radius: 4px; font-size: 12px; }
    </style>
</head>
<body>

    <h1>Daftar Pendaftaran Mahasiswa Baru</h1>
    <p style="text-align: center; font-style: italic;">Sistem Simulasi PBO Berbasis Web</p>

    <h2>Kategori: Jalur Reguler</h2>
    <table>
        <thead>
            <tr>
                <th>ID</th>
                <th>Nama Calon</th>
                <th>Asal Sekolah</th>
                <th>Nilai Ujian</th>
                <th>Biaya Dasar</th>
                <th>Informasi Spesifik Jalur (Polimorfik)</th>
                <th>Total Biaya Akhir (Polimorfik)</th>
            </tr>
        </thead>
        <tbody>
            <?php if (empty($dataRegulerMurni)): ?>
                <tr><td colspan="7" style="text-align: center;">Tidak ada data calon mahasiswa jalur Reguler.</td></tr>
            <?php else: ?>
                <?php foreach ($dataRegulerMurni as $row): ?>
                    <?php 
                    // Instansiasi objek konkrit secara dinamis dari data baris database
                    $objekReguler = new PendaftaranReguler(
                        $row['id_pendaftaran'], $row['nama_calon'], $row['asal_sekolah'], 
                        $row['nilai_ujian'], $row['biaya_pendaftaran_dasar'],
                        $row['pilihan_prodi'], $row['lokasi_campust'] ?? $row['lokasi_kampus']
                    );
                    ?>
                    <tr>
                        <td><?= $objekReguler->getIdPendaftaran(); ?></td>
                        <td><strong><?= htmlspecialchars($objekReguler->getNamaCalon()); ?></strong></td>
                        <td><?= htmlspecialchars($objekReguler->getAsalSekolah()); ?></td>
                        <td><?= $objekReguler->getNilaiUjian(); ?></td>
                        <td><?= formatRupiah($objekReguler->getBiayaPendaftaranDasar()); ?></td>
                        <td><?= htmlspecialchars($objekReguler->tampilkanInfoJalur()); ?></td>
                        <td class="text-right" style="font-weight: bold; color: #27ae60;"><?= formatRupiah($objekReguler->hitungTotalBiaya()); ?></td>
                    </tr>
                <?php endforeach; ?>
            <?php endif; ?>
        </tbody>
    </table>


    <h2>Kategori: Jalur Prestasi</h2>
    <table>
        <thead>
            <tr>
                <th>ID</th>
                <th>Nama Calon</th>
                <th>Asal Sekolah</th>
                <th>Nilai Ujian</th>
                <th>Biaya Dasar</th>
                <th>Informasi Spesifik Jalur (Polimorfik)</th>
                <th>Total Biaya Akhir (Polimorfik)</th>
            </tr>
        </thead>
        <tbody>
            <?php if (empty($dataPrestasiMurni)): ?>
                <tr><td colspan="7" style="text-align: center;">Tidak ada data calon mahasiswa jalur Prestasi.</td></tr>
            <?php else: ?>
                <?php foreach ($dataPrestasiMurni as $row): ?>
                    <?php 
                    // Instansiasi objek konkrit Prestasi
                    $objekPrestasi = new PendaftaranPrestasi(
                        $row['id_pendaftaran'], $row['nama_calon'], $row['asal_sekolah'], 
                        $row['nilai_ujian'], $row['biaya_pendaftaran_dasar'],
                        $row['jenis_prestasi'], $row['tingkat_prestasi']
                    );
                    ?>
                    <tr>
                        <td><?= $objekPrestasi->getIdPendaftaran(); ?></td>
                        <td><strong><?= htmlspecialchars($objekPrestasi->getNamaCalon()); ?></strong></td>
                        <td><?= htmlspecialchars($objekPrestasi->getAsalSekolah()); ?></td>
                        <td><?= $objekPrestasi->getNilaiUjian(); ?></td>
                        <td><?= formatRupiah($objekPrestasi->getBiayaPendaftaranDasar()); ?></td>
                        <td><?= htmlspecialchars($objekPrestasi->tampilkanInfoJalur()); ?></td>
                        <td class="text-right" style="font-weight: bold; color: #27ae60;"><?= formatRupiah($objekPrestasi->hitungTotalBiaya()); ?></td>
                    </tr>
                <?php endforeach; ?>
            <?php endif; ?>
        </tbody>
    </table>


    <h2>Kategori: Jalur Kedinasan</h2>
    <table>
        <thead>
            <tr>
                <th>ID</th>
                <th>Nama Calon</th>
                <th>Asal Sekolah</th>
                <th>Nilai Ujian</th>
                <th>Biaya Dasar</th>
                <th>Informasi Spesifik Jalur (Polimorfik)</th>
                <th>Total Biaya Akhir (Polimorfik)</th>
            </tr>
        </thead>
        <tbody>
            <?php if (empty($dataKedinasanMurni)): ?>
                <tr><td colspan="7" style="text-align: center;">Tidak ada data calon mahasiswa jalur Kedinasan.</td></tr>
            <?php else: ?>
                <?php foreach ($dataKedinasanMurni as $row): ?>
                    <?php 
                    // Instansiasi objek konkrit Kedinasan
                    $objekKedinasan = new PendaftaranKedinasan(
                        $row['id_pendaftaran'], $row['nama_calon'], $row['asal_sekolah'], 
                        $row['nilai_ujian'], $row['biaya_pendaftaran_dasar'],
                        $row['sk_ikatan_dinas'], $row['instansi_sponsor']
                    );
                    ?>
                    <tr>
                        <td><?= $objekKedinasan->getIdPendaftaran(); ?></td>
                        <td><strong><?= htmlspecialchars($objekKedinasan->getNamaCalon()); ?></strong></td>
                        <td><?= htmlspecialchars($objekKedinasan->getAsalSekolah()); ?></td>
                        <td><?= $objekKedinasan->getNilaiUjian(); ?></td>
                        <td><?= formatRupiah($objekKedinasan->getBiayaPendaftaranDasar()); ?></td>
                        <td><?= htmlspecialchars($objekKedinasan->tampilkanInfoJalur()); ?></td>
                        <td class="text-right" style="font-weight: bold; color: #27ae60;"><?= formatRupiah($objekKedinasan->hitungTotalBiaya()); ?></td>
                    </tr>
                <?php endforeach; ?>
            <?php endif; ?>
        </tbody>
    </table>

</body>
</html>