<!--         modal Produk -->
<button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#productModal">
    Tambah Produk
</button>

<div class="modal fade" id="productModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Tambah Produk</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
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
                    <tbody>
                    <?php if (isset($products)): ?>
                      <?php foreach ($products as $product): ?>
                            <tr>
                                <td><?= htmlspecialchars($product['id_produk']) ?></td>
                                <td><?= htmlspecialchars($product['nama_produk']) ?></td>
                                <td><?= htmlspecialchars($product['jumlah_produk']) ?></td>
                                <td>Rp. <?= htmlspecialchars($product['harga_produk']) ?></td>
                                <td><?= htmlspecialchars($product['total_produk']) ?></td>

                                <td>
                                    <button
                                            type="button"
                                            class="btn btn-danger btn-sm get-product">Tambah
                                    </button>
                                </td>
                            </tr>
                      <?php endforeach; ?>
                    <?php endif; ?>
                    </tbody>
                </table>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                <button type="button" class="btn btn-primary">Save changes</button>
            </div>
        </div>
    </div>
</div>
<!--        Modal Produk end-->

<script>
	// Event Listener untuk Tombol "Tambah Produk" di Modal
	document.querySelectorAll('.get-product').forEach(button => {
		button.addEventListener('click', function () {
			const row = this.closest('tr'); // Ambil baris tabel
			const id = row.children[0].textContent; // Ambil ID produk
			const name = row.children[1].textContent; // Nama produk
			const quantity = row.children[2].textContent; // Jumlah produk
			const price = row.children[3].textContent.replace(/Rp\.|,/g, '').trim(); // Harga produk
			const total = row.children[4].textContent // Total harga

			// Tambahkan produk ke tabel utama
			const tableBody = document.getElementById('invoiceTable').querySelector('tbody');
			const newRow = ` <tr>
                <td>${id}
                    <input type="hidden" name="products_id" value="${id}">
                </td>
                <td>${name}</td>
                <td class="jumlah-produk">${quantity}</td>
                <td class="harga-produk">${parseInt(price).toLocaleString('id-ID')}</td>
                <td class="total-produk"> ${total}</td>
                <td>
                    <button class="btn btn-sm btn-danger" onclick="removeRow(this)">Hapus</button>
                </td>
            </tr>
        `;
			tableBody.insertAdjacentHTML('beforeend', newRow);

			// Update total keseluruhan
			calculateSubtotal()

			// Tutup modal setelah menambahkan produk
			const modal = bootstrap.Modal.getInstance(document.getElementById('productModal'));
			modal.hide();
		});
	});

</script>

<!--invoiceTable-->
<script>
	// Tangkap event submit form
	document.querySelector('form').addEventListener('submit', function (e) {
		// e.preventDefault();
		const tableBody = document.getElementById('invoiceTable').querySelector('tbody');
		const rowsProduct = tableBody.querySelectorAll('tr');
		if (rowsProduct.length === 0) {
			alert("Harap pilih Produk sebelum menyimpan invoice.");
			e.preventDefault(); // Batalkan submit jika tidak ada pelanggan
			return;
		}
		const products = Array.from(rowsProduct).map(row => {
			return {
				id: row.children[0].textContent.trim(),
			};
		});
		// console.log(products)
		document.getElementById('products').value = JSON.stringify(products);
	});
</script>