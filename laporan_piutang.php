<!DOCTYPE html>
<html>
<?
include_once __DIR__ . '/fungsi/view/view.php';
include_once './config.php';
$lihat = new view($config);
?>

<head>
    <title>Print Laporan Piutang</title>
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
    <h2>Laporan Piutang DSE</h2>


    <table class="table table-bordered">
        <thead>
            <tr>
                <th>Tanggal</th>
                <th>No Transaksi</th>
                <th>Tipe</th>
                <th>Keterangan</th>
                <th>Jumlah</th>
            </tr>
        </thead>
        <tbody>
            <?php
            $from = $_GET['from'] ?? date('Y-m-01');
            $to = $_GET['to'] ?? date('Y-m-d');
            $data = $lihat->laporan_piutang($from, $to);

            $total = 0;

            foreach ($data as $row):
                $total += $row['Jumlah'];
            ?>
                <tr>
                    <td><?= date('d-m-Y', strtotime($row['tanggal'])) ?></td>
                    <td><?= $row['nomor'] ?></td>
                    <td><?= $row['tipe'] ?></td>
                    <td><?= $row['keterangan_fix'] ?></td>
                    <td>Rp <?= number_format($row['Jumlah']) ?></td>
                </tr>
            <?php endforeach; ?>
            <tr style="font-weight:bold; background:#e0ffe0;">
                <td colspan="4" align="right">Total Piutang</td>
                <td colspan="2">Rp <?= number_format($total) ?></td>
            </tr>
        </tbody>
    </table>

</body>

</html>