<?php
require_once 'invoices.php';
require_once '../produk/products.php';
require_once '../customer/customers.php';

$productObj = new Products();
$products = $productObj->readAll();

$customerObj = new Customers();
$customers = $customerObj->readAll();

$invoiceObj = new Invoices();

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
// Calculate total
  $customerData = json_decode($_POST['customer'], true);
  $productsData = json_decode($_POST['products'], true); // Decode data produk

  $id_customer = $customerData[0]['id'];
  $id_products = array();
  foreach ($productsData as $product) {
    array_push($id_products, $product["id"]);// why is error
  }


  $data = [
    ':tanggal_invoice' => $_POST['tanggal_invoice'],
    ':ongkir' => $_POST['ongkir'],
    ':discount' => $_POST['discount'],
    ':total' => $_POST['total'],
    ':notes' => $_POST['notes'],
    ':status' => $_POST['status'],
    ':uang_muka' => $_POST['uang_muka'],
    ':id_customers' => $id_customer
  ];

  // Simpan invoice ke database
  if ($invoiceObj->create($data, $id_products)) {
    header('Location: /invoice/index.php');
    exit();
  }
}
?>

<?php require_once '../header.php' ?>

<div class="container mt-5">
    <h2>Buat Invoice Baru</h2>
    <form method="POST">
        <div class="row">
            <div class="col-md-6 mb-3">
                <label class="form-label">Tanggal Invoice</label>
                <input type="date" name="tanggal_invoice" class="form-control" required/>
            </div>


            <div class="col-md-6 mb-3">
                <label class="form-label">Status</label>
                <select name="status" class="form-control" required>
                    <option value="Pending">Pending</option>
                    <option value="Lunas">Lunas</option>
                    <option value="Dibatalkan">Dibatalkan</option>
                </select>
            </div>


        </div>
        <div class="row">
            <div class="col-md-6 mb-3">
                <label class="form-label">Uang Muka</label>
                <input type="number" name="uang_muka" class="form-control" required>
            </div>

            <div class="col-md-6 mb-3">
                <label class="form-label">Ongkos Kirim</label>
                <input type="number" name="ongkir" class="form-control" required>
            </div>
        </div>
        <div class="row">
            <div class="col-md-6 mb-3">
                <label class="form-label">Diskon</label>
                <input type="number" name="discount" class="form-control" required max="100"/>
            </div>

            <input type="text" name="total" required/>
        </div>


        <div class="mb-3">
            <label class="form-label">Catatan</label>
            <textarea name="notes" class="form-control" rows="3"></textarea>
        </div>
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
                                <th>Aksi</th>
                            </tr>
                            </thead>
                            <tbody>
                            <?php foreach ($products as $product): ?>
                                <tr>
                                    <td><?= htmlspecialchars($product['id_produk']) ?></td>
                                    <td><?= htmlspecialchars($product['nama_produk']) ?></td>
                                    <td><?= htmlspecialchars($product['jumlah_produk']) ?></td>
                                    <td>Rp. <?= htmlspecialchars($product['harga_produk']) ?></td>
                                    <td>
                                        <button
                                                type="button"
                                                class="btn btn-danger btn-sm get-product">Tambah
                                        </button>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
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
        <!--add table here after push-->
        <!-- Table Produk di Form Utama -->
        <div class="mt-4">
            <h5>Daftar Produk</h5>
            <table class="table table-bordered" id="invoiceTable">
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
                <!-- Produk yang ditambahkan akan tampil di sini -->
                </tbody>
            </table>

            <h4>Total Keseluruhan: <span id="total-keseluruhan">0</span></h4>

        </div>


        <!--         modal Customers -->
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
                                        <button
                                                type="button"
                                                class="btn btn-danger btn-sm get-customer" onclick="">Tambah
                                        </button>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
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


        <!-- Tempat Menampilkan Data Pelanggan -->
        <div class="mt-4">
            <h5>Data Pelanggan</h5>
            <table class="table table-bordered" id="customerTable">
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
                <!-- Data pelanggan yang dipilih akan ditambahkan di sini -->
                </tbody>
            </table>
        </div>
        <input  name="customer" id="customer">
        <input type="hidden" name="products" id="products">


        <h4>Total Invoice: <span id="total-invoice">0</span></h4>

        <button type="submit" class="btn btn-primary">Simpan Invoice</button>
        <a href="invoices.php" class="btn btn-secondary">Batal</a>
    </form>
</div>


