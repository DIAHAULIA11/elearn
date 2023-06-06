<?php
include 'config.php';

session_start();

// Cek apakah user sudah login atau belum
if (!isset($_SESSION['username'])) {
  header("location:auth/login.php");
}

// Menghitung jumlah data pada tabel pengguna
$sqlPengguna = "SELECT COUNT(*) as jumlahPengguna FROM pengguna";
$resultMahasiswa = mysqli_query($koneksi, $sqlPengguna);
$dataPengguna = mysqli_fetch_assoc($resultMahasiswa);
$jumlahPengguna = $dataPengguna['jumlahPengguna'];

// Menghitung jumlah data pada tabel mataKuliah
$sqlMataKuliah = "SELECT COUNT(*) as jumlahMataKuliah FROM matakuliah";
$resultMataKuliah = mysqli_query($koneksi, $sqlMataKuliah);
$dataMataKuliah = mysqli_fetch_assoc($resultMataKuliah);
$jumlahMataKuliah = $dataMataKuliah['jumlahMataKuliah'];

// Menghitung jumlah data pada tabel Pengumpulan
$sqlPengumpulan = "SELECT COUNT(*) as jumlahPengumpulan FROM pengumpulan";
$resultPengumpulan = mysqli_query($koneksi, $sqlPengumpulan);
$dataPengumpulan = mysqli_fetch_assoc($resultPengumpulan);
$jumlahPengumpulan = $dataPengumpulan['jumlahPengumpulan'];

// Menghitung jumlah data pada tabel penugasan
$sqlPenugasan = "SELECT COUNT(*) as jumlahPenugasan FROM penugasan";
$resultPenugasan = mysqli_query($koneksi, $sqlPenugasan);
$dataPenugasan = mysqli_fetch_assoc($resultPenugasan);
$jumlahPenugasan = $dataPenugasan['jumlahPenugasan'];

// Mendapatkan nama hari dalam bahasa Indonesia
$hariArray = array(
  'Sunday' => 'Minggu',
  'Monday' => 'Senin',
  'Tuesday' => 'Selasa',
  'Wednesday' => 'Rabu',
  'Thursday' => 'Kamis',
  'Friday' => 'Jumat',
  'Saturday' => 'Sabtu'
);

// Mendapatkan nama bulan dalam bahasa Indonesia
$bulanArray = array(
  'January' => 'Januari',
  'February' => 'Februari',
  'March' => 'Maret',
  'April' => 'April',
  'May' => 'Mei',
  'June' => 'Juni',
  'July' => 'Juli',
  'August' => 'Agustus',
  'September' => 'September',
  'October' => 'Oktober',
  'November' => 'November',
  'December' => 'Desember'
);

// Mendapatkan hari ini dalam bahasa Indonesia
$hari = $hariArray[date("l")];

// Mendapatkan tanggal hari ini dalam bahasa Indonesia
$tanggal = date("d") . " " . $bulanArray[date("F")] . " " . date("Y");

?>

<!DOCTYPE html>
<html lang="en">

<head>

  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <meta name="description" content="">
  <meta name="author" content="">

  <title>Dashboard | Admin</title>

  <!-- Custom fonts for this template-->
  <link href="vendor/fontawesome-free/css/all.min.css" rel="stylesheet" type="text/css">
  <link href="https://fonts.googleapis.com/css?family=Nunito:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i" rel="stylesheet">
  <link href="https://fonts.googleapis.com/css2?family=Poppins:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&display=swap" rel="stylesheet">

  <!-- Custom styles for this template-->
  <link href="css/sb-admin-2.min.css" rel="stylesheet">

  <!-- Favicon -->
  <link rel="shortcut icon" href="./img/logo_pens1.png" type="image/x-icon">

</head>

