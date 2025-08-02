<!DOCTYPE html>
<html>
<?
include_once __DIR__ . '/fungsi/view/view.php';
include_once './config.php';
$lihat = new view($config);
?>

<head>
    <title>Print Laporan Pemasukan Pengeluaran</title>
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
    <h2>Laporan Pemasukan Pengeluaran DSE</h2>


    <table class="table table-bordered">
        <thead>
            <tr>
                <th>Tanggal</th>
                <th>No Transaksi</th>
                <th>Tipe</th>
                <th>Keterangan</th>
                <th>Kredit (Masuk)</th>
                <th>Debit (Keluar)</th>
            </tr>
        </thead>
        <tbody>
            <?php
            $tgl_dari = $_GET['from'] ?? null;
            $tgl_sampai = $_GET['to'] ?? null;

            $data = $lihat->laporan_pemasukan_pengeluaran($tgl_dari, $tgl_sampai);

            $total_debit = 0;
            $total_kredit = 0;

            foreach ($data as $row):
                $total_debit += $row['debit'];
                $total_kredit += $row['kredit'];
            ?>
                <tr>
                    <td><?= date('d-m-Y', strtotime($row['tanggal'])) ?></td>
                    <td><?= $row['nomor'] ?></td>
                    <td><?= $row['tipe'] ?></td>
                    <td><?= $row['keterangan_fix'] ?></td>
                    <td>Rp <?= number_format($row['kredit']) ?></td>
                    <td>Rp <?= number_format($row['debit']) ?></td>
                </tr>
            <?php endforeach; ?>
        </tbody>
        <tfoot>
            <tr style="font-weight:bold;">
                <td colspan="4" align="right">Total</td>
                <td>Rp <?= number_format($total_kredit) ?></td>
                <td>Rp <?= number_format($total_debit) ?></td>
            </tr>
            <tr style="font-weight:bold; background:#e0ffe0;">
                <td colspan="4" align="right">Saldo Akhir (Kredit - Debit)</td>
                <td colspan="2">Rp <?= number_format($total_kredit - $total_debit) ?></td>
            </tr>
        </tfoot>
    </table>

</body>

</html>