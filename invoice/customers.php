<button type="button"
        class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#customersModal">
    Tambah Customers
</button>

<div class="modal fade" id="customersModal" tabindex="-1" aria-labelledby="exampleModalLabel"
     aria-hidden="true">
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
                        <th>Nama</th>
                        <th>Kota</th>
                        <th>Aksi</th>
                    </tr>
                    </thead>
                    <tbody>
                    <?php if (isset($customers)): ?>
                      <?php foreach ($customers as $customer): ?>
                            <tr>
                                <td><?= htmlspecialchars($customer['id']) ?></td>
                                <td><?= htmlspecialchars($customer['nama']) ?></td>
                                <td><?= htmlspecialchars($customer['kota']) ?></td>
                                <td>
                                    <button
                                            type="button"
                                            class="btn btn-danger btn-sm get-customer" onclick="">Tambah
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
<!--        modal Customers end-->

<!--get-customer modal-->
<script>
	// Event Listener untuk Tambah Pelanggan dari Modal
	document.querySelectorAll('.get-customer').forEach(button => {
		button.addEventListener('click', function () {
			const row = this.closest('tr'); // Ambil baris tabel
			const id = row.children[0].textContent.trim(); // ID pelanggan
			const name = row.children[1].textContent.trim(); // Nama pelanggan
			const city = row.children[2].textContent.trim(); // Kota pelanggan

			// Periksa apakah pelanggan sudah ditambahkan
			const existingRow = document.querySelector(`#customerTable tbody tr[data-id="${id}"]`);
			if (existingRow) {
				alert("Pelanggan sudah ditambahkan.");
				return;
			}

			// Tambahkan data pelanggan ke tabel
			const tableBody = document.getElementById('customerTable').querySelector('tbody');
			const newRow = `
                <tr data-id="${id}">
                    <td>${id}
                        <input type="hidden" name="customer_id"  value="${id}">
                    </td>
                    <td>${name}</td>
                    <td>${city}</td>
                    <td>
                        <button class="btn btn-sm btn-danger" onclick="removeCustomer(this)">Hapus</button>
                    </td>
                </tr>
            `;
			tableBody.insertAdjacentHTML('beforeend', newRow);

			// Tutup modal setelah pelanggan ditambahkan
			const modal = bootstrap.Modal.getInstance(document.getElementById('customersModal'));
			modal.hide();
		});
	});

	// Fungsi untuk Menghapus Pelanggan
	function removeCustomer(button) {
		button.closest('tr').remove();
	}
</script>

<!--customerTable-->
<script>
	document.querySelector('form').addEventListener('submit', function (e) {
		const tableBody = document.getElementById('customerTable').querySelector('tbody');
		const rows = tableBody.querySelectorAll('tr');
		if (rows.length === 0) {
			alert("Harap pilih pelanggan sebelum menyimpan invoice.");
			e.preventDefault(); // Batalkan submit jika tidak ada pelanggan
			return;
		}

		const customers = Array.from(rows).map(row => {
			return {
				id: row.dataset.id,
			};
		});
		console.log(customers)
		document.getElementById('customer').value = JSON.stringify(customers);
	});
</script>
