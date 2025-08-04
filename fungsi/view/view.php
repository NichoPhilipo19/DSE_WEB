<?php
/*
* PROSES TAMPIL
*/
class view
{
    protected $db;
    public function __construct($db)
    {
        $this->db = $db;
    }

    public function supplier()
    {
        $sql = "select * from tbl_supplier;";
        $row = $this->db->prepare($sql);
        $row->execute();
        $hasil = $row->fetchAll();
        return $hasil;
    }

    public function bahanbaku()
    {
        $sql = "SELECT 
            bb.*,
            u.kode_uom,
            u.nama_uom,
            u.batas_aman,
            s.nama_supplier
        FROM tbl_bahan_baku bb
        JOIN tbl_supplier s ON bb.supp_id = s.recid
        JOIN uom u ON bb.satuan = u.kode_uom
        ORDER BY bb.recid ASC;";

        $row = $this->db->prepare($sql);
        $row->execute();
        $hasil = $row->fetchAll();
        return $hasil;
    }
    public function cekstok()
    {
        // echo "<pre>";
        $sql = "SELECT bb.*, u.batas_aman 
FROM tbl_bahan_baku bb 
LEFT JOIN uom u ON bb.satuan = u.kode_uom
WHERE bb.stok <= u.batas_aman";
        $row = $this->db->prepare($sql);
        $row->execute();
        $r = $row->rowCount();
        // print_r(($r));
        return $r;
    }


    public function bahanbaku_edit($id)
    {
        $sql = "select 
        bb.recid,
        bb.nama_bb,
        bb.`desc`,
        bb.stok,
        bb.satuan,
        bb.supp_id,
        s.nama_supplier
        from tbl_bahan_baku bb
        join tbl_supplier s ON bb.supp_id = s.recid 
        where bb.recid =?;";
        $row = $this->db->prepare($sql);
        $row->execute(array($id));
        $hasil = $row->fetch();
        return $hasil;
    }

    public function clietList()
    {
        $sql = "SELECT * FROM tbl_client";
        $row = $this->db->prepare($sql);
        $row->execute();
        $hasil = $row->fetchAll();
        return $hasil;
    }

    public function clientList_edit($id)
    {
        $sql = "select * from tbl_client where recid =?;";
        $row = $this->db->prepare($sql);
        $row->execute(array($id));
        $hasil = $row->fetch();
        return $hasil;
    }

    public function client_relasi_inven($id)
    {
        $sql = "SELECT 
        r.recid,
        r.client_id,
        r.inven_id,
        i.nama_inven,
        r.jml_total,
        r.jml_active,
        r.jml_nonactive
    FROM 
        tbl_relasi_inven r
    JOIN 
        tbl_inventaris i ON r.inven_id = i.recid WHERE client_id =? ";
        $row = $this->db->prepare($sql);
        $row->execute(array($id));
        $hasil = $row->fetchAll();
        return $hasil;
    }

    public function invenList()
    {
        $sql = "SELECT * FROM tbl_inventaris";
        $row = $this->db->prepare($sql);
        $row->execute();
        $hasil = $row->fetchAll();
        return $hasil;
    }

