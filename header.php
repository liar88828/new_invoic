<?php
session_start();

// Get the current script path
$currentPath = $_SERVER['PHP_SELF']; // e.g., "/customer/index.php"


//index_r("is : $currentPath")
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Manajemen Invoice</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet"
          integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
</head>
<body class="d-flex">
<div class="d-flex flex-column flex-shrink-0 p-3 bg-light  " style="width: 280px; min-height: 100vh;">
    <div class="d-flex flex-row">
        <a href="/" class="d-flex align-items-center mb-3 mb-md-0 me-md-auto link-dark text-decoration-none">
            <span class="fs-4">Pt.Mas Isom</span>
        </a>
        <div class="">

          <?php if (isset($_SESSION['user_id'])): ?>
              <a href="../auth/logout.php" class="btn btn-danger btn-sm">Logout</a>
          <?php endif; ?>
        </div>
    </div>
    <hr>
    <ul class="nav nav-pills flex-column mb-auto">
        <li class="nav-item">
            <a href="/" class="nav-link <?php echo $currentPath == '/home/index.php' ? 'active' : 'link-dark'; ?>"
               aria-current="page">
                <svg class="bi me-2" width="16" height="16">
                    <use xlink:href="#home"></use>
                </svg>
                Home
            </a>
        </li>

        <li>
            <a href="/customer/index.php"
               class="nav-link <?php echo $currentPath == '/customer/index.php' ? 'active' : 'link-dark'; ?>">
                <svg class="bi me-2" width="16" height="16">
                    <use xlink:href="#speedometer2"></use>
                </svg>
                Pelanggan
            </a>
        </li>

        <li>
            <a href="/produk/index.php"
               class="nav-link <?php echo $currentPath == '/produk/index.php' ? 'active' : 'link-dark'; ?>">
                <svg class="bi me-2" width="16" height="16">
                    <use xlink:href="#table"></use>
                </svg>
                Produk
            </a>
        </li>

        <li>
            <a href="/invoice/index.php"
               class="nav-link <?php echo $currentPath == '/invoice/index.php' ? 'active' : 'link-dark'; ?>">
                <svg class="bi me-2" width="16" height="16">
                    <use xlink:href="#people-circle"></use>
                </svg>
                Invoice
            </a>
        </li>
    </ul>


    <!--    here -->
</div>
