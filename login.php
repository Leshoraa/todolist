<?php
session_start();
if (isset($_SESSION['status']) && $_SESSION['status'] == 'login') {
    header("Location: index.php");
    exit();
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sign In To-Do-List</title>
    <!-- Link ke file CSS Bootstrap -->
    <link rel="stylesheet" type="text/css" href="assets/css/bootstrap.min.css">
</head>

<body>
    <!-- Navigasi -->
    <nav class="navbar navbar-expand-lg mt-3">
        <div class="container">
            <a class="navbar-brand" href="index.php">
                <h4>Sign In To-Do-List</h4>
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
                            <h5>Login To-Do-List</h5>
                        </div>
                        <!-- Form login -->
                        <form action="config/login_process.php" method="POST">
                            <label class="form-label">Username</label>
                            <input type="text" name="username" class="form-control" required>
                            <label class="form-label">Password</label>
                            <input type="password" name="password" class="form-control" required>
                            <div class="d-grid mt-2">
                                <button class="btn btn-primary" type="submit" name="kirim">Sign In</button>
                            </div>
                        </form>
                        <hr>
                        <p>Don't have an account? <a href='register.php'>Sign up here!</a></p>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Script Bootstrap -->
    <script type="text/javascript" src="assets/js/bootstrap.min.js"></script>
</body>

</html>