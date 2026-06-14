<?php

require_once('koneksi.php');

$sql = "SELECT * FROM jurusan
        WHERE status='aktif'";

$query = mysqli_query($koneksi, $sql);

$result = array();

while ($row = mysqli_fetch_array($query)) {

    array_push($result, array(
        'id_jurusan' => $row['id_jurusan'],
        'nama_jurusan' => $row['nama_jurusan']
    ));
}

echo json_encode($result);

mysqli_close($koneksi);
