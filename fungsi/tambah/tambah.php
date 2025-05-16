<?php

session_start();
if (!empty($_SESSION['admin'])) {
    require '../../config.php';

    if (!empty($_GET['bahanbaku'])) {
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
        $sql = 'INSERT INTO tbl_bahan_baku (nama_bb, `desc`, stok, satuan, supp_id) 
			    VALUES (?,?,?,?,?) ';
        $row = $config->prepare($sql);
        $row->execute($data);
        // echo $row;
        echo '<script>window.location="../../index.php?page=bahanbaku&success=tambah-data"</script>';
    }

    if (!empty($_GET['client'])) {
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

        $sql = 'INSERT INTO tbl_client (nama_client, alamat, status, email, no_telp, fax) 
                VALUES (?, ?, ?, ?, ?, ?)';

        $row = $config->prepare($sql);
        $row->execute($data);

        echo '<script>window.location="../../index.php?page=client&success=tambah";</script>';
    }

    if (!empty($_GET['inventaris'])) {
        $nama_inven   = htmlentities($_POST['nama']);
        $desc        = htmlentities($_POST['desc']);
        $jml        = (int) htmlentities($_POST['jml']);
        $jml_rusak         = 0;
        $jml_active         = $jml;

        $data[] = $nama_inven;
        $data[] = $desc;
        $data[] = $jml;
        $data[] = $jml_rusak;
        $data[] = $jml_active;

        $sql = 'INSERT INTO tbl_inventaris (nama_inven, `desc`, jml, jml_rusak, jml_active) 
                VALUES (?, ?, ?, ?, ?)';

        $row = $config->prepare($sql);
        $row->execute($data);

        echo '<script>window.location="../../index.php?page=inventaris&success=tambah";</script>';
    }

    if (!empty($_GET['product'])) {
        // Ambil dan filter data input
        $nama   = trim($_POST['nama_product']);
        $desc   = trim($_POST['desc_product']);
        $grade  = trim($_POST['grade']);
        $level  = trim($_POST['level']);
        // Siapkan query insert
        $stmt = $config->prepare("INSERT INTO tbl_product (nama_product, desc_product, grade, level) VALUES (?, ?, ?, ?)");
        $stmt->execute([$nama, $desc, $grade, $level]);
        header("Location: ../../index.php?page=product&success=1");
    }

    if (!empty($_GET['supplier'])) {
        $nama_supplier = htmlentities($_POST['nama_supplier']);
        $alamat        = htmlentities($_POST['alamat']);
        $status        = intval($_POST['status']);
        $email         = htmlentities($_POST['email']);
        $no_telp       = (int) $_POST['no_telp'];
        $fax           = (int) $_POST['fax'];

        $data = [$nama_supplier, $alamat, $status, $email, $no_telp, $fax];
        // echo $nama_supplier, $alamat, $status, $email, $no_telp, $fax;
        // exit;

        $sql = "INSERT INTO tbl_supplier (nama_supplier, alamat, status, email, no_telp, fax) VALUES (?, ?, ?, ?, ?, ?)";
        $row = $config->prepare($sql);
        $row->execute($data);

        echo '<script>window.location="../../index.php?page=supplier&success=tambah";</script>';
    }

    if (!empty($_GET['tempat_produksi'])) {
        $nama   = htmlentities($_POST['nama']);
        $alamat = htmlentities($_POST['alamat']);
    
        $data = [$nama, $alamat];
    
        $sql = "INSERT INTO tbl_tmpt_produksi (nama, alamat) VALUES (?, ?)";
        $row = $config->prepare($sql);
        $row->execute($data);
    
        echo '<script>window.location="../../index.php?page=tempat_produksi&success=tambah";</script>';
    }
    if (!empty($_GET['number_sequence'])) {
        // Ambil dan sanitasi input
        $kode_perusahaan    = htmlentities($_POST['kode_pt']);
        $prefix     = htmlentities($_POST['prefix']);
        $bulan      = intval($_POST['bulan']);
        $tahun      = intval($_POST['tahun']);
        $last_number  = $_POST['numbering'];
    
        // Data yang akan disisipkan ke dalam tabel
        $data = [$prefix, $kode_perusahaan, $bulan, $tahun, $last_number];
    
        // Query insert
        $sql = "INSERT INTO number_sequences (prefix, kode_perusahaan, bulan, tahun, last_number)
                VALUES (?, ?, ?, ?, ?)";
    
        $row = $config->prepare($sql);
        $row->execute($data);
    
        // Redirect dengan pesan sukses
        echo '<script>window.location="../../index.php?page=number_sequence&success=tambah";</script>';
    }
    
    if (!empty($_GET['user'])) {
        $username = htmlentities($_POST['username']);
        $nama     = htmlentities($_POST['nama']);
        $email    = htmlentities($_POST['email']);
        $status   = intval($_POST['status']);
        $level    = htmlentities($_POST['level']);
        $alamat   = htmlentities($_POST['alamat']);
        $password = htmlentities($_POST['password']); 
        // $password = password_hash('123456', PASSWORD_DEFAULT); // default password
    
        $data = [$username, $nama, $email, $password, $status, $level, $alamat];
    
        $sql = "INSERT INTO tbl_user (username, nama, email, password, status, level, alamat) VALUES (?, ?, ?, ?, ?, ?, ?)";
        $row = $config->prepare($sql);
        $row->execute($data);
    
        echo '<script>window.location="../../index.php?page=user&success=tambah";</script>';
    }

    if (!empty($_GET['transaksi_bahan_baku'])) {
        echo "<pre>";
    
        // Cek apakah POST data terkirim
        print_r($_POST);
    
        // Ambil dan sanitasi input
        if (isset($_POST['bahanbaku_id'], $_POST['qty'], $_POST['uom'])) {
            $bahanbaku_id = htmlentities($_POST['bahanbaku_id']);
            $qty          = floatval($_POST['qty']);
            $uom          = htmlentities($_POST['uom']);
    
            echo "Sanitized Input:\n";
            var_dump($bahanbaku_id, $qty, $uom);
    
            // Siapkan data
            $data = [$bahanbaku_id, $qty, $uom];
    
            // Query insert
            $sql = "INSERT INTO tbl_transaksi_bahanbaku (tgl, bahanbaku_id, qty, uom, status)
                    VALUES (CURDATE(), ?, ?, ?, 0)";
    
            try {
                $row = $config->prepare($sql);
                $row->execute($data);
                echo '<script>window.location="../../index.php?page=transaksi_bahan_baku&success=tambah";</script>';
            } catch (PDOException $e) {
                echo "SQL Error:\n";
                echo $e->getMessage();
            }
        } else {
            echo "Input data belum lengkap.\n";
        }
    
        echo "</pre>";
        exit; // Hentikan agar tidak redirect saat debugging
    }
    
    
    


    if (!empty($_GET['kategori'])) {
        $nama = htmlentities(htmlentities($_POST['kategori']));
        $tgl = date("j F Y, G:i");
        $data[] = $nama;
        $data[] = $tgl;
        $sql = 'INSERT INTO kategori (nama_kategori,tgl_input) VALUES(?,?)';
        $row = $config->prepare($sql);
        $row->execute($data);
        echo '<script>window.location="../../index.php?page=kategori&&success=tambah-data"</script>';
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

        $data[] = $id;
        $data[] = $kategori;
        $data[] = $nama;
        $data[] = $merk;
        $data[] = $beli;
        $data[] = $jual;
        $data[] = $satuan;
        $data[] = $stok;
        $data[] = $tgl;
        $sql = 'INSERT INTO barang (id_barang,id_kategori,nama_barang,merk,harga_beli,harga_jual,satuan_barang,stok,tgl_input) 
			    VALUES (?,?,?,?,?,?,?,?,?) ';
        $row = $config->prepare($sql);
        $row->execute($data);
        echo '<script>window.location="../../index.php?page=barang&success=tambah-data"</script>';
    }

    if (!empty($_GET['jual'])) {
        $id = $_GET['id'];

        // get tabel barang id_barang
        $sql = 'SELECT * FROM barang WHERE id_barang = ?';
        $row = $config->prepare($sql);
        $row->execute(array($id));
        $hsl = $row->fetch();

        if ($hsl['stok'] > 0) {
            $kasir =  $_GET['id_kasir'];
            $jumlah = 1;
            $total = $hsl['harga_jual'];
            $tgl = date("j F Y, G:i");

            $data1[] = $id;
            $data1[] = $kasir;
            $data1[] = $jumlah;
            $data1[] = $total;
            $data1[] = $tgl;

            $sql1 = 'INSERT INTO penjualan (id_barang,id_member,jumlah,total,tanggal_input) VALUES (?,?,?,?,?)';
            $row1 = $config->prepare($sql1);
            $row1->execute($data1);

            echo '<script>window.location="../../index.php?page=jual&success=tambah-data"</script>';
        } else {
            echo '<script>alert("Stok Barang Anda Telah Habis !");
					window.location="../../index.php?page=jual#keranjang"</script>';
        }
    }
}
