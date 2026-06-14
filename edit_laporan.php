<?php
require_once('koneksi.php');
header('Content-Type: application/json');

if ($_SERVER['REQUEST_METHOD'] != 'POST') {
    echo json_encode(['error' => 'Method tidak diizinkan']);
    exit;
}

$id_laporan   = $_POST['id_laporan']    ?? '';
$id_user      = $_POST['id_user']       ?? '';
$judul        = $_POST['judul_laporan'] ?? '';
$isi          = $_POST['isi_laporan']   ?? '';
$tgl_kejadian = $_POST['tgl_kejadian']  ?? '';
$id_kategori  = $_POST['id_kategori']   ?? '';
$image        = $_POST['image']         ?? '';

// Validasi
if (empty($id_laporan) || empty($id_user) || empty($judul) || empty($isi) || empty($tgl_kejadian) || empty($id_kategori)) {
    echo json_encode(['error' => 'Semua field harus diisi']);
    exit;
}

// Cek laporan milik user dan masih pending
$stmt = mysqli_prepare($koneksi, "SELECT status FROM laporan WHERE id_laporan = ? AND id_user = ?");
mysqli_stmt_bind_param($stmt, "ii", $id_laporan, $id_user);
mysqli_stmt_execute($stmt);
$result = mysqli_stmt_get_result($stmt);
$data   = mysqli_fetch_assoc($result);

if (!$data) {
    echo json_encode(['error' => 'Laporan tidak ditemukan']);
    exit;
}
if ($data['status'] != 'pending') {
    echo json_encode(['error' => 'Laporan tidak dapat diedit, status bukan pending']);
    exit;
}

// Update — image berisi public_id yang sudah diupload Android ke Cloudinary
$stmt = mysqli_prepare(
    $koneksi,
    "UPDATE laporan SET judul_laporan=?, isi_laporan=?, tgl_kejadian=?, id_kategori=?, image=?, updated_at=NOW()
     WHERE id_laporan=? AND id_user=?"
);

mysqli_stmt_bind_param($stmt, "sssssii", $judul, $isi, $tgl_kejadian, $id_kategori, $image, $id_laporan, $id_user);

if (mysqli_stmt_execute($stmt)) {
    echo json_encode(['success' => true, 'message' => 'Laporan berhasil diperbarui']);
} else {
    echo json_encode(['error' => 'Gagal update: ' . mysqli_error($koneksi)]);
}

?>