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
    public function numberSequence()
    {
        $sql = "SELECT * FROM number_sequences";
        $row = $this-> db -> prepare($sql);
        $row -> execute();
        $hasil = $row -> fetchAll();
        return $hasil;
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
