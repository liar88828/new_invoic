<?php
require_once 'invoices.php';

$invoiceObj = new Invoices();
$invoices = $invoiceObj->readAll();
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Manajemen Invoice</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
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
        <td><?= htmlspecialchars($invoice['invoice']) ?></td>
        <td><?= htmlspecialchars($invoice['tanggal_invoice']) ?></td>
        <td>Rp. <?= number_format($invoice['total'], 0, ',', '.') ?></td>
        <td><?= htmlspecialchars($invoice['status']) ?></td>
        <td>
          <a href="update.php?id=<?= $invoice['id'] ?>" class="btn btn-warning btn-sm">Edit</a>
          <a href="delete.php?id=<?= $invoice['id'] ?>" class="btn btn-danger btn-sm" onclick="return confirm('Yakin ingin menghapus?')">Hapus</a>
        </td>
      </tr>
    <?php endforeach; ?>
    </tbody>
  </table>
</div>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>