<!--get-customer modal-->
<script>
	// Event Listener untuk Tambah Pelanggan dari Modal
	document.querySelectorAll('.get-customer').forEach(button => {
		button.addEventListener('click', function () {
			const row = this.closest('tr'); // Ambil baris tabel
			const id = row.children[0].textContent.trim(); // ID pelanggan
			const invoice = row.children[1].textContent.trim(); // Invoice pelanggan
			const name = row.children[2].textContent.trim(); // Nama pelanggan
			const city = row.children[3].textContent.trim(); // Kota pelanggan

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
                    <td>${invoice}</td>
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
				name: row.children[1].textContent.trim(),
				quantity: row.children[2].textContent.trim(),
				price: row.children[3].textContent.replace(/Rp\.|,/g, '').trim(),
				total: row.children[4].textContent.replace(/Rp\.|,/g, '').trim()
			};
		});
		// console.log(products)
		document.getElementById('products').value = JSON.stringify(products);
	});
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
				invoice: row.children[1].textContent.trim(),
				name: row.children[2].textContent.trim(),
				city: row.children[3].textContent.trim()
			};
		});

		document.getElementById('customer').value = JSON.stringify(customers);
	});
</script>

<!--get-product -->
<script>

	<!--get-product -->
	// Event Listener untuk Tombol "Tambah Produk" di Modal
	document.querySelectorAll('.get-product').forEach(button => {
		button.addEventListener('click', function () {
			const row = this.closest('tr'); // Ambil baris tabel
			const id = row.children[0].textContent; // Ambil ID produk
			const name = row.children[1].textContent; // Nama produk
			const quantity = row.children[2].textContent; // Jumlah produk
			const price = row.children[3].textContent.replace(/Rp\.|,/g, '').trim(); // Harga produk
			const total = parseInt(quantity) * parseInt(price); // Total harga

			// Tambahkan produk ke tabel utama
			const tableBody = document.getElementById('invoiceTable').querySelector('tbody');
			const newRow = ` <tr>
                <td>${id}
                    <input type="hidden" name="products_id" value="${id}">
                </td>
                <td>${name}</td>
                <td class="jumlah-produk">${quantity}</td>
                <td class="harga-produk">${parseInt(price).toLocaleString('id-ID')}</td>
                <td class="total-produk">Rp ${total.toLocaleString('id-ID')}</td>
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


	// Fungsi untuk Menghitung Total Keseluruhan
	function updateTotal() {
		const rows = document.querySelectorAll('#invoiceTable tbody tr');
		let grandTotal = 0;

		rows.forEach(row => {
			const quantity = parseInt(row.querySelector('.jumlah-produk').textContent) || 0;
			const price = parseInt(row.querySelector('.harga-produk').textContent.replace(/Rp\.|,/g, '').trim()) || 0;
			const total = quantity * price;
			grandTotal += total;

			// Update total per row
			row.querySelector('.total-produk').textContent = `Rp ${total.toLocaleString('id-ID')}`;
		});

		// Update grand total
		document.getElementById('total-keseluruhan').textContent = `${grandTotal.toLocaleString('id-ID')}`;
		return grandTotal
	}


	// Fungsi untuk Menghapus Baris
	function removeRow(button) {
		button.closest('tr').remove();
		calculateSubtotal()
	}

	// Get form inputs
	const uangMukaInput = document.querySelector('[name="uang_muka"]');
	const ongkirInput = document.querySelector('[name="ongkir"]');
	const discountInput = document.querySelector('[name="discount"]');
	const totalInput = document.querySelector('[name="total"]');
	const totalInvoice = document.getElementById('total-invoice');  // Add this for total invoice update

	// Function to calculate subtotal based on inputs
	function calculateSubtotal() {
		let data = updateTotal()
		const uangMuka = parseFloat(uangMukaInput.value) || 0;
		const ongkir = parseFloat(ongkirInput.value) || 0;
		const discount = parseFloat(discountInput.value) || 0;

		// Ensure discount is not greater than 100
		const validDiscount = discount > 100 ? 100 : discount;

		// Calculate subtotal with discount applied to ongkir (if that's your requirement)
		// const subtotal = (ongkir - (ongkir * (validDiscount / 100))) - uangMuka;
		let totalAll = data + ongkir;
		const totalAfterDiscount = (totalAll - (totalAll * (validDiscount / 100))) - uangMuka

		totalInput.value = totalAfterDiscount

		// Update the total-invoice (use subtotal for total invoice)
		totalInvoice.textContent = `Rp ${totalAfterDiscount.toFixed(2).toLocaleString('id-ID')}`;
		// totalKeseluruhan.textContent = totalAfterDiscount.toLocaleString('id-ID')
	}


	// Event listeners to trigger calculation whenever an input changes
	uangMukaInput.addEventListener('input', calculateSubtotal);
	ongkirInput.addEventListener('input', calculateSubtotal);
	discountInput.addEventListener('input', calculateSubtotal);

	// Optional: Trigger the calculation on form load if any initial values exist
	window.addEventListener('load', calculateSubtotal);
</script>

<?php require_once '../footer.php' ?>
