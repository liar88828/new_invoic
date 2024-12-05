<?php
require_once 'invoices.php';

$invoiceObj = new Invoices();

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
  // Calculate total
  $subtotal = $_POST['subtotal'];
  $ongkir = $_POST['ongkir'];
  $discount = $_POST['discount'];
  $uang_muka = $_POST['uang_muka'];
  $total = $invoiceObj->calculateTotal($subtotal, $ongkir, $discount, $uang_muka);

  $data = [
    ':invoice' => $_POST['invoice'],
    ':tanggal_invoice' => $_POST['tanggal_invoice'],
    ':subtotal' => $subtotal,
    ':ongkir' => $ongkir,
    ':discount' => $discount,
    ':total' => $total,
    ':notes' => $_POST['notes'],
    ':status' => $_POST['status'],
    ':uang_muka' => $uang_muka
  ];

  if ($invoiceObj->create($data)) {
    header('Location: /invoice/index.php');
    exit();
  }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Buat Invoice Baru</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
<div class="container mt-5">
    <h2>Buat Invoice Baru</h2>
    <form method="POST">
        <div class="row">
            <div class="col-md-6 mb-3">
                <label class="form-label">Nomor Invoice</label>
                <input type="text" name="invoice" class="form-control" required/>
            </div>
            <div class="col-md-6 mb-3">
                <label class="form-label">Tanggal Invoice</label>
                <input type="date" name="tanggal_invoice" class="form-control" required/>
            </div>
        </div>
        <div class="row">
            <div class="col-md-4 mb-3">
                <label class="form-label">Subtotal</label>
                <input type="number" name="subtotal" class="form-control" required>
            </div>
            <div class="col-md-4 mb-3">
                <label class="form-label">Ongkos Kirim</label>
                <input type="number" name="ongkir" class="form-control" required>
            </div>
            <div class="col-md-4 mb-3">
                <label class="form-label">Diskon</label>
                <input type="number" name="discount" class="form-control" required>
            </div>
        </div>
        <div class="row">
            <div class="col-md-6 mb-3">
                <label class="form-label">Uang Muka</label>
                <input type="number" name="uang_muka" class="form-control" required>
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
                            <tr>
                                <td>1</td>
                                <td>nama prodak</td>
                                <td>2</td>
                                <td>Rp.200.00</td>
                                <td>
                                    <button
                                            type="button"
                                            class="btn btn-danger btn-sm" onclick="">Tambah
                                    </button>
                                </td>
                            </tr>
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


        <!--         modal Customers -->
        <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#customersModal">
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
                            <tr>
                                <td>32</td>
                                <td>#234243</td>
                                <td>jone doe</td>
                                <td>semarang</td>
                                <td>
                                    <button class="btn btn-danger btn-sm" onclick="">Tambah</button>
                                </td>
                            </tr>
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


        <button type="submit" class="btn btn-primary">Simpan Invoice</button>
        <a href="invoices.php" class="btn btn-secondary">Batal</a>
    </form>
</div>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>