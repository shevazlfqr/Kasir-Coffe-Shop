<?php
// log.php
function log_aktivitas($conn, $username, $aksi, $keterangan = null) {
    $aksi = mysqli_real_escape_string($conn, $aksi);
    $keterangan = $keterangan ? mysqli_real_escape_string($conn, $keterangan) : '';
    $username = mysqli_real_escape_string($conn, $username);
    mysqli_query($conn, "INSERT INTO log_aktivitas (waktu, username, aksi, keterangan) VALUES (NOW(), '$username', '$aksi', '$keterangan')");
}
?>