    public function productList()
    {
        $sql = "SELECT * FROM tbl_product";
        $row = $this->db->prepare($sql);
        $row->execute();
        $hasil = $row->fetchAll();
        return $hasil;
    }
    public function supplierList()
    {
        $sql = "SELECT * FROM tbl_supplier";
        $row = $this->db->prepare($sql);
        $row->execute();
        $hasil = $row->fetchAll();
        return $hasil;
    }
    public function tmptProduksiList()
    {
        $sql = "SELECT * FROM tbl_tmpt_produksi";
        $row = $this->db->prepare($sql);
        $row->execute();
        $hasil = $row->fetchAll();
        return $hasil;
    }
    public function userList()
    {
        $sql = "SELECT * FROM tbl_user";
        $row = $this->db->prepare($sql);
        $row->execute();
        $hasil = $row->fetchAll();
        return $hasil;
    }
    public function uomList()
    {
        $sql = "SELECT * FROM uom";
        $row = $this->db->prepare($sql);
        $row->execute();
        $hasil = $row->fetchAll();
        return $hasil;
    }
    public function numberSequence()
    {
        $sql = "SELECT * FROM number_sequences";
        $row = $this->db->prepare($sql);
        $row->execute();
        $hasil = $row->fetchAll();
        return $hasil;
    }
    public function numberSequenceForTransaksi()
    {
        // echo "<pre>";
        $prefix = "INV";
        // $bulan = 1;
        // $tahun = 2025;
        $bulan = date("m");
        $tahun = date("Y");
        // print_r($bulan);
        // $sql_seq = "SELECT * FROM number_sequences WHERE prefix = ? AND bulan = ? AND tahun = ? LIMIT 1";
        // $stmt_seq = $this->db->prepare($sql_seq);
        // $stmt_seq->execute([$prefix, $bulan, $tahun]);
        // $seq = $stmt_seq->fetch();


        // return $no_inv;

        $sql = "SELECT * FROM number_sequences WHERE prefix = ? AND bulan = ? AND tahun = ? LIMIT 1";
        $stmt = $this->db->prepare($sql);

        if ($stmt->execute([$prefix, $bulan, $tahun])) {
            $hasil = $stmt->fetch(PDO::FETCH_ASSOC);

            if ($hasil) {
                $kode_perusahaan = $hasil['kode_perusahaan'] ?? '';
                $last_number = intval($hasil['last_number']) + 1;
                $no_inv = str_pad($last_number, 4, '0', STR_PAD_LEFT) . '/' . $prefix . '/' . $kode_perusahaan . '-' . $bulan . '/' . $tahun;

                return $no_inv;
            } else {
                // Tidak ada data ditemukan
                echo "Data number_sequences tidak ditemukan.";
            }
        } else {
            // Query gagal
            echo "Query gagal dijalankan.";
        }
    }
    // public function transaksi_bahanbaku_list()
    // {
    //     // $sql = "SELECT t.* FROM tbl_transaksi_bahanbaku as t";
    //     $sql = "SELECT t.*, b.nama_bb, u.kode_uom FROM tbl_transaksi_bahanbaku as t
    //             JOIN tbl_bahan_baku as b ON t.bahanbaku_id = b.recid
    //             JOIN uom as u ON b.satuan = u.kode_uom ORDER BY t.tgl DESC";
    //     $row = $this-> db -> prepare($sql);
    //     $row -> execute();
    //     $hasil = $row -> fetchAll();
    //     return $hasil;
    // }
    function transaksi_bahanbaku_filtered($from, $to, $offset = 0, $limit = 10)
    {
        // echo "<pre>";
        // var_dump($from, $to, $offset, $limit);
        $query = "SELECT t.*, b.nama_bb, u.kode_uom 
                  FROM tbl_transaksi_bahanbaku AS t
                  JOIN tbl_bahan_baku AS b ON t.bahanbaku_id = b.recid
                  JOIN uom AS u ON b.satuan = u.kode_uom
                  WHERE t.tgl BETWEEN :from AND :to
                  ORDER BY t.tgl DESC
                  LIMIT :offset, :limit";

        $stmt = $this->db->prepare($query);
        $stmt->bindValue(':from', $from);
        $stmt->bindValue(':to', $to);
        $stmt->bindValue(':offset', (int)$offset, PDO::PARAM_INT);
        $stmt->bindValue(':limit', (int)$limit, PDO::PARAM_INT);
        $stmt->execute();

        return $stmt->fetchAll();
    }

    function total_transaksi_bahanbaku_filtered($from, $to)
    {
        $query = "SELECT COUNT(*) as total FROM tbl_transaksi_bahanbaku
                  WHERE tgl BETWEEN :from AND :to";
        $stmt = $this->db->prepare($query);
        $stmt->bindValue(':from', $from);
        $stmt->bindValue(':to', $to);
        $stmt->execute();

        $row = $stmt->fetch();

        return $row['total'];
    }

    public function getProductById($id)
    {
        $data = array();
        $sql = "SELECT * FROM tbl_product WHERE recid = ?";
        $row = $this->db->prepare($sql);
        $row->execute(array($id));
        $data = $row->fetch();
        return $data;
    }
    public function getFormulasiByProduct($produk_id)
    {
        $sql = "SELECT f.recid, f.bahanbaku_id, f.qty_per_ton, f.uom, 
        b.nama_bb, b.satuan 
        FROM tbl_formulasi f 
        JOIN tbl_bahan_baku b ON f.bahanbaku_id = b.recid 
        WHERE f.produk_id = ?
        ORDER BY b.nama_bb ASC";
        $row = $this->db->prepare($sql);
        $row->execute(array($produk_id));
        return $row->fetchAll();
    }

    public function dataBahanBakuUntukFormulasi()
    {
        // echo "<pre>";
        $sql = "SELECT 
        bb.recid,
        bb.nama_bb, 
        bb.stok, 
        bb.satuan,
        bb.harga_beli, 
        bb.harga_pasaran_per_satuan, 
        f.qty_per_ton, 
        f.produk_id
                FROM tbl_formulasi f
                JOIN tbl_bahan_baku bb ON f.bahanbaku_id = bb.recid
                JOIN tbl_product p ON f.produk_id = p.recid
                WHERE p.status = 1
                GROUP BY f.produk_id, f.bahanbaku_id
                ORDER BY bb.nama_bb
                ";

        $stmt = $this->db->prepare($sql); // ✅ pakai $config, bukan $this
        $stmt->execute();
        $rows = $stmt->fetchAll();
        $data = [];
        foreach ($rows as $row) {
            $data[] = [
                'bahanbaku_id' => intval($row['recid']),
                'produk_id' => intval($row['produk_id']),
                'nama_bahan' => $row['nama_bb'],
                'kebutuhan' => $row['qty_per_ton'],
                'stok' => intval($row['stok']),
                'uom' => $row['satuan'],
                'harga_beli' => $row['harga_beli'],
                'harga_pasaran_per_satuan' => $row['harga_pasaran_per_satuan']
            ];
        }
        // var_dump($data);
        return $data;
    }

