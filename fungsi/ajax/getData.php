<?php

session_start();
if (!empty($_SESSION['admin'])) {
    require '../../config.php';
    header('Content-Type: application/json');

    if (!empty($_GET['aksi']) && $_GET['aksi'] == 'jual_batch') {
        $product_id = intval($_GET['product_id']);
        $qty = floatval($_GET['qty']);

        // Ambil bahan baku dan kebutuhan per ton
        $sql = "SELECT bb.recid,bb.nama_bb, bb.stok, f.qty_per_ton
                FROM tbl_formulasi f
                JOIN tbl_bahan_baku bb ON f.bahanbaku_id = bb.recid
                WHERE f.produk_id = :product_id";

        $stmt = $config->prepare($sql); // ✅ pakai $config, bukan $this
        $stmt->execute(['product_id' => $product_id]);

        $data = [];
        while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
            // var_dump($row);
            $totalKebutuhan = $row['qty_per_ton'] * $qty;

            $data[] = [
                'recid' => $row['recid'],
                'nama_bahan' => $row['nama_bb'],
                'kebutuhan' => $totalKebutuhan,
                'stok' => $row['stok']
            ];
        }
        echo json_encode($data);
    }
}
