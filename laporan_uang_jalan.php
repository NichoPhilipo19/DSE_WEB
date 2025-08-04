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
                <th>No Invoice</th>
                <th>Tanggal</th>
                <th>Client</th>
                <th>Pengiriman</th>
                <th>Biaya Ongkir</th>
                <th>Ditanggung Oleh</th>
                <th>Total Harga</th>
                <th>Status Pembayaran</th>
            </tr>
        </thead>
        <tbody>
            <?php
            $no = 1;

                                    $from = $_GET['from'] ?? date('Y-m-01');
                                    $to = $_GET['to'] ?? date('Y-m-d');
                                    $data = $lihat->laporan_uang_jalan_supir($from, $to);
            $total_ongkir_client_count = 0;
            $total_ongkir_subsidi_count = 0;
            $total_ongkir_client = 0;
            $total_ongkir_subsidi = 0;
            foreach ($data as $row):
                $status = $row['status_pembayaran'] == 1 ? 'Lunas' : 'Belum Lunas';
                $penanggung = $row['penanggung_ongkir'] == 1 ? 'Perusahaan (Subsidi)' : 'Client';

                // hitung total berdasarkan penanggung ongkir
                if ($row['penanggung_ongkir'] == 1) {
                    $total_ongkir_subsidi += $row['ongkir'];
                    $total_ongkir_subsidi_count += 1;
                } else {
                    $total_ongkir_client += $row['ongkir'];
                    $total_ongkir_client_count +=  1;
                }
            ?>
                <tr>
                    <td><?= $no++ ?></td>
                    <td><?= $row['no_invoice'] ?></td>
                    <td><?= date('d-m-Y', strtotime($row['tgl'])) ?></td>
                    <td><?= $row['nama_client'] ?></td>
                    <td><?= $row['pengiriman'] ?></td>
                    <td>Rp <?= number_format($row['ongkir']) ?></td>
                    <td><?= $penanggung ?></td>
                    <td>Rp <?= number_format($row['total_harga']) ?></td>
                    <td><?= $status ?></td>
                </tr>
            <?php endforeach; ?>
            <tr style="font-weight:bold; background:#f0f0f0;">
                <td colspan="5" align="right">Subtotal Ongkir (Dibayar Client) (<? echo $total_ongkir_client_count ?>)</td>
                <td colspan="4">Rp <?= number_format($total_ongkir_client) ?></td>
            </tr>
            <tr style="font-weight:bold; background:#f0f0f0;">
                <td colspan="5" align="right">Subtotal Ongkir (Subsidi Perusahaan) (<? echo $total_ongkir_subsidi_count ?>)</td>
                <td colspan="4">Rp <?= number_format($total_ongkir_subsidi) ?></td>
            </tr>
            <tr style="font-weight:bold; background:#d0ffd0;">
                <td colspan="5" align="right">Grand Total Ongkir (Semua)</td>
                <td colspan="4">Rp <?= number_format($total_ongkir_client + $total_ongkir_subsidi) ?></td>
            </tr>
        </tbody>
    </table>

</body>

</html>