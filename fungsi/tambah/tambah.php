<?php

session_start();
if (!empty($_SESSION['admin'])) {
    require '../../config.php';

    echo "<pre>";
    if (!empty($_GET['bahanbaku'])) {
        echo "<pre>";
        // print_r($_POST);
        // Ambil dan sanitasi input
        $nama     = htmlentities($_POST['nama']);
        $desc     = htmlentities($_POST['desc']);
        $satuan   = htmlentities($_POST['satuan']);
        $supplier = htmlentities($_POST['supplier']);
        $harga    = intval($_POST['harga']);

        // Siapkan data untuk binding (harus sesuai jumlah tanda tanya)
        $data = [
            $nama,
            $desc,
            0, // stok default
            $satuan,
            $supplier,
            $harga
        ];

        // SQL: jumlah tanda tanya (?) harus sesuai jumlah elemen di $data (6)
        $sql = 'INSERT INTO tbl_bahan_baku 
                (nama_bb, `desc`, stok, satuan, supp_id, harga_pasaran_per_satuan) 
                VALUES (?, ?, ?, ?, ?, ?)';

        $row = $config->prepare($sql);
        $hasil = $row->execute($data);

        if ($hasil) {
            echo '<script>alert("Data berhasil ditambahkan!"); window.location="../../index.php?page=bahanbaku&success=tambah";</script>';
        } else {
            // Debug error PDO
            $error = $row->errorInfo();
            echo "Gagal menambahkan data: " . $error[2];
        }
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

        $cek = "SELECT * FROM tbl_client WHERE nama_client = ?";
        $cekHasil = $config->prepare($cek);
        $cekHasil->execute([$nama_client]);

        $cekValidasi = $cekHasil->fetchAll(); // Ambil semua hasil query
        if (count($cekValidasi) > 0) {
            // Ada data yang dikembalikan
            echo "<script>
                    alert('Nama Client yang sama sudah ada');
                    window.history.back();
                </script>";
        } else {
            $sql = 'INSERT INTO tbl_client (nama_client, alamat, status, email, no_telp, fax) 
                    VALUES (?, ?, ?, ?, ?, ?)';

            $row = $config->prepare($sql);
            $row->execute($data);

            echo '<script>window.location="../../index.php?page=client&success=tambah";</script>';
        }
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
        $harga = intval($_POST['harga']);
        // Siapkan query insert
        $stmt = $config->prepare("INSERT INTO tbl_product (nama_product, desc_product, grade, level, hargaPerTon) VALUES (?, ?, ?, ?, ?)");
        $stmt->execute([$nama, $desc, $grade, $level, $harga]);
        header("Location: ../../index.php?page=product&success=1");
    }
    if (!empty($_GET['uom'])) {
        // Ambil dan filter data input
        $kode = trim($_POST['kode_uom']);
        $nama = trim($_POST['nama_uom']);
        $batas = intval($_POST['batas_aman']);

        // Insert ke DB
        $stmt = $config->prepare("INSERT INTO uom (kode_uom, nama_uom, batas_aman) VALUES (?, ?, ?)");
        $stmt->execute([$kode, $nama, $batas]);

        header("Location: ../../index.php?page=uom&success=1");
        exit;
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

    if (!empty($_GET['formulasi']) && $_GET['formulasi'] == 'tambah') {
        echo "<pre>";
        // Ambil dan sanitasi input
        $produk_id     = intval($_POST['produk_id']);
        $bahanbaku_id  = intval($_POST['bahanbaku_id']);
        $qty_per_ton   = floatval($_POST['qty_per_ton']);
        $uom           = htmlentities($_POST['uom']);

        // Data yang akan disisipkan ke dalam tabel
        $data = [$produk_id, $bahanbaku_id, $qty_per_ton, $uom];
        // print_r($data);
        // Query insert
        $sql = "INSERT INTO tbl_formulasi (produk_id, bahanbaku_id, qty_per_ton, uom)
                VALUES (?, ?, ?, ?)";

        $stmt = $config->prepare($sql);
        $stmt->execute($data);

        // Redirect ke halaman detail produk dengan pesan sukses
        echo '<script>window.location="../../index.php?page=product/details&product=' . $produk_id . '&success=formulasi";</script>';
    }
    if ($_GET['aksi'] == 'tambah_inventaris_client') {
        $client_id = $_POST['client_id'];
        $inven_id = $_POST['inven_id'];
        $jml_total = $_POST['jml_total'];
        $jml_active = $_POST['jml_active'];
        $jml_nonactive = $_POST['jml_nonactive'];

        $sql = "INSERT INTO tbl_relasi_inven (client_id, inven_id, jml_total, jml_active, jml_nonactive) VALUES (?, ?, ?, ?, ?)";
        $query = $config->prepare($sql);
        $query->execute([$client_id, $inven_id, $jml_total, $jml_active, $jml_nonactive]);

        header("location:../../index.php?page=client/details&client=$client_id&relasi_inven=tambah");
    }


    if (!empty($_GET['transaksi_bahan_baku'])) {
        echo "<pre>";


        // Ambil dan sanitasi input
        if (isset($_POST['bahanbaku_id'], $_POST['qty'], $_POST['uom'])) {
            $date           = date("Y/m/d");
            $bahanbaku_id   = htmlentities($_POST['bahanbaku_id']);
            $supp_id        = htmlentities($_POST['supp_id']);
            $qty            = floatval($_POST['qty']);
            $uom            = htmlentities($_POST['uom']);
            $username       = htmlentities($_SESSION['admin']["username"]);

            // Siapkan data
            $data = [$date, $bahanbaku_id, $qty, $uom, $username, $username];

            // Query insert
            $sql = "INSERT INTO tbl_transaksi_bahanbaku (tgl, bahanbaku_id,supp_id, qty, uom, status, createdby, modifiedby) 
                    VALUES ('$date', $bahanbaku_id, $supp_id, $qty, '$uom', 0,'$username','$username')";
            // VALUES (?, ?, ?, ?, 0,?,?)";
            print_r($sql);

            try {
                $row = $config->prepare($sql);
                $row->execute();
                // print_r($sql);
                echo '<script>window.location="../../index.php?page=transaksi_bahan_baku&success=tambah";</script>';
            } catch (PDOException $e) {
                echo "SQL Error:\n";
                echo $e->getMessage();
                echo "Query: $sql\n";
                print_r($data);
            }
        } else {
            echo "Input data belum lengkap.\n";
        }

        echo "</pre>";
        exit; // Hentikan agar tidak redirect saat debugging
    }

    if (!empty($_GET['jual']) && $_GET['jual'] === "tambah") {
        echo "<pre>";
        $input = json_decode(file_get_contents("php://input"), true);

        var_dump($input);
        // Konversi format & bersihkan input
        $tgl = date('Y-m-d', strtotime($input['tgl']));
        $tgl_produksi = date('Y-m-d', strtotime($input['tgl_produksi']));
        $harga = str_replace(['Rp', '.', ','], '', $input['harga']);

        $data = [
            ':tgl' => $tgl,
            ':no_invoice' => $input['no_invoice'],
            ':harga' => $harga,
            ':ppn' => $input['ppn'],
            ':qty' => $input['qty'],
            ':total_harga' => $input['total_harga'],
            ':profit' => $input['profit'],
            ':pengiriman' => $input['pengiriman'],
            ':ongkir' => $input['ongkir'],
            ':penanggung_ongkir' => $input['penanggung_ongkir'],
            ':tanggal_sampai' => $input['tanggal_sampai'],
            ':tgl_jatuh_tempo' => $input['tgl_jatuh_tempo'],
            ':status_pembayaran' => $input['status_pembayaran'],
            ':sisa_pembayaran' => $input['sisa_pembayaran'],
            ':sudah_diterima' => $input['sudah_diterima'],
            ':pakai_inventaris' => $input['pakai_inventaris'],
            ':inven_id' => $input['inven_id'],
            ':jml_inven' => $input['jml_inven'],
            ':client_id' => $input['client_id'],
            ':product_id' => $input['product_id'],
            ':tgl_produksi' => $tgl_produksi,
            ':tmpt_produksi_id' => $input['tmpt_produksi_id'],
            ':createdby' => $input['createdby'],
            ':modifiedby' => $input['modifiedby']
        ];

        $sql = "INSERT INTO transaksi_keluar (
    tgl, no_invoice, hargaPerTon, ppn, qty, total_harga, profit,
    pengiriman, ongkir, penanggung_ongkir, tanggal_sampai, tgl_jatuh_tempo,
    status_pembayaran, sisa_pembayaran, sudah_diterima, pakai_inventaris,
    inven_id, jml_inven, client_id, product_id, tgl_produksi,
    tmpt_produksi_id, createdby, modifiedby
) VALUES (
    :tgl, :no_invoice, :harga, :ppn, :qty, :total_harga, :profit,
    :pengiriman, :ongkir, :penanggung_ongkir, :tanggal_sampai, :tgl_jatuh_tempo,
    :status_pembayaran, :sisa_pembayaran, :sudah_diterima, :pakai_inventaris,
    :inven_id, :jml_inven, :client_id, :product_id, :tgl_produksi,
    :tmpt_produksi_id, :createdby, :modifiedby
)";

        $row = $config->prepare($sql);
        if (!$row->execute($data)) {
            print_r($row->errorInfo()); // DEBUG error
        } else {
            $bahanBaku = $input['dataBahanBaku']; // pastikan dari frontend kirim key ini
            foreach ($bahanBaku as $item) {
                $recid = (int)$item['recid'];
                $totalKebutuhan = (float)$item['total_kebutuhan'];

                $updateStokSQL = "UPDATE tbl_bahan_baku SET stok = stok - :kebutuhan WHERE recid = :recid";
                $updateStokStmt = $config->prepare($updateStokSQL);
                $updateStokStmt->execute([
                    ':kebutuhan' => $totalKebutuhan,
                    ':recid' => $recid
                ]);
            }

            echo json_encode(["success" => true]);
        }
    }
}
