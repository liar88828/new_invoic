<?php
require_once '../db_connection.php';

class Products
{
  private $conn;

  public function __construct()
  {
    $database = new Database();
    $this->conn = $database->connect();
  }

  // Create Product
  public function create($data)
  {
    $sql = "INSERT INTO products (nama_produk, keterangan_produk, harga_produk,jumlah_produk) 
                VALUES (:nama_produk, :keterangan_produk, :harga_produk,:jumlah_produk)";

    $stmt = $this->conn->prepare($sql);
    return $stmt->execute($data);
  }

  // Read All Products
  public function readAll()
  {
    $sql = "SELECT * FROM products";
    $stmt = $this->conn->query($sql);
    return $stmt->fetchAll();
  }

  public function readAllById($id)
  {
    $sql = "SELECT * FROM products as p
            JOIN   invoice_product as ip  on p.id_produk = ip.id_product
            WHERE  ip.id_invoice =:id_invoice
            ";
    $stmt = $this->conn->prepare($sql);
    $stmt->execute(['id_invoice' => $id]);
    return $stmt->fetchAll();
  }


  // Read Single Product
  public function readSingle($id)
  {
    $sql = "SELECT * FROM products WHERE id_produk = :id";
    $stmt = $this->conn->prepare($sql);
    $stmt->execute(['id' => $id]);
    return $stmt->fetch();
  }

  // Update Product
  public function update($data)
  {
    $sql = "UPDATE products SET 
                nama_produk = :nama_produk, 
                keterangan_produk = :keterangan_produk, 
                harga_produk = :harga_produk 
                WHERE id_produk = :id_produk";

    $stmt = $this->conn->prepare($sql);
    return $stmt->execute($data);
  }

  // Delete Product
  public function delete($id)
  {
    $sql = "DELETE FROM products WHERE id_produk = :id";
    $stmt = $this->conn->prepare($sql);
    return $stmt->execute(['id' => $id]);
  }
}

?>