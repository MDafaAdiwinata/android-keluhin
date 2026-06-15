<?php
$host = getenv('DB_HOST')     ?: 'localhost';
$user = getenv('DB_USER')     ?: 'root';
$pass = getenv('DB_PASS')     ?: '';
$db   = getenv('DB_NAME')     ?: 'nama_db_kamu';
$port = getenv('DB_PORT')     ?: 3306;

$koneksi = new mysqli($host, $user, $pass, $db, (int)$port);

if (!$koneksi) {
    die("Koneksi Gagal: " . mysqli_connect_error());
}
