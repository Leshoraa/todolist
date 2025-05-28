<?php
// Mengatur konfigurasi koneksi ke database
$host = 'localhost';
$user = 'root';
$pass = '';
$db = 'todolist_database';

// Membuat koneksi ke database
$koneksi = mysqli_connect($host, $user, $pass, $db);

// Mengecek apakah koneksi berhasil
if (!$koneksi) {
    // Jika koneksi gagal, menampilkan pesan error
    echo "error wak";
}
?>
