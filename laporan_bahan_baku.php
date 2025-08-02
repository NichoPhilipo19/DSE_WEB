<!DOCTYPE html>
<html>
<?
include_once __DIR__ . '/fungsi/view/view.php';
include_once './config.php';
$lihat = new view($config);
?>

<head>
    <title>Print Laporan Stock Bahan Baku</title>
    <style>
        @media print {
            @page {
                size: landscape;
            }

            .no-print {
                display: none;
            }

            table {
                width: 100%;
                border-collapse: collapse;
            }

            table,
            th,
            td {
                border: 1px solid black;
            }
        }

        table {
            margin-top: 20px;
        }

        th,
        td {
            padding: 8px;
            text-align: left;
        }

        .print-button {
            margin-bottom: 20px;
        }
    </style>
</head>

<body>

    <div class="no-print">
        <button class="print-button" onclick="window.print()">🖨 Print Laporan</button>
    </div>
    <h2>Laporan Bahan Baku DSE</h2>


    <table class="table table-bordered">
        <thead>
            <tr>
                <th>No</th>
                <th>Nama Bahan Baku</th>
                <th>Stok Tersedia</th>
                <th>Satuan (UOM)</th>
                <th>Minimal Stok</th>
            </tr>
        </thead>
        <tbody>
            <?php
            $data = $lihat->laporan_stok_bahan_baku();
            $no = 1;
            foreach ($data as $row): ?>
                <tr <?= $row['stok'] < $row['batas_aman'] ? 'style="background-color: #f8d7da;"' : '' ?>>
                    <td><?= $no++ ?></td>
                    <td><?= $row['nama_bb'] ?></td>
                    <td><?= $row['stok'] ?></td>
                    <td><?= $row['kode_uom'] ?></td>
                    <td><?= $row['batas_aman'] ?></td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>

</body>

</html>