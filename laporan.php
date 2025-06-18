<?php
// laporan.php (Laporan Penjualan)
session_start();
if (!isset($_SESSION['kasir'])) {
    header('Location: login.php');
    exit;
}
include 'config/db.php';
$tgl = isset($_GET['tgl']) ? $_GET['tgl'] : date('Y-m-d');
?>
<!DOCTYPE html>
<html>
<head>
    <title>Laporan | Drippin'</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="assets/style.css">
</head>
<body class="page-fade bg-light">
<div class="container">
    <nav class="navbar navbar-expand-lg navbar-light shadow-sm rounded mb-4">
        <div class="container-fluid">
            <a class="navbar-brand fw-bold" href="#">Drippin'</a>
            <div>
                <a href="index.php" class="btn btn-link">Transaksi</a>
                <a href="produk.php" class="btn btn-link">Produk</a>
                <a href="riwayat.php" class="btn btn-link">Riwayat</a>
                <a href="laporan.php" class="btn btn-link">Laporan</a>
                <a href="logout.php" class="btn btn-danger ms-2">Logout</a>
            </div>
        </div>
    </nav>
    <div class="card shadow mb-4">
        <div class="card-body">
            <h2 class="mb-4">Laporan Penjualan</h2>
            <?php if (isset($_SESSION['notif'])): ?>
                <div class="alert alert-success alert-dismissible fade show" role="alert">
                    <?= $_SESSION['notif']; unset($_SESSION['notif']); ?>
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            <?php endif; ?>
            <form method="get" class="mb-4">
                <div class="row g-2 align-items-center">
                    <div class="col-md-4">
                        <label for="tgl" class="form-label mb-1">Tanggal</label>
                        <input type="date" id="tgl" name="tgl" value="<?= $tgl ?>" class="form-control">
                    </div>
                    <div class="col-md-12 mt-2">
                        <button class="btn btn-primary px-4" type="submit">Tampilkan</button>
                    </div>
                </div>
            </form>
            <div class="table-responsive">
                <table class="table table-bordered align-middle">
                    <tr><th>Tanggal</th><th>Kasir</th><th>Total</th></tr>
                    <?php
                    $q = mysqli_query($conn, "SELECT * FROM transaksi WHERE DATE(tanggal)='$tgl' ORDER BY tanggal DESC");
                    $grand = 0;
                    while ($row = mysqli_fetch_assoc($q)) {
                        $grand += $row['total'];
                        echo "<tr>
                            <td>{$row['tanggal']}</td>
                            <td>{$row['kasir']}</td>
                            <td>Rp ".number_format($row['total'])."</td>
                        </tr>";
                    }
                    echo "<tr><th colspan='2'>Total Penjualan</th><th>Rp ".number_format($grand)."</th></tr>";
                    ?>
                </table>
            </div>
        </div>
    </div>
</div>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
