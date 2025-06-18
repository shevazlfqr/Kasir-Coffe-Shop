<?php
// index.php (Dashboard & Transaksi)
session_start();
if (!isset($_SESSION['kasir'])) {
    header('Location: login.php');
    exit;
}
include 'config/db.php';

// Proses tambah ke keranjang (session)
if (!isset($_SESSION['cart'])) $_SESSION['cart'] = [];
if (isset($_POST['tambah'])) {
    $produk_id = $_POST['produk_id'];
    $jumlah = $_POST['jumlah'];
    if (isset($_SESSION['cart'][$produk_id])) {
        $_SESSION['cart'][$produk_id] += $jumlah;
    } else {
        $_SESSION['cart'][$produk_id] = $jumlah;
    }
    $_SESSION['notif'] = 'Produk berhasil ditambahkan ke keranjang!';
}
// Hapus item dari keranjang
if (isset($_GET['hapus'])) {
    $id = $_GET['hapus'];
    if (isset($_SESSION['cart'][$id])) {
        unset($_SESSION['cart'][$id]);
        $_SESSION['notif'] = 'Produk dihapus dari keranjang!';
    }
}
// Simpan nama pelanggan ke session jika diisi
if (isset($_POST['nama_pelanggan'])) {
    $_SESSION['nama_pelanggan'] = $_POST['nama_pelanggan'];
}
// Proses simpan transaksi
if (isset($_POST['bayar']) && count($_SESSION['cart']) > 0) {
    $kasir = $_SESSION['kasir'];
    $tanggal = date('Y-m-d H:i:s');
    $total_harga = 0;
    $nama_pelanggan = isset($_SESSION['nama_pelanggan']) ? mysqli_real_escape_string($conn, $_SESSION['nama_pelanggan']) : '';
    foreach ($_SESSION['cart'] as $id => $jumlah) {
        $q = mysqli_query($conn, "SELECT * FROM produk WHERE id='$id'");
        $p = mysqli_fetch_assoc($q);
        $subtotal = $p['harga'] * $jumlah;
        $total_harga += $subtotal;
    }
    $insert = mysqli_query($conn, "INSERT INTO transaksi (tanggal, kasir, nama_pelanggan, total) VALUES ('$tanggal', '$kasir', '$nama_pelanggan', '$total_harga')");
    if ($insert) {
        $transaksi_id = mysqli_insert_id($conn);
        foreach ($_SESSION['cart'] as $id => $jumlah) {
            $q = mysqli_query($conn, "SELECT * FROM produk WHERE id='$id'");
            $p = mysqli_fetch_assoc($q);
            $subtotal = $p['harga'] * $jumlah;
            mysqli_query($conn, "INSERT INTO transaksi_detail (transaksi_id, produk_id, jumlah, harga) VALUES ('$transaksi_id', '$id', '$jumlah', '{$p['harga']}')");
        }
        $_SESSION['cart'] = [];
        unset($_SESSION['nama_pelanggan']);
        $_SESSION['notif'] = 'Transaksi berhasil disimpan!';
    }
}
?>
<!DOCTYPE html>
<html>
<head>
    <title>Dashboard | Drippin'</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="assets/style.css">
