<?php
// Memulai session
session_start();

// Menghubungkan ke file koneksi database
include 'connect.php';

// Mengambil input username dan password dari form login
$username = $_POST['username'];
$password = md5($_POST['password']); // Mengenkripsi password menggunakan fungsi md5

// Menjalankan query untuk mengecek apakah username dan password ada dalam database
$sql = mysqli_query($koneksi, "SELECT * FROM user WHERE username='$username' AND password='$password'");
// Menghitung jumlah baris hasil query
$cek = mysqli_num_rows($sql);

// Mengecek apakah username dan password cocok
if ($cek > 0) {
    // Mengambil data user dari database
    $data = mysqli_fetch_array($sql);
    // Menyimpan data user ke dalam session
    $_SESSION['username'] = $data['username'];
    $_SESSION['userid'] = $data['userid'];
    $_SESSION['status'] = 'login';

    // Mengarahkan user ke halaman utama
    echo "<script>
            location.href='../index.php';
        </script>";
} else {
    // Jika username dan password tidak cocok, menampilkan pesan kesalahan dan mengarahkan kembali ke halaman login
    echo "<script>
            alert('Username atau Password salah');
            location.href='../login.php';
        </script>";
}
?>