    public function transaksi_penjualan_filter_limit($tgl_dari, $tgl_sampai, $limit, $offset)
    {
        $sql = "SELECT tk.*, c.nama_client 
                FROM transaksi_keluar tk
                LEFT JOIN tbl_client c ON tk.client_id = c.recid
                WHERE tk.tgl BETWEEN ? AND ?
                ORDER BY tk.tgl DESC
                LIMIT ? OFFSET ?";
        $stmt = $this->db->prepare($sql);
        $stmt->bindValue(1, $tgl_dari);
        $stmt->bindValue(2, $tgl_sampai);
        $stmt->bindValue(3, (int)$limit, PDO::PARAM_INT);
        $stmt->bindValue(4, (int)$offset, PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->fetchAll();
    }


    public function hitung_transaksi_penjualan_filter($tgl_dari, $tgl_sampai)
    {
        $sql = "SELECT COUNT(*) as total FROM transaksi_keluar WHERE tgl BETWEEN ? AND ?";
        $row = $this->db->prepare($sql);
        $row->execute([$tgl_dari, $tgl_sampai]);
        $result = $row->fetch();
        return $result['total'];
    }


    public function transaksi_detail_penjualan($id)
    {
        // echo "<pre>";
        $sql = "select *,(total_harga + ppn + 
        CASE WHEN penanggung_ongkir = 1 THEN 0 ELSE ongkir END
    ) AS total_bayar from transaksi_keluar where no_invoice = ? ";
        //     $sql = "SELECT 
        //     tk.*, -- semua field dari transaksi_keluar
        //     ti.recid AS recid_inventaris,
        //     ti.*, -- semua field dari tbl_inventaris
        //     tc.recid AS recid_client,
        //     tc.*, -- semua field dari tbl_client
        //     tp.recid AS recid_product,
        //     tp.recid AS recid_product, -- alias sesuai permintaan
        //     tp.*, -- semua field dari tbl_product
        //     ttp.recid AS recid_tmpt_produksi,
        //     ttp.* -- semua field dari tbl_tmpt_produksi
        // FROM 
        //     transaksi_keluar tk
        // LEFT JOIN tbl_inventaris ti ON tk.inven_id = ti.recid
        // LEFT JOIN tbl_client tc ON tk.client_id = tc.recid
        // LEFT JOIN tbl_product tp ON tk.product_id = tp.recid
        // LEFT JOIN tbl_tmpt_produksi ttp ON tk.tmpt_produksi_id = ttp.recid
        // WHERE tk.no_invoice = '0005/INV/DSE-07/2025'
        // ";
        $row = $this->db->prepare($sql);
        $row->execute(array($id));
        $hasil = $row->fetch();
        // var_dump($hasil);
        return $hasil;
    }

    public function detail_transaksi_product($id)
    {

        // echo "<pre>";
        $sql = "SELECT 
        tk.qty, tk.total_harga, -- semua field dari transaksi_keluar
        tp.recid AS recid_product, -- alias sesuai permintaan
        tp.* -- semua field dari tbl_product
    FROM 
        transaksi_keluar tk
    LEFT JOIN tbl_product tp ON tk.product_id = tp.recid
    WHERE tk.no_invoice = ?
    ";
        $row = $this->db->prepare($sql);
        $row->execute(array($id));
        $hasil = $row->fetchAll();

        // print_r($hasil);
        return $hasil;
    }

    public function total_penjualan_bulan_ini()
    {
        $bulan_ini = date('Y-m');
        $sql = "SELECT SUM(hargaPerTon * qty) as total FROM transaksi_keluar WHERE DATE_FORMAT(tgl, '%Y-%m') = ?";
        $query = $this->db->prepare($sql);
        $query->execute([$bulan_ini]);
        $data = $query->fetch();
        return $data['total'] ?? 0;
    }

    public function total_produksi_bulan_ini()
    {
        $bulan_ini = date('Y-m');
        $sql = "SELECT COUNT(*) as total, SUM(qty) as total_ton FROM transaksi_keluar WHERE DATE_FORMAT(tgl, '%Y-%m') = ?";
        $query = $this->db->prepare($sql);
        $query->execute([$bulan_ini]);
        $data = $query->fetch();
        return $data['total'] ?? 0;
    }
    public function total_produksi_bulan_ini_per_ton()
    {
        $bulan_ini = date('Y-m');
        $sql = "SELECT SUM(qty) as total_ton FROM transaksi_keluar WHERE DATE_FORMAT(tgl, '%Y-%m') = ?";
        $query = $this->db->prepare($sql);
        $query->execute([$bulan_ini]);
        $data = $query->fetch();
        return $data['total_ton'] ?? 0;
    }

    public function jumlah_bahanbaku_kritis()
    {
        $sql = "SELECT COUNT(*) as total FROM tbl_bahan_baku AS bb JOIN uom AS u ON bb.satuan = u.kode_uom WHERE bb.stok <= u.batas_aman";
        $query = $this->db->query($sql);
        $data = $query->fetch();
        return $data['total'] ?? 0;
    }

