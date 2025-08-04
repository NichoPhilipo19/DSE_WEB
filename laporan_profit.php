<!DOCTYPE html>
<html>
<?
include_once __DIR__ . '/fungsi/view/view.php';
include_once './config.php';
$lihat = new view($config);
?>

<head>
    <title>Print Laporan Uang Jalan</title>
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
    <h2>Laporan Uang Jalan DSE</h2>


    <table class="table table-bordered">
        <thead>
            <tr>
                <th>No</th>
                <th>Tanggal</th>
                <th>No Invoice</th>
                <th>Client</th>
                <th>Produk</th>
                <th>Qty (Ton)</th>
                <th>Harga per Ton</th>
                <th>Total Harga</th>
                <th>Profit</th>
                <th>Profit Bahan Baku</th>
            </tr>
        </thead>
        <tbody>
            <?php
            $from = $_GET['from'] ?? date('Y-m-01');
            $to = $_GET['to'] ?? date('Y-m-d');
            $data = $lihat->laporan_profit($from, $to);
            $total_profit = 0;
            $total_profit_bb = 0;

            foreach ($data as $no => $row) {
                $total_profit += $row['profit'];
                $total_profit_bb += $row['profit_bahanbaku'];
                echo "<tr>
                <td>" . ($no + 1) . "</td>
                <td>" . date('d-m-Y', strtotime($row['tgl'])) . "</td>
                <td>{$row['no_invoice']}</td>
                <td>{$row['nama_client']}</td>
                <td>{$row['nama_produk']}</td>
                <td align='right'>" . number_format($row['qty'], 2) . "</td>
                <td align='right'>Rp " . number_format($row['hargaPerTon'], 0) . "</td>
                <td align='right'>Rp " . number_format($row['total_harga'], 0) . "</td>
                <td align='right'>Rp " . number_format($row['profit'], 0) . "</td>
                <td align='right'>Rp " . number_format($row['profit_bahanbaku'], 0) . "</td>
            </tr>";
            }
            ?>
        </tbody>
        <tfoot>
            <tr>
                <td colspan="8" align="right">TOTAL</td>
                <td align="right">Rp <?= number_format($total_profit, 0); ?></td>
                <td align="right">Rp <?= number_format($total_profit_bb, 0); ?></td>
            </tr>
        </tfoot>
    </table>

</body>

</html>