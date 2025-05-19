<?php

session_start();
if (!empty($_SESSION['admin'])) {
    require '../../config.php';

    if (!empty(htmlentities($_GET['bahanbaku']))) {
        $id = intval($_GET['id']);
        $data[] = $id;
        // cek table formulasi
        $cek = "SELECT * FROM tbl_formulasi WHERE bahanbaku_id = :id";
        $cekHasil = $config->prepare($cek);
        $cekHasil->execute(['id' => $id]);

        $cekValidasi = $cekHasil->fetchAll(); // Ambil semua hasil query
        // cek table formulasi
        if (count($cekValidasi) > 0) {
            // Ada data yang dikembalikan
            echo "<script>
                    alert('tidak bisa di hapus, Bahan baku di gunakan pada formulasi');
                    window.history.back();
                </script>";
        } else {
            // Tidak ada data
            // echo "Tidak ada relasi di tabel formulasi.";
            $sql = 'DELETE FROM tbl_bahan_baku WHERE recid=?';
            $row = $config->prepare($sql);
            $row->execute($data);
            echo '<script>window.location="../../index.php?page=bahanbaku&&remove=hapus-data"</script>';
        }
    }

    if (!empty(htmlentities($_GET['client']))) {
        $id= htmlentities($_GET['id']);
        $data[] = $id;
        $sql = 'DELETE FROM tbl_client WHERE recid=?';
        $row = $config -> prepare($sql);
        $row -> execute($data);
        echo '<script>window.location="../../index.php?page=client&&remove=hapus-data"</script>';
    }

    if (!empty(htmlentities($_GET['uom']))) {
        $id = intval($_GET['id']);

        // Hapus dari DB
        $stmt = $config->prepare("DELETE FROM uom WHERE recid = ?");
        $stmt->execute([$id]);

        header("Location: ../../index.php?page=uom&remove=1");
        exit;
    }

    if (!empty(htmlentities($_GET['inventaris']))) {
        $id= htmlentities($_GET['id']);
        $data[] = $id;
        $sql = 'DELETE FROM tbl_inventaris WHERE recid=?';
        $row = $config -> prepare($sql);
        $row -> execute($data);
        echo '<script>window.location="../../index.php?page=inventaris&&remove=hapus-data"</script>';
    }

    if (!empty(htmlentities($_GET['product']))) {
        $id= htmlentities($_GET['id']);
        $data[] = $id;
        $sql = 'DELETE FROM tbl_product WHERE recid=?';
        $row = $config -> prepare($sql);
        $row -> execute($data);
        echo '<script>window.location="../../index.php?page=product&&remove=hapus-data"</script>';
    }

    if (!empty($_GET['supplier'])) {
        $id = $_GET['id'];
    
        $sql = "DELETE FROM tbl_supplier WHERE recid = ?";
        $row = $config->prepare($sql);
        $row->execute([$id]);
    
        echo '<script>window.location="../../index.php?page=supplier&remove=hapus";</script>';
    }

    if (!empty($_GET['tempat_produksi'])) {
        $id = $_GET['id'];
    
        $sql = "DELETE FROM tbl_tmpt_produksi WHERE recid = ?";
        $row = $config->prepare($sql);
        $row->execute([$id]);
    
        echo '<script>window.location="../../index.php?page=tempat_produksi&remove=hapus";</script>';
    }
    
    if (!empty($_GET['user'])) {
        $id = $_GET['id'];
    
        $sql = "DELETE FROM tbl_user WHERE recid = ?";
        $row = $config->prepare($sql);
        $row->execute([$id]);
    
        echo '<script>window.location="../../index.php?page=user&remove=hapus";</script>';
    }
    
    if (!empty($_GET['number_sequence'])) {
        $id = $_GET['id'];
    
        $sql = "DELETE FROM number_sequences WHERE recid = ?";
        $row = $config->prepare($sql);
        $row->execute([$id]);
    
        echo '<script>window.location="../../index.php?page=number_sequence&remove=hapus";</script>';
    }

    if (!empty($_GET['transaksi_bahan_baku'])) {
        $id = $_GET['id'];

        $sql = "DELETE FROM tbl_transaksi_bahanbaku WHERE recid = ?";
        $row = $config->prepare($sql);
        $row->execute([$id]);

        echo '<script>window.location="../../index.php?page=transaksi_bahan_baku&success=hapus";</script>';
    }

    if (!empty($_GET['formulasi']) && $_GET['formulasi'] == 'hapus') {
        echo "<pre>";
        // print_r($_GET);
        // Ambil dan sanitasi input
        $recid = intval($_GET['id']);
        $produk_id = intval($_GET['productt']);

        // Query hapus
        $sql = "DELETE FROM tbl_formulasi WHERE recid = ?";
        $stmt = $config->prepare($sql);
        $stmt->execute([$recid]);

        // Redirect ke halaman detail produk setelah hapus
        echo '<script>window.location="../../index.php?page=product/details&product=' . $produk_id . '&success=hapus";</script>';
    }
    if ($_GET['aksi'] == 'hapus_inventaris_client') {
        $id = $_GET['id'];
        $client = $_GET['clientt'];
        $sql = "DELETE FROM tbl_relasi_inven WHERE recid = ?";
        $query = $config->prepare($sql);
        $query->execute([$id]);
        header("location:../../index.php?page=client/details&client=$client&success=hapus");
    }




    if (!empty(htmlentities($_GET['kategori']))) {
        $id= htmlentities($_GET['id']);
        $data[] = $id;
        $sql = 'DELETE FROM kategori WHERE id_kategori=?';
        $row = $config -> prepare($sql);
        $row -> execute($data);
        echo '<script>window.location="../../index.php?page=kategori&&remove=hapus-data"</script>';
    }

    if (!empty(htmlentities($_GET['barang']))) {
        $id= htmlentities($_GET['id']);
        $data[] = $id;
        $sql = 'DELETE FROM barang WHERE id_barang=?';
        $row = $config -> prepare($sql);
        $row -> execute($data);
        echo '<script>window.location="../../index.php?page=barang&&remove=hapus-data"</script>';
    }

    if (!empty(htmlentities($_GET['jual']))) {
        $dataI[] = htmlentities($_GET['brg']);
        $sqlI = 'select*from barang where id_barang=?';
        $rowI = $config -> prepare($sqlI);
        $rowI -> execute($dataI);
        $hasil = $rowI -> fetch();

        /*$jml = htmlentities($_GET['jml']) + $hasil['stok'];

        $dataU[] = $jml;
        $dataU[] = htmlentities($_GET['brg']);
        $sqlU = 'UPDATE barang SET stok =? where id_barang=?';
        $rowU = $config -> prepare($sqlU);
        $rowU -> execute($dataU);*/

        $id = htmlentities($_GET['id']);
        $data[] = $id;
        $sql = 'DELETE FROM penjualan WHERE id_penjualan=?';
        $row = $config -> prepare($sql);
        $row -> execute($data);
        echo '<script>window.location="../../index.php?page=jual"</script>';
    }

    if (!empty(htmlentities($_GET['penjualan']))) {
        $sql = 'DELETE FROM penjualan';
        $row = $config -> prepare($sql);
        $row -> execute();
        echo '<script>window.location="../../index.php?page=jual"</script>';
    }
    
    if (!empty(htmlentities($_GET['laporan']))) {
        $sql = 'DELETE FROM nota';
        $row = $config -> prepare($sql);
        $row -> execute();
        echo '<script>window.location="../../index.php?page=laporan&remove=hapus"</script>';
    }
}
