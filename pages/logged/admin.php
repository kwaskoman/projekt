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
              <span style="color:red">
              <?php
                echo $_SESSION['logged']['name'];
              ?>
              </span>
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
              <div class="icon">
                <i class="ion ion-bag"></i>
              </div>
              <a href="adminlist.php" class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a>
            </div>
          </div>
          <!-- ./col -->
          <div class="col-lg-3 col-6">
            <!-- small box -->
            <div class="small-box bg-success">
              <div class="inner">
                <h3><?php echo $tab[1] ?></h3>

                <p>Użytkownicy</p>
              </div>
              <div class="icon">
                <i class="ion ion-stats-bars"></i>
              </div>
              <a href="userlist.php" class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a>
            </div>
          </div>
          <!-- ./col -->
          <div class="col-lg-3 col-6">
            <!-- small box -->
            <div class="small-box bg-warning">
              <div class="inner">
                <h3><?php echo $tab[2] ?></h3>

                <p>Moderatorzy</p>
              </div>
              <div class="icon">
                <i class="ion ion-person-add"></i>
              </div>
              <a href="moderlist.php" class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a>
            </div>
          </div>
          <!-- ./col -->
          <div class="col-lg-3 col-6">
            <!-- small box -->
            <div class="small-box bg-danger">
              <div class="inner">
                <h3><?php echo $blocked ?></h3>

                <p>Zablokowani</p>
              </div>
              <div class="icon">
                <i class="ion ion-pie-graph"></i>
              </div>
              <a href="blockedlist.php" class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a>
            </div>
          </div>
          <!-- ./col -->
        </div>


        <!-- Main row -->
        <div class="row">
          <!-- Left col -->
          <div class="col-md-6">
            <div class="card">
              <div class="card-header">
                <h3 class="card-title">Wykres 4 U</h3>
              </div>
              <!-- /.card-header -->
              <div class="card-body text-center">


                <div class="progress vertical">
                  <?php
                  echo $tab[0]

                   ?>



                  <div class="progress-bar bg-info" role="progressbar" aria-valuenow="40" aria-valuemin="0"
                       aria-valuemax="100" style="height: 20%">
                    <span class="sr-only">20%</span>
                  </div>
                </div>
                <div class="progress vertical">
                  <?php
                  echo $tab[1]

                   ?>


                  <div class="progress-bar bg-success" role="progressbar" aria-valuenow="20" aria-valuemin="0"
                       aria-valuemax="100" style="height: 50%">
                    <span class="sr-only">20%</span>
                  </div>
                </div>
                <div class="progress vertical">
                  <?php
                  echo $tab[2]

                   ?>
                  <div class="progress-bar bg-warning" role="progressbar" aria-valuenow="60" aria-valuemin="0"
                       aria-valuemax="100" style="height: 20%">
                    <span class="sr-only">60%</span>
                  </div>
                </div>
                <div class="progress vertical">
                  <?php
                  echo $blocked

                   ?>
                  <div class="progress-bar bg-danger" role="progressbar" aria-valuenow="80" aria-valuemin="0"
                       aria-valuemax="100" style="height: 30%">
                    <span class="sr-only">80%</span>
                  </div>
                </div>
              </div>
              <!-- /.card-body -->
            </div>
            <!-- /.card -->
            <div class="card bg-gradient-success">
              <div class="card-header border-0">

                <h3 class="card-title">
                  <i class="far fa-calendar-alt"></i>
                  Calendar
                </h3>
                <!-- tools card -->
                <div class="card-tools">
                  <!-- button with a dropdown -->
                  <div class="btn-group">
                    <button type="button" class="btn btn-success btn-sm dropdown-toggle" data-toggle="dropdown">
                      <i class="fas fa-bars"></i></button>
                    <div class="dropdown-menu float-right" role="menu">
                      <a href="#" class="dropdown-item">Add new event</a>
                      <a href="#" class="dropdown-item">Clear events</a>
                      <div class="dropdown-divider"></div>
                      <a href="#" class="dropdown-item">View calendar</a>
                    </div>
                  </div>
                  <button type="button" class="btn btn-success btn-sm" data-card-widget="collapse">
                    <i class="fas fa-minus"></i>
                  </button>
                  <button type="button" class="btn btn-success btn-sm" data-card-widget="remove">
                    <i class="fas fa-times"></i>
                  </button>
                </div>
                <!-- /. tools -->
              </div>
              <!-- /.card-header -->
              <div class="card-body pt-0">
                <!--The calendar -->
                <div class="bootstrap-datetimepicker-widget usetwentyfour">
                  <ul class="list-unstyled">
                    <li class="show">
                      <div class="datepicker">
                      <div class="datepicker-days" style="">
                        <table class="table table-sm">
                        <thead>
                          <tr>
                          <th class="prev" data-action="previous">
                            <span class="fa fa-chevron-left" title="Previous Month">
                            </span>
                </th>
                <th class="picker-switch" data-action="pickerSwitch" colspan="5" title="Select Month">June 2020</th>
                <th class="next" data-action="next">
                  <span class="fa fa-chevron-right" title="Next Month">
                  </span>
                </th>
              </tr>
              <tr>
                <th class="dow">Su</th>
                    <th class="dow">Mo</th>
                    <th class="dow">Tu</th>
                <th class="dow">We</th>
                <th class="dow">Th</th>
                <th class="dow">Fr</th>
                <th class="dow">Sa</th>
              </tr>
              </thead><tbody>
                  <tr>
                    <td data-action="selectDay" data-day="05/31/2020" class="day old weekend">31</td>
                    <td data-action="selectDay" data-day="06/01/2020" class="day">1</td>
                    <td data-action="selectDay" data-day="06/02/2020" class="day">2</td>
                    <td data-action="selectDay" data-day="06/03/2020" class="day">3</td>
                    <td data-action="selectDay" data-day="06/04/2020" class="day">4</td>
                    <td data-action="selectDay" data-day="06/05/2020" class="day">5</td>
                    <td data-action="selectDay" data-day="06/06/2020" class="day weekend">6
                    </td>
                  </tr>
                  <tr>
                    <td data-action="selectDay" data-day="06/07/2020" class="day weekend">7</td>
                    <td data-action="selectDay" data-day="06/08/2020" class="day">8</td>
                    <td data-action="selectDay" data-day="06/09/2020" class="day">9</td>
                    <td data-action="selectDay" data-day="06/10/2020" class="day">10</td>
                    <td data-action="selectDay" data-day="06/11/2020" class="day">11</td>
                    <td data-action="selectDay" data-day="06/12/2020" class="day">12</td>
                    <td data-action="selectDay" data-day="06/13/2020" class="day weekend">13</td>
                  </tr>
                    <tr><td data-action="selectDay" data-day="06/14/2020" class="day weekend">14</td>
                      <td data-action="selectDay" data-day="06/15/2020" class="day">15</td>
                      <td data-action="selectDay" data-day="06/16/2020" class="day">16</td>
                      <td data-action="selectDay" data-day="06/17/2020" class="day">17</td><td data-action="selectDay" data-day="06/18/2020" class="day">18</td>
                      <td data-action="selectDay" data-day="06/19/2020" class="day">19</td>
                      <td data-action="selectDay" data-day="06/20/2020" class="day weekend">20</td>
                    </tr>
                      <tr>
                        <td data-action="selectDay" data-day="06/21/2020" class="day weekend">21</td>
                        <td data-action="selectDay" data-day="06/22/2020" class="day">22</td>
                        <td data-action="selectDay" data-day="06/23/2020" class="day">23
                        </td>
                        <td data-action="selectDay" data-day="06/24/2020" class="day">24
                        </td>
                        <td data-action="selectDay" data-day="06/25/2020" class="day">25</td>
                        <td data-action="selectDay" data-day="06/26/2020" class="day">26</td>
                        <td data-action="selectDay" data-day="06/27/2020" class="day active today weekend">27</td>
                      </tr>
                        <tr>
                          <td data-action="selectDay" data-day="06/28/2020" class="day weekend">28</td>
                          <td data-action="selectDay" data-day="06/29/2020" class="day">29</td>
                          <td data-action="selectDay" data-day="06/30/2020" class="day">30</td>
                          <td data-action="selectDay" data-day="07/01/2020" class="day new">1</td>
                          <td data-action="selectDay" data-day="07/02/2020" class="day new">2</td>
                          <td data-action="selectDay" data-day="07/03/2020" class="day new">3</td>
                          <td data-action="selectDay" data-day="07/04/2020" class="day new weekend">4</td>
                        </tr>
                        <tr>
                          <td data-action="selectDay" data-day="07/05/2020" class="day new weekend">5</td>
                            <td data-action="selectDay" data-day="07/06/2020" class="day new">6</td>
                            <td data-action="selectDay" data-day="07/07/2020" class="day new">7</td>
                            <td data-action="selectDay" data-day="07/08/2020" class="day new">8</td>
                            <td data-action="selectDay" data-day="07/09/2020" class="day new">9</td>
                            <td data-action="selectDay" data-day="07/10/2020" class="day new">10</td>
                            <td data-action="selectDay" data-day="07/11/2020" class="day new weekend">11</td>
                          </tr>
                        </tbody>
                      </table>
                    </div>
                    <div class="datepicker-months" style="display: none;">
                              <table class="table-condensed">
                                <thead>
                                <tr>
                              <th class="prev" data-action="previous"><span class="fa fa-chevron-left" title="Previous Year">
                              </span>
                              </th>
                              <th class="picker-switch" data-action="pickerSwitch" colspan="5" title="Select Year">2020</th>
                              <th class="next" data-action="next">
                                <span class="fa fa-chevron-right" title="Next Year">
                              </span>
                            </th>
                          </tr>
                          </thead>
                          <tbody>
                            <tr>
                            <td colspan="7">
                              <span data-action="selectMonth" class="month">Jan</span>
                                <span data-action="selectMonth" class="month">Feb</span>
                                <span data-action="selectMonth" class="month">Mar</span>
                                <span data-action="selectMonth" class="month">Apr</span>
                                <span data-action="selectMonth" class="month">May</span>
                                <span data-action="selectMonth" class="month active">Jun</span>
                                <span data-action="selectMonth" class="month">Jul</span>
                                <span data-action="selectMonth" class="month">Aug</span>
                                <span data-action="selectMonth" class="month">Sep
                                </span>
                                <span data-action="selectMonth" class="month">
                                  Oct
                                </span>
                                <span data-action="selectMonth" class="month">Nov</span><span data-action="selectMonth" class="month">Dec</span>
                              </td>
                            </tr>
                            </tbody>
                          </table>
                            </div><div class="datepicker-years" style="display: none;">
                                  <table class="table-condensed">
                                    <thead>
                                      <tr>
                                  <th class="prev" data-action="previous">
                                  <span class="fa fa-chevron-left" title="Previous Decade">
                                  </span>
                                </th>
                                  <th class="picker-switch" data-action="pickerSwitch" colspan="5" title="Select Decade">2020-2029</th><th class="next" data-action="next"><span class="fa fa-chevron-right" title="Next Decade">
                                  </span>
                                </th>
                                </tr>
                                </thead>
                                  <tbody>
                                    <tr>
                                    <td colspan="7"><span data-action="selectYear" class="year old">2019</span><span data-action="selectYear" class="year active">2020</span><span data-action="selectYear" class="year">2021</span>
                                      <span data-action="selectYear" class="year">2022</span>
                                      <span data-action="selectYear" class="year">2023</span>
                                      <span data-action="selectYear" class="year">2024</span><span data-action="selectYear" class="year">2025</span>
                                      <span data-action="selectYear" class="year">2026</span>
                                      <span data-action="selectYear" class="year">2027</span>
                                      <span data-action="selectYear" class="year">2028</span>
                                      <span data-action="selectYear" class="year">2029</span>
                                      <span data-action="selectYear" class="year old">2030</span>
                                    </td>
                                  </tr>
                                </tbody>
                              </table>
                            </div>
                            <div class="datepicker-decades" style="display: none;">
                              <table class="table-condensed">
                                <thead>
                                  <tr>
                                    <th class="prev" data-action="previous">
                                      <span class="fa fa-chevron-left" title="Previous Century">
                                      </span>
                                    </th>
                                    <th class="picker-switch" data-action="pickerSwitch" colspan="5">2000-2090
                                    </th>
                                    <th class="next" data-action="next">
                                      <span class="fa fa-chevron-right" title="Next Century">
                                      </span>
                                    </th>
                                    </tr>
                                    </thead>
                                    <tbody
                                    ><tr>
                                      <td colspan="7">
                                      <span data-action="selectDecade" class="decade old" data-selection="2006">1990</span>
                                      <span data-action="selectDecade" class="decade" data-selection="2006">2000
                                      </span><span data-action="selectDecade" class="decade active" data-selection="2016">2010</span>
                                      <span data-action="selectDecade" class="decade" data-selection="2026">2020
                                      </span><span data-action="selectDecade" class="decade" data-selection="2036">2030
                                      </span><span data-action="selectDecade" class="decade" data-selection="2046">2040
                                      </span><span data-action="selectDecade" class="decade" data-selection="2056">2050
                                      </span>
                                      <span data-action="selectDecade" class="decade" data-selection="2066">2060
                                      </span>
                                      <span data-action="selectDecade" class="decade" data-selection="2076">2070
                                      </span>
                                      <span data-action="selectDecade" class="decade" data-selection="2086">2080
                                      </span>
                                      <span data-action="selectDecade" class="decade" data-selection="2096">2090
                                      </span>
                                      <span data-action="selectDecade" class="decade old" data-selection="2106">2100
                                      </span>
                                    </td>
                                  </tr>
                                </tbody>
                                    </table>
                                    </div>
                                    </div>
                                  </li>
                                    <li class="picker-switch accordion-toggle">
                                      </li>
                                    </ul>
                                  </div>
                <div id="calendar" style="width: 100%"></div>
              </div>
              <!-- /.card-body -->
            </div>
          </div>
            <!-- /.row -->

            <!-- TABLE: Użytkownicy  z bazy danych -->
            <div class="card">
        </div>
            <div class="col-md-6">
              <!-- LIsta 8 osmiu ostatni dodanych uzytkownkow -->
              <div class="card">
                <div class="card-header">
                  <h3 class="card-title">Użytkownicy</h3>

                  <div class="card-tools">
                    <span class="badge badge-danger">8 ostatnio dodanych </span>
                    <button type="button" class="btn btn-tool" data-card-widget="collapse"><i class="fas fa-minus"></i>
                    </button>
                    <button type="button" class="btn btn-tool" data-card-widget="remove"><i class="fas fa-times"></i>
                    </button>
                  </div>
                </div>
                <!-- /.card-header -->
                <div class="card-body p-0">
                  <ul class="users-list clearfix">

