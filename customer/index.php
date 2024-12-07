<?php
require_once 'customers.php';

$customerObj = new Customers();
$customers = $customerObj->readAll();
?>
<?php require_once '../header.php'?>

<div class="container mt-5">
    <h2>Daftar Pelanggan</h2>
    <a href="/customer/create.php" class="btn btn-primary mb-3">
        Tambah Pelanggan Baru
    </a>

    <table class="table table-striped">
        <thead>
        <tr>
            <th>ID</th>
            <th>Nama</th>
            <th>Kota</th>
            <th>Aksi</th>
        </tr>
        </thead>
        <tbody>
        <?php foreach ($customers as $customer): ?>
            <tr>
                <td><?= htmlspecialchars($customer['id']) ?></td>
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

<?php require_once '../footer.php'?>
