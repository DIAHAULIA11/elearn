<?php
include('../../config.php');

session_start();

// Cek apakah user sudah login atau belum
if (!isset($_SESSION['username'])) {
    header("location:auth/login.php");
}

// Cek peran pengguna setelah login
if ($_SESSION['peran'] !== 'mahasiswa') {
    header("location:../errors/forbidden.php");
    exit(); // Hentikan eksekusi script setelah melakukan redirect
}

if (isset($_POST['submit'])) {
    $penugasan_id = $_GET['id'];
    $file_penugasan = $_FILES['file_penugasan']['name'];

    $pengguna_id = $_SESSION['id'];

    // Retrieve nama_penugasan based on penugasan_id
    $query_penugasan = "SELECT nama FROM Penugasan WHERE id = $penugasan_id";
    $result_penugasan = mysqli_query($koneksi, $query_penugasan);
    $row_penugasan = mysqli_fetch_assoc($result_penugasan);
    $nama_penugasan = $row_penugasan['nama'];

    // Retrieve nama_pengguna based on pengguna_id
    $query_pengguna = "SELECT nama FROM Pengguna WHERE id = $pengguna_id";
    $result_pengguna = mysqli_query($koneksi, $query_pengguna);
    $row_pengguna = mysqli_fetch_assoc($result_pengguna);
    $nama_pengguna = $row_pengguna['nama'];

    $ekstensi = array('pdf', 'txt');
    $filename = $_FILES['file_penugasan']['name'];
    $filesize = $_FILES['file_penugasan']['size'];
    $ext = pathinfo($filename, PATHINFO_EXTENSION);

    if (!in_array($ext, $ekstensi)) {
        header("location:index.php?alert=gagal_ekstensi");
        exit;
    } else {
        $path_file = $nama_penugasan . '_' . $nama_pengguna . '_' . pathinfo($filename, PATHINFO_FILENAME) . '.' . $ext;
        move_uploaded_file($_FILES['file_penugasan']['tmp_name'], '../../uploads/' . $path_fbrowile);

        $query_insert = "INSERT INTO pengumpulan (mahasiswa_id, penugasan_id, file_penugasan) 
                    SELECT p.id, pen.id, '$path_file'
                    FROM Pengguna p
                    JOIN Penugasan pen ON pen.id = $penugasan_id
                    WHERE p.id = $pengguna_id AND p.peran = 'mahasiswa'";

        if (mysqli_query($koneksi, $query_insert)) {
            // Berhasil menyimpan data
            header("location:../../index.php?alert=berhasil");
        } else {
            // Gagal menyimpan data
            header("location:index.php?alert=gagal_upload");
        }
    }
}

?>

<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="">

    <title>Submit Task</title>

    <!-- Custom fonts for this template-->
    <link href="../../vendor/fontawesome-free/css/all.min.css" rel="stylesheet" type="text/css">
    <link href="https://fonts.googleapis.com/css?family=Nunito:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&display=swap" rel="stylesheet">

    <!-- Custom styles for this template-->
    <link href="../../css/sb-admin-2.min.css" rel="stylesheet">

    <!-- Favicon -->
    <link rel="shortcut icon" href="../../img/logo_pens1.png" type="image/x-icon">

</head>

