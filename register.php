<?php

require_once('koneksi.php');

if ($_SERVER['REQUEST_METHOD'] == 'POST') {

    $id_jurusan = $_POST['id_jurusan'];
    $nis = $_POST['nis'];
    $nama = $_POST['nama_lengkap'];
    $username = $_POST['username'];
    $email = $_POST['email'];
    $password = password_hash(
        $_POST['password'],
        PASSWORD_DEFAULT
    );
    $kelas = $_POST['kelas'];

    $cek = mysqli_query(
        $koneksi,
        "SELECT * FROM users
         WHERE username='$username'
         OR email='$email'
         OR nis='$nis'"
    );

    $result = array();

    if (mysqli_num_rows($cek) > 0) {

        $result['status'] = "failed";
        $result['message'] = "Data sudah digunakan";
    } else {

        $sql = "INSERT INTO users(
                    id_jurusan,
                    nis,
                    nama_lengkap,
                    username,
                    email,
                    password,
                    kelas,
                    role,
                    status,
                    email_verified_at,
                    created_at,
                    updated_at
                )

                VALUES(
                    '$id_jurusan',
                    '$nis',
                    '$nama',
                    '$username',
                    '$email',
                    '$password',
                    '$kelas',
                    'siswa',
                    'nonaktif',
                    NOW(),
                    NOW(),
                    NOW()
                )";

        if (mysqli_query($koneksi, $sql)) {

            $result['status'] = "success";
            $result['message'] =
                "Register berhasil, tunggu akun diaktifkan admin";
        } else {

            $result['status'] = "failed";
            $result['message'] = "Register gagal";
        }
    }

    echo json_encode($result);

    mysqli_close($koneksi);
}