    public function jumlah_po_dalam_proses()
    {
        $sql = "SELECT COUNT(*) as total FROM tbl_transaksi_bahanbaku WHERE status = 1";
        $query = $this->db->query($sql);
        $data = $query->fetch();
        return $data['total'] ?? 0;
    }
    public function grafikPerBulan()
    {
        // $sql = "SELECT DATE_FORMAT(tgl, '%Y-%m') AS bulan, SUM(hargaPerTon * qty) as total 
        //       FROM transaksi_keluar 
        //       GROUP BY bulan 
        //       ORDER BY bulan ASC";
        $tahun = date('Y'); // Tahun sekarang

        $sql = "
                  SELECT 
                      bulan_list.bulan,
                      COALESCE(SUM(t.hargaPerTon * t.qty),0) as total,
                      COALESCE(SUM(t.qty), 0) AS total_qty
                  FROM (
                      SELECT '01' AS bulan_num, 'Jan' AS bulan
                      UNION SELECT '02', 'Feb'
                      UNION SELECT '03', 'Mar'
                      UNION SELECT '04', 'Apr'
                      UNION SELECT '05', 'Mei'
                      UNION SELECT '06', 'Jun'
                      UNION SELECT '07', 'Jul'
                      UNION SELECT '08', 'Ags'
                      UNION SELECT '09', 'Sep'
                      UNION SELECT '10', 'Okt'
                      UNION SELECT '11', 'Nov'
                      UNION SELECT '12', 'Des'
                  ) AS bulan_list
                  LEFT JOIN transaksi_keluar t
                      ON MONTH(t.tgl) = bulan_list.bulan_num AND YEAR(t.tgl) = '$tahun'
                  GROUP BY bulan_list.bulan_num
                  ORDER BY bulan_list.bulan_num
              ";
        $query = $this->db->query($sql);
        $rows = $query->fetchAll();
        $data = [];
        foreach ($rows as $row) {
            $data[] = [
                'bulan' => $row['bulan'],
                'total' => (int)$row['total'],
                'total_qty' => ($row['total_qty'] ?? 0)
            ];
        }
        return $data;
    }

    public function total_ppn_bulan_ini()
    {
        $bulan_ini = date('Y-m');
        $sql = "SELECT SUM(ppn) as total FROM transaksi_keluar WHERE DATE_FORMAT(tgl, '%Y-%m') = ?";
        $query = $this->db->prepare($sql);
        $query->execute([$bulan_ini]);
        $data = $query->fetch();
        return $data['total'] ?? 0;
    }
    public function jumlah_ppn_bulan_ini()
    {
        $bulan_ini = date('Y-m');
        $sql = "SELECT COUNT(*) as total FROM transaksi_keluar WHERE ppn > 0 AND DATE_FORMAT(tgl, '%Y-%m') = ?";
        $query = $this->db->prepare($sql);
        $query->execute([$bulan_ini]);
        $data = $query->fetch();
        return $data['total'] ?? 0;
    }
    public function jumlah_bulan_ini()
    {
        $bulan_ini = date('Y-m');
        $sql = "SELECT COUNT(*) as total FROM transaksi_keluar WHERE DATE_FORMAT(tgl, '%Y-%m') = ?";
        $query = $this->db->prepare($sql);
        $query->execute([$bulan_ini]);
        $data = $query->fetch();
        return $data['total'] ?? 0;
    }

    public function total_ongkir_bulan_ini()
    {
        $bulan_ini = date('Y-m');
        $sql = "SELECT SUM(ongkir) as total_ongkir FROM transaksi_keluar WHERE DATE_FORMAT(tgl, '%Y-%m') = ?";
        $query = $this->db->prepare($sql);
        $query->execute([$bulan_ini]);
        $data = $query->fetch();
        return $data['total_ongkir'] ?? 0;
    }

    public function jumlah_ongkir_gratis()
    {
        $bulan_ini = date('Y-m');
        $sql = "SELECT COUNT(*) as total FROM transaksi_keluar WHERE penanggung_ongkir = 1 AND DATE_FORMAT(tgl, '%Y-%m') = ?";
        $query = $this->db->prepare($sql);
        $query->execute([$bulan_ini]);
        $data = $query->fetch();
        return $data['total'] ?? 0;
    }

    public function jumlah_ongkir_bulan_ini()
    {
        $bulan_ini = date('Y-m');
        $sql = "SELECT COUNT(*) as total FROM transaksi_keluar WHERE ongkir IS NOT NULL AND DATE_FORMAT(tgl, '%Y-%m') = ?";
        $query = $this->db->prepare($sql);
        $query->execute([$bulan_ini]);
        $data = $query->fetch();
        return $data['total'] ?? 0;
    }

    public function pembayaran_jatuh_tempo()
    {
        // $today = date('Y-m-d');
        // $next7 = date('Y-m-d', strtotime('+7 days'));

        $sql = "SELECT 
    tk.client_id,
    tc.nama_client,
    
    SUM(CASE WHEN tk.tgl_jatuh_tempo < CURDATE() THEN 1 ELSE 0 END) AS total_jatuh_tempo,
    SUM(CASE WHEN tk.tgl_jatuh_tempo BETWEEN CURDATE() AND DATE_ADD(CURDATE(), INTERVAL 7 DAY) THEN 1 ELSE 0 END) AS total_segera_jatuh_tempo,

    SUM(CASE WHEN tk.tgl_jatuh_tempo < CURDATE() THEN tk.total_harga ELSE 0 END) AS tagihan_jatuh_tempo,
    SUM(CASE WHEN tk.tgl_jatuh_tempo BETWEEN CURDATE() AND DATE_ADD(CURDATE(), INTERVAL 7 DAY) THEN tk.total_harga ELSE 0 END) AS tagihan_segera_jatuh_tempo

FROM transaksi_keluar tk
JOIN tbl_client tc ON tk.client_id = tc.recid
WHERE 
    tk.tgl_jatuh_tempo <= DATE_ADD(CURDATE(), INTERVAL 7 DAY)
    AND tk.status_pembayaran = 0
GROUP BY tk.client_id
ORDER BY total_jatuh_tempo DESC, total_segera_jatuh_tempo DESC";

        $query = $this->db->prepare($sql);
        $query->execute();
        $data = $query->fetchAll();
        return $data;
    }

