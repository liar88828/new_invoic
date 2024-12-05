<?php
require_once 'customers.php';

$customerObj = new Customers();
$customers = $customerObj->readAll();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Customer Management</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
<div class="container mt-5">
    <h2>Daftar Pelanggan</h2>
    <a href="/customer/create.php" class="btn btn-primary mb-3">
        Tambah Pelanggan Baru
    </a>

    <table class="table table-striped">
        <thead>
        <tr>
            <th>ID</th>
            <th>Invoice</th>
            <th>Nama</th>
            <th>Kota</th>
            <th>Aksi</th>
        </tr>
        </thead>
        <tbody>
        <?php foreach ($customers as $customer): ?>
            <tr>
                <td><?= htmlspecialchars($customer['id']) ?></td>
                <td><?= htmlspecialchars($customer['invoice']) ?></td>
                <td><?= htmlspecialchars($customer['nama']) ?></td>
                <td><?= htmlspecialchars($customer['kota']) ?></td>
                <td>
                    <a href="update.php?id=<?= $customer['id'] ?>" class="btn btn-warning btn-sm">Edit</a>
                    <a href="delete.php?id=<?= $customer['id'] ?>" class="btn btn-danger btn-sm"
                       onclick="return confirm('Yakin ingin menghapus?')">
                        Hapus
                    </a>
                </td>
            </tr>
        <?php endforeach; ?>
        </tbody>
    </table>
</div>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>