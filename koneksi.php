<?php
$server = "localhost";
$user = "root";
$pass = "";
$db = "keluhin";

$koneksi = mysqli_connect($server, $user, $pass, $db);

if (!$koneksi) {
    die("Koneksi Gagal: " . mysqli_connect_error());
}