</head>
<body class="page-fade">
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
        <!-- Dashboard ringkasan transaksi harian -->
    <?php
    $tgl_hari_ini = date('Y-m-d');
    $q_harian = mysqli_query($conn, "SELECT COUNT(*) as total_transaksi, COALESCE(SUM(total),0) as total_penghasilan FROM transaksi WHERE DATE(tanggal) = '$tgl_hari_ini'");
    $harian = mysqli_fetch_assoc($q_harian);
    ?>
    <div class="row mb-4">
        <div class="col-md-6">
            <div class="card text-white bg-primary mb-3">
                <div class="card-body">
                    <h5 class="card-title">Total Transaksi Hari Ini</h5>
                    <p class="card-text" style="font-size:2rem; font-weight:bold;"><?= $harian['total_transaksi'] ?></p>
                </div>
            </div>
        </div>
        <div class="col-md-6">
            <div class="card text-white bg-success mb-3">
                <div class="card-body">
                    <h5 class="card-title">Penghasilan Hari Ini</h5>
                    <p class="card-text" style="font-size:2rem; font-weight:bold;">Rp <?= number_format($harian['total_penghasilan']) ?></p>
                </div>
            </div>
        </div>
    </div>
    <div class="card shadow mb-4">
        <div class="card-body">
            <h2 class="mb-4">Transaksi Penjualan</h2>
            <form method="post" class="mb-4">
    <div class="row g-2 align-items-center">
        <div class="col-md-4">
            <label class="form-label">Nama Pelanggan:</label>
            <input type="text" name="nama_pelanggan" class="form-control" placeholder="Opsional, isi jika ada" value="<?= isset($_SESSION['nama_pelanggan']) ? htmlspecialchars($_SESSION['nama_pelanggan']) : '' ?>">
        </div>
        <div class="col-md-4">
            <label class="form-label">Pilih Produk:</label>
            <select name="produk_id" class="form-select form-control" required>
                <option value="">-- Pilih Produk --</option>
                <?php
                $q = mysqli_query($conn, "SELECT * FROM produk ORDER BY nama_produk");
                while ($row = mysqli_fetch_assoc($q)) {
                    echo "<option value='{$row['id']}'>{$row['nama_produk']} (Rp ".number_format($row['harga']).")</option>";
                }
                ?>
            </select>
        </div>
        <div class="col-md-3">
            <label class="form-label">Jumlah:</label>
            <input type="number" name="jumlah" min="1" value="1" class="form-control" required>
        </div>
        <div class="col-md-12 mt-2">
            <button class="btn btn-primary px-4" type="submit" name="tambah">Tambah</button>
        </div>
    </div>
</form>
            <h3 class="mt-4">Keranjang</h3>
            <div class="table-responsive">
                <table class="table table-bordered align-middle">
                    <tr><th>Produk</th><th>Harga</th><th>Jumlah</th><th>Subtotal</th><th>Aksi</th></tr>
                    <?php
                    $total = 0;
                    if (isset($_SESSION['cart']) && count($_SESSION['cart']) > 0) {
                        foreach ($_SESSION['cart'] as $id => $jml) {
                            $q = mysqli_query($conn, "SELECT * FROM produk WHERE id='$id'");
                            $p = mysqli_fetch_assoc($q);
                            $sub = $p['harga'] * $jml;
                            $total += $sub;
                            echo "<tr>
                                <td>{$p['nama_produk']}</td>
                                <td>Rp ".number_format($p['harga'])."</td>
                                <td>$jml</td>
                                <td>Rp ".number_format($sub)."</td>
                                <td><a class='btn btn-danger btn-sm' href='?hapus=$id'>Hapus</a></td>
                            </tr>";
                        }
                        echo "<tr><th colspan='3'>Total</th><th colspan='2'>Rp ".number_format($total)."</th></tr>";
                    } else {
                        echo "<tr><td colspan='5' class='text-center'>Keranjang kosong</td></tr>";
                    }
                    ?>
                </table>
            </div>
            <form method="post">
                <button class="btn btn-success" type="submit" name="bayar" onclick="return confirm('Simpan transaksi?')" <?php if (!isset($_SESSION['cart']) || count($_SESSION['cart'])==0) echo 'disabled'; ?>>Bayar</button>
            </form>
        </div>
    </div>

    <!-- Modal Notifikasi -->
    <div class="modal fade" id="notifModal" tabindex="-1" aria-labelledby="notifModalLabel" aria-hidden="true">
      <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
          <div class="modal-header">
            <h5 class="modal-title" id="notifModalLabel">Notifikasi</h5>
            <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
              <span aria-hidden="true">&times;</span>
            </button>
          </div>
          <div class="modal-body" id="notifModalBody">
            <!-- Pesan notifikasi -->
          </div>
          <div class="modal-footer">
            <button type="button" class="btn btn-primary" data-bs-dismiss="modal">OK</button>
          </div>
        </div>
      </div>
    </div>
    <script>
      document.addEventListener('DOMContentLoaded', function() {
        <?php if (isset($_SESSION['notif'])): ?>
          var notifMsg = <?= json_encode($_SESSION['notif']); ?>;
          var modalBody = document.getElementById('notifModalBody');
          if (modalBody) modalBody.textContent = notifMsg;
          var notifModal = new bootstrap.Modal(document.getElementById('notifModal'));
          notifModal.show();
          <?php unset($_SESSION['notif']); ?>
        <?php endif; ?>
      });
    </script>
</div>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
