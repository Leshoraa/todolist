<?php
session_start();
$userid = $_SESSION['userid'];
include 'config/connect.php';

date_default_timezone_set('Asia/Jakarta'); // Set the default timezone to your local timezone

/**
 * Mengatur ucapan salam sesuai dengan waktu saat ini.
 *
 * @return string Ucapan salam yang sesuai dengan waktu.
 */
$hour = date('H');
if ($hour >= 5 && $hour < 12) {
    $greeting = "Good Morning ";
} elseif ($hour >= 12 && $hour < 15) {
    $greeting = "Good Afternoon ";
} elseif ($hour >= 15 && $hour < 18) {
    $greeting = "Good Evening ";
} else {
    $greeting = "Good Night ";
}

// Memastikan user telah login
if ($_SESSION['status'] != 'login') {
    echo "<script>
    location.href='login.php';
    </script>";
}

/**
 * Menambah task baru ke dalam database.
 */
if (isset($_POST['add_task'])) {
    $task = $_POST['task'];
    $priority = $_POST['priority'];
    $due_date = $_POST['due_date'];

    if (!empty($task) && !empty($priority) && !empty($due_date)) {
        mysqli_query($koneksi, "INSERT INTO tugas VALUES('', '$task', '$priority', '$due_date', '0', '$userid')");
        header("Location: index.php");
    } else {
        echo "<script>alert('Isi semua kolom!');</script>";
    }
}

/**
 * Menandai task sebagai selesai di dalam database.
 *
 * @param int $id ID dari task yang akan ditandai sebagai selesai.
 */
if (isset($_GET['complete'])) {
    $id = $_GET['complete'];
    mysqli_query($koneksi, "UPDATE tugas SET status=1 WHERE tugasid=$id");
    echo "<script>alert('Data berhasil diperbaharui!');</script>";
    header("Location: index.php");
}

/**
 * Menghapus task dari database.
 *
 * @param int $id ID dari task yang akan dihapus.
 */
if (isset($_GET['delete'])) {
    $id = $_GET['delete'];
    mysqli_query($koneksi, "DELETE FROM tugas WHERE tugasid=$id");
    echo "<script>alert('Data berhasil dihapus!');</script>";
    header("Location: index.php");
}

/**
 * Menghapus semua task yang dimiliki user dari database dengan status 0.
 */
if (isset($_GET['deleteallpending'])) {
    $id = $_SESSION['userid'];
    mysqli_query($koneksi, "DELETE FROM tugas WHERE userid=$id AND status=0");
    echo "<script>alert('Data berhasil dihapus!');</script>";
    header("Location: index.php");
}

/**
 * Menghapus semua task yang dimiliki user dari database dengan status 1.
 */
if (isset($_GET['deleteallcompleted'])) {
    $id = $_SESSION['userid'];
    mysqli_query($koneksi, "DELETE FROM tugas WHERE userid=$id AND status=1");
    echo "<script>alert('Data berhasil dihapus!');</script>";
    header("Location: index.php");
}

/**
 * Mengupdate task di dalam database.
 *
 * @param int $id ID dari task yang akan diupdate.
 * @param string $task Nama task yang baru.
 * @param string $priority Prioritas dari task yang baru.
 * @param string $due_date Tanggal jatuh tempo dari task yang baru.
 * @param int $status Status dari task yang baru (0 = belum selesai, 1 = selesai).
 */
if (isset($_POST['update'])) {
    $id = $_POST['tugasid'];
    $task = $_POST['task'];
    $priority = $_POST['priority'];
    $due_date = $_POST['due_date'];
    $status = $_POST['status'];
    mysqli_query($koneksi, "UPDATE tugas SET task='$task', priority='$priority', due_date='$due_date', status='$status' WHERE tugasid='$id'");
    echo "<script>alert('Data berhasil diupdate!');</script>";
    header("Location: index.php");
}

