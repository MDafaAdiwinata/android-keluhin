<?php

require_once('koneksi.php');

$id_user = $_GET['id_user'];

$query = mysqli_query(

    $koneksi,

    "SELECT

        laporan.*,
        kategori.nama_kategori

     FROM laporan

     JOIN kategori
     ON laporan.id_kategori = kategori.id_kategori

     WHERE laporan.id_user='$id_user'

     ORDER BY laporan.id_laporan DESC"
);

$result = array();

while ($row = mysqli_fetch_array($query)) {

    $result[] = array(

        'id_laporan' =>
        $row['id_laporan'],

        'judul_laporan' =>
        $row['judul_laporan'],

        'nama_kategori' =>
        $row['nama_kategori'],

        'status' =>
        $row['status'],

        'created_at' =>
        $row['created_at'],

        'image' =>
        $row['image']
    );
}

echo json_encode($result);

mysqli_close($koneksi);
