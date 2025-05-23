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
        $row = $this-> db -> prepare($sql);
        $row -> execute();
        $hasil = $row -> fetchAll();
        return $hasil;
    }

    public function bahanbaku()
    {
        $sql = "SELECT 
            bb.recid,
            bb.nama_bb,
            bb.`desc`,
            bb.stok,
            bb.satuan,
            bb.supp_id,
            bb.harga_pasaran_per_satuan,
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
        $row = $this-> db -> prepare($sql);
        $row -> execute(array($id));
        $hasil = $row -> fetch();
        return $hasil;
    }

    public function clietList()
    {
        $sql = "SELECT * FROM tbl_client";
        $row = $this-> db -> prepare($sql);
        $row -> execute();
        $hasil = $row -> fetchAll();
        return $hasil;
    }
    
    public function clientList_edit($id)
    {
        $sql = "select * from tbl_client where recid =?;";
        $row = $this-> db -> prepare($sql);
        $row -> execute(array($id));
        $hasil = $row -> fetch();
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
        $row = $this-> db -> prepare($sql);
        $row -> execute(array($id));
        $hasil = $row -> fetchAll();
        return $hasil;
    }

    public function invenList()
    {
        $sql = "SELECT * FROM tbl_inventaris";
        $row = $this-> db -> prepare($sql);
        $row -> execute();
        $hasil = $row -> fetchAll();
        return $hasil;
    }

    public function productList()
    {
        $sql = "SELECT * FROM tbl_product";
        $row = $this-> db -> prepare($sql);
        $row -> execute();
        $hasil = $row -> fetchAll();
        return $hasil;
    }
    public function supplierList()
    {
        $sql = "SELECT * FROM tbl_supplier";
        $row = $this-> db -> prepare($sql);
        $row -> execute();
        $hasil = $row -> fetchAll();
        return $hasil;
    }
    public function tmptProduksiList()
    {
        $sql = "SELECT * FROM tbl_tmpt_produksi";
        $row = $this-> db -> prepare($sql);
        $row -> execute();
        $hasil = $row -> fetchAll();
        return $hasil;
    }
    public function userList()
    {
        $sql = "SELECT * FROM tbl_user";
        $row = $this-> db -> prepare($sql);
        $row -> execute();
        $hasil = $row -> fetchAll();
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
        $row = $this-> db -> prepare($sql);
        $row -> execute();
        $hasil = $row -> fetchAll();
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
    public function transaksi_bahanbaku_list()
    {
        // $sql = "SELECT t.* FROM tbl_transaksi_bahanbaku as t";
        $sql = "SELECT t.*, b.nama_bb, u.kode_uom FROM tbl_transaksi_bahanbaku as t
                JOIN tbl_bahan_baku as b ON t.bahanbaku_id = b.recid
                JOIN uom as u ON b.satuan = u.kode_uom ORDER BY t.tgl DESC";
        $row = $this-> db -> prepare($sql);
        $row -> execute();
        $hasil = $row -> fetchAll();
        return $hasil;
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
        $sql = "SELECT bb.recid,bb.nama_bb, bb.stok, bb.satuan, f.qty_per_ton, f.produk_id
                FROM tbl_formulasi f
                JOIN tbl_bahan_baku bb ON f.bahanbaku_id = bb.recid";

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
                'uom' => $row['satuan']
            ];
        }
        // var_dump($data);
        return $data;
    }

    public function transaksi_penjualan_list()
    {
        $sql = "SELECT tk.*, c.nama_client 
          FROM transaksi_keluar tk
          LEFT JOIN tbl_client c ON tk.client_id = c.recid
          ORDER BY tk.tgl DESC";
        $row = $this->db->prepare($sql);
        $row->execute();
        $hasil = $row->fetchAll();
        return $hasil;
    }




    public function member()
    {
        $sql = "select member.*, login.*
                from member inner join login on member.id_member = login.id_member";
        $row = $this-> db -> prepare($sql);
        $row -> execute();
        $hasil = $row -> fetchAll();
        return $hasil;
    }

    public function member_edit($id)
    {
        $sql = "select member.*, login.*
                from member inner join login on member.id_member = login.id_member
                where member.id_member= ?";
        $row = $this-> db -> prepare($sql);
        $row -> execute(array($id));
        $hasil = $row -> fetch();
        return $hasil;
    }

    public function toko()
    {
        $sql = "select*from toko where id_toko='1'";
        $row = $this-> db -> prepare($sql);
        $row -> execute();
        $hasil = $row -> fetch();
        return $hasil;
    }

    public function kategori()
    {
        $sql = "select*from kategori";
        $row = $this-> db -> prepare($sql);
        $row -> execute();
        $hasil = $row -> fetchAll();
        return $hasil;
    }

    public function barang()
    {
        $sql = "select barang.*, kategori.id_kategori, kategori.nama_kategori
                from barang inner join kategori on barang.id_kategori = kategori.id_kategori 
                ORDER BY id DESC";
        $row = $this-> db -> prepare($sql);
        $row -> execute();
        $hasil = $row -> fetchAll();
        return $hasil;
    }

    public function barang_stok()
    {
        $sql = "select barang.*, kategori.id_kategori, kategori.nama_kategori
                from barang inner join kategori on barang.id_kategori = kategori.id_kategori 
                where stok <= 3 
                ORDER BY id DESC";
        $row = $this-> db -> prepare($sql);
        $row -> execute();
        $hasil = $row -> fetchAll();
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
        $row = $this-> db -> prepare($sql);
        $row -> execute();
        $hasil = $row -> fetchAll();
        return $hasil;
    }

    public function barang_id()
    {
        $sql = 'SELECT * FROM barang ORDER BY id DESC';
        $row = $this-> db -> prepare($sql);
        $row -> execute();
        $hasil = $row -> fetch();

        $urut = substr($hasil['id_barang'], 2, 3);
        $tambah = (int) $urut + 1;
        if (strlen($tambah) == 1) {
            $format = 'BR00'.$tambah.'';
        } elseif (strlen($tambah) == 2) {
            $format = 'BR0'.$tambah.'';
        } else {
            $ex = explode('BR', $hasil['id_barang']);
            $no = (int) $ex[1] + 1;
            $format = 'BR'.$no.'';
        }
        return $format;
    }

    public function kategori_edit($id)
    {
        $sql = "select*from kategori where id_kategori=?";
        $row = $this-> db -> prepare($sql);
        $row -> execute(array($id));
        $hasil = $row -> fetch();
        return $hasil;
    }

    public function kategori_row()
    {
        $sql = "select*from kategori";
        $row = $this-> db -> prepare($sql);
        $row -> execute();
        $hasil = $row -> rowCount();
        return $hasil;
    }

    public function barang_row()
    {
        $sql = "select*from tbl_bahan_baku";
        $row = $this-> db -> prepare($sql);
        $row -> execute();
        $hasil = $row -> rowCount();
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
        $sql ="SELECT SUM(stok) as jml FROM barang";
        $row = $this-> db -> prepare($sql);
        $row -> execute();
        $hasil = $row -> fetch();
        return $hasil;
    }

    public function barang_beli_row()
    {
        $sql ="SELECT SUM(harga_beli) as beli FROM barang";
        $row = $this-> db -> prepare($sql);
        $row -> execute();
        $hasil = $row -> fetch();
        return $hasil;
    }

    public function jual_row()
    {
        $sql ="SELECT SUM(jumlah) as stok FROM nota";
        $row = $this-> db -> prepare($sql);
        $row -> execute();
        $hasil = $row -> fetch();
        return $hasil;
    }

    public function jual()
    {
        $sql ="SELECT nota.* , barang.id_barang, barang.nama_barang, barang.harga_beli, member.id_member,
                member.nm_member from nota 
                left join barang on barang.id_barang=nota.id_barang 
                left join member on member.id_member=nota.id_member 
                where nota.periode = ?
                ORDER BY id_nota DESC";
        $row = $this-> db -> prepare($sql);
        $row -> execute(array(date('m-Y')));
        $hasil = $row -> fetchAll();
        return $hasil;
    }

    public function periode_jual($periode)
    {
        $sql ="SELECT nota.* , barang.id_barang, barang.nama_barang, barang.harga_beli, member.id_member,
                member.nm_member from nota 
                left join barang on barang.id_barang=nota.id_barang 
                left join member on member.id_member=nota.id_member WHERE nota.periode = ? 
                ORDER BY id_nota ASC";
        $row = $this-> db -> prepare($sql);
        $row -> execute(array($periode));
        $hasil = $row -> fetchAll();
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
        $cek = $tgl.' '.$monthName.' '.$ex[0];
        $param = "%{$cek}%";
        $sql ="SELECT nota.* , barang.id_barang, barang.nama_barang,  barang.harga_beli, member.id_member,
                member.nm_member from nota 
                left join barang on barang.id_barang=nota.id_barang 
                left join member on member.id_member=nota.id_member WHERE nota.tanggal_input LIKE ? 
                ORDER BY id_nota ASC";
        $row = $this-> db -> prepare($sql);
        $row -> execute(array($param));
        $hasil = $row -> fetchAll();
        return $hasil;
    }

    public function penjualan()
    {
        $sql ="SELECT penjualan.* , barang.id_barang, barang.nama_barang, member.id_member,
                member.nm_member from penjualan 
                left join barang on barang.id_barang=penjualan.id_barang 
                left join member on member.id_member=penjualan.id_member
                ORDER BY id_penjualan";
        $row = $this-> db -> prepare($sql);
        $row -> execute();
        $hasil = $row -> fetchAll();
        return $hasil;
    }

    public function jumlah()
    {
        $sql ="SELECT SUM(total) as bayar FROM penjualan";
        $row = $this -> db -> prepare($sql);
        $row -> execute();
        $hasil = $row -> fetch();
        return $hasil;
    }

    public function jumlah_nota()
    {
        $sql ="SELECT SUM(total) as bayar FROM nota";
        $row = $this -> db -> prepare($sql);
        $row -> execute();
        $hasil = $row -> fetch();
        return $hasil;
    }

    public function jml()
    {
        $sql ="SELECT SUM(harga_beli*stok) as byr FROM barang";
        $row = $this -> db -> prepare($sql);
        $row -> execute();
        $hasil = $row -> fetch();
        return $hasil;
    }
}
