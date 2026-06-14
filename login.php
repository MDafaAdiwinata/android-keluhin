<?php

require_once('koneksi.php');

if ($_SERVER['REQUEST_METHOD'] == 'POST') {

    $username = $_POST['username'];
    $password = $_POST['password'];

    $query = mysqli_query(
        $koneksi,
        "SELECT * FROM users
         WHERE username='$username'
         AND role='siswa'"
    );

    $result = array();

    if ($row = mysqli_fetch_array($query)) {

        if (password_verify($password, $row['password'])) {

            $result['status'] = "success";

            $result['message'] =
                "Login berhasil";

            $result['id_user'] =
                $row['id_user'];

            $result['nama_lengkap'] =
                $row['nama_lengkap'];

            $result['status_akun'] =
                $row['status'];
        } else {

            $result['status'] = "failed";

            $result['message'] =
                "Password salah";
        }
    } else {

        $result['status'] = "failed";

        $result['message'] =
            "Username tidak ditemukan";
    }

    echo json_encode($result);
}
