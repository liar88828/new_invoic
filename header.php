<?php
// Get the current script path
$currentPath = $_SERVER['PHP_SELF']; // e.g., "/customer/index.php"


//print_r("is : $currentPath")
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
    <a href="/" class="d-flex align-items-center mb-3 mb-md-0 me-md-auto link-dark text-decoration-none">
        <svg class="bi me-2" width="40" height="32">
            <use xlink:href="#bootstrap"></use>
        </svg>
        <span class="fs-4">Sidebar</span>
    </a>
    <hr>
    <ul class="nav nav-pills flex-column mb-auto">
        <li class="nav-item">
            <a href="/" class="nav-link <?php echo $currentPath == '/index.php' ? 'active' : 'link-dark'; ?>" aria-current="page">
                <svg class="bi me-2" width="16" height="16">
                    <use xlink:href="#home"></use>
                </svg>
                Home
            </a>
        </li>

        <li>
            <a href="/customer/index.php" class="nav-link <?php echo $currentPath == '/customer/index.php' ? 'active' : 'link-dark'; ?>">
                <svg class="bi me-2" width="16" height="16">
                    <use xlink:href="#speedometer2"></use>
                </svg>
                Pelanggan
            </a>
        </li>

        <li>
            <a href="/produk/index.php" class="nav-link <?php echo $currentPath == '/produk/index.php' ? 'active' : 'link-dark'; ?>">
                <svg class="bi me-2" width="16" height="16">
                    <use xlink:href="#table"></use>
                </svg>
                Produk
            </a>
        </li>

        <li>
            <a href="/invoice/index.php" class="nav-link <?php echo $currentPath == '/invoice/index.php' ? 'active' : 'link-dark'; ?>">
                <svg class="bi me-2" width="16" height="16">
                    <use xlink:href="#people-circle"></use>
                </svg>
                Invoice
            </a>
        </li>
    </ul>
    <!--    here -->
</div>
