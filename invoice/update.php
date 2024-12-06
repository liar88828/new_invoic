<?php
require_once 'invoices.php';

$invoiceObj = new Invoices();

if (isset($_GET['id'])) {
  $invoice = $invoiceObj->readSingle($_GET['id']);
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
  // Calculate total
  $subtotal = $_POST['subtotal'];
  $ongkir = $_POST['ongkir'];
  $discount = $_POST['discount'];
  $uang_muka = $_POST['uang_muka'];
  $total = $invoiceObj->calculateTotal($subtotal, $ongkir, $discount, $uang_muka);

  $data = [
    ':id' => $_POST['id'],
//    ':invoice' => $_POST['invoice'],
    ':tanggal_invoice' => $_POST['tanggal_invoice'],
    ':subtotal' => $subtotal,
    ':ongkir' => $ongkir,
    ':discount' => $discount,
    ':total' => $total,
    ':notes' => $_POST['notes'],
    ':status' => $_POST['status'],
    ':uang_muka' => $uang_muka
  ];

  if ($invoiceObj->update($data)) {
    header('Location: /invoice/index.php');
    exit();
  }
}
?>
<?php require_once '../header.php'?>


<div class="container mt-5">
  <h2>Edit Invoice</h2>
  <form method="POST">
    <input type="hidden" name="id" value="<?= htmlspecialchars($invoice['id']) ?>">
    <div class="row">
      <div class="col-md-6 mb-3">
        <label class="form-label">Nomor Invoice</label>
        <input type="text" name="invoice" class="form-control" value="<?= htmlspecialchars($invoice['invoice']) ?>" required>
      </div>
      <div class="col-md-6 mb-3">
        <label class="form-label">Tanggal Invoice</label>
        <input type="date" name="tanggal_invoice" class="form-control" value="<?= htmlspecialchars($invoice['tanggal_invoice']) ?>" required>
      </div>
    </div>
    <div class="row">
      <div class="col-md-4 mb-3">
        <label class="form-label">Subtotal</label>
        <input type="number" name="subtotal" class="form-control" value="<?= htmlspecialchars($invoice['subtotal']) ?>" required>
      </div>
      <div class="col-md-4 mb-3">
        <label class="form-label">Ongkos Kirim</label>
        <input type="number" name="ongkir" class="form-control" value="<?= htmlspecialchars($invoice['ongkir']) ?>" required>
      </div>
      <div class="col-md-4 mb-3">
        <label class="form-label">Diskon</label>
        <input type="number" name="discount" class="form-control" value="<?= htmlspecialchars($invoice['discount']) ?>" required>
      </div>
    </div>
    <div class="row">
      <div class="col-md-6 mb-3">
        <label class="form-label">Uang Muka</label>
        <input type="number" name="uang_muka" class="form-control" value="<?= htmlspecialchars($invoice['uang_muka']) ?>" required>
      </div>
      <div class="col-md-6 mb-3">
        <label class="form-label">Status</label>
        <select name="status" class="form-control" required>
          <option value="Pending" <?= $invoice['status'] == 'Pending' ? 'selected' : '' ?>>Pending</option>
          <option value="Lunas" <?= $invoice['status'] == 'Lunas' ? 'selected' : '' ?>>Lunas</option>
          <option value="Dibatalkan" <?= $invoice['status'] == 'Dibatalkan' ? 'selected' : '' ?>>Dibatalkan</option>
        </select>
      </div>
    </div>
    <div class="mb-3">
      <label class="form-label">Catatan</label>
      <textarea name="notes" class="form-control" rows="3"><?= htmlspecialchars($invoice['notes']) ?></textarea>
    </div>
    <button type="submit" class="btn btn-primary">Update Invoice</button>
    <a href="invoices.php" class="btn btn-secondary">Batal</a>
  </form>
</div>

<?php require_once '../footer.php'?>
