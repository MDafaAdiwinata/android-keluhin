<?php
require_once('koneksi.php');

// Tampilkan error untuk debugging (hapus setelah selesai)
ini_set('display_errors', 1);
error_reporting(E_ALL);

header('Content-Type: application/json');

$id_laporan = $_GET['id'] ?? '';
$id_user    = $_GET['id_user'] ?? '';

if (empty($id_laporan) || empty($id_user)) {
    echo json_encode(['error' => 'Parameter id atau id_user tidak lengkap']);
    exit;
}

// Gunakan prepared statement
$query = "SELECT id_laporan, judul_laporan, isi_laporan, tgl_kejadian, 
                 image, id_kategori, status, keterangan_status
          FROM laporan 
          WHERE id_laporan = ? AND id_user = ? AND status = 'pending'";

$stmt = mysqli_prepare($koneksi, $query);
if (!$stmt) {
    echo json_encode(['error' => 'Database error: ' . mysqli_error($koneksi)]);
    exit;
}

mysqli_stmt_bind_param($stmt, "ii", $id_laporan, $id_user);
mysqli_stmt_execute($stmt);
$result = mysqli_stmt_get_result($stmt);

if (mysqli_num_rows($result) == 0) {
    echo json_encode(['error' => 'Laporan tidak ditemukan atau tidak bisa diedit']);
    exit;
}

$data = mysqli_fetch_assoc($result);
echo json_encode($data);
