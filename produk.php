<?php
// produk.php (CRUD Produk)
session_start();
if (!isset($_SESSION['kasir'])) {
    header('Location: login.php');
    exit;
}
include 'config/db.php';
// Tambah produk
if (isset($_POST['tambah'])) {
    $nama = $_POST['nama_produk'];
    $harga = $_POST['harga'];
    $stok = $_POST['stok'];
    $kategori = $_POST['kategori'];
    mysqli_query($conn, "INSERT INTO produk (nama_produk, harga, stok, kategori) VALUES ('$nama', '$harga', '$stok', '$kategori')");
    $_SESSION['notif'] = 'Produk berhasil ditambahkan!';
}
// Edit produk
if (isset($_POST['edit'])) {
    $id = $_POST['id'];
    $nama = $_POST['nama_produk'];
    $harga = $_POST['harga'];
    $stok = $_POST['stok'];
    $kategori = $_POST['kategori'];
    mysqli_query($conn, "UPDATE produk SET nama_produk='$nama', harga='$harga', stok='$stok', kategori='$kategori' WHERE id='$id'");
    $_SESSION['notif'] = 'Produk berhasil diupdate!';
}
// Hapus produk
if (isset($_GET['hapus'])) {
    $id = $_GET['hapus'];
    mysqli_query($conn, "DELETE FROM produk WHERE id='$id'");
    $_SESSION['notif'] = 'Produk berhasil dihapus!';
}
// Ambil data produk untuk edit
$edit = null;
if (isset($_GET['edit'])) {
    $id = $_GET['edit'];
    $q = mysqli_query($conn, "SELECT * FROM produk WHERE id='$id'");
    $edit = mysqli_fetch_assoc($q);
}
?>
<!DOCTYPE html>
<html>
<head>
    <title>Produk | Drippin'</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="assets/style.css">
</head>
<body class="page-fade">
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
            <h2 class="mb-4">Manajemen Produk</h2>
            <?php if (isset($_SESSION['notif'])): ?>
                <div class="alert alert-success alert-dismissible fade show" role="alert">
                    <?= $_SESSION['notif']; unset($_SESSION['notif']); ?>
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            <?php endif; ?>
            <form method="post" class="mb-4">
                <div class="row g-2 align-items-center">
                    <input type="hidden" name="id" value="<?= $edit ? $edit['id'] : '' ?>">
                    <div class="col-md-4">
                        <label class="form-label">Nama Produk</label>
                        <input type="text" name="nama_produk" value="<?= $edit ? $edit['nama_produk'] : '' ?>" class="form-control" required>
                    </div>
                    <div class="col-md-2">
                        <label class="form-label">Harga</label>
                        <input type="number" name="harga" value="<?= $edit ? $edit['harga'] : '' ?>" class="form-control" required>
                    </div>
                    <div class="col-md-2">
                        <label class="form-label">Stok</label>
                        <input type="number" name="stok" value="<?= $edit ? $edit['stok'] : '' ?>" class="form-control" required>
                    </div>
                    <div class="col-md-2">
                        <label class="form-label">Kategori</label>
                        <input type="text" name="kategori" value="<?= $edit ? $edit['kategori'] : '' ?>" class="form-control" required>
                    </div>
                    <div class="col-md-12 mt-2">
                        <button class="btn btn-primary px-4" type="submit" name="<?= $edit ? 'edit' : 'tambah' ?>">
                            <?= $edit ? 'Update' : 'Tambah' ?>
                        </button>
                        <?php if ($edit) echo '<a class="btn btn-secondary ms-2" href="produk.php">Batal</a>'; ?>
                    </div>
                </div>
            </form>
            <h3 class="mt-4">Daftar Produk</h3>
            <div class="table-responsive">
                <table class="table table-bordered align-middle">
                    <tr><th>Nama</th><th>Harga</th><th>Stok</th><th>Kategori</th><th>Aksi</th></tr>
                    <?php
                    $q = mysqli_query($conn, "SELECT * FROM produk ORDER BY nama_produk");
                    while ($row = mysqli_fetch_assoc($q)) {
                        echo "<tr>
                            <td>{$row['nama_produk']}</td>
                            <td>Rp ".number_format($row['harga'])."</td>
                            <td>{$row['stok']}</td>
                            <td>{$row['kategori']}</td>
                            <td>
                                <a class='btn btn-warning btn-sm' href='?edit={$row['id']}'>Edit</a>
                                <a class='btn btn-danger btn-sm' href='?hapus={$row['id']}' onclick=\"return confirm('Hapus produk?')\">Hapus</a>
                            </td>
                        </tr>";
                    }
                    ?>
                </table>
            </div>
        </div>
    </div>
</div>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
