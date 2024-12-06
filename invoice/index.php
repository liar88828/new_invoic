<?php
require_once 'invoices.php';

$invoiceObj = new Invoices();
$invoices = $invoiceObj->readAll();
?>
<?php require_once '../header.php'?>

<div class="container mt-5">
  <h2>Daftar Invoice</h2>
  <a href="create.php" class="btn btn-primary mb-3">Buat Invoice Baru</a>

  <table class="table table-striped">
    <thead>
    <tr>
      <th>Nomor Invoice</th>
      <th>Tanggal</th>
      <th>Total</th>
      <th>Status</th>
      <th>Aksi</th>
    </tr>
    </thead>
    <tbody>
    <?php foreach($invoices as $invoice): ?>
      <tr>
        <td><?= htmlspecialchars($invoice['id']) ?></td>
        <td><?= htmlspecialchars($invoice['tanggal_invoice']) ?></td>
        <td>Rp. <?= number_format($invoice['total'], 0, ',', '.') ?></td>
        <td><?= htmlspecialchars($invoice['status']) ?></td>
        <td>
          <a href="update.php?id=<?= $invoice['id'] ?>" class="btn btn-warning btn-sm">Edit</a>
          <a href="delete.php?id=<?= $invoice['id'] ?>" class="btn btn-danger btn-sm" onclick="return confirm('Yakin ingin menghapus?')">Hapus</a>
          <a href="print.php?id=<?= $invoice['id'] ?>" class="btn btn-info btn-sm" >Print</a>
        </td>
      </tr>
    <?php endforeach; ?>
    </tbody>
  </table>
</div>

<?php require_once '../footer.php'?>
