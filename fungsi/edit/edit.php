<?php
session_start();
if (!empty($_SESSION['admin'])) {
    require '../../config.php';

    if (!empty($_GET['bahanbaku'])) {
        $recid = htmlentities($_POST['recid']);
        $nama = htmlentities($_POST['nama']);
        $desc = htmlentities($_POST['desc']);
        $satuan = htmlentities($_POST['satuan']);
        $stok = htmlentities($_POST['stok']);
        $supplier = htmlentities($_POST['supplier']);

        $data[] = $nama;
        $data[] = $desc;
        $data[] = $stok;
        $data[] = $satuan;
        $data[] = $supplier;
        $data[] = $recid;

        $sql = 'UPDATE tbl_bahan_baku SET nama_bb=?, `desc`=?, stok=?, satuan=?, supp_id=? WHERE recid=?';
        $row = $config->prepare($sql);
        $row->execute($data);
        // echo $row;
        echo '<script>window.location="../../index.php?page=bahanbaku/edit&bahanbaku=' . $recid . '&success=edit-data"</script>';
    }

    if (!empty($_GET['client'])) {
        $recid         = htmlentities($_POST['recid']);
        $nama_client   = htmlentities($_POST['nama']);
        $alamat        = htmlentities($_POST['alamat']);
        $status        = intval(htmlentities($_POST['status']));
        $email         = htmlentities($_POST['email']);
        $no_telp       = (int) htmlentities($_POST['notelp']);
        $fax           = (int) htmlentities($_POST['fax']);

        $data[] = $nama_client;
        $data[] = $alamat;
        $data[] = $status;
        $data[] = $email;
        $data[] = $no_telp;
        $data[] = $fax;
        $data[] = $recid;

        $sql = 'UPDATE tbl_client SET nama_client=?, alamat=?, status=?, email=?, no_telp=?, fax=? where recid=?';
        $row = $config->prepare($sql);
        $row->execute($data);

        echo '<script>window.location="../../index.php?page=client/edit&client=' . $recid . '&success=edit-data";</script>';
    }

    if (!empty($_GET['inventaris'])) {
        $recid      = intval($_POST['id']);
        $nama       = htmlentities($_POST['nama']);
        $desc       = htmlentities($_POST['desc']);
        $jml        = intval($_POST['jml']);
        $jml_rusak  = isset($_POST['jml_rusak']) ? intval($_POST['jml_rusak']) : null;
        $jml_aktif  = isset($_POST['jml_aktif']) ? intval($_POST['jml_aktif']) : null;

        $edit_aktif_rusak = isset($_POST['check-edit-aktif-rusak']);
        $edit_total_saja  = isset($_POST['check-edit-total']);

        // Ambil data lama dari database
        $sqlOld = "SELECT jml, jml_rusak, jml_active FROM tbl_inventaris WHERE recid = ?";
        $stmtOld = $config->prepare($sqlOld);
        $stmtOld->execute([$recid]);
        $oldData = $stmtOld->fetch();

        if (!$oldData) {
            echo '<script>alert("Data tidak ditemukan!");window.location="../../index.php?page=inventaris";</script>';
            exit;
        }

        $old_jml = intval($oldData['jml']);
        $old_rusak = intval($oldData['jml_rusak']);
        $old_aktif = intval($oldData['jml_active']);

        if ($edit_aktif_rusak) {
            // Validasi: rusak + aktif harus = jumlah total
            $tambah = $jml_rusak + $jml_aktif;
            if ($tambah !== $jml) {
                echo '<script>alert("Jumlah rusak + aktif harus sama dengan jumlah total!");window.history.back();</script>';
                exit;
            }

            $sql = "UPDATE tbl_inventaris SET nama_inven=?, `desc`=?, jml=?, jml_rusak=?, jml_active=? WHERE recid=?";
            $stmt = $config->prepare($sql);
            $stmt->execute([$nama, $desc, $jml, $jml_rusak, $jml_aktif, $recid]);
        } elseif ($edit_total_saja) {
            // Validasi: jumlah total tidak boleh lebih kecil dari sebelumnya
            if ($jml < $old_jml) {
                echo '<script>alert("Jumlah total tidak boleh lebih kecil dari sebelumnya!");window.history.back();</script>';
                exit;
            }

            // Hitung aktif ulang
            $jml_rusak = $old_rusak;
            $jml_aktif = $jml - $jml_rusak;

            $sql = "UPDATE tbl_inventaris SET nama_inven=?, `desc`=?, jml=?, jml_rusak=?, jml_active=? WHERE recid=?";
            $stmt = $config->prepare($sql);
            $stmt->execute([$nama, $desc, $jml, $jml_rusak, $jml_aktif, $recid]);
        } else {
            // Tidak centang checkbox apapun -> update nama, desc, dan jumlah
            $sql = "UPDATE tbl_inventaris SET nama_inven=?, `desc`=?, jml=?, jml_active=? WHERE recid=?";
            $stmt = $config->prepare($sql);
            $stmt->execute([$nama, $desc, $jml, $jml, $recid]);
        }

        echo '<script>window.location="../../index.php?page=inventaris&success=edit-data";</script>';
    }

    if (!empty($_GET['product'])) {
        $recid         = htmlentities($_POST['id']);
        $nama_product  = htmlentities($_POST['nama_product']);
        $desc_product  = htmlentities($_POST['desc_product']);
        $grade         = htmlentities($_POST['grade']);
        $level         = htmlentities($_POST['level']);

        $data[] = $nama_product;
        $data[] = $desc_product;
        $data[] = $grade;
        $data[] = $level;
        $data[] = $recid;

        $sql = 'UPDATE tbl_product SET nama_product=?, desc_product=?, grade=?, level=? WHERE recid=?';
        $row = $config->prepare($sql);
        $row->execute($data);

        echo '<script>window.location="../../index.php?page=product&success=edit";</script>';
    }

    if (!empty($_GET['supplier'])) {
        $recid           = $_POST['recid'];
        $nama_supplier   = htmlentities($_POST['nama_supplier']);
        $alamat          = htmlentities($_POST['alamat']);
        $status          = intval($_POST['status']);
        $email           = htmlentities($_POST['email']);
        $no_telp         = (int) $_POST['no_telp'];
        $fax             = (int) $_POST['fax'];

        $data = [$nama_supplier, $alamat, $status, $email, $no_telp, $fax, $recid];

        $sql = 'UPDATE tbl_supplier SET nama_supplier=?, alamat=?, status=?, email=?, no_telp=?, fax=? WHERE recid=?';
        $row = $config->prepare($sql);
        $row->execute($data);

        echo '<script>window.location="../../index.php?page=supplier&success=edit";</script>';
    }

    if (!empty($_GET['tempat_produksi'])) {
        $recid  = $_POST['recid'];
        $nama   = htmlentities($_POST['nama']);
        $alamat = htmlentities($_POST['alamat']);

        $data = [$nama, $alamat, $recid];

        $sql = "UPDATE tbl_tmpt_produksi SET nama=?, alamat=? WHERE recid=?";
        $row = $config->prepare($sql);
        $row->execute($data);

        echo '<script>window.location="../../index.php?page=tempat_produksi&success=edit";</script>';
    }

    if (!empty($_GET['user'])) {
        $recid    = $_POST['recid'];
        // $username = htmlentities($_POST['username']);
        // $nama     = htmlentities($_POST['nama']);
        $email    = htmlentities($_POST['email']);
        $status   = intval($_POST['status']);
        // $level    = htmlentities($_POST['level']);
        $alamat   = htmlentities($_POST['alamat']);

        $data = [$email, $status, $alamat, $recid];
        // $data = [$username, $nama, $email, $status, $level, $alamat, $recid];

        $sql = "UPDATE tbl_user SET email=?, status=?, alamat=? WHERE recid=?";
        $row = $config->prepare($sql);
        $row->execute($data);

        echo '<script>window.location="../../index.php?page=user&success=edit";</script>';
    }

    if (!empty($_GET['number_sequence'])) {
        // Ambil dan sanitasi input
        $recid      = htmlentities($_POST['id']);
        $numbering  = $_POST['numbering'];

        // Susun data untuk update
        $data[] = $numbering;
        $data[] = $recid;

        // Query update (yang bisa diubah hanya numbering)
        $sql = "UPDATE number_sequences SET last_number = ? WHERE recid = ?";
        $row = $config->prepare($sql);
        $row->execute($data);

        // Redirect ke halaman awal dengan pesan sukses
        echo '<script>window.location="../../index.php?page=number_sequence&success=edit";</script>';
    }

    if (!empty($_GET['transaksi_bahanbaku']) && $_GET['transaksi_bahanbaku'] == 'edit') {
        $recid          = $_POST['edit_revid'];
        $bahanbaku_id   = htmlentities($_POST['bahanbaku_id']);
        $supp_id        = htmlentities($_POST['supp_id']);
        $qty            = floatval($_POST['qty']);
        $uom            = htmlentities($_POST['uom']);

        $data[] = $bahanbaku_id;
        $data[] = $qty;
        $data[] = $uom;
        $data[] = $supp_id;
        $data[] = $recid;
        // print_r($data);
        $sql = "UPDATE tbl_transaksi_bahanbaku SET bahanbaku_id = ?, qty = ?, uom = ?,supp_id=? WHERE recid = ? AND status = 0";

        $stmt = $config->prepare($sql);
        $stmt->execute($data);

        echo '<script>window.location="../../index.php?page=transaksi_bahan_baku&success=edit";</script>';
    }

    if (!empty($_GET['order_transaksi_bahanbaku'])) {
        $recid = $_POST['recid_order'];
        // $bulan = date("m");
        // $tahun = date("Y");
        $bulan = 1;
        $tahun = 2025;
        $prefix = "PO"; // atau bisa ambil dari config

        try {
            $sql_seq = "SELECT * FROM number_sequences WHERE prefix = ? AND bulan = ? AND tahun = ? LIMIT 1";
            $stmt_seq = $config->prepare($sql_seq);
            $stmt_seq->execute([$prefix, $bulan, $tahun]);
            $seq = $stmt_seq->fetch();

            if ($seq) {
                $kode_perusahaan = $seq['kode_perusahaan'];
                $last_number = intval($seq['last_number']) + 1;
                $no_po = str_pad($last_number, 4, '0', STR_PAD_LEFT) . '/' . $prefix . '/' . $kode_perusahaan . '/' . $bulan . '/' . $tahun;

                $sql = "UPDATE tbl_transaksi_bahanbaku SET status = 1, no_po = '$no_po' WHERE recid = ?";
                $stmt = $config->prepare($sql);
                $stmt->execute([$recid]);

                $sql_update_seq = "UPDATE number_sequences SET last_number = ? WHERE prefix = 'PO' ";
                $stmt_upd_seq = $config->prepare($sql_update_seq);
                $stmt_upd_seq->execute([$last_number]);

                echo '<script>window.location="../../index.php?page=transaksi_bahan_baku&success=order";</script>';
            } else {
                echo "Nomor urut tidak ditemukan untuk prefix $prefix/$kode_perusahaan/$bulan/$tahun.";
            }
        } catch (PDOException $e) {
            echo "Error: " . $e->getMessage();
        }
    }

    if (isset($_GET['transaksi_bahanbaku']) && $_GET['transaksi_bahanbaku'] == 'add_invoice') {
        $recid = htmlentities($_POST['recid']);
        $no_invoice = htmlentities($_POST['no_invoice']);
        $harga = intval($_POST['harga']);


        try {
            $sql = "UPDATE tbl_transaksi_bahanbaku
                    SET no_invoice = ?, harga = ?
                    WHERE recid = ?";
            $stmt = $config->prepare($sql);
            $stmt->execute([$no_invoice, $harga, $recid]);

            echo '<script>window.location="../../index.php?page=transaksi_bahan_baku&success=invoice";</script>';
        } catch (PDOException $e) {
            echo "Error: " . $e->getMessage();
        }
    }

    if (isset($_GET['bukti_bayar']) && $_GET['bukti_bayar'] === 'submit') {
        $recid        = $_POST['recid'];
        $tgl_bayar    = $_POST['tgl_bayar'];
        $jumlah_bayar = preg_replace('/[^\d]/', '', $_POST['jumlah_bayar']); // hilangkan format titik/koma
        $jumlah_bayar_fix = intval($jumlah_bayar);


        $upload_dir = '../../assets/bukti_bayar/';
        $filename   = basename($_FILES['bukti_file']['name']);
        $target     = $upload_dir . $filename;
        $filetype   = strtolower(pathinfo($target, PATHINFO_EXTENSION));

        // Validasi file
        $allowed = ['jpg', 'jpeg', 'png', 'pdf'];
        if (!in_array($filetype, $allowed)) {
            echo "<script>alert('Format file tidak didukung.'); window.history.back();</script>";
            exit;
        }

        if (move_uploaded_file($_FILES['bukti_file']['tmp_name'], $target)) {
            try {
                $sql = "UPDATE tbl_transaksi_bahanbaku 
                        SET tgl_byr = ?, jumlah_bayar = ?, bukti_file = ?, status_bayar = 1
                        WHERE recid = ?";
                $stmt = $config->prepare($sql);
                $stmt->execute([$tgl_bayar, $jumlah_bayar_fix, $filename, $recid]);
                // print_r([$tgl_bayar, $jumlah_bayar_fix, $filename, $recid]);
                header("Location: ../../index.php?page=transaksi_bahan_baku&success=bukti");
                exit;
            } catch (PDOException $e) {
                echo "Error: " . $e->getMessage();
            }
        } else {
            echo "<script>alert('Upload gagal.'); window.history.back();</script>";
        }
    }

    if (isset($_GET['transaksi_bahanbaku']) && $_GET['transaksi_bahanbaku'] === 'terima_barang') {


        $id             = htmlentities($_POST['id']);
        $qty_aktual     = isset($_POST['qty_aktual']) ? floatval($_POST['qty_aktual']) : 0;
        $qty_po         = isset($_POST['qty']) ? floatval($_POST['qty']) : 0;
        $catatan        = htmlentities($_POST['catatan']);
        $bahanbakuid    = htmlentities($_POST['bahanbakuid']);

        if ($qty_aktual < $qty_po) {
            echo "<script>alert('Quantity yang di terima kurang, silahkan hubungi supplier untuk meminta Quantity yang kurang'); window.history.back();</script>";
            $sql = "UPDATE tbl_transaksi_bahanbaku
                SET qty_terima = ?, catatan_terima = ?
                WHERE recid = ?";

            $stmt = $config->prepare($sql);
            $exec = $stmt->execute([$qty_aktual, $catatan, $id]);

            if ($exec) {
                header("Location: ../../index.php?page=transaksi_bahan_baku&success=terima");
            } else {
                echo "Gagal update: ";
                print_r($stmt->errorInfo());
            }
        } else {
            $sql = "UPDATE tbl_transaksi_bahanbaku
                SET qty_terima = ?, catatan_terima = ?, status = 2
                WHERE recid = ?";

            $stmt = $config->prepare($sql);
            $exec = $stmt->execute([$qty_aktual, $catatan, $id]);

            if ($exec) {

                $sql_seq = "SELECT * FROM tbl_bahan_baku WHERE recid = $bahanbakuid LIMIT 1";
                $stmt_seq = $config->prepare($sql_seq);
                $stmt_seq->execute();
                $seq = $stmt_seq->fetch();
                $lastStok = $seq["stok"];
                $updateStok = $lastStok + $qty_aktual;

                $sql = 'UPDATE tbl_bahan_baku SET stok= ? WHERE recid=?';
                $row = $config->prepare($sql);
                $row->execute([$updateStok, $bahanbakuid]);

                header("Location: ../../index.php?page=transaksi_bahan_baku&success=terima");
            } else {
                echo "Gagal update: ";
                print_r($stmt->errorInfo());
            }
        }
    }



    if (!empty($_GET['pengaturan'])) {
        $nama = htmlentities($_POST['namatoko']);
        $alamat = htmlentities($_POST['alamat']);
        $kontak = htmlentities($_POST['kontak']);
        $pemilik = htmlentities($_POST['pemilik']);
        $id = '1';

        $data[] = $nama;
        $data[] = $alamat;
        $data[] = $kontak;
        $data[] = $pemilik;
        $data[] = $id;
        $sql = 'UPDATE toko SET nama_toko=?, alamat_toko=?, tlp=?, nama_pemilik=? WHERE id_toko = ?';
        $row = $config->prepare($sql);
        $row->execute($data);
        echo '<script>window.location="../../index.php?page=pengaturan&success=edit-data"</script>';
    }

    if (!empty($_GET['kategori'])) {
        $nama = htmlentities($_POST['kategori']);
        $id = htmlentities($_POST['id']);
        $data[] = $nama;
        $data[] = $id;
        $sql = 'UPDATE kategori SET  nama_kategori=? WHERE id_kategori=?';
        $row = $config->prepare($sql);
        $row->execute($data);
        echo '<script>window.location="../../index.php?page=kategori&uid=' . $id . '&success-edit=edit-data"</script>';
    }

    if (!empty($_GET['stok'])) {
        $restok = htmlentities($_POST['restok']);
        $id = htmlentities($_POST['id']);
        $dataS[] = $id;
        $sqlS = 'select*from barang WHERE id_barang=?';
        $rowS = $config->prepare($sqlS);
        $rowS->execute($dataS);
        $hasil = $rowS->fetch();

        $stok = $restok + $hasil['stok'];

        $data[] = $stok;
        $data[] = $id;
        $sql = 'UPDATE barang SET stok=? WHERE id_barang=?';
        $row = $config->prepare($sql);
        $row->execute($data);
        echo '<script>window.location="../../index.php?page=barang&success-stok=stok-data"</script>';
    }

    if (!empty($_GET['barang'])) {
        $id = htmlentities($_POST['id']);
        $kategori = htmlentities($_POST['kategori']);
        $nama = htmlentities($_POST['nama']);
        $merk = htmlentities($_POST['merk']);
        $beli = htmlentities($_POST['beli']);
        $jual = htmlentities($_POST['jual']);
        $satuan = htmlentities($_POST['satuan']);
        $stok = htmlentities($_POST['stok']);
        $tgl = htmlentities($_POST['tgl']);

        $data[] = $kategori;
        $data[] = $nama;
        $data[] = $merk;
        $data[] = $beli;
        $data[] = $jual;
        $data[] = $satuan;
        $data[] = $stok;
        $data[] = $tgl;
        $data[] = $id;
        $sql = 'UPDATE barang SET id_kategori=?, nama_barang=?, merk=?, 
				harga_beli=?, harga_jual=?, satuan_barang=?, stok=?, tgl_update=?  WHERE id_barang=?';
        $row = $config->prepare($sql);
        $row->execute($data);
        echo '<script>window.location="../../index.php?page=barang/edit&barang=' . $id . '&success=edit-data"</script>';
    }

    if (!empty($_GET['gambar'])) {
        $id = htmlentities($_POST['id']);
        set_time_limit(0);
        $allowedImageType = array("image/gif", "image/JPG", "image/jpeg", "image/pjpeg", "image/png", "image/x-png", 'image/webp');
        $filepath = $_FILES['foto']['tmp_name'];
        $fileSize = filesize($filepath);
        $fileinfo = finfo_open(FILEINFO_MIME_TYPE);
        $filetype = finfo_file($fileinfo, $filepath);
        $allowedTypes = [
            'image/png'   => 'png',
            'image/jpeg'  => 'jpg',
            'image/gif'   => 'gif',
            'image/jpg'   => 'jpeg',
            'image/webp'  => 'webp'
        ];
        if (!in_array($filetype, array_keys($allowedTypes))) {
            echo '<script>alert("You can only upload JPG, PNG and GIF file");window.location="../../index.php?page=user"</script>';
            exit;
        } else if ($_FILES['foto']["error"] > 0) {
            echo '<script>alert("You can only upload JPG, PNG and GIF file");window.location="../../index.php?page=user"</script>';
            exit;
        } elseif (!in_array($_FILES['foto']["type"], $allowedImageType)) {
            // echo "You can only upload JPG, PNG and GIF file";
            // echo "<font face='Verdana' size='2' ><BR><BR><BR>
            // 		<a href='../../index.php?page=user'>Back to upform</a><BR>";
            echo '<script>alert("You can only upload JPG, PNG and GIF file");window.location="../../index.php?page=user"</script>';
            exit;
        } elseif (round($_FILES['foto']["size"] / 1024) > 4096) {
            // echo "WARNING !!! Besar Gambar Tidak Boleh Lebih Dari 4 MB";
            // echo "<font face='Verdana' size='2' ><BR><BR><BR>
            // 		<a href='../../index.php?page=user'>Back to upform</a><BR>";
            echo '<script>alert("WARNING !!! Besar Gambar Tidak Boleh Lebih Dari 4 MB");window.location="../../index.php?page=user"</script>';
            exit;
        } else {
            $dir = '../../assets/img/user/';
            $tmp_name = $_FILES['foto']['tmp_name'];
            $name = time() . basename($_FILES['foto']['name']);
            if (move_uploaded_file($tmp_name, $dir . $name)) {
                //post foto lama
                $foto2 = $_POST['foto2'];
                //remove foto di direktori
                unlink('../../assets/img/user/' . $foto2 . '');
                //input foto
                $id = $_POST['id'];
                $data[] = $name;
                $data[] = $id;
                $sql = 'UPDATE member SET gambar=?  WHERE member.id_member=?';
                $row = $config->prepare($sql);
                $row->execute($data);
                echo '<script>window.location="../../index.php?page=user&success=edit-data"</script>';
            } else {
                echo '<script>alert("Masukan Gambar !");window.location="../../index.php?page=user"</script>';
                exit;
            }
        }
    }

    if (!empty($_GET['profil'])) {
        $id = htmlentities($_POST['id']);
        $nama = htmlentities($_POST['nama']);
        $alamat = htmlentities($_POST['alamat']);
        $tlp = htmlentities($_POST['tlp']);
        $email = htmlentities($_POST['email']);
        $nik = htmlentities($_POST['nik']);

        $data[] = $nama;
        $data[] = $alamat;
        $data[] = $tlp;
        $data[] = $email;
        $data[] = $nik;
        $data[] = $id;
        $sql = 'UPDATE member SET nm_member=?,alamat_member=?,telepon=?,email=?,NIK=? WHERE id_member=?';
        $row = $config->prepare($sql);
        $row->execute($data);
        echo '<script>window.location="../../index.php?page=user&success=edit-data"</script>';
    }

    if (!empty($_GET['pass'])) {
        $id = htmlentities($_POST['id']);
        $user = htmlentities($_POST['user']);
        $pass = htmlentities($_POST['pass']);

        $data[] = $user;
        $data[] = $pass;
        $data[] = $id;
        $sql = 'UPDATE login SET user=?,pass=md5(?) WHERE id_member=?';
        $row = $config->prepare($sql);
        $row->execute($data);
        echo '<script>window.location="../../index.php?page=user&success=edit-data"</script>';
    }

    if (!empty($_GET['jual'])) {
        $id = htmlentities($_POST['id']);
        $id_barang = htmlentities($_POST['id_barang']);
        $jumlah = htmlentities($_POST['jumlah']);

        $sql_tampil = "select *from barang where barang.id_barang=?";
        $row_tampil = $config->prepare($sql_tampil);
        $row_tampil->execute(array($id_barang));
        $hasil = $row_tampil->fetch();

        if ($hasil['stok'] > $jumlah) {
            $jual = $hasil['harga_jual'];
            $total = $jual * $jumlah;
            $data1[] = $jumlah;
            $data1[] = $total;
            $data1[] = $id;
            $sql1 = 'UPDATE penjualan SET jumlah=?,total=? WHERE id_penjualan=?';
            $row1 = $config->prepare($sql1);
            $row1->execute($data1);
            echo '<script>window.location="../../index.php?page=jual#keranjang"</script>';
        } else {
            echo '<script>alert("Keranjang Melebihi Stok Barang Anda !");
					window.location="../../index.php?page=jual#keranjang"</script>';
        }
    }

    if (!empty($_GET['cari_barang'])) {
        $cari = trim(strip_tags($_POST['keyword']));
        if ($cari == '') {
        } else {
            $sql = "select barang.*, kategori.id_kategori, kategori.nama_kategori
					from barang inner join kategori on barang.id_kategori = kategori.id_kategori
					where barang.id_barang like '%$cari%' or barang.nama_barang like '%$cari%' or barang.merk like '%$cari%'";
            $row = $config->prepare($sql);
            $row->execute();
            $hasil1 = $row->fetchAll();
?>
            <table class="table table-stripped" width="100%" id="example2">
                <tr>
                    <th>ID Barang</th>
                    <th>Nama Barang</th>
                    <th>Merk</th>
                    <th>Harga Jual</th>
                    <th>Aksi</th>
                </tr>
                <?php foreach ($hasil1 as $hasil) { ?>
                    <tr>
                        <td><?php echo $hasil['id_barang']; ?></td>
                        <td><?php echo $hasil['nama_barang']; ?></td>
                        <td><?php echo $hasil['merk']; ?></td>
                        <td><?php echo $hasil['harga_jual']; ?></td>
                        <td>
                            <a href="fungsi/tambah/tambah.php?jual=jual&id=<?php echo $hasil['id_barang']; ?>&id_kasir=<?php echo $_SESSION['admin']['id_member']; ?>"
                                class="btn btn-success">
                                <i class="fa fa-shopping-cart"></i></a>
                        </td>
                    </tr>
                <?php } ?>
            </table>
<?php
        }
    }
}