<?php
//pobranie osmiu ostatnich uzytkwnikoew
require_once '../../scripts/connect.php';
$sql = "SELECT * FROM `user` ORDER BY create_user DESC limit 8";
$result = $conn->query($sql);
while($user1 = $result->fetch_assoc()){
  echo <<<USER
        <li>
          <img src="../../dist/img/$user1[avatar]" alt="User Image">
          <a class="users-list-name" href="#">$user1[name]</a>
          <span class="users-list-date">
USER;

//obliczanie ile dnitemu zostalo dodane konto
//dzsiaj, wwczoraj ile dni temu ( do miesiaca) miesiac temu i rok temu

    require_once '../../scripts/function.php';
    $create_user = $user1['create_user'];
    echo countDay($create_user);




  echo <<<USER
          </span>
        </li>
USER;
}
?>


                  </ul>
                  <!-- /.users-list -->
                </div>
                <!-- /.card-body -->
                <div class="card-footer text-center">
                  <a href="alllist.php">Wszyscy Użytkownicy</a>
                </div>
                <!-- /.card-footer -->
              </div>


              <!--/.card -->
            </div>

            <!-- /.card -->

          </div>
          <!-- /.col (LEFT) -->
          <div class="col-md-6">
            <!-- LINE CHART -->

            <canvas id="bar-chart" width="800" height="450"></canvas>



            <!-- /.card -->

            <!-- BAR CHART -->

            <!-- /.card -->

            <!-- STACKED BAR CHART -->

            <!-- /.card -->

          </div>
          <div class="col-md-6">
            <canvas id="doughnut-chart" width="800" height="450"></canvas>

          </div>


          <div class="col-md-6">
            <div id="chart-container">
                <canvas id="graphCanvas"></canvas>
            </div>

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
<script src="plugins/jquery/jquery.min.js"></script>
<!-- jQuery UI 1.11.4 -->
<script src="plugins/jquery-ui/jquery-ui.min.js"></script>
<!-- Resolve conflict in jQuery UI tooltip with Bootstrap tooltip -->
<script>
  $.widget.bridge('uibutton', $.ui.button)
