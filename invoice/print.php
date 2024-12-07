<?php
// Konfigurasi koneksi database
require_once '../db_connection.php';
require_once 'invoices.php';


// Ambil data invoice berdasarkan ID atau parameter lainnya
$invoice_id = $_GET['id'] ?? 1; // Ganti dengan parameter dinamis
$invoices = new  Invoices();
$response = $invoices->findPrint($invoice_id);

$invoice = $response['invoice'];
$products = $response['products'];

if (!$invoice) {
  die("Invoice tidak ditemukan.");
}


// Tutup koneksi setelah fetch
//$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Print Invoice</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
</head>
<body>
<div class="container my-5 ">

    <div class="card " id="print-pdf">
        <div class="card-header text-center">
            <div class="d-flex justify-content-between items-center">
                <img src="/public/logo.png"
                     alt="logo"
                     style="height: 100px;width: 100px; border-radius: 100%;"
                >
                <div class="mt-3">
                    <h3>Invoice #<?= $invoice['id_invoice'] ?></h3>
                    <small>Tanggal: <?= $invoice['tanggal_invoice'] ?></small>
                </div>
                <div class=""
                     style="height: 100px;width: 100px; border-radius: 100%;"

                ></div>
            </div>
        </div>
        <div class="card-body">
            <div class="d-flex justify-content-between">
                <div>
                    <h5>Customer</h5>
                    <p>
                      <?= $invoice['nama_customer'] ?><br>
                      <?= $invoice['alamat_customer'] ?><br>
                      <?= $invoice['kota_customer'] ?>, <?= $invoice['postcode_customer'] ?><br>
                        Telepon: <?= $invoice['telepon_customer'] ?>
                    </p>
                </div>

                <div>
                    <h5>Penerima</h5>
                    <p>
                      <?= $invoice['nama_penerima'] ?><br>
                      <?= $invoice['alamat_penerima'] ?><br>
                        Kode Pos: <?= $invoice['postcode_penerima'] ?>
                    </p>
                </div>
            </div>
            <div class="row">
                <table class="table table-bordered">
                    <thead>
                    <tr>
                        <th>Nama Produk</th>
                        <th>Keterangan Produk</th>
                        <th>Jumlah Produk</th>
                        <th>Harga Produk</th>
                        <th>Total Produk</th>
                    </tr>
                    </thead>
                    <tbody>
                    <?php foreach ($products as $product) : ?>
                        <tr>
                            <td><?= $product['nama_produk'] ?><br></td>
                            <td><?= mb_strimwidth($product['keterangan_produk'], 0, 50, "...") ?> </td>
                            <td class="jumlah-produk"><?= htmlspecialchars($product['jumlah_produk']) ?></td>
                            <td class="harga-produk"><?= htmlspecialchars($product['harga_produk']) ?></td>
                            <td class="totaldb-produk"><?= htmlspecialchars($product['total_produk']) ?></td>
                        </tr>
                    <?php endforeach; ?>
                    </tbody>
                </table>
                <h5 class="text-end">Total Keseluruhan Produk: <span id="total-keseluruhan">Rp. 0</span></h5>

            </div>
            <div class="row">
                <table class="table table-bordered">
                    <thead>
                    <tr>
                        <th>Ongkir</th>
                        <th>Diskon</th>
                        <th>Bayar Total</th>
                    </tr>
                    </thead>
                    <tbody>
                    <tr>
                        <td>Rp <?= number_format($invoice['ongkir'], 0, ',', '.') ?></td>
                        <td><?= $invoice['discount'] ?>%</td>
                        <td class="fw-bold text-decoration-underline">
                            Rp <?= number_format($invoice['total'], 0, ',', '.') ?></td>

                    </tr>
                    </tbody>
                </table>
            </div>
            <div class="d-flex justify-content-between">
                <div>
                    <h5>Deskripsi</h5>
                    <p><?= $invoice['notes'] ?></p>

                </div>

                <div class="row">
                    <div class="col-md-12 text-end">
                        <h5>Uang Muka: Rp <?= number_format($invoice['uang_muka'], 0, ',', '.') ?></h5>
                        <small>Status: <?= $invoice['status'] ?></small>

                    </div>
                </div>
            </div>
        </div>

    </div>
    <div class="card-footer text-center mt-5">
        <button class="btn btn-primary" onclick="window.print()">Print</button>
        <button class="btn btn-success" id="downloadPDF">Download PDF</button>
        <a href="/invoice/index.php" class="btn btn-secondary">Back</a>
    </div>
</div>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf/2.4.0/jspdf.umd.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/html2canvas/1.4.1/html2canvas.min.js"></script>
<script>
	document.getElementById('downloadPDF').addEventListener('click', async function () {
		const {jsPDF} = window.jspdf;
		const pdf = new jsPDF();

		// Ambil elemen HTML yang akan dijadikan PDF
		const element = document.querySelector('#print-pdf');

		// Konversi elemen ke gambar menggunakan html2canvas
		const canvas = await html2canvas(element, {scale: 2});
		const imgData = canvas.toDataURL('image/png');

		// Atur ukuran PDF sesuai ukuran elemen HTML
		const imgWidth = 190; // A4 width in mm
		const pageHeight = 277; // A4 height in mm
		const imgHeight = (canvas.height * imgWidth) / canvas.width;

		let position = 10; // Margin atas

		pdf.addImage(imgData, 'PNG', 10, position, imgWidth, imgHeight);

		// Simpan PDF dengan nama file
		pdf.save('invoice.pdf');
	});
</script>

<script>
	document.addEventListener('DOMContentLoaded', function () {
		let totalKeseluruhan = 0;
		const totalElements = document.querySelectorAll('.totaldb-produk');

		totalElements.forEach(function (element) {
			const total = parseFloat(element.textContent.replace(/[^0-9.-]+/g, '')) || 0;
			totalKeseluruhan += total;
		});

		document.getElementById('total-keseluruhan').textContent = 'Rp. ' + totalKeseluruhan.toLocaleString('id-ID');
	});
</script>

</body>
</html>
