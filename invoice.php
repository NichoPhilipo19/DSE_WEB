<?
include_once __DIR__ . '/fungsi/view/view.php';
include_once './config.php';
$lihat = new view($config);
$invoice = $_GET["inv"] ?? null;
$data = $lihat->invoice_print($_GET["inv"]);
$grandTotal = ($data['hargaPerTon'] * $data['qty']) + $data['ppn'] + ($data['penanggung_ongkir'] == 1 ? 0 : $data['ongkir']);
?>

<!-- <button class="print-button" onclick="window.print()">🖨 Print Laporan</button> -->
<!DOCTYPE html>
<html>

<head>
    <title>Invoice #<?= $data['no_invoice'] ?></title>
    <style>
        body {
            font-family: Arial;
        }

        .container {
            width: 700px;
            margin: 0 auto;
        }

        .header,
        .footer {
            text-align: center;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
        }

        td,
        th {
            padding: 8px;
            border: 1px solid #ccc;
        }

        .text-right {
            text-align: right;
        }

        .no-border {
            border: none;
        }

        .borderlessRight {
            border-right: none !important;
        }

        .borderlessLeft {
            border-left: none !important;
        }

        @media print {
            .no-print {
                display: none;
            }
        }
    </style>
</head>

<body>
    <div class="container">
        <div class="header">
            <h2>INVOICE PENJUALAN</h2>
            <p>No Invoice: <strong><?= $data['no_invoice'] ?></strong></p>
        </div>

        <table>
            <tr>
                <td width="50%">
                    <strong>Kepada:</strong><br>
                    <?= $data['nama_client'] ?><br>
                    <?= nl2br($data['alamat_client']) ?>
                </td>
                <td class="borderlessRight">
                    <strong>Tanggal</strong><br>
                    <strong>No PO</strong> <br>
                    <strong>Pengiriman</strong>
                </td>
                <td class="borderlessLeft">
                    <strong>:</strong> <?= date('d M Y', strtotime($data['tgl'])) ?><br>
                    <strong>:</strong> <?= $data['no_po'] ?><br>
                    <strong>:</strong> <?= $data['pengiriman'] ?>
                </td>
            </tr>
        </table>

        <table>
            <thead>
                <tr>
                    <th>Produk</th>
                    <th>Qty (Ton)</th>
                    <th>Harga / Ton</th>
                    <th>Total Harga</th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td><?= $data['nama_product'] ?></td>
                    <td class="text-right"><?= number_format($data['qty'], 2) ?></td>
                    <td class="text-right">Rp <?= number_format($data['hargaPerTon'], 0) ?></td>
                    <td class="text-right">Rp <?= number_format($data['hargaPerTon'] * $data['qty'], 0) ?></td>
                </tr>
            </tbody>
            <tfoot>
                <tr>
                    <td colspan="3" class="text-right"><strong>Subtotal</strong></td>
                    <td class="text-right">Rp <?= number_format($data['hargaPerTon'] * $data['qty'], 0) ?></td>
                </tr>
                <tr>
                    <td colspan="3" class="text-right"><strong>PPN</strong></td>
                    <td class="text-right">Rp <?= number_format($data['ppn'], 0) ?></td>
                </tr>
                <tr>
                    <td colspan="3" class="text-right"><strong>Ongkir</strong> <?= $data['penanggung_ongkir'] == 1 ? "(Gratis)" : "" ?></td>
                    <td class="text-right">Rp <?= number_format($data['ongkir'], 0) ?></td>
                </tr>
                <tr>
                    <td colspan="3" class="text-right"><strong>Grand Total</strong></td>
                    <td class="text-right">
                        Rp <?= number_format($grandTotal, 0) ?>
                    </td>
                </tr>
            </tfoot>
        </table>

        <p style="margin-top: 30px;">Catatan: Pembayaran ditujukan ke rekening perusahaan CV. Deltasindo Engineering.</p>

        <div class="footer" style="margin-top:50px;">
            <div style="float:left; width:45%; text-align:center;">
                <p>Penerima,</p><br><br>
                <p>_____________________</p>
            </div>
            <div style="float:right; width:45%; text-align:center;">
                <p>Hormat Kami,</p><br><br>
                <p>_____________________</p>
            </div>
            <div style="clear:both;"></div>
        </div>

        <div class="no-print" style="margin-top: 40px; text-align: center;">
            <button onclick="window.print()">🖨 Cetak Invoice</button>
        </div>
    </div>
</body>

</html>