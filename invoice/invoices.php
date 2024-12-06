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
    try {
      $this->conn->beginTransaction(); // Mulai transaksi
      $sql = "INSERT INTO invoices 
                (  tanggal_invoice,  ongkir, discount, total, notes, status, uang_muka,id_customers) 
                VALUES 
                ( :tanggal_invoice, :ongkir, :discount, :total, :notes, :status, :uang_muka,:id_customers)";

      $stmt = $this->conn->prepare($sql);
      $response = $stmt->execute($data);
      if ($response) {
        foreach ($id_products as $id_product) {
          $stmt = $this->conn->prepare("INSERT INTO invoice_product (id_invoice, id_product) VALUES (:id_invoice, :id_product)");
          $stmt->execute([
            'id_invoice' => $this->conn->lastInsertId(),
            'id_product' => $id_product
          ]);
        }

        $this->conn->commit(); // Komit transaksi jika semua berhasil
        return true;
      }
      return false;
    } catch (e) {
      $this->conn->rollBack(); // Batalkan transaksi jika terjadi kesalahan
      throw $e;
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
  public function update($id, $data, $new_products)
  {
    $this->conn->beginTransaction();

    try {
      // Update data invoice utama
      $sql = "UPDATE invoices SET 
                tanggal_invoice = :tanggal_invoice, 
                ongkir = :ongkir, 
                discount = :discount, 
                total = :total, 
                notes = :notes, 
                status = :status, 
                uang_muka = :uang_muka,
                id_customers = :id_customers
                WHERE id = :id";

      $stmt = $this->conn->prepare($sql);

//      print_r(array_merge($data, ['id' => $id]));
      $response_invoice = $stmt->execute(array_merge($data, ['id' => $id]));

      if ($response_invoice) {
        // Hapus produk yang sudah ada pada invoice
        $sql = "DELETE FROM invoice_product WHERE id_invoice = :id";
        $stmt = $this->conn->prepare($sql);
        $response_deleteProduct = $stmt->execute(['id' => $id]);
//        print_r($response_deleteProduct);
        print_r($new_products);

        if ($response_deleteProduct) {
          // Tambahkan produk baru ke invoice
          foreach ($new_products as $id_product) {
            $sql = "INSERT INTO invoice_product (id_invoice, id_product) 
                    VALUES (:id_invoice, :id_product)";
            $stmt = $this->conn->prepare($sql);
            $stmt->execute([
              'id_invoice' => $id,
              'id_product' => $id_product
            ]);
          }
          $this->conn->commit();
          return true;
        }
      }

    } catch (PDOException $e) {
      $this->conn->rollBack();
      throw $e;
    }
  }


  public function delete($id)
  {
    $this->conn->beginTransaction();

    try {
      $sql = "DELETE FROM invoice_product WHERE id_invoice = :id";
      $stmt = $this->conn->prepare($sql);
      $stmt->execute(['id' => $id]);

      $sql = "DELETE FROM invoices WHERE id = :id";
      $stmt = $this->conn->prepare($sql);
      $stmt->execute(['id' => $id]);

      $this->conn->commit();
    } catch (PDOException $e) {
      $this->conn->rollBack();
      throw $e;
    }
  }


  function findPrint($id)
  {
    $invoice = $this->findInvoice($id);
    return [
      'invoice' => $invoice,
      'products' => $this->findProduct($invoice['id_invoice'])
    ];
  }

  function findInvoice($id)
  {
    $sql = "
    SELECT 
        c.nama AS nama_customer,
        c.alamat AS alamat_customer,
        c.kota AS kota_customer,
        c.postcode AS postcode_customer,
        c.tlp AS telepon_customer,
        c.nama_penerima,
        c.alamat_penerima,
        c.postcode_penerima,
        i.id as id_invoice,
        i.tanggal_invoice,
        i.total,
        i.ongkir,
        i.discount,
        i.total,
        i.notes,
        i.status,
        i.uang_muka
    FROM invoices i
         JOIN customers as c ON i.id_customers = c.id
    WHERE i.id = :id
";
    $stmt = $this->conn->prepare($sql);
    $stmt->execute(['id' => $id]);
    return $stmt->fetch();

  }


  function findProduct($id_invoice)
  {
    $sql = "SELECT * FROM products as p
         JOIN invoice_product ip on p.id_produk = ip.id_product
         where ip.id_invoice = :id_invoice";
    $stmt = $this->conn->prepare($sql);
    $stmt->execute(['id_invoice' => $id_invoice]);
    return $stmt->fetchAll();
  }


}

?>