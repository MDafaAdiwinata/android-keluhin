<?php

require_once('koneksi.php');

$id = $_GET['id'];

$query = mysqli_query(

    $koneksi,

    "SELECT

        laporan.*,

        kategori.nama_kategori,

        users.nama_lengkap,
        users.nis,
        users.kelas,
        users.username

    FROM laporan

    JOIN kategori
    ON laporan.id_kategori = kategori.id_kategori

    JOIN users
    ON laporan.id_user = users.id_user

    WHERE laporan.id_laporan='$id'"
);

$data = mysqli_fetch_assoc($query);

echo json_encode($data);

mysqli_close($koneksi);

?>