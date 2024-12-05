<?php
require_once 'customers.php';

if (isset($_GET['id'])) {
  $customerObj = new Customers();

  if ($customerObj->delete($_GET['id'])) {
    header('Location: index.php');
    exit();
  } else {
    echo "Gagal menghapus pelanggan.";
  }
} else {
  header('Location: index.php');
  exit();
}
?>