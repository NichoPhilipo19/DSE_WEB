<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8" />
    <title>Tambah dan Sembunyikan Baris Table</title>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <style>
        table {
            border-collapse: collapse;
            margin-bottom: 20px;
        }

        table,
        th,
        td {
            border: 1px solid black;
            padding: 8px;
        }

        button {
            cursor: pointer;
        }
    </style>
</head>

<body>
    <form action="fungsi/tambah/tambah.php?jual=debug" method="POST">
        <input type="text" name="tes" value="0004/INV/DSE-07/2025">
        <button class="btn btn-warning btn-xs add-row-trigger" id="debug">Tambah ke transaksi</button>
    </form>
    <h3>Table 1</h3>
    <table id="table1">
        <thead>
            <tr>
                <th>Nama</th>
                <th>Umur</th>
                <th>Aksi</th>
            </tr>
        </thead>
        <tbody>
            <tr data-id="1">
                <td>Alice</td>
                <td>25</td>
                <td><button class="add-row-trigger">Tambah</button></td>
            </tr>
            <tr data-id="2">
                <td>Bob</td>
                <td>30</td>
                <td><button class="add-row-trigger">Tambah</button></td>
            </tr>
            <tr data-id="3">
                <td>Charlie</td>
                <td>28</td>
                <td><button class="add-row-trigger">Tambah</button></td>
            </tr>
        </tbody>
    </table>

    <h3>Table 2</h3>
    <table id="table2">
        <thead>
            <tr>
                <th>No.</th> <!-- Header nomor -->
                <th>Nama</th>
                <th>Umur</th>
                <th>Aksi</th>
            </tr>
        </thead>
        <tbody>
            <!-- Row akan ditambahkan di sini -->
        </tbody>
    </table>


    <script>
        $(document).ready(function() {
            // Ketika tombol "Tambah" di Table 1 diklik
            $('#debug').on('click', function() {
                const payload = {
                    no_invoice: "0004/INV/DSE-07/2025",
                };
                fetch("fungsi/tambah/tambah.php?jual=debug", {
                    method: "POST",
                    headers: {
                        "Content-Type": "application/json"
                    },
                    body: JSON.stringify(payload)
                })
                // .then(res => res.text())
                // .then(result => {
                //     alert("Invoice Telah Di buat!");
                //     // console.log(result);
                //     window.location.href = 'index.php?page=penjualan';
                // })
                // .catch(error => {
                //     console.error("Gagal:", error);
                // });
            })
            $('#table1').on('click', '.add-row-trigger', function() {
                var $row = $(this).closest('tr');
                var id = $row.data('id');

                // Cek apakah row sudah ada di table2, agar gak duplikat
                if ($('#table2 tbody tr[data-id="' + id + '"]').length > 0) {
                    alert('Data sudah ada di Table 2!');
                    return;
                }

                // Ambil data dari kolom nama dan umur
                var nama = $row.find('td:eq(0)').text();
                var umur = $row.find('td:eq(1)').text();

                // Buat row baru dengan kolom nomor (sementara kosong, nanti diupdate)
                var newRow = `<tr data-id="${id}">
                    <td class="no"></td>  <!-- Kolom nomor -->
                    <td>${nama}</td>
                    <td>${umur}</td>
                    <td><button class="remove-row-trigger">Hapus</button></td>
                  </tr>`;

                // Tambah ke table2
                $('#table2 tbody').append(newRow);

                // Hide row asli di table1
                $row.hide();

                // Update nomor urut di table2
                updateTable2Numbering();
            });

            // Fungsi untuk update nomor urut di Table 2
            function updateTable2Numbering() {
                $('#table2 tbody tr').each(function(index) {
                    // index mulai dari 0, jadi +1 agar mulai dari 1
                    $(this).find('td.no').text(index + 1);
                });
            }


            // Ketika tombol "Hapus" di Table 2 diklik
            $('#table2').on('click', '.remove-row-trigger', function() {
                var $row = $(this).closest('tr');
                var id = $row.data('id');

                // Hapus baris dari table2
                $row.remove();

                // Tampilkan kembali baris terkait di table1
                $('#table1 tbody tr[data-id="' + id + '"]').show();

                // Update nomor urut setelah hapus
                updateTable2Numbering();
            });

        });
    </script>

</body>

</html>