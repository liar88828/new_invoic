<?php
// Konfigurasi koneksi database
require_once '../db_connection.php';
require_once '../utils/toRupiah.php';


$database = new Database();
$conn = $database->connect();


function countProduct()
{
  global $conn;
  $sql = "
 select count(products.id_produk) 
 from products;
";

  $stmt = $conn->query($sql);
  return $stmt->fetchColumn();
}

function countInvoice()
{
  global $conn;
  $sql = "
select count(invoices.id) 
from invoices;
";
  $stmt = $conn->query($sql);
  return $stmt->fetchColumn();
}
function countPendapatan()
{
  global $conn;
  $sql = "
SELECT SUM(total) AS total_lunas
FROM invoices
WHERE status = 'Lunas';
";
  $stmt = $conn->query($sql);
  $result = $stmt->fetch(PDO::FETCH_ASSOC);
  return $result['total_lunas'] ?? 0;
}

function countCustomers()
{
  global $conn;
  $sql = "
select count(customers.id)
from customers;

";

  $stmt = $conn->query($sql);
  return $stmt->fetchColumn();
}

$products = countProduct();
$invoice = countInvoice();
$customers = countCustomers();
$pendapatan = countPendapatan();


?>

<?php require_once '../header.php' ?>


<div class="container p-5">
    <div class="row mb-5 gap-5">
        <div class="col">
            <div class="card" style="width: 18rem;">
                <div class="card-body">
                    <h5 class="card-title">Total Pelanggan</h5>
                    <p class="card-text"><?= htmlspecialchars($customers) ?></p>
                </div>
            </div>
        </div>
        <div class="col">
            <div class="card" style="width: 18rem;">
                <div class="card-body">
                    <h5 class="card-title">Total Produk</h5>
                    <p class="card-text"><?= htmlspecialchars($products) ?></p>

                </div>
            </div>
        </div>
        <div class="col">
            <div class="card" style="width: 18rem;">
                <div class="card-body">
                    <h5 class="card-title">Total invoice</h5>
                    <p class="card-text"><?= htmlspecialchars($invoice) ?></p>

                </div>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col">
            <div class="card" style="width: 18rem;">
                <div class="card-body">
                    <h5 class="card-title">Total Pendapatan</h5>
                    <p class="card-text">
                      <?= toRupiah($pendapatan) ?>
                    </p>
                </div>
            </div>
        </div>
    </div>
</div>
<?php require_once '../footer.php' ?>


