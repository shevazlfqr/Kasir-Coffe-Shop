<?php
// riwayat.php (Riwayat Transaksi)
session_start();
if (!isset($_SESSION['kasir'])) {
    header('Location: login.php');
    exit;
}
include 'config/db.php';
?>
<!DOCTYPE html>
<html>
<head>
    <title>Riwayat | Drippin'</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="assets/style.css">
</head>
<body class="page-fade bg-light">
<div class="container">
    <nav class="navbar navbar-expand-lg navbar-light bg-white shadow-sm rounded mb-4">
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
            <h2 class="mb-4">Riwayat Transaksi</h2>
            <?php if (isset($_SESSION['notif'])): ?>
                <div class="alert alert-success alert-dismissible fade show" role="alert">
                    <?= $_SESSION['notif']; unset($_SESSION['notif']); ?>
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            <?php endif; ?>
            <div class="table-responsive">
                <table class="table table-bordered align-middle">
                    <tr><th>Tanggal</th><th>Hari</th><th>Nama Pelanggan</th><th>Kasir</th><th>Total</th><th>Detail</th></tr>
                    <?php
                    $q = mysqli_query($conn, "SELECT * FROM transaksi ORDER BY tanggal DESC");
                    while ($row = mysqli_fetch_assoc($q)) {
                        $tanggal = $row['tanggal'];
                        $hari = date('l', strtotime($tanggal));
                        $nama_pelanggan = $row['nama_pelanggan'] ?: '-';
                        echo "<tr>
                            <td>".date('d-m-Y H:i', strtotime($tanggal))."</td>
                            <td>".$hari."</td>
                            <td>".$nama_pelanggan."</td>
                            <td>{$row['kasir']}</td>
                            <td>Rp ".number_format($row['total'])."</td>
                            <td><a class='btn btn-info btn-sm' href='?detail={$row['id']}'>Lihat</a></td>
                        </tr>";
                    }
                    ?>
                </table>
            </div>
            <?php
            if (isset($_GET['detail'])) {
                $id = $_GET['detail'];
                $qtrx = mysqli_query($conn, "SELECT * FROM transaksi WHERE id='$id'");
                $trx = mysqli_fetch_assoc($qtrx);
                echo "<h3 class='mt-4'>Detail Transaksi #$id</h3>";
                echo "<p><b>Nama Pelanggan:</b> ".($trx['nama_pelanggan'] ?: '-') . "<br><b>Kasir:</b> {$trx['kasir']}<br><b>Tanggal:</b> ".date('d-m-Y H:i', strtotime($trx['tanggal']))." (".date('l', strtotime($trx['tanggal'])).")</p>";
                echo "<div class='table-responsive'><table class='table table-bordered align-middle'><tr><th>Produk</th><th>Harga</th><th>Jumlah</th><th>Subtotal</th></tr>";
                $q = mysqli_query($conn, "SELECT td.*, p.nama_produk FROM transaksi_detail td JOIN produk p ON td.produk_id=p.id WHERE td.transaksi_id='$id'");
                while ($row = mysqli_fetch_assoc($q)) {
                    $sub = $row['harga'] * $row['jumlah'];
                    echo "<tr>
                        <td>{$row['nama_produk']}</td>
                        <td>Rp ".number_format($row['harga'])."</td>
                        <td>{$row['jumlah']}</td>
                        <td>Rp ".number_format($sub)."</td>
                    </tr>";
                }
                echo "</table></div>";
            }
            ?>
        </div>
    </div>
</div>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
