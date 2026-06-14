<?php

require_once('koneksi.php');

$query = mysqli_query(
    $koneksi,
    "SELECT * FROM kategori"
);

$data = array();

while ($row = mysqli_fetch_array($query)) {

    $data[] = array(
        'id_kategori' => $row['id_kategori'],
        'nama_kategori' => $row['nama_kategori']
    );
}

echo json_encode($data);