    public function laporan_penjualan($tgl_dari = null, $tgl_sampai = null, $client_id = null, $status_bayar = null)
    {
        $sql = "SELECT tk.*, tc.nama_client 
                FROM transaksi_keluar tk
                LEFT JOIN tbl_client tc ON tk.client_id = tc.recid
                WHERE 1=1";

        $params = [];

        // Filter tanggal
        if (!empty($tgl_dari) && !empty($tgl_sampai)) {
            $sql .= " AND DATE(tk.tgl) BETWEEN ? AND ?";
            $params[] = $tgl_dari;
            $params[] = $tgl_sampai;
        }

        // Filter client (opsional)
        if (!empty($client_id)) {
            $sql .= " AND tk.client_id = ?";
            $params[] = $client_id;
        }

        // Filter status bayar (opsional)
        if ($status_bayar === 'lunas') {
            $sql .= " AND tk.status_pembayaran = 1";
        } elseif ($status_bayar === 'belum') {
            $sql .= " AND tk.status_pembayaran = 0";
        }

        $sql .= " ORDER BY tk.tgl DESC";

        $query = $this->db->prepare($sql);
        $query->execute($params);
        $rows = $query->fetchAll(PDO::FETCH_ASSOC);
        $data = [];
        foreach ($rows as $row) {
            // var_dump(json_encode($row));
            $data[] = array_merge(
                $row,
                [
                    'status_bayar' => $row['status_pembayaran'] == 1 ? "Lunas" : "Belum Lunas",
                    'jatuh_tempo' => $row['status_pembayaran'] == 1 ? "-" : date(
                        'd-m-Y',
                        strtotime($row['tgl_jatuh_tempo'])
                    )
                ]
            );
        }

        return $data;
    }

    public function laporan_penjualan_print($tgl_dari = null, $tgl_sampai = null, $client_id = null, $status_bayar = null)
    {
        // echo "<pre>";
        $method = $this->laporan_penjualan($tgl_dari, $tgl_sampai, $client_id, $status_bayar);
        // var_dump($method)
        return $method;
    }

    public function laporan_pembelian_bahan_baku($tgl_dari = null, $tgl_sampai = null, $status_bayar = null)
    {
        // echo "<pre>";
        // var_dump("bisa");
        $sql = "SELECT sp.nama_supplier,t.*, b.nama_bb, u.kode_uom FROM tbl_transaksi_bahanbaku as t
                    JOIN tbl_bahan_baku as b ON t.bahanbaku_id = b.recid
                    JOIN uom as u ON b.satuan = u.kode_uom 
                    JOIN tbl_supplier as sp ON b.supp_id = sp.recid 
                    WHERE 1=1";

        $params = [];

        // Filter tanggal
        if (!empty($tgl_dari) && !empty($tgl_sampai)) {
            $sql .= " AND DATE(t.tgl) BETWEEN ? AND ?";
            $params[] = $tgl_dari;
            $params[] = $tgl_sampai;
        }


        // Filter status bayar (opsional)
        if ($status_bayar === 'lunas') {
            $sql .= " AND t.status_bayar = 1";
        } elseif ($status_bayar === 'belum') {
            $sql .= " AND t.status_bayar = 0";
        }

        $sql .= " ORDER BY t.tgl DESC";
        $query = $this->db->prepare($sql);
        $query->execute($params);
        $rows = $query->fetchAll(PDO::FETCH_ASSOC);

        // var_dump($sql);
        // var_dump($rows);
        $data = [];
        foreach ($rows as $row) {
            // var_dump(json_encode($row));
            $status = ($row['status'] == 0 ? "Draft" : ($row['status'] == 1 ? "In Order" : "Finish"));
            $status_pembayaran = $row['bukti_file'] != NULL ? "Lunas" : "Belum Bayar";
            $data[] = array_merge(
                $row,
                [
                    'status' => $status,
                    'status_pembayaran' => $status_pembayaran,

                ]
            );
        }
        return $data;
    }

    public function laporan_stok_bahan_baku()
    {

        // echo "<pre>";
        $sql = "SELECT 
            bb.*,
            u.kode_uom,
            u.nama_uom,
            u.batas_aman,
            s.nama_supplier
        FROM tbl_bahan_baku bb
        JOIN tbl_supplier s ON bb.supp_id = s.recid
        JOIN uom u ON bb.satuan = u.kode_uom
        ORDER BY bb.recid ASC;";

        $row = $this->db->prepare($sql);
        $row->execute();
        $hasil = $row->fetchAll();

        // var_dump($hasil);
        return $hasil;
    }

