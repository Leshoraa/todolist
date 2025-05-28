<?php
session_start();
if (isset($_SESSION['status']) && $_SESSION['status'] == 'login') {
    header("Location: index.php");
    exit();
}
?>
<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>To-Do-List</title>
    <!-- Link ke file CSS Bootstrap -->
    <link rel="stylesheet" type="text/css" href="assets/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    <script>
        function validateForm() {
            var password = document.getElementById('password').value;
            if (password.length < 8) {
                alert('Password must be at least 8 characters long.');
                return false;
            }
            return true;
        }
    </script>
</head>

<body>
    <!-- Navigasi -->
    <nav class="navbar navbar-expand-lg mt-3">
        <div class="container">
            <a class="navbar-brand" href="index.php">
                <h4>Sign Up To-Do-List</h4>
            </a>
        </div>
    </nav>
    
    <!-- Kontainer utama -->
    <div class="container py-5">
        <div class="row justify-content-center">
            <div class="col-md-4">
                <div class="card">
                    <div class="card-body bg-light">
                        <div class="text-center">
                            <h5>Sign Up To-Do-List</h5>
                        </div>
                        <!-- Form registrasi -->
                        <form action="config/register_process.php" method="POST">
                            <label class="form-label">Username</label>
                            <input type="text" name="username" class="form-control" required>
                            <label class="form-label">Password</label>
                            <input type="password" name="password" class="form-control" required>
                            <label class="form-label">Email</label>
                            <input type="email" name="email" class="form-control" required>
                            <label class="form-label">Full Name</label>
                            <input type="text" name="namalengkap" class="form-control" required>
                            <label class="form-label">Address</label>
                            <input type="text" name="alamat" class="form-control" required>
                            <div class="d-grid mt-2">
                                <button class="btn btn-primary" type="submit" name="kirim">Sign Up</button>
                            </div>
                        </form>
                        <hr>
                        <p>Already have an account? <a href="login.php">Sign in here!</a></p>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Script Bootstrap -->
    <script type="text/javascript" src="assets/js/bootstrap.min.js"></script>
</body>

</html>