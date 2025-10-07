<?php
// Aktifkan error reporting untuk debugging awal (boleh dihapus saat produksi)
error_reporting(E_ALL);
ini_set('display_errors', 1);

// Session dan cek login
session_start();
if (!isset($_SESSION['username'])) {
    header("Location: ../index.php?pesan=belum_login");
    exit;
}

include '../koneksi.php';
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>AdminLTE 3 </title>

  <!-- Asset bawaan AdminLTE -->
 <link rel="stylesheet" href="../asset/dist/css/adminlte.min.css">

  <link rel="stylesheet" href="../asset/dist/css/adminlte.min.css">
</head>
<body class="hold-transition sidebar-mini">
<div class="wrapper">

  <!-- Navbar -->
  <?php include '../page/navbar.php'; ?>

  <!-- Sidebar -->
  <?php include 'sidebar.php'; ?>

<div class="content-wrapper">
  <!-- Content Header -->
  <section class="content-header">
    <div class="container-fluid">
      <h1>
        <?php
        $page = isset($_GET['page']) ? $_GET['page'] : 'dashboard';
        echo ($page == 'data') ? '' : 'Selamat datang di Dashboard';
        ?>
      </h1>
    </div>
  </section>

   <!-- Main Content -->
  <section class="content">
    <div class="container-fluid">
      <?php
      if ($page == 'data') {
          include "data.php";
      } else {
          echo "
          <div class='card'>
            <div class='card-body'>
              Ini adalah halaman Dashboard.
            </div>
          </div>";
      }
      ?>
    </div>
  </section>
</div>

  <?php include '../page/footer.php'; ?>
</div>

<script src="../asset/plugins/jquery/jquery.min.js"></script>
<script src="../asset/plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
<script src="../asset/dist/js/adminlte.min.js"></script>
</body>
</html>