<?php
require_once 'customers.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
  $customerObj = new Customers();
  $data = [
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

  if ($customerObj->create($data)) {
    header('Location: \customer\index.php');
    exit();
  }
}
?>
<?php require_once '../header.php'?>


<div class="container mt-5">
  <h2>Tambah Pelanggan Baru</h2>
  <form method="POST">
    <div class="row">
      <div class="col-md-6 mb-3">
        <label class="form-label">Invoice</label>
        <input type="text" name="invoice" class="form-control" required>
      </div>
      <div class="col-md-6 mb-3">
        <label class="form-label">Nama</label>
        <input type="text" name="nama" class="form-control" required>
      </div>
    </div>
    <div class="mb-3">
      <label class="form-label">Alamat</label>
      <input type="text" name="alamat" class="form-control" required>
    </div>
    <div class="row">
      <div class="col-md-4 mb-3">
        <label class="form-label">Kota</label>
        <input type="text" name="kota" class="form-control" required>
      </div>
      <div class="col-md-4 mb-3">
        <label class="form-label">Kode Pos</label>
        <input type="text" name="postcode" class="form-control" required>
      </div>
      <div class="col-md-4 mb-3">
        <label class="form-label">Telepon</label>
        <input type="text" name="tlp" class="form-control" required>
      </div>
    </div>
    <h4>Informasi Penerima</h4>
    <div class="mb-3">
      <label class="form-label">Nama Penerima</label>
      <input type="text" name="nama_penerima" class="form-control" required>
    </div>
    <div class="mb-3">
      <label class="form-label">Alamat Penerima</label>
      <input type="text" name="alamat_penerima" class="form-control" required>
    </div>
    <div class="mb-3">
      <label class="form-label">Kode Pos Penerima</label>
      <input type="text" name="postcode_penerima" class="form-control" required>
    </div>
    <button type="submit" class="btn btn-primary">Simpan</button>
    <a href="index.php" class="btn btn-secondary">Batal</a>
  </form>
</div>

<?php require_once '../footer.php'?>
