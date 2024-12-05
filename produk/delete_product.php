<?php
require_once 'products.php';

if (isset($_GET['id'])) {
  $productObj = new Products();

  if ($productObj->delete($_GET['id'])) {
    header('Location: /produk/index.php');
    exit();
  } else {
    echo "Gagal menghapus produk.";
  }
} else {
  header('Location: /produk/index.php');
  exit();
}
?>