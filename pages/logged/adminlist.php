<?php
  session_start();

   if (!isset($_SESSION['logged']['email'])) {
     header('location: ../../');
     exit();
   }
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <meta http-equiv="x-ua-compatible" content="ie=edge">

  <title>AdminLTE 3 | administrator</title>

  <!-- Font Awesome Icons -->
  <link rel="stylesheet" href="../../plugins/fontawesome-free/css/all.min.css">
  <!-- overlayScrollbars -->
  <link rel="stylesheet" href="../../plugins/overlayScrollbars/css/OverlayScrollbars.min.css">
  <!-- Theme style -->
  <link rel="stylesheet" href="../../dist/css/adminlte.min.css">
    <!-- Google Font: Source Sans Pro -->
  <link href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700" rel="stylesheet">
</head>
<body class="hold-transition sidebar-mini layout-fixed layout-navbar-fixed layout-footer-fixed">
<div class="wrapper">
  <!-- Navbar -->


  <!-- Main Sidebar Container -->
  <aside class="main-sidebar sidebar-dark-primary elevation-4">
    <!-- Brand Logo -->
    <a href="#" class="brand-link">
      <img src="../../dist/img/AdminLTELogo.png" alt="AdminLTE Logo" class="brand-image img-circle elevation-3"
           style="opacity: .8">
      <span class="brand-text font-weight-light">AdminTEB</span>
    </a>

    <!-- Sidebar -->
    <div class="sidebar">
      <!-- Sidebar user panel (optional) -->
      <div class="user-panel mt-3 pb-3 mb-3 d-flex">
        <div class="image">
        <?php
          echo "<img src=\"../../dist/img/{$_SESSION['logged']['avatar']}\" class='img-circle elevation-2' alt='User Image'>";
        ?>

        </div>
        <div class="info">
          <a href="#" class="d-block">
            <?php
              echo $_SESSION['logged']['name'], ' ', $_SESSION['logged']['surname'];
            ?>
          </a>
        </div>
      </div>

      <!-- Sidebar Menu -->
      <nav class="mt-2">
        <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
          <!-- Add icons to the links using the .nav-icon class
               with font-awesome or any other icon font library -->

          <li class="nav-item">
            <a href="../../scripts/logout.php" class="nav-link">
              <i class="fas fa-sign-out-alt"></i>
              <p>
                Wyloguj się
              </p>
            </a>
          </li>

      </nav>
      <!-- /.sidebar-menu -->
    </div>
    <!-- /.sidebar -->
  </aside>

  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <div class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1 class="m-0 text-dark">
              Strona domowa użytkownika
              <?php
                echo $_SESSION['logged']['name'];
              ?>
            </h1>
          </div><!-- /.col -->

        </div><!-- /.row -->
      </div><!-- /.container-fluid -->
    </div>
    <!-- /.content-header -->

    <!-- Main content -->
    <section class="content">
      <div class="container-fluid">
        <div class="row">
          <?php

            //ilość użytkowników o odpowiednich uprawnieniach
            require_once '../../scripts/connect.php';

            $sql = "SELECT permission, count(*) as 'num' FROM `user` as u INNER JOIN `permission` as p ON u.permissionid=p.id GROUP BY `permissionid` ORDER BY p.id";

            $result = $conn->query($sql);

            $i = 0;
            while ($row = $result->fetch_assoc()) {
              $tab[$i] = $row['num'];
              $i++;
            }

            // administrator - tab[0], użytkownik - tab[1], moderator - tab[2]

            //użytkownicy zablokowani
            $sql = "SELECT active, count(*) as 'num' FROM `user` GROUP BY active";
            $result = $conn->query($sql);
            while ($row = $result->fetch_assoc()) {
              if ($row['active'] == 0) {
                $blocked = $row['num'];
              }
            }

          ?>
          <div class="col-lg-3 col-6">
            <!-- small box -->
            <div class="small-box bg-info">
              <div class="inner">
                <h3><?php echo $tab[0] ?></h3>

                <p>Administratorzy</p>
              </div>
            </div>
          </div>
        </div>
        <!-- Main row -->
        <div class="row">
          <!-- Left col -->
          <div class="col-md-8">
            <!-- MAP & BOX PANE -->
            <div class="card">
              <!-- /.card-header -->
              <!-- /.card-body -->
            </div>
            <!-- /.card -->
            <!-- /.row -->
            <!-- TABLE: Użytkownicy  z bazy danych -->
            <div class="card">
              <!-- /.card-header -->
              <div class="card-body p-0">
                <div class="table-responsive">
                  <table class="table m-0">
                    <thead>
                    <tr>
                      <th>Imię</th>
                      <th>Nazwisko</th>
                      <th>Ostatnie logowanie</th>
                    </tr>
                    </thead>
                    <tbody>
                    <!--
                      class="badge badge-success">
                      warning, danger, info
                     -->
      <?php
        require_once '../../scripts/connect.php';

        $sql = "SELECT `id`, `permissionid`, `name`, `surname`, `email`, `last_login` FROM `user` WHERE permissionid = 1 ";

        $result = $conn->query($sql);

        if ($result->num_rows != 0) {
          while($user = $result->fetch_assoc()){
            echo <<<USER
              <tr>
                <td>
                  $user[name]
                </td>
                <td>
                  $user[surname]
                </td>

                <td>
USER;

          
            if ($user['last_login'] == NULL) {
              echo 'Brak logowania';
            }else{
              echo $user['last_login'];
            }
            echo <<<USER

                  </div>
                </td>
              </tr>
USER;
          }
        }else{
          echo <<<EMPTYROW
          <tr>
            <td colspan="2">Brak użytkowników w bazie danych</td>
          </tr>
EMPTYROW;
        }
      ?>
                    </tbody>
                  </table>
                </div>
                <!-- /.table-responsive -->
              </div>
              <!-- /.card-body -->
              <div class="card-footer clearfix">

                <a href="admin.php" class="btn btn-sm btn-secondary float-right">Powrót</a>
              </div>
              <!-- /.card-footer -->
            </div>
            <!-- /.card -->
          </div>
          <!-- /.col -->




          <!-- /.col -->
        </div>
        <!-- /.row -->
      </div><!--/. container-fluid -->
    </section>
    <!-- /.content -->
  </div>
  <!-- /.content-wrapper -->

  <!-- Control Sidebar -->
  <aside class="control-sidebar control-sidebar-dark">
    <!-- Control sidebar content goes here -->
  </aside>
  <!-- /.control-sidebar -->

  <!-- Main Footer -->
  <footer class="main-footer">
    <strong>Copyright &copy; 2014-2019 <a href="http://adminlte.io">AdminLTE.io</a>.</strong>
    All rights reserved.
    <div class="float-right d-none d-sm-inline-block">
      <b>Version</b> 3.0.4
    </div>
  </footer>
</div>
<!-- ./wrapper -->

<!-- REQUIRED SCRIPTS -->
<!-- jQuery -->
<script src="../../plugins/jquery/jquery.min.js"></script>
<!-- Bootstrap -->
<script src="../../plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
<!-- overlayScrollbars -->
<script src="../../plugins/overlayScrollbars/js/jquery.overlayScrollbars.min.js"></script>
<!-- AdminLTE App -->
<script src="../../dist/js/adminlte.js"></script>

<!-- OPTIONAL SCRIPTS -->
<script src="../../dist/js/demo.js"></script>

<!-- PAGE PLUGINS -->
<!-- jQuery Mapael -->
<script src="../../plugins/jquery-mousewheel/jquery.mousewheel.js"></script>
<script src="../../plugins/raphael/raphael.min.js"></script>
<script src="../../plugins/jquery-mapael/jquery.mapael.min.js"></script>
<script src="../../plugins/jquery-mapael/maps/usa_states.min.js"></script>
<!-- ChartJS -->
<script src="../../plugins/chart.js/Chart.min.js"></script>

<!-- PAGE SCRIPTS -->
<script src="../../dist/js/pages/dashboard2.js"></script>
</body>
</html>
