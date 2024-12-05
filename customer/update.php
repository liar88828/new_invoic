<?php
require_once 'customers.php';

$customerObj = new Customers();

if (isset($_GET['id'])) {
  $customer = $customerObj->readSingle($_GET['id']);
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
  $data = [
    ':id' => $_POST['id'],
    ':invoice' => $_POST['invoice'],
    ':nama' => $_POST['nama'],
    ':alamat' => $_POST['alamat'],
    ':kota' => $_POST['kota'],
    ':postcode' => $_POST['postcode'],
    ':tlp' => $_POST['tlp'],
    ':nama_penerima' => $_POST['nama_penerima'],
    ':alamat_penerima' => $_POST['alamat_penerima'],
    ':postcode_penerima' => $_POST['postcode_penerima']
  ];

  if ($customerObj->update($data)) {
    header('Location: index.php');
    exit();
  }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Edit Pelanggan</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
<div class="container mt-5">
  <h2>Edit Pelanggan</h2>
  <form method="POST">
    <input type="hidden" name="id" value="<?= htmlspecialchars($customer['id']) ?>">
    <div class="row">
      <div class="col-md-6 mb-3">
        <label class="form-label">Invoice</label>
        <input type="text" name="invoice" class="form-control" value="<?= htmlspecialchars($customer['invoice']) ?>" required>
      </div>
      <div class="col-md-6 mb-3">
        <label class="form-label">Nama</label>
        <input type="text" name="nama" class="form-control" value="<?= htmlspecialchars($customer['nama']) ?>" required>
      </div>
    </div>
    <div class="mb-3">
      <label class="form-label">Alamat</label>
      <input type="text" name="alamat" class="form-control" value="<?= htmlspecialchars($customer['alamat']) ?>" required>
    </div>
    <div class="row">
      <div class="col-md-4 mb-3">
        <label class="form-label">Kota</label>
        <input type="text" name="kota" class="form-control" value="<?= htmlspecialchars($customer['kota']) ?>" required>
      </div>
      <div class="col-md-4 mb-3">
        <label class="form-label">Kode Pos</label>
        <input type="text" name="postcode" class="form-control" value="<?= htmlspecialchars($customer['postcode']) ?>" required>
      </div>
      <div class="col-md-4 mb-3">
        <label class="form-label">Telepon</label>
        <input type="text" name="tlp" class="form-control" value="<?= htmlspecialchars($customer['tlp']) ?>" required>
      </div>
    </div>
    <h4>Informasi Penerima</h4>
    <div class="mb-3">
      <label class="form-label">Nama Penerima</label>
      <input type="text" name="nama_penerima" class="form-control" value="<?= htmlspecialchars($customer['nama_penerima']) ?>" required>
    </div>
    <div class="mb-3">
      <label class="form-label">Alamat Penerima</label>
      <input type="text" name="alamat_penerima" class="form-control" value="<?= htmlspecialchars($customer['alamat_penerima']) ?>" required>
    </div>
    <div class="mb-3">
      <label class="form-label">Kode Pos Penerima</label>
      <input type="text" name="postcode_penerima" class="form-control" value="<?= htmlspecialchars($customer['postcode_penerima']) ?>" required>
    </div>
    <button type="submit" class="btn btn-primary">Update</button>
    <a href="index.php" class="btn btn-secondary">Batal</a>
  </form>
</div>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>