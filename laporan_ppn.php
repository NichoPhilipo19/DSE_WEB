<!DOCTYPE html>
<html>
<?
include_once __DIR__ . '/fungsi/view/view.php';
include_once './config.php';
$lihat = new view($config);
?>

<head>
    <title>Print Laporan PPN</title>
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
    <h2>Laporan PPN DSE</h2>


    <table class="table table-bordered">
        <thead>
            <tr>
                <th>No</th>
                <th>Tanggal</th>
                <th>No Invoice</th>
                <th>Nama Client</th>
                <th>Total Harga</th>
                <th>PPn (11%)</th>
                <th>Pakai PPn</th>
            </tr>
        </thead>
        <tbody>
            <?php
            $from = $_GET['from'] ?? date('Y-m-01');
            $to = $_GET['to'] ?? date('Y-m-d');
            $data = $lihat->laporan_ppn($from, $to);

            $total = 0;

            $no = 1;
            foreach ($data as $row):
                $total += $row['total_ppn'];
            ?>
                <tr>
                    <td><?= $no++ ?></td>
                    <td><?= date('d-m-Y', strtotime($row['tgl'])) ?></td>
                    <td><?= $row['no_invoice'] ?></td>
                    <td><?= $row['nama_client'] ?></td>
                    <td>Rp <?= number_format($row['total_harga']) ?></td>
                    <td>Rp <?= number_format($row['total_ppn']) ?></td>
                    <td><?= $row['pakai_ppn'] ?></td>
                </tr>
            <?php endforeach; ?>
            <tr style="font-weight:bold; background:#e0ffe0;">
                <td colspan="5" align="right">Total PPn</td>
                <td colspan="2">Rp <?= number_format($total) ?></td>
            </tr>
        </tbody>
    </table>

</body>

</html>