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

        </div>


        <div class="mb-3">
            <label class="form-label">Catatan</label>
            <textarea name="notes" class="form-control" rows="3"></textarea>
        </div>

      <?php require './produk.php'; ?>

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


      <?php require './customers.php' ?>
        <!-- Tempat Menampilkan Data Pelanggan -->
        <div class="mt-4">
            <h5>Data Pelanggan</h5>
            <table class="table table-bordered" id="customerTable">
                <thead>
                <tr>
                    <th>ID</th>
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

        <input type="hidden" name="total" required/>
        <input type="hidden" name="customer" id="customer">
        <input type="hidden" name="products" id="products">


        <h4>Total Invoice: <span id="total-invoice">0</span></h4>

        <button type="submit" class="btn btn-primary">Simpan Invoice</button>
        <a href="invoices.php" class="btn btn-secondary">Batal</a>
    </form>
</div>


<!--get-product -->
<script>

	<!--get-product -->


	// Fungsi untuk Menghitung Total Keseluruhan
	function updateTotal() {
		const rows = document.querySelectorAll('#invoiceTable tbody tr');
		let grandTotal = 0;

		rows.forEach(row => {
			const quantity = parseInt(row.querySelector('.jumlah-produk').textContent) || 0;
			const price = parseInt(row.querySelector('.harga-produk').textContent.replace(/Rp\.|,/g, '').trim()) || 0;
			const total = parseInt(row.querySelector('.total-produk').textContent);
			grandTotal += total;
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