    public function laporan_uang_jalan_supir($tgl_dari = null, $tgl_sampai = null)
    {
        $sql = "SELECT 
    tk.no_invoice,
    tk.tgl,
    tk.pengiriman,
    tk.ongkir,
    tk.penanggung_ongkir,
    tk.total_harga,
    tk.status_pembayaran,
    tc.nama_client
FROM transaksi_keluar tk
JOIN tbl_client tc ON tc.recid = tk.client_id

                WHERE 1=1";

        $params = [];

        // Filter tanggal
        if (!empty($tgl_dari) && !empty($tgl_sampai)) {
            $sql .= " AND DATE(tk.tgl) BETWEEN ? AND ?";
            $params[] = $tgl_dari;
            $params[] = $tgl_sampai;
        }

        $sql .= " ORDER BY tk.tgl DESC";

        $query = $this->db->prepare($sql);
        $query->execute($params);
        $rows = $query->fetchAll(PDO::FETCH_ASSOC);

        return $rows;
    }

    public function laporan_pemasukan_pengeluaran($tgl_dari = null, $tgl_sampai = null)
    {
        // echo "<pre>";
        // print_r($type);
        $wherePenjualan1 = "tk.tgl BETWEEN ? AND ?";
        $wherePembelian2 = "tb.tgl BETWEEN ? AND ?";
        $params = [$tgl_dari, $tgl_sampai, $tgl_dari, $tgl_sampai];


        $sql = "
            SELECT * FROM (
    -- PENJUALAN
    SELECT 
        tk.tgl AS tanggal, 
        tk.no_invoice AS nomor,
        'Penjualan' AS tipe, 
        tk.pengiriman AS keterangan, 
        SUM(tk.hargaPerTon * tk.qty) AS kredit,
        0 AS debit,
        tc.nama_client AS nama
    FROM transaksi_keluar tk
    JOIN tbl_client tc ON tc.recid = tk.client_id
    WHERE $wherePenjualan1
    GROUP BY tk.tgl, tk.no_invoice, tk.pengiriman, tc.nama_client

    UNION ALL

    -- PEMBELIAN
    SELECT 
        tb.tgl AS tanggal,
        tb.no_po AS nomor,
        'Pembelian' AS tipe,
        tb.pengiriman AS keterangan,
        0 AS kredit,
        tb.jumlah_bayar AS debit,
        ts.nama_supplier AS nama
    FROM tbl_transaksi_bahanbaku tb
    JOIN tbl_supplier ts ON ts.recid = tb.supp_id
    WHERE $wherePembelian2
) AS transaksi
ORDER BY tanggal ASC

        ";

        $stmt = $this->db->prepare($sql);
        $stmt->execute($params);
        $rows = $stmt->fetchAll(PDO::FETCH_ASSOC);

        $data = [];
        foreach ($rows as $row) {

            if ($row['tipe'] == "Pembelian") {
                $data[] = array_merge(
                    $row,
                    [
                        'keterangan_fix' => "Pembelian dari Supplier " . $row["nama"],
                    ]
                );
            } else {
                $data[] = array_merge(
                    $row,
                    [
                        'keterangan_fix' => "Penjualan ke Client " . $row["nama"],
                    ]
                );
            }
        }
        return $data;
    }
    public function laporan_piutang($tgl_dari = null, $tgl_sampai = null)
    {
        // echo "<pre>";
        // print_r($type);
        $wherePenjualan1 = "tk.tgl BETWEEN ? AND ?";
        $wherePembelian2 = "tb.tgl BETWEEN ? AND ?";
        $params = [$tgl_dari, $tgl_sampai, $tgl_dari, $tgl_sampai];


        $sql = "
            SELECT * FROM (
    -- PENJUALAN (hanya yang Belum Lunas)
    SELECT 
        tk.tgl AS tanggal, 
        tk.no_invoice AS nomor,
        'Penjualan' AS tipe, 
        tk.pengiriman AS keterangan, 
        tk.total_harga AS Jumlah,
        tc.nama_client AS nama
    FROM transaksi_keluar tk
    JOIN tbl_client tc ON tc.recid = tk.client_id
    WHERE $wherePenjualan1
      AND tk.status_pembayaran = 0
    GROUP BY tk.tgl, tk.no_invoice, tk.pengiriman, tc.nama_client

    UNION ALL

    -- PEMBELIAN (hanya yang belum dibayar / tidak punya bukti_file)
    SELECT 
        tb.tgl AS tanggal,
        tb.no_po AS nomor,
        'Pembelian' AS tipe,
        tb.pengiriman AS keterangan,
        tb.harga AS Jumlah,
        ts.nama_supplier AS nama
    FROM tbl_transaksi_bahanbaku tb
    JOIN tbl_supplier ts ON ts.recid = tb.supp_id
    WHERE $wherePembelian2
      AND (tb.bukti_file IS NULL OR tb.bukti_file = '')
) AS transaksi
ORDER BY tanggal ASC


        ";

        $stmt = $this->db->prepare($sql);
        $stmt->execute($params);
        $rows = $stmt->fetchAll(PDO::FETCH_ASSOC);

        $data = [];
        foreach ($rows as $row) {

            if ($row['tipe'] == "Pembelian") {
                $data[] = array_merge(
                    $row,
                    [
                        'keterangan_fix' => "Pembelian dari Supplier " . $row["nama"],
                    ]
                );
            } else {
                $data[] = array_merge(
                    $row,
                    [
                        'keterangan_fix' => "Penjualan ke Client " . $row["nama"],
                    ]
                );
            }
        }
        return $data;
    }