<body id="page-top">

    <!-- Page Wrapper -->
    <div id="wrapper">

        <!-- Sidebar -->
        <ul class="navbar-nav bg-warning sidebar sidebar-dark accordion" id="accordionSidebar">

            <!-- Sidebar - Brand -->
            <a class="sidebar-brand d-flex align-items-center justify-content-center">
                <div class="sidebar-brand-icon">
                    <img class="logo" src="../../img/logo_pens.png" style="width:2rem; transform: rotate(3deg)">
                </div>
                <div class="sidebar-brand-text mx-3">ELearn</div>
            </a>

            <!-- Divider -->
            <hr class="sidebar-divider my-0">

            <!-- Nav Item - Dashboard -->
            <?php if ($_SESSION['peran'] !== 'dosen') { ?>
                <li class="nav-item">
                    <a class="nav-link" href="../../index.php">
                        <i class="fas fa-columns"></i>
                        <span>Dashboard</span></a>
                </li>
            <?php } ?>

            <!-- Divider -->
            <hr class="sidebar-divider">

            <!-- Heading -->
            <div class="sidebar-heading">
                Tables
            </div>

            <!-- Nav Item -->
            <?php if ($_SESSION['peran'] !== 'mahasiswa') { ?>
                <li class="nav-item">
                    <a class="nav-link" href="../mahasiswa/">
                        <i class="fas fa-user-graduate"></i>
                        <span>Student</span></a>
                </li>
            <?php } ?>

            <li class="nav-item">
                <a class="nav-link" href="../dosen/">
                    <i class="fas fa-chalkboard-teacher"></i>
                    <span>Lecture</span></a>
            </li>

            <li class="nav-item">
                <a class="nav-link" href="../matakuliah/">
                    <i class="fas fa-book"></i>
                    <span>Course</span></a>
            </li>

            <li class="nav-item">
                <a class="nav-link" href="../penugasan/">
                    <i class="fas fa-puzzle-piece"></i>
                    <span>Assignment</span></a>
            </li>

            <?php if ($_SESSION['peran'] !== 'mahasiswa') { ?>
                <li class="nav-item">
                    <a class="nav-link" href="../pengerjaan/">
                        <i class="fas fa-folder-open"></i>
                        <span>Submissions</span></a>
                </li>
            <?php } ?>

            <!-- Divider -->
            <hr class="sidebar-divider d-none d-md-block">

            <!-- Sidebar Toggler (Sidebar) -->
            <div class="text-center d-none d-md-inline">
                <button class="rounded-circle border-0" id="sidebarToggle"></button>
            </div>
        </ul>
        <!-- End of Sidebar -->

        <!-- Content Wrapper -->
        <div id="content-wrapper" class="d-flex flex-column">

            <!-- Main Content -->
            <div id="content">

                <!-- Topbar -->
                <nav class="navbar navbar-expand navbar-light bg-white topbar mb-4 static-top shadow">

                    <!-- Sidebar Toggle (Topbar) -->
                    <button id="sidebarToggleTop" class="btn btn-link d-md-none rounded-circle mr-3">
                        <i class="fa fa-bars"></i>
                    </button>

                    <!-- Topbar Search -->
                    <!-- <form class="d-none d-sm-inline-block form-inline mr-auto ml-md-3 my-2 my-md-0 mw-100 navbar-search">
                        <div class="input-group">
                            <input type="text" class="form-control bg-light border-0 small" placeholder="Search for..." aria-label="Search" aria-describedby="basic-addon2">
                            <div class="input-group-append">
                                <button class="btn btn-primary" type="button">
                                    <i class="fas fa-search fa-sm"></i>
                                </button>
                            </div>
                        </div>
                    </form> -->

                    <!-- Topbar Navbar -->
                    <ul class="navbar-nav ml-auto">
                        <!-- <div class="topbar-divider d-none d-sm-block"></div> -->
                        <!-- Nav Item - User Information -->
                        <li class="nav-item dropdown no-arrow">
                            <a class="nav-link dropdown-toggle" href="#" id="userDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                <span class="mr-3 text-gray-600 small text-capitalize"><?php echo $_SESSION['nama']; ?></span>
                                <img class="rounded" src="../../gambar/<?php echo $_SESSION['foto']; ?>" alt="Gambar" style="width:2rem">
                            </a>
                            <!-- Dropdown - User Information -->
                            <div class="dropdown-menu dropdown-menu-right shadow animated--grow-in" aria-labelledby="userDropdown">
                                <a class="dropdown-item" href="#" data-toggle="modal" data-target="#logoutModal">
                                    <i class="fas fa-sign-out-alt fa-sm fa-fw mr-2 text-gray-400"></i>
                                    Logout
                                </a>
                            </div>
                        </li>

                    </ul>

                </nav>
                <!-- End of Topbar -->

                <!-- Begin Page Content -->
                <div class="container-fluid">

                    <!-- Pengerjaan Tugas -->
                    <div class="d-sm-flex align-items-center justify-content-between mb-4 p-0 py-1 col-md-5 mx-auto">
                        <div class="d-sm-flex align-items-center">
                            <i class="mr-2 fas fa-clipboard fa-lg"></i>
                            <h4 class="h4 mb-0 text-gray-800">Submit Task</h4>
                        </div>
                    </div>

                    <div class="card mt-4 mb-4 col-md-5 mx-auto">
                        <div class="card-body">
                            <div class="table-responsive">
                                <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                                    <form action="" method="POST" enctype="multipart/form-data">
                                        <div class="input-group">
                                            <div class="input-group-prepend">
                                                <span class="input-group-text" id="basic-addon1">
                                                    <i class="fas fa-file-upload"></i>
                                                </span>
                                            </div>
                                            <div class="custom-file">
                                                <input id="file_penugasan" name="file_penugasan" type="file" class="custom-file-input" accept=".pdf,.txt" aria-describedby="basic-addon1" required>
                                                <label data-browse="Browse..." class="custom-file-label" for="file_penugasan">Submit Task</label>
                                            </div>
                                        </div>

                                        <div class="text-light mb-3 px-1 mt-1" id="upload-status"></div>
                                        <div class="modal-footer p-0">
                                            <div class="d-flex w-100 mt-3">
                                                <button type="button" class="btn btn-secondary flex-fill mr-2" onclick="window.location.href='index.php'">Cancel</button>
                                                <button type="submit" name="submit" class="btn btn-primary text-light flex-fill ml-2">Add</button>
                                            </div>
                                        </div>
                                    </form>
                                </table>
                            </div>
                        </div>
                    </div>
                    <!-- Endof Penugasan -->
                </div>
                <!-- /.container-fluid -->

            </div>
            <!-- End of Main Content -->

            <!-- Footer -->
            <footer class="sticky-footer">
                <div class="container my-auto">
                    <div class="copyright text-center my-auto">
                        <span>pens.ac.id</span>
                    </div>
                </div>
            </footer>
            <!-- End of Footer -->

        </div>
        <!-- End of Content Wrapper -->

    </div>
    <!-- End of Page Wrapper -->

    <!-- Scroll to Top Button-->
    <a class="scroll-to-top rounded" href="#page-top">
        <i class="fas fa-angle-up"></i>
    </a>

    <!-- Logout Modal-->
    <div class="modal fade" id="logoutModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Ready to Leave?</h5>
                    <button class="close" type="button" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">×</span>
                    </button>
                </div>
                <div class="modal-body">Select "Logout" below if you are ready to end your current session.</div>
                <div class="modal-footer">
                    <button class="btn btn-secondary" type="button" data-dismiss="modal">Cancel</button>
                    <a class="btn btn-primary" href="../../auth/logout.php">Logout</a>
                </div>
            </div>
        </div>
    </div>

    <!-- Bootstrap core JavaScript-->
    <script src="../../vendor/jquery/jquery.min.js"></script>
    <script src="../../vendor/bootstrap/js/bootstrap.bundle.min.js"></script>

    <!-- Core plugin JavaScript-->
    <script src="../../vendor/jquery-easing/jquery.easing.min.js"></script>

    <!-- Custom scripts for all pages-->
    <script src="../../js/sb-admin-2.min.js"></script>

    <!-- Page level plugins -->
    <script src="../../vendor/chart.js/Chart.min.js"></script>

    <!-- Page level custom scripts -->
    <script src="../../js/demo/chart-area-demo.js"></script>
    <script src="../../js/demo/chart-pie-demo.js"></script>

</body>

</html>