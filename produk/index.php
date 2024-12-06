<?php
require_once 'products.php';

$productObj = new Products();
$products = $productObj->readAll();
?>
<?php require_once '../header.php' ?>


<div class="container mt-5">
    <h2>Daftar Produk</h2>
    <a href="create_product.php" class="btn btn-primary mb-3">Tambah Produk Baru</a>

    <table class="table table-striped">
        <thead>
        <tr>
            <th>ID</th>
            <th>Nama Produk</th>
            <th>Jumlah</th>
            <th>Harga</th>
            <th>Total</th>
            <th>Aksi</th>
        </tr>
        </thead>
        <tbody id="product-table">
        <?php foreach ($products as $product): ?>
            <tr>
                <td><?= htmlspecialchars($product['id_produk']) ?></td>
                <td><?= htmlspecialchars($product['nama_produk']) ?></td>
                <td class="jumlah-produk"><?= htmlspecialchars($product['jumlah_produk']) ?></td>
                <td class="harga-produk"><?= htmlspecialchars($product['harga_produk']) ?></td>
                <td class="total-produk">Rp. 0</td>
                <td>
                    <a href="update_product.php?id=<?= $product['id_produk'] ?>" class="btn btn-warning btn-sm">Edit</a>
                    <a href="delete_product.php?id=<?= $product['id_produk'] ?>" class="btn btn-danger btn-sm"
                       onclick="return confirm('Yakin ingin menghapus?')">
                        Hapus
                    </a>
                </td>
            </tr>
        <?php endforeach; ?>
        </tbody>
    </table>

    <h4>Total Keseluruhan: <span id="total-keseluruhan">Rp. 0</span></h4>
</div>
<script>
	document.addEventListener('DOMContentLoaded', function () {
		const rows = document.querySelectorAll('#product-table ');
		let grandTotal = 0;
		console.log(rows)
		rows.forEach(row => {
			const jumlahProduk = parseFloat(row.querySelector('.jumlah-produk').textContent) || 0;
			const hargaProduk = parseFloat(row.querySelector('.harga-produk').textContent) || 0;
			const totalProduk = jumlahProduk * hargaProduk;

			// Update the total for the current row
			row.querySelector('.total-produk').textContent = `Rp. ${totalProduk.toLocaleString('id-ID')}`;

			// Add to grand total
			grandTotal += totalProduk;
		});

		// Update the grand total
		document.getElementById('total-keseluruhan').textContent = `Rp. ${grandTotal.toLocaleString('id-ID')}`;
	});
</script>

<?php require_once '../footer.php' ?>
