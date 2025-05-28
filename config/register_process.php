<?php
// Menghubungkan ke file koneksi database
include 'connect.php';

// Mengambil input dari form registrasi
$username = $_POST['username'];
$password = md5($_POST['password']); 
$email = $_POST['email'];
$namalengkap = $_POST['namalengkap'];
$alamat = $_POST['alamat'];

// Cek apakah username sudah ada di database
$check_username = mysqli_query($koneksi, "SELECT username FROM user WHERE username = '$username'");
if(mysqli_num_rows($check_username) > 0) {
    // Username sudah ada, tampilkan peringatan
    echo "<script>
        alert('Username sudah digunakan! Silakan pilih username lain.');
        window.location.href='../register.php';
    </script>";
    exit();
}

// Jika username belum ada, lanjutkan proses registrasi
$sql = mysqli_query($koneksi, "INSERT INTO user (username, password, email, namalengkap, alamat) VALUES ('$username', '$password', '$email', '$namalengkap', '$alamat')");

// Mengecek apakah query berhasil
if ($sql) {
    // Jika berhasil, mengarahkan user ke halaman login
    echo "<script>
        location.href='../login.php';
    </script>";
} else {
    // Jika gagal, mengarahkan kembali ke halaman registrasi dengan status gagal
    echo "<script>
        alert('Registrasi gagal! Silakan coba lagi.');
        window.location.href='../register.php';
    </script>";
}
?>