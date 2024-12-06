<?php
require_once '../db_connection.php';

class Invoices
{
  private $conn;

  public function __construct()
  {
    $database = new Database();
    $this->conn = $database->connect();
  }

  // Create Invoice
  public function create($data, $id_products)
  {
    $sql = "INSERT INTO invoices 
                (  tanggal_invoice, subtotal, ongkir, discount, total, notes, status, uang_muka,id_customers) 
                VALUES 
                ( :tanggal_invoice, :subtotal, :ongkir, :discount, :total, :notes, :status, :uang_muka,:id_customers)";

    $stmt = $this->conn->prepare($sql);
    $response = $stmt->execute($data);
//    print_r($response);
    if ($response) {
      foreach ($id_products as $id_product) {
        $stmt = $this->conn->prepare("INSERT INTO invoice_product (id_invoice, id_product) VALUES (:id_invoice, :id_product)");
        $stmt->execute([
          'id_invoice' => $this->conn->lastInsertId(),
          'id_product' => $id_product
        ]);
      }
    }

  }

  // Read All Invoices
  public function readAll()
  {
    $sql = "SELECT * FROM invoices ORDER BY tanggal_invoice DESC";
    $stmt = $this->conn->query($sql);
    return $stmt->fetchAll();
  }

  // Read Single Invoice
  public function readSingle($id)
  {
    $sql = "SELECT * FROM invoices WHERE id = :id";
    $stmt = $this->conn->prepare($sql);
    $stmt->execute(['id' => $id]);
    return $stmt->fetch();
  }

  // Update Invoice
  public function update($data)
  {
    $sql = "UPDATE invoices SET 
                invoice = :invoice, 
                tanggal_invoice = :tanggal_invoice, 
                subtotal = :subtotal, 
                ongkir = :ongkir, 
                discount = :discount, 
                total = :total, 
                notes = :notes, 
                status = :status,
                uang_muka = :uang_muka 
                WHERE id = :id";

    $stmt = $this->conn->prepare($sql);
    return $stmt->execute($data);
  }

  // Delete Invoice
  public function delete($id)
  {
    $sql = "DELETE FROM invoices WHERE id = :id";
    $stmt = $this->conn->prepare($sql);
    return $stmt->execute(['id' => $id]);
  }

  // Calculate Total
  public function calculateTotal($subtotal, $ongkir, $discount, $uang_muka)
  {
    return $subtotal + $ongkir - $discount - $uang_muka;
  }
}

?>