</script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.5.0/Chart.min.js"></script>
<!-- Bootstrap 4 -->
<script src="plugins/bootstrap/js/bootstrap.bundle.min.js"></script>

<!-- ChartJS -->
<script src="plugins/chart.js/Chart.min.js"></script>
<!-- Sparkline -->
<script src="plugins/sparklines/sparkline.js"></script>
<!-- JQVMap -->
<script src="plugins/jqvmap/jquery.vmap.min.js"></script>
<script src="plugins/jqvmap/maps/jquery.vmap.usa.js"></script>
<!-- jQuery Knob Chart -->
<script src="plugins/jquery-knob/jquery.knob.min.js"></script>
<!-- daterangepicker -->
<script src="plugins/moment/moment.min.js"></script>
<script src="plugins/daterangepicker/daterangepicker.js"></script>
<!-- Tempusdominus Bootstrap 4 -->
<script src="plugins/tempusdominus-bootstrap-4/js/tempusdominus-bootstrap-4.min.js"></script>
<!-- Summernote -->
<script src="plugins/summernote/summernote-bs4.min.js"></script>
<!-- overlayScrollbars -->
<script src="plugins/overlayScrollbars/js/jquery.overlayScrollbars.min.js"></script>
<!-- AdminLTE App -->
<script src="dist/js/adminlte.js"></script>
<!-- AdminLTE dashboard demo (This is only for demo purposes) -->
<script src="dist/js/pages/dashboard.js"></script>
<!-- AdminLTE for demo purposes -->
<script src="dist/js/demo.js"></script>
<script>

  new Chart(document.getElementById("bar-chart"), {
      type: 'bar',
      data: {
        labels: ["Admin", "User", "Mod", "Ban"],
        datasets: [
          {
            label: "Ilość",
            backgroundColor: ["#17a2b8", "#28a745","#ffc107","#dc3545",],
            data: [<?php echo $tab[0]?>,<?php echo $tab[1]?>,<?php echo $tab[2]?>,<?php echo $blocked?>]
          }
        ]
      },
      options: {
        legend: { display: false },
        title: {
          display: true,
          text: 'ilość użytkowników'
        }
      }
  });
  </script>
  <script>
  new Chart(document.getElementById("doughnut-chart"), {
    type: 'doughnut',
    data: {
      labels: ["Admin", "User", "Mod", "Ban"],
      datasets: [
        {
          label: "Population (millions)",
          backgroundColor: ["#17a2b8", "#28a745","#ffc107","#dc3545",],
          data: [<?php echo $tab[0]?>,<?php echo $tab[1]?>,<?php echo $tab[2]?>,<?php echo $blocked?>]
        }
      ]
    },
    options: {
      title: {
        display: true,
        text: 'stosunek ilosci uzytkownikow'
      }
    }
});

  </script>
  <script type="text/javascript">
  $(document).ready(function () {
      showGraph();
  });


  function showGraph()
  {
      {
          $.post("data.php",
          function (data)
          {
              console.log(data);
               var name = [];
              var marks = [];

              for (var i in data) {
                  name.push(data[i].student_name);
                  marks.push(data[i].marks);
              }

              var chartdata = {
                  labels: name,
                  datasets: [
                      {
                          label: 'Student Marks',
                          backgroundColor: '#49e2ff',
                          borderColor: '#46d5f1',
                          hoverBackgroundColor: '#CCCCCC',
                          hoverBorderColor: '#666666',
                          data: marks
                      }
                  ]
              };

              var graphTarget = $("#graphCanvas");

              var barGraph = new Chart(graphTarget, {
                  type: 'bar',
                  data: chartdata
              });
          });
      }
  }

  </script>


</body>
</html>
