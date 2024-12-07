<?php
require_once '../db_connection.php';

class Customers
{
  private $conn;

  public function __construct()
  {
    $database = new Database();
    $this->conn = $database->connect();
  }

  // Create Customer
  public function create($data)
  {
    $sql = "INSERT INTO customers 
                (  nama, alamat, kota, postcode, tlp, nama_penerima, alamat_penerima, postcode_penerima) 
                VALUES 
                (  :nama, :alamat, :kota, :postcode, :tlp, :nama_penerima, :alamat_penerima, :postcode_penerima)";

    $stmt = $this->conn->prepare($sql);
    return $stmt->execute($data);
  }

  // Read All Customers
  public function readAll()
  {
    $sql = "SELECT * FROM customers";
    $stmt = $this->conn->query($sql);
    return $stmt->fetchAll();
  }

  public function readAllById($id)
  {
    $sql = "SELECT * FROM customers WHERE id = :id";
    $stmt = $this->conn->prepare($sql);
    $stmt->execute(['id' => $id]);
    return $stmt->fetchAll();
  }


  // Read Single Customer
  public function readSingle($id)
  {
    $sql = "SELECT * FROM customers WHERE id = :id";
    $stmt = $this->conn->prepare($sql);
    $stmt->execute(['id' => $id]);
    return $stmt->fetch();
  }

  // Update Customer
  public function update($data)
  {
    $sql = "UPDATE customers SET 
                nama = :nama, 
                alamat = :alamat, 
                kota = :kota, 
                postcode = :postcode, 
                tlp = :tlp, 
                nama_penerima = :nama_penerima, 
                alamat_penerima = :alamat_penerima, 
                postcode_penerima = :postcode_penerima 
                WHERE id = :id";

    $stmt = $this->conn->prepare($sql);
    return $stmt->execute($data);
  }

  // Delete Customer
  public function delete($id)
  {
    $sql = "DELETE FROM customers WHERE id = :id";
    $stmt = $this->conn->prepare($sql);
    return $stmt->execute(['id' => $id]);
  }
}

?>