<body id="page-top">

  <!-- Page Wrapper -->
  <div id="wrapper">

    <!-- Sidebar -->
    <ul class="navbar-nav bg-warning sidebar sidebar-dark accordion" id="accordionSidebar">

      <!-- Sidebar - Brand -->
      <a class="sidebar-brand d-flex align-items-center justify-content-center">
        <div class="sidebar-brand-icon ">
          <img class="logo" src="./img/logo_pens.png" style="width:2rem; transform: rotate(3deg)">
        </div>
        <div class="sidebar-brand-text mx-3">ELearn</div>
      </a>

      <!-- Divider -->
      <hr class="sidebar-divider my-0">

      <!-- Nav Item - Dashboard -->
      <li class="nav-item active">
        <a class="nav-link" href="index.php">
          <i class="fas fa-columns"></i>
          <span>Dashboard</span></a>
      </li>

      <!-- Divider -->
      <hr class="sidebar-divider">

      <!-- Heading -->
      <div class="sidebar-heading">
        Tables
      </div>

      <!-- Nav Item -->
      <?php if ($_SESSION['peran'] !== 'mahasiswa') { ?>
        <li class="nav-item">
          <a class="nav-link" href="views/mahasiswa/">
            <i class="fas fa-user-graduate"></i>
            <span>Student</span>
          </a>
        </li>
      <?php } ?>

      <li class="nav-item">
        <a class="nav-link" href="views/dosen/">
          <i class="fas fa-chalkboard-teacher"></i>
          <span>Lecturer</span></a>
      </li>

      <li class="nav-item">
        <a class="nav-link" href="views/matakuliah/">
          <i class="fas fa-book"></i>
          <span>Course</span></a>
      </li>

      <li class="nav-item">
        <a class="nav-link" href="views/penugasan/">
          <i class="fas fa-puzzle-piece"></i>
          <span>Assignment</span></a>
      </li>

      <?php if ($_SESSION['peran'] !== 'mahasiswa') { ?>
        <li class="nav-item">
          <a class="nav-link" href="views/pengerjaan/">
            <i class="fas fa-folder-open"></i>
            <span>Submission</span></a>
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

          <!-- Topbar Search
          <form class="d-none d-sm-inline-block form-inline mr-auto ml-md-3 my-2 my-md-0 mw-100 navbar-search">
            <div class="input-group">
              <input type="text" class="form-control bg-light border-0 small" placeholder="Search for..." aria-label="Search" aria-describedby="basic-addon2">
              <div class="input-group-append">
                <button class="btn btn-warning" type="button">
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
                <img class="rounded" src="./gambar/<?php echo $_SESSION['foto']; ?>" alt="Gambar" style="width:2rem">
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

          <!-- Page Heading -->
          <div class="d-sm-flex align-items-center justify-content-between mb-4">
            <div class="d-sm-flex align-items-center">
              <!-- <i class="fas fa-columns"></i> -->
              <i class="mr-2 fas fa-columns-alt fa-lg"></i>
              <h4 class="h4 mb-0 text-gray-800 py-1">Dashboard</h4>
            </div>

            <!-- <a href="404.php" class="btn bg-primary text-light btn-icon-split" id="modal-trigger">
                            <span class="icon text-white-50">
                                <i class="fas fa-plus"></i>
                            </span>
                            <span class="text">Tambah Data</span>
                        </a> -->
          </div>

          <?php
          // Cek apakah pengguna memiliki session dan peran admin
          if (isset($_SESSION['peran']) && $_SESSION['peran'] === 'admin') {
          ?>
            <!-- Content Row -->
            <div class="row">

              <!-- Earnings (Monthly) Card Example -->
              <div class="col-xl-3 col-md-6 mb-4">
                <div class="card border-left-primary shadow h-100 py-2">
                  <div class="card-body">
                    <div class="row no-gutters align-items-center">
                      <div class="col mr-2">
                        <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">
                          Users</div>
                        <div class="h5 mb-0 font-weight-bold text-gray-800"><?php echo $jumlahPengguna ?></div>
                      </div>
                      <div class="col-auto">
                        <i class="fas fa-user-friends fa-2x text-gray-300"></i>
                      </div>
                    </div>
                  </div>
                </div>
              </div>

              <!-- Earnings (Monthly) Card Example -->
              <div class="col-xl-3 col-md-6 mb-4">
                <div class="card border-left-success shadow h-100 py-2">
                  <div class="card-body">
                    <div class="row no-gutters align-items-center">
                      <div class="col mr-2">
                        <div class="text-xs font-weight-bold text-success text-uppercase mb-1">
                          Assignment</div>
                        <div class="h5 mb-0 font-weight-bold text-gray-800"><?php echo $jumlahPenugasan ?></div>
                      </div>
                      <div class="col-auto">
                        <i class="fas fa-chalkboard-teacher fa-2x text-gray-300"></i>
                      </div>
                    </div>
                  </div>
                </div>
              </div>

              <!-- Earnings (Monthly) Card Example -->
              <div class="col-xl-3 col-md-6 mb-4">
                <div class="card border-left-info shadow h-100 py-2">
                  <div class="card-body">
                    <div class="row no-gutters align-items-center">
                      <div class="col mr-2">
                        <div class="text-xs font-weight-bold text-info text-uppercase mb-1">Course
                        </div>
                        <div class="row no-gutters align-items-center">
                          <div class="col-auto">
                            <div class="h5 mb-0 mr-3 font-weight-bold text-gray-800"><?php echo $jumlahMataKuliah ?></div>
                          </div>
                        </div>
                      </div>
                      <div class="col-auto">
                        <i class="fas fa-book fa-2x text-gray-300"></i>

                      </div>
                    </div>
                  </div>
                </div>
              </div>

              <!-- Pending Requests Card Example -->
              <div class="col-xl-3 col-md-6 mb-4">
                <div class="card border-left-warning shadow h-100 py-2">
                  <div class="card-body">
                    <div class="row no-gutters align-items-center">
                      <div class="col mr-2">
                        <div class="text-xs font-weight-bold text-warning text-uppercase mb-1">
                          <?php echo $hari ?></div>
                        <div class="h5 mb-0 font-weight-bold text-gray-800"><?php echo $tanggal ?></div>
                      </div>
                      <div class="col-auto">
                        <i class="fas fa-calendar-alt fa-2x text-gray-300"></i>
                      </div>
                    </div>
                  </div>
                </div>
              </div>

            </div>
          <?php
          }
          ?>

          <?php
          // Cek peran pengguna setelah login
          if ($_SESSION['peran'] === 'mahasiswa') {
            include 'views/mahasiswa/dashboard.php';
          }
          ?>
        </div>
        <!-- /.container-fluid -->

      </div>
      <!-- End of Main Content -->

      <!-- Footer -->
      <footer class="sticky-footer">
        <div class="container my-auto">
          <div class="copyright text-center my-auto">
            <span>pens.ac.id<t /span>
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
          <a class="btn btn-primary" href="auth/logout.php">Logout</a>
        </div>
      </div>
    </div>
  </div>

  <!-- Bootstrap core JavaScript-->
  <script src="vendor/jquery/jquery.min.js"></script>
  <script src="vendor/bootstrap/js/bootstrap.bundle.min.js"></script>

  <!-- Core plugin JavaScript-->
  <script src="vendor/jquery-easing/jquery.easing.min.js"></script>

  <!-- Custom scripts for all pages-->
  <script src="js/sb-admin-2.min.js"></script>

  <!-- Page level plugins -->
  <script src="vendor/chart.js/Chart.min.js"></script>

  <!-- Page level custom scripts -->
  <script src="js/demo/chart-area-demo.js"></script>
  <script src="js/demo/chart-pie-demo.js"></script>

</body>

</html>