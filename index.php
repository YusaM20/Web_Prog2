<?php

// Memuat data buku dari file JSON
$dataBuku = json_decode(file_get_contents('data/data.json'), true);

// Fungsi untuk menampilkan data buku ke tabel
function tampilDataBuku($dataBuku) {
    $html = '';
    foreach ($dataBuku as $buku) {
        $html .= '<tr>';
        $html .= '<td>' . $buku['judul'] . '</td>';
        $html .= '<td>' . $buku['penulis'] . '</td>';
        $html .= '<td>' . $buku['status'] . '</td>';
        $html .= '<td>';
        if ($buku['status'] === 'Dipinjam') {
            $html .= '<a href="?action=kembalikan&id=' . $buku['id'] . '">Kembalikan</a>';
        } else {
            $html .= '<a href="?action=pinjam&id=' . $buku['id'] . '">Pinjam</a>';
        }
        $html .= '</td>';
        $html .= '</tr>';
    }
    return $html;
}

// Menangani aksi (pinjam/kembalikan) buku
if (isset($_GET['action'])) {
    $action = $_GET['action'];
    $id = $_GET['id'];

    if ($action === 'pinjam') {
        $dataBuku[$id - 1]['status'] = 'Dipinjam';
    } else if ($action === 'kembalikan') {
        $dataBuku[$id - 1]['status'] = 'Tersedia';
    }

    // Simpan data buku yang diperbarui ke file JSON
    file_put_contents('data/data.json', json_encode($dataBuku));
}

?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Perpustakaan Sederhana</title>
    <link rel="stylesheet" href="css/style.css">
</head>
<body>
    <h1>Perpustakaan Sederhana</h1>

    <div class="container">
        <h2>Daftar Buku</h2>
        <table id="tabel-buku">
            <thead>
                <tr>
                    <th>Judul Buku</th>
                    <th>Penulis</th>
                    <th>Status</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
                <?php echo tampilDataBuku($dataBuku); ?>
            </tbody>
        </table>

        <button onclick="tambahBuku()">Tambah Buku</button>
    </div>

    <div id="modal-tambah-buku" class="modal">
        <div class="modal-content">
            <span class="close">&times;</span>
            <h2>Tambah Buku Baru</h2>
            <form id="form-tambah-buku">
                <div class="form-group">
                    <label for="judul">Judul Buku:</label>
                    <input type="text" id="judul" name="judul" required>
                </div>
                <div class="form-group">
                    <label for="penulis">Penulis:</label>
                    <input type="text" id="penulis" name="penulis" required>
                </div>
                <div class="form-group">
                    <label for="status">Status:</label>
                    <select id="status" name="status" required>
                        <option value="Dipinjam">Dipinjam</option>
                        <option value="Tersedia">Tersedia</option>
                    </select>
                </div>
                <button type="submit">Tambah</button>
            </form>
        </div>
    </div>

    <script src="script.js"></script>
</body>
</html>
