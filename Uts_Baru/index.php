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
        <?php include 'Data.php'; ?>
        <?php include 'Buku.php'; ?>

        <?php
        if (isset($_GET['action'])) {
            $buku = new Buku();
            $action = $_GET['action'];

            if ($action == "tambah") {
                $judul = $_POST['judul'];
                $penulis = $_POST['penulis'];
                $buku->tambahBuku($judul, $penulis);
            } elseif ($action == "pinjam") {
                $id = $_GET['id'];
                $buku->pinjamBuku($id);
            } elseif ($action == "kembalikan") {
                $id = $_GET['id'];
                $buku->kembalikanBuku($id);
            } elseif ($action == "update") {
                $id = $_GET['id'];
                $judulBaru = $_POST['judulBaru'];
                $penulisBaru = $_POST['penulisBaru'];

                // Cari data buku berdasarkan id
                $indexBuku = array_search($id, array_column($buku->getDaftarBuku(), 'id'));

                // Jika data buku ditemukan, update data
                if ($indexBuku !== false) {
                    $buku->getDaftarBuku()[$indexBuku]['judul'] = $judulBaru;
                    $buku->getDaftarBuku()[$indexBuku]['penulis'] = $penulisBaru;
                    echo "<p>Data buku berhasil diperbarui!</p>";
                } else {
                    echo "<p>Data buku dengan id $id tidak ditemukan!</p>";
                }
            }
        }
        ?>

        <h2>Daftar Buku</h2>

        <table class="table">
            <thead>
                <tr>
                    <th>Judul</th>
                    <th>Penulis</th>
                    <th>Status</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($buku->getDaftarBuku() as $data) : ?>
                    <tr>
                        <td><?php echo $data['judul']; ?></td>
                        <td><?php echo $data['penulis']; ?></td>
                        <td><?php echo $data['status']; ?></td>
                        <td>
                            <?php if ($data['status'] == "Dipinjam") : ?>
                                <a href="?action=kembalikan&id=<?php echo $data['id']; ?>">Kembalikan</a>
                            <?php else : ?>
                                <a href="?action=pinjam&id=<?php echo $data['id']; ?>">Pinjam</a>
                            <?php endif; ?>
                            <a href="?action=update&id=<?php echo $data['id']; ?>">Update</a>
                        </td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>

        <h2>Tambah Buku Baru</h2>

        <form action="?action=tambah" method="post">
            <label for="judul">Judul Buku:</label>
            <input type="text" id="judul" name="judul" required>
            <br>
            <label for="penulis">Penulis:</label>
            <input type="text" id="penulis" name="penulis" required>
            <br>
            <button type="submit">Tambah</button>
        </form>

        <h2>Update Buku</h2>

        <form action="?action=update" method="post">
            <label for="id">ID Buku:</label>
            <input type="text" id="id" name="id" required readonly>  <br>
            <label for="judulBaru">Judul Baru:</label>
            <input type="text" id="judulBaru" name="judulBaru" required>