// Menampilkan task yang ada di database
$result_pending = mysqli_query($koneksi, "SELECT * FROM tugas WHERE userid='$userid' AND status=0 ORDER BY due_date DESC, priority DESC");
$result_completed = mysqli_query($koneksi, "SELECT * FROM tugas WHERE userid='$userid' AND status=1 ORDER BY due_date DESC, priority DESC");
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>To-Do-List</title>
    <link rel="stylesheet" type="text/css" href="assets/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    <style>
        .typing-animation {
            display: inline-block;
            border-right: 2px solid black;
            white-space: nowrap;
            overflow: hidden;
            animation: typing 3.2s steps(30, end), blink-caret .75s step-end infinite;
        }

        @keyframes typing {
            from {
                width: 0;
            }

            to {
                width: 100%;
            }
        }

        @keyframes blink-caret {

            from,
            to {
                border-color: transparent;
            }

            50% {
                border-color: black;
            }
        }

        .zoom-effect {
            transition: transform 0.3s ease-in-out;
        }

        .zoom-effect:hover {
            transform: scale(1.1);
        }
    </style>
</head>

<body>
    <nav class="navbar navbar-expand-lg bg-body-tertiary">
        <div class="container">
            <!-- Link ke halaman utama dengan efek zoom -->
            <a href="index.php" class="navbar-brand mt-1 mb-1 zoom-effect">
                <h5 class="mt-2 typing-animation">Hello, <?php echo $greeting;
                echo $_SESSION['username']; ?></h5>
            </a>
            <!-- Navbar collapse -->
            <div class="collapse navbar-collapse mt-1 mb-1" id="navbarNavAltMarkup">
                <div class="navbar-nav me-auto"></div>
                <!-- Tombol toggle untuk navbar saat tampilan mobile -->
                <button class="navbar-toggler zoom-effect" type="button" data-bs-toggle="collapse"
                    data-bs-target="#navbarNavAltMarkup" aria-controls="navbarNavAltMarkup" aria-expanded="false"
                    aria-label="Toggle navigation">
                    <span class="navbar-toggler-icon"></span>
                </button>
            </div>
            <!-- Tombol logout dengan animasi zoom -->
            <a href="#" class="btn btn-outline-danger mt-1 mb-1 zoom-effect" data-bs-toggle="modal"
                data-bs-target="#logoutModal">
                <i class="bi bi-door-closed"></i> Logout
            </a>
        </div>
    </nav>

    <div class="container mb-5 mt-4">
        <!-- Kartu untuk daftar ketugasanku -->
        <div class="card mt-2 mb-4 sticky-top" id="taskListCard">
            <div class="card-header d-flex justify-content-between align-items-center">
                <h6 class="mt-2">My To-Do List</h6>

                <!-- Tombol Hamburger untuk layar kecil -->
                <button class="btn btn-sm d-md-none" type="button" data-bs-toggle="collapse" data-bs-target="#taskMenu">
                    <i class="bi bi-list"></i>
                </button>

                <!-- Menu Navigasi untuk layar besar -->
                <div class="d-none d-md-flex">
                    <a href="#" class="nav-link btn-sm zoom-effect ms-2">
                        |
                    </a>
                    <a href="#" class="nav-link btn-sm zoom-effect ms-2" id="scrollToCompleted">
                        Completed <i class="bi bi-arrow-down"></i>
                    </a>
                </div>

                <!-- Navbar untuk layar besar -->
                <div class="navbar-nav ms-auto d-none d-md-flex flex-row">
                    <a href="#" class="nav-link btn-sm zoom-effect me-3" data-bs-toggle="modal"
                        data-bs-target="#addTaskModal">
                        <i class="bi bi-plus-circle"></i> Create Task
                    </a>
                    <a href="?deleteallpending" class="nav-link btn-sm zoom-effect me-3" data-bs-toggle="modal"
                        data-bs-target="#confirmModalpending">
                        <i class="bi bi-trash"></i> Delete All
                    </a>
                </div>
            </div>

            <!-- Menu Dropdown ketika layar kecil -->
            <div class="collapse d-md-none" id="taskMenu">
                <div class="card-body">
                    <a href="#" class="nav-link btn-sm zoom-effect ms-2" id="scrollToCompleted">
                        Completed <i class="bi bi-arrow-down"></i>
                    </a>
                    <hr>
                    <a href="#" class="nav-link btn-sm zoom-effect d-block mb-2" data-bs-toggle="modal"
                        data-bs-target="#addTaskModal">
                        <i class="bi bi-plus-circle"></i> Create Task
                    </a>
                    <a href="?deleteallpending" class="nav-link btn-sm zoom-effect d-block mb-2" data-bs-toggle="modal"
                        data-bs-target="#confirmModalpending">
                        <i class="bi bi-trash"></i> Delete All
                    </a>
                </div>
            </div>
        </div>


        <div class="card-body">
            <!-- Tampilkan tugas yang belum selesai -->
            <div class="row">
                <?php
                // Cek apakah ada tugas dalam hasil query
                if (mysqli_num_rows($result_pending) > 0) {
                    $no = 1;
                    // Loop melalui setiap tugas
                    while ($row = mysqli_fetch_assoc($result_pending)) { ?>
                        <div class="col-12 col-sm-6 col-md-4 col-lg-3 mb-3">
                            <div class="card h-100 zoom-effect clickable-card" data-bs-toggle="modal"
                                data-bs-target="#updateModal<?php echo $row['tugasid']; ?>">
                                <div class="card-header d-flex justify-content-between align-items-center">
                                    <span>Task #<?php echo $no++; ?></span>
                                    <i class="bi bi-pencil-square"></i>
                                </div>
                                <div class="card-body">
                                    <h5 class="card-title"><?php echo $row['task']; ?></h5>
                                    <p class="card-text">
                                        <strong>Priority: </strong>
                                        <span class="badge <?php
                                        if ($row['priority'] == 1) {
                                            echo 'bg-success';
                                        } else if ($row['priority'] == 2) {
                                            echo 'bg-warning';
                                        } else {
                                            echo 'bg-danger';
                                        }
                                        ?>">
                                            <?php
                                            if ($row['priority'] == 1) {
                                                echo "Low";
                                            } else if ($row['priority'] == 2) {
                                                echo "Medium";
                                            } else {
                                                echo "High";
                                            }
                                            ?>
                                        </span>
                                    </p>
                                    <p class="card-text"><strong>Date: </strong><?php echo $row['due_date']; ?></p>
                                    <p class="card-text"><strong>Status: </strong>
                                        <?php
                                        if ($row['status'] == 0) {
                                            echo "Incomplete";
                                        } else {
                                            echo "Completed";
                                        }
                                        ?>
                                    </p>
                                    <div class="d-flex">
                                        <?php if ($row['status'] == 0) { ?>
                                            <a href="?complete=<?php echo $row['tugasid']; ?>"
                                                class="btn btn-success me-2 zoom-effect">Completed</a>
                                        <?php } ?>
                                        <a href="?delete=<?php echo $row['tugasid']; ?>"
                                            class="btn btn-danger zoom-effect">Delete</a>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Update Modal -->
                        <div class="modal fade" id="updateModal<?php echo $row['tugasid']; ?>" tabindex="-1"
                            aria-labelledby="updateModalLabel<?php echo $row['tugasid']; ?>" aria-hidden="true">
                            <div class="modal-dialog">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h5 class="modal-title" id="updateModalLabel<?php echo $row['tugasid']; ?>">Update Task
                                        </h5>
                                        <button type="button" class="btn-close" data-bs-dismiss="modal"
                                            aria-label="Close"></button>
                                    </div>
                                    <div class="modal-body">
                                        <form action="" method="POST">
                                            <input type="hidden" name="tugasid" value="<?php echo $row['tugasid']; ?>">
                                            <div class="mb-3">
                                                <label for="task" class="form-label">Task Name:</label>
                                                <input type="text" class="form-control" id="task" name="task"
                                                    value="<?php echo $row['task']; ?>" required>
                                            </div>
                                            <div class="mb-3">
                                                <label for="priority" class="form-label">Priority</label>
                                                <select class="form-select" id="priority" name="priority" required>
                                                    <option value="1" <?php if ($row['priority'] == 1)
                                                        echo 'selected'; ?>>Low
                                                    </option>
                                                    <option value="2" <?php if ($row['priority'] == 2)
                                                        echo 'selected'; ?>>Medium
                                                    </option>
                                                    <option value="3" <?php if ($row['priority'] == 3)
                                                        echo 'selected'; ?>>High
                                                    </option>
                                                </select>
                                            </div>
                                            <div class="mb-3">
                                                <label for="due_date" class="form-label">Date</label>
                                                <input type="date" class="form-control" id="due_date" name="due_date"
                                                    value="<?php echo $row['due_date']; ?>" required>
                                            </div>
                                            <div class="mb-3">
                                                <label for="status" class="form-label">Status</label>
                                                <select class="form-select" id="status" name="status" required>
                                                    <option value="0" <?php if ($row['status'] == 0)
                                                        echo 'selected'; ?>>Incomplete
                                                    </option>
                                                    <option value="1" <?php if ($row['status'] == 1)
                                                        echo 'selected'; ?>>Completed
                                                    </option>
                                                </select>
                                            </div>
                                            <div class="d-flex">
                                                <button type="submit" name="update"
                                                    class="btn btn-primary me-2 zoom-effect">Update</button>
                                                <button type="button" class="btn btn-secondary zoom-effect"
                                                    data-bs-dismiss="modal">Cancel</button>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                <?php } ?>
            <?php } else {
                    echo "No data available";
                } ?>
        </div>

        <!-- Tugas Selesai -->
        <div class="card mt-2 mb-4 sticky-top" id="completedTasksCard">
            <div class="card-header d-flex justify-content-between align-items-center">
                <h6 class="mt-2">Completed Tasks</h6>

                <!-- Tombol Hamburger untuk layar kecil -->
                <button class="btn btn-sm d-md-none" type="button" data-bs-toggle="collapse" data-bs-target="#taskMenu">
                    <i class="bi bi-list"></i>
                </button>

                <!-- Menu Navigasi untuk layar besar -->
                <div class="d-none d-md-flex">
                    <a href="#" class="nav-link btn-sm zoom-effect ms-2">
                        |
                    </a>
                    <a href="#" class="nav-link btn-sm zoom-effect ms-2" id="scrollToTop">
                        Incomplete <i class="bi bi-arrow-up"></i>
                    </a>
                </div>

                <!-- Navbar untuk layar besar -->
                <div class="navbar-nav ms-auto d-none d-md-flex flex-row">
                    <a href="?deleteallpending" class="nav-link btn-sm zoom-effect me-3" data-bs-toggle="modal"
                        data-bs-target="#confirmModalcomplete">
                        <i class="bi bi-trash"></i> Delete All
                    </a>
            </div>
            </div>

            <!-- Menu Dropdown ketika layar kecil -->
            <div class="collapse d-md-none" id="taskMenu">
                <div class="card-body">
                    <a href="#" class="nav-link btn-sm zoom-effect d-block mb-2" id="scrollToTop">
                        Incomplete <i class="bi bi-arrow-up"></i>
                    </a>
                    <hr>
                    <a href="?deleteallpending" class="nav-link btn-sm zoom-effect d-block mb-2" data-bs-toggle="modal"
                        data-bs-target="#confirmModalcomplete">
                        <i class="bi bi-trash"></i> Delete All
                    </a>
                </div>
            </div>
        </div>

        <div class="row" id="completed-tasks">
            <?php
            if (mysqli_num_rows($result_completed) > 0) {
                while ($row = mysqli_fetch_assoc($result_completed)) { ?>
                    <div class="col-12 col-sm-6 col-md-4 col-lg-3 mb-3" id="task-<?php echo $row['tugasid']; ?>">
                        <!-- Isi kartu tugas yang sudah selesai -->
                        <div class="card h-100 zoom-effect clickable-card" data-bs-toggle="modal"
                            data-bs-target="#updateModal<?php echo $row['tugasid']; ?>">
                            <div class="card-header d-flex justify-content-between align-items-center">
                                <span>Completed Tasks</span>
                                <i class="bi bi-pencil-square"></i>
                            </div>
                            <div class="card-body">
                                <h5 class="card-title"><?php echo $row['task']; ?></h5>
                                <p class="card-text">
                                    <strong>Priority: </strong>
                                    <span class="badge <?php
                                    if ($row['priority'] == 1) {
                                        echo 'bg-success';
                                    } else if ($row['priority'] == 2) {
                                        echo 'bg-warning';
                                    } else {
                                        echo 'bg-danger';
                                    }
                                    ?>">
                                        <?php
                                        if ($row['priority'] == 1) {
                                            echo "Low";
                                        } else if ($row['priority'] == 2) {
                                            echo "Medium";
                                        } else {
                                            echo "High";
                                        }
                                        ?>
                                    </span>
                                </p>
                                <p class="card-text"><strong>Date: </strong><?php echo $row['due_date']; ?></p>
                                <p class="card-text"><strong>Status: </strong>
                                    <?php
                                    if ($row['status'] == 1) {
                                        echo "CompletedZ";
                                    } ?>
                                </p>
                                <div class="d-flex">
                                    <a href="?delete=<?php echo $row['tugasid']; ?>"
                                        class="btn btn-danger zoom-effect">Delete</a>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Update Modal -->
                    <div class="modal fade" id="updateModal<?php echo $row['tugasid']; ?>" tabindex="-1"
                        aria-labelledby="updateModalLabel<?php echo $row['tugasid']; ?>" aria-hidden="true">
                        <div class="modal-dialog">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title" id="updateModalLabel<?php echo $row['tugasid']; ?>">Update Tugas
                                    </h5>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                </div>
                                <div class="modal-body">
                                    <form action="" method="POST">
                                        <input type="hidden" name="tugasid" value="<?php echo $row['tugasid']; ?>">
                                        <div class="mb-3">
                                            <label for="task" class="form-label">Tugas</label>
                                            <input type="text" class="form-control" id="task" name="task"
                                                value="<?php echo $row['task']; ?>" required>
                                        </div>
                                        <div class="mb-3">
                                            <label for="priority" class="form-label">Priority</label>
                                            <select class="form-select" id="priority" name="priority" required>
                                                <option value="1" <?php if ($row['priority'] == 1)
                                                    echo 'selected'; ?>>Low
                                                </option>
                                                <option value="2" <?php if ($row['priority'] == 2)
                                                    echo 'selected'; ?>>Medium
                                                </option>
                                                <option value="3" <?php if ($row['priority'] == 3)
                                                    echo 'selected'; ?>>High
                                                </option>
                                            </select>
                                        </div>
                                        <div class="mb-3">
                                            <label for="due_date" class="form-label">Date</label>
                                            <input type="date" class="form-control" id="due_date" name="due_date"
                                                value="<?php echo $row['due_date']; ?>" required>
                                        </div>
                                        <div class="mb-3">
                                            <label for="status" class="form-label">Status</label>
                                            <select class="form-select" id="status" name="status" required>
                                                <option value="0" <?php if ($row['status'] == 0)
                                                    echo 'selected'; ?>>Incomplete
                                                </option>
                                                <option value="1" <?php if ($row['status'] == 1)
                                                    echo 'selected'; ?>>Completed
                                                </option>
                                            </select>
                                        </div>
                                        <div class="d-flex">
                                            <button type="submit" name="update"
                                                class="btn btn-primary me-2 zoom-effect">Update</button>
                                            <button type="button" class="btn btn-secondary zoom-effect"
                                                data-bs-dismiss="modal">Cancel</button>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            <?php }
            } else {
                echo "No data available";
            } ?>
    </div>
    <!-- Confirm Buat Delete Semua Data Pake Modal -->
    <div class="modal fade" id="confirmModalpending" tabindex="-1" aria-labelledby="confirmModalLabel"
        aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="confirmModalLabel">Confirm</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    Do you really want to delete all tasks?
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                    <a href="?deleteallpending" class="btn btn-danger zoom-effect">Delete All</a>
                </div>
            </div>
        </div>
    </div>

    <div class="modal fade" id="confirmModalcomplete" tabindex="-1" aria-labelledby="confirmModalLabel"
        aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="confirmModalLabel">Confirm</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    Do you really want to delete all tasks?
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                    <a href="?deleteallcompleted" class="btn btn-danger zoom-effect">Delete All</a>
                </div>
            </div>
        </div>
    </div>

    <!-- Logout Confirmation Modal -->
    <div class="modal fade" id="logoutModal" tabindex="-1" aria-labelledby="logoutModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="logoutModalLabel">Confirm Logout</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    Do you really want to log out?
                </div>
                <div class="modal-footer">
                    <a href="config/logout_process.php" class="btn btn-outline-danger">Logout</a>
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                </div>
            </div>
        </div>
    </div>

    <!--modal-addtask-->
    <div class="modal fade" id="addTaskModal" tabindex="-1" aria-labelledby="addTaskModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="addTaskModalLabel">A</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form method="POST">
                        <div class="mb-3">
                            <label class="form-label">Task Name:</label>
                            <textarea type="text" name="task" class="form-control" placeholder="Add new task"
                                autocomplete="off" autofocus required></textarea>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Priority:</label>
                            <select name="priority" class="form-control" required>
                                <option value="">--Select Priority--</option>
                                <option value="1">Low</option>
                                <option value="2">Medium</option>
                                <option value="3">High</option>
                            </select>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Date:</label>
                            <input type="date" name="due_date" class="form-control" value="<?php echo date('Y-m-d') ?>"
                                required>
                        </div>
                        <button class="btn btn-primary w-100 mt-2" type="submit" name="add_task">Insert Data</button>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <script type="text/javascript" src="assets/js/bootstrap.min.js"></script>
    <script>
        // Fungsi untuk memindahkan tugas yang sudah selesai ke bagian Complete
        function moveToComplete(taskId) {
            const taskCard = document.querySelector(`#task-${taskId}`);
            document.querySelector('#completed-tasks').appendChild(taskCard);
        }

        // Fungsi untuk memindahkan tugas yang belum selesai ke bagian atas
        function moveToPending(taskId) {
            const taskCard = document.querySelector(`#task-${taskId}`);
            document.querySelector('#pending-tasks').appendChild(taskCard);
        }
    </script>
    <script>
        document.getElementById("swapSticky").addEventListener("click", function (event) {
            event.preventDefault();
            let taskList = document.getElementById("taskListCard");
            let completedTasks = document.getElementById("completedTasksCard");

            taskList.classList.toggle("sticky-top");
            completedTasks.querySelector(".card").classList.toggle("sticky-top");
        });
    </script>
    <script>
        document.getElementById("scrollToTop").addEventListener("click", function (event) {
            event.preventDefault();
            window.scrollTo({ top: 0, behavior: 'smooth' });
        });
    </script>

    <script>
        document.addEventListener("DOMContentLoaded", function () {
            // Scroll ke atas
            document.getElementById("scrollToTop")?.addEventListener("click", function (event) {
                event.preventDefault();
                window.scrollTo({ top: 0, behavior: 'smooth' });
            });

            // Scroll ke bagian tugas yang sudah selesai
            document.querySelectorAll("#scrollToCompleted").forEach(button => {
                button.addEventListener("click", function (event) {
                    event.preventDefault();
                    let completedTasks = document.getElementById("completedTasksCard");
                    if (completedTasks) {
                        let offset = completedTasks.getBoundingClientRect().top + window.scrollY;
                        window.scrollTo({ top: offset, behavior: 'smooth' });
                    }
                });
            });

            // Menutup menu dropdown setelah diklik (untuk layar kecil)
            document.querySelectorAll("#taskMenu a").forEach(item => {
                item.addEventListener("click", function () {
                    let taskMenu = document.getElementById("taskMenu");
                    let bsCollapse = new bootstrap.Collapse(taskMenu, { toggle: false });
                    bsCollapse.hide();
                });
            });
        });

    </script>
</body>

</html>