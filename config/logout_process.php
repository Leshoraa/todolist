<?php
// Memulai session
session_start();

// Menghancurkan semua session yang ada
session_destroy();

// Mengarahkan user kembali ke halaman utama setelah logout
echo "<script>
location.href='../index.php';
</script>";
?>
