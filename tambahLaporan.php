<?php

require_once('koneksi.php');

if ($_SERVER['REQUEST_METHOD'] == 'POST') {

    $id_user = $_POST['id_user'];

    $id_kategori = $_POST['id_kategori'];

    $judul =
        $_POST['judul_laporan'];

    $isi =
        $_POST['isi_laporan'];

    $tanggal =
        $_POST['tgl_kejadian'];

    $image =
        $_POST['image'];

    $query = mysqli_query(

        $koneksi,

        "INSERT INTO laporan(

            id_user,
            id_kategori,
            judul_laporan,
            isi_laporan,
            tgl_kejadian,
            image,
            status,
            keterangan_status,
            created_at,
            updated_at

        )

        VALUES(

            '$id_user',
            '$id_kategori',
            '$judul',
            '$isi',
            '$tanggal',
            '$image',
            'pending',
            'Laporan dalam pending',
            NOW(),
            NOW()
        )"
    );

    $result = array();

    if ($query) {

        $result['status'] = "success";

        $result['message'] =
            "Laporan berhasil dikirim";
    } else {

        $result['status'] = "failed";

        $result['message'] =
            "Gagal tambah laporan";
    }

    echo json_encode($result);
}
