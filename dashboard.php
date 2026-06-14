<?php

require_once('koneksi.php');

$id_user = $_GET['id_user'];

$response = array();

$total = mysqli_num_rows(
    mysqli_query(
        $koneksi,
        "SELECT * FROM laporan
         WHERE id_user='$id_user'"
    )
);

$pending = mysqli_num_rows(
    mysqli_query(
        $koneksi,
        "SELECT * FROM laporan
         WHERE id_user='$id_user'
         AND status='pending'"
    )
);

$proses = mysqli_num_rows(
    mysqli_query(
        $koneksi,
        "SELECT * FROM laporan
         WHERE id_user='$id_user'
         AND status='proses'"
    )
);

$selesai = mysqli_num_rows(
    mysqli_query(
        $koneksi,
        "SELECT * FROM laporan
         WHERE id_user='$id_user'
         AND status='selesai'"
    )
);

$ditolak = mysqli_num_rows(
    mysqli_query(
        $koneksi,
        "SELECT * FROM laporan
         WHERE id_user='$id_user'
         AND status='ditolak'"
    )
);

$response['total'] = $total;
$response['pending'] = $pending;
$response['proses'] = $proses;
$response['selesai'] = $selesai;
$response['ditolak'] = $ditolak;

$latest = array();

$query = mysqli_query(
    $koneksi,
    "SELECT
        laporan.*,
        kategori.nama_kategori
     FROM laporan
     JOIN kategori
     ON laporan.id_kategori = kategori.id_kategori
     WHERE laporan.id_user='$id_user'
     ORDER BY laporan.id_laporan DESC
     LIMIT 3"
);

while ($row = mysqli_fetch_array($query)) {

    $latest[] = array(

        'id_laporan' => $row['id_laporan'],
        'judul_laporan' => $row['judul_laporan'],
        'isi_laporan' => $row['isi_laporan'],
        'tgl_kejadian' => $row['tgl_kejadian'],
        'status' => $row['status'],
        'keterangan_status' => $row['keterangan_status'],
        'image' => $row['image'],
        'nama_kategori' => $row['nama_kategori'],
        'created_at' => $row['created_at']
    );
}

$response['latest'] = $latest;

echo json_encode($response);

mysqli_close($koneksi);
