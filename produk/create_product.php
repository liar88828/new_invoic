<?php
require_once 'products.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
  $productObj = new Products();
  $data = [
    ':nama_produk' => $_POST['nama_produk'],
    ':keterangan_produk' => $_POST['keterangan_produk'],
    ':harga_produk' => $_POST['harga_produk'],
    ':jumlah_produk' => $_POST['jumlah_produk']
  ];

  if ($productObj->create($data)) {
    header('Location: /produk/index.php');
    exit();
  }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Tambah Produk Baru</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
<div class="container mt-5">
    <h2>Tambah Produk Baru</h2>
    <form method="POST">
        <div class="mb-3">
            <label class="form-label">Nama Produk</label>
            <input type="text" name="nama_produk" class="form-control" required>
        </div>
        <div class="mb-3">
            <label class="form-label">Keterangan Produk</label>
            <textarea name="keterangan_produk" class="form-control" rows="3" required></textarea>
        </div>
        <div class="mb-3">
            <label class="form-label">Jumlah Produk</label>
            <input type="number" name="jumlah_produk" class="form-control" required>
        </div>
        <div class="mb-3">
            <label class="form-label">Harga Produk</label>
            <input type="number" name="harga_produk" class="form-control" required>
        </div>
        <button type="submit" class="btn btn-primary">Simpan</button>
        <a href="products.php" class="btn btn-secondary">Batal</a>
    </form>
</div>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>