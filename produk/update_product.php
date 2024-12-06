<?php
require_once 'products.php';

$productObj = new Products();

if (isset($_GET['id'])) {
  $product = $productObj->readSingle($_GET['id']);
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
  $data = [
    ':id_produk' => $_POST['id_produk'],
    ':nama_produk' => $_POST['nama_produk'],
    ':keterangan_produk' => $_POST['keterangan_produk'],
    ':harga_produk' => $_POST['harga_produk'],
    ':jumlah_produk' => $_POST['jumlah_produk']
  ];

  if ($productObj->update($data)) {
    header('Location: /produk/index.php');
    exit();
  }
}
?>
<?php require_once '../header.php'?>


<div class="container mt-5">
  <h2>Edit Produk</h2>
  <form method="POST">
    <input type="hidden" name="id_produk" value="<?= htmlspecialchars($product['id_produk']) ?>">
    <div class="mb-3">
      <label class="form-label">Nama Produk</label>
      <input type="text" name="nama_produk" class="form-control" value="<?= htmlspecialchars($product['nama_produk']) ?>" required>
    </div>
    <div class="mb-3">
      <label class="form-label">Keterangan Produk</label>
      <textarea name="keterangan_produk" class="form-control" rows="3" required><?= htmlspecialchars($product['keterangan_produk']) ?></textarea>
    </div>
      <div class="mb-3">
          <label class="form-label">Jumlah Produk</label>
          <input type="number" name="jumlah_produk" class="form-control"
                 value="<?= htmlspecialchars($product['jumlah_produk']) ?>"
                 required>
      </div>
    <div class="mb-3">
      <label class="form-label">Harga Produk</label>
      <input type="text" name="harga_produk" class="form-control"
             value="<?= htmlspecialchars($product['harga_produk']) ?>"
             required>
    </div>
    <button type="submit" class="btn btn-primary">Update</button>
    <a href="products.php" class="btn btn-secondary">Batal</a>
  </form>
</div>

<?php require_once '../footer.php'?>
