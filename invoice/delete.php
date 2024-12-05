<?php
require_once 'invoices.php';

if (isset($_GET['id'])) {
  $invoiceObj = new Invoices();

  if ($invoiceObj->delete($_GET['id'])) {
    header('Location: /invoice/index.php');
    exit();
  } else {
    echo "Gagal menghapus invoice.";
  }
} else {
  header('Location: /invoice/index.php');
  exit();
}
?>