    public function laporan_ppn($tgl_dari, $tgl_sampai)
    {
        $sql = "
        SELECT 
            tk.no_invoice,
            tk.tgl,
            tc.nama_client,
            SUM(tk.ppn) AS total_ppn,
            SUM(tk.hargaPerTon * tk.qty) AS total_harga,
            CASE 
                WHEN SUM(tk.ppn) != 0 THEN 'Ya'
                ELSE 'Tidak'
            END AS pakai_ppn
        FROM transaksi_keluar tk
        JOIN tbl_client tc ON tc.recid = tk.client_id
        WHERE tk.tgl BETWEEN ? AND ?
        GROUP BY tk.no_invoice, tk.tgl, tc.nama_client
        ORDER BY tk.tgl ASC
    ";

        $stmt = $this->db->prepare($sql);
        $stmt->execute([$tgl_dari, $tgl_sampai]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function laporan_profit($tgl_dari, $tgl_sampai)
    {
        // echo "<pre>";
        $sql = "
        SELECT 
            tk.tgl,
            tk.no_invoice,
            c.nama_client,
            p.nama_product,
            tk.qty,
            tk.hargaPerTon,
            (tk.hargaPerTon * tk.qty) AS total_harga,
            tk.profit,
            tk.profit_bahanbaku
        FROM transaksi_keluar tk
        JOIN tbl_client c ON c.recid = tk.client_id
        JOIN tbl_product p ON p.recid = tk.product_id
        WHERE tk.tgl BETWEEN ? AND ?
        ORDER BY tk.tgl ASC
    ";

        $stmt = $this->db->prepare($sql);
        $stmt->execute([$tgl_dari, $tgl_sampai]);
        $rows = $stmt->fetchAll(PDO::FETCH_ASSOC);
        // print_r($rows);
        return $rows;
    }

    public function invoice_print($inv)
    {

        $sql = "
        SELECT 
        tk.*, 
        c.nama_client, c.alamat, 
        p.nama_product 
    FROM transaksi_keluar tk
    JOIN tbl_client c ON c.recid = tk.client_id
    JOIN tbl_product p ON p.recid = tk.product_id
    WHERE tk.no_invoice = ?
        ";

        $stmt = $this->db->prepare($sql);
        $stmt->execute([$inv]);
        $rows = $stmt->fetch(PDO::FETCH_ASSOC);

        // print_r($rows);
        return $rows;
    }




    public function member()
    {
        $sql = "select member.*, login.*
                from member inner join login on member.id_member = login.id_member";
        $row = $this->db->prepare($sql);
        $row->execute();
        $hasil = $row->fetchAll();
        return $hasil;
    }

    public function member_edit($id)
    {
        $sql = "select member.*, login.*
                from member inner join login on member.id_member = login.id_member
                where member.id_member= ?";
        $row = $this->db->prepare($sql);
        $row->execute(array($id));
        $hasil = $row->fetch();
        return $hasil;
    }

    public function toko()
    {
        $sql = "select*from toko where id_toko='1'";
        $row = $this->db->prepare($sql);
        $row->execute();
        $hasil = $row->fetch();
        return $hasil;
    }

    public function kategori()
    {
        $sql = "select*from kategori";
        $row = $this->db->prepare($sql);
        $row->execute();
        $hasil = $row->fetchAll();
        return $hasil;
    }

    public function barang()
    {
        $sql = "select barang.*, kategori.id_kategori, kategori.nama_kategori
                from barang inner join kategori on barang.id_kategori = kategori.id_kategori 
                ORDER BY id DESC";
        $row = $this->db->prepare($sql);
        $row->execute();
        $hasil = $row->fetchAll();
        return $hasil;
    }

    public function barang_stok()
    {
        $sql = "select barang.*, kategori.id_kategori, kategori.nama_kategori
                from barang inner join kategori on barang.id_kategori = kategori.id_kategori 
                where stok <= 3 
                ORDER BY id DESC";
        $row = $this->db->prepare($sql);
        $row->execute();
        $hasil = $row->fetchAll();
        return $hasil;
    }

    // public function barang_edit($id)
    // {
    //     $sql = "select barang.*, kategori.id_kategori, kategori.nama_kategori
    //             from barang inner join kategori on barang.id_kategori = kategori.id_kategori
    //             where id_barang=?";
    //     $row = $this-> db -> prepare($sql);
    //     $row -> execute(array($id));
    //     $hasil = $row -> fetch();
    //     return $hasil;
    // }

    public function barang_cari($cari)
    {
        $sql = "select barang.*, kategori.id_kategori, kategori.nama_kategori
                from barang inner join kategori on barang.id_kategori = kategori.id_kategori
                where id_barang like '%$cari%' or nama_barang like '%$cari%' or merk like '%$cari%'";
        $row = $this->db->prepare($sql);
        $row->execute();
        $hasil = $row->fetchAll();
        return $hasil;
    }

    public function barang_id()
    {
        $sql = 'SELECT * FROM barang ORDER BY id DESC';
        $row = $this->db->prepare($sql);
        $row->execute();
        $hasil = $row->fetch();

        $urut = substr($hasil['id_barang'], 2, 3);
        $tambah = (int) $urut + 1;
        if (strlen($tambah) == 1) {
            $format = 'BR00' . $tambah . '';
        } elseif (strlen($tambah) == 2) {
            $format = 'BR0' . $tambah . '';
        } else {
            $ex = explode('BR', $hasil['id_barang']);
            $no = (int) $ex[1] + 1;
            $format = 'BR' . $no . '';
        }
        return $format;
    }

    public function kategori_edit($id)
    {
        $sql = "select*from kategori where id_kategori=?";
        $row = $this->db->prepare($sql);
        $row->execute(array($id));
        $hasil = $row->fetch();
        return $hasil;
    }

    public function kategori_row()
    {
        $sql = "select*from kategori";
        $row = $this->db->prepare($sql);
        $row->execute();
        $hasil = $row->rowCount();
        return $hasil;
    }

    public function barang_row()
    {
        $sql = "select*from tbl_bahan_baku";
        $row = $this->db->prepare($sql);
        $row->execute();
        $hasil = $row->rowCount();
        return $hasil;
    }
    // public function barang_row()
    // {
    //     $sql = "select*from barang";
    //     $row = $this-> db -> prepare($sql);
    //     $row -> execute();
    //     $hasil = $row -> rowCount();
    //     return $hasil;
    // }

    public function barang_stok_row()
    {
        $sql = "SELECT SUM(stok) as jml FROM barang";
        $row = $this->db->prepare($sql);
        $row->execute();
        $hasil = $row->fetch();
        return $hasil;
    }

    public function barang_beli_row()
    {
        $sql = "SELECT SUM(harga_beli) as beli FROM barang";
        $row = $this->db->prepare($sql);
        $row->execute();
        $hasil = $row->fetch();
        return $hasil;
    }

    public function jual_row()
    {
        $sql = "SELECT SUM(jumlah) as stok FROM nota";
        $row = $this->db->prepare($sql);
        $row->execute();
        $hasil = $row->fetch();
        return $hasil;
    }

    public function jual()
    {
        $sql = "SELECT nota.* , barang.id_barang, barang.nama_barang, barang.harga_beli, member.id_member,
                member.nm_member from nota 
                left join barang on barang.id_barang=nota.id_barang 
                left join member on member.id_member=nota.id_member 
                where nota.periode = ?
                ORDER BY id_nota DESC";
        $row = $this->db->prepare($sql);
        $row->execute(array(date('m-Y')));
        $hasil = $row->fetchAll();
        return $hasil;
    }

    public function periode_jual($periode)
    {
        $sql = "SELECT nota.* , barang.id_barang, barang.nama_barang, barang.harga_beli, member.id_member,
                member.nm_member from nota 
                left join barang on barang.id_barang=nota.id_barang 
                left join member on member.id_member=nota.id_member WHERE nota.periode = ? 
                ORDER BY id_nota ASC";
        $row = $this->db->prepare($sql);
        $row->execute(array($periode));
        $hasil = $row->fetchAll();
        return $hasil;
    }

    public function hari_jual($hari)
    {
        $ex = explode('-', $hari);
        $monthNum  = $ex[1];
        $monthName = date('F', mktime(0, 0, 0, $monthNum, 10));
        if ($ex[2] > 9) {
            $tgl = $ex[2];
        } else {
            $tgl1 = explode('0', $ex[2]);
            $tgl = $tgl1[1];
        }
        $cek = $tgl . ' ' . $monthName . ' ' . $ex[0];
        $param = "%{$cek}%";
        $sql = "SELECT nota.* , barang.id_barang, barang.nama_barang,  barang.harga_beli, member.id_member,
                member.nm_member from nota 
                left join barang on barang.id_barang=nota.id_barang 
                left join member on member.id_member=nota.id_member WHERE nota.tanggal_input LIKE ? 
                ORDER BY id_nota ASC";
        $row = $this->db->prepare($sql);
        $row->execute(array($param));
        $hasil = $row->fetchAll();
        return $hasil;
    }

    public function penjualan()
    {
        $sql = "SELECT penjualan.* , barang.id_barang, barang.nama_barang, member.id_member,
                member.nm_member from penjualan 
                left join barang on barang.id_barang=penjualan.id_barang 
                left join member on member.id_member=penjualan.id_member
                ORDER BY id_penjualan";
        $row = $this->db->prepare($sql);
        $row->execute();
        $hasil = $row->fetchAll();
        return $hasil;
    }

    public function jumlah()
    {
        $sql = "SELECT SUM(total) as bayar FROM penjualan";
        $row = $this->db->prepare($sql);
        $row->execute();
        $hasil = $row->fetch();
        return $hasil;
    }

    public function jumlah_nota()
    {
        $sql = "SELECT SUM(total) as bayar FROM nota";
        $row = $this->db->prepare($sql);
        $row->execute();
        $hasil = $row->fetch();
        return $hasil;
    }

    public function jml()
    {
        $sql = "SELECT SUM(harga_beli*stok) as byr FROM barang";
        $row = $this->db->prepare($sql);
        $row->execute();
        $hasil = $row->fetch();
        return $hasil;
    }
}
