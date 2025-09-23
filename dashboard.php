<?php
require('lib/header.php');
require('lib/sidebar.php');
?>
  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <div class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1 class="m-0">Dashboard</h1>
          </div><!-- /.col -->
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="#">Home</a></li>
              <li class="breadcrumb-item active">Dashboard</li>
            </ol>
          </div><!-- /.col -->
        </div><!-- /.row -->
      </div><!-- /.container-fluid -->
    </div>
    <!-- /.content-header -->

    <!-- Main content -->
    <section class="content">
      <div class="container-fluid">
        <!-- Small boxes (Stat box) -->
        <div class="row">
          <div class="col-lg-6 col-12">
            <!-- small box -->
            <div class="small-box bg-success">
              <div class="inner">
                <?php
                $sql = $con->prepare("SELECT * FROM biodata WHERE status = 1");
                $sql->execute();
                $results = $sql->fetchAll(PDO::FETCH_OBJ);
                ?>
                <h3><?= $sql->rowCount() ?? "NaN"; ?></h3>

                <p>Birth</p>
              </div>
              <div class="icon">
                <i class="ion ion-person-add"></i>
              </div>
              <a href="users" class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a>
            </div>
          </div>
          <!-- ./col -->
          <div class="col-lg-6 col-12">
            <!-- small box -->
            <div class="small-box bg-danger">
              <div class="inner">
                <?php
                $sql = $con->prepare("SELECT * FROM biodata WHERE status = 0");
                $sql->execute();
                $results = $sql->fetchAll(PDO::FETCH_OBJ);
                ?>
                <h3><?= $sql->rowCount() ?? "NaN"; ?></h3>

                <p>Death</p>
              </div>
              <div class="icon">
                <i class="ion ion-person"></i>
              </div>
              <a href="biodata" class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a>
            </div>
          </div>
          <!-- ./col -->
        </div>
        <!-- /.row -->
        <?php
          $sql = $con->prepare("SELECT DATE_FORMAT(reg_date, '%b %Y') as month_year, SUM(CASE WHEN status = 1 THEN 1 ELSE 0 END) as birth, SUM(CASE WHEN status = 0 THEN 1 ELSE 0 END) as death FROM biodata WHERE reg_date >= DATE_SUB(NOW(), INTERVAL 12 MONTH) GROUP BY MONTH(reg_date), YEAR(reg_date) ORDER BY reg_date ASC");
        $sql->execute();
        $monthsYears = array();
          $birthCounts = array();
          $deathCounts = array();

        while ($row = $sql->fetch(PDO::FETCH_ASSOC)) {
              $monthsYears[] = $row['month_year'];
              $birthCounts[] = intval($row['birth']);
              $deathCounts[] = intval($row['death']);
          }
          // $dates = json_encode($dates);
          // $values = json_encode($values);
        ?>
        <!-- Main row -->
        <div class="row">
          <!-- Left col -->
          <section class="col-lg-12 connectedSortable">
            <!-- Custom tabs (Charts with tabs)-->
            <div class="card">
              <div class="card-header">
              <div class="card-body">
                <div class="tab-content p-0">
                  <!-- Morris chart - Sales -->
                  <div id="chartContainer"></div>
                </div>
              </div><!-- /.card-body -->
            </div>
            <!-- /.card -->

          </section>
          <!-- /.Left col -->

        </div>
        <!-- /.row (main row) -->
      </div><!-- /.container-fluid -->
    </section>
    <!-- /.content -->
  </div>
  <!-- /.content-wrapper -->
<?php require('lib/footer.php'); ?>
  <!-- Control Sidebar -->
  <aside class="control-sidebar control-sidebar-dark">
    <!-- Control sidebar content goes here -->
  </aside>
  <!-- /.control-sidebar -->
</div>
<!-- ./wrapper -->
<script>
    // Convert PHP arrays to JavaScript arrays
    var monthsYears = <?php echo json_encode($monthsYears); ?>;
    var birthCounts = <?php echo json_encode($birthCounts); ?>;
    var deathCounts = <?php echo json_encode($deathCounts); ?>;
    
    // Create the chart
    Highcharts.chart('chartContainer', {
        chart: {
            type: 'column'
        },
        title: {
            text: 'All Records (Last 12 Months)'
        },
        xAxis: {
            categories: monthsYears,
            title: {
                text: 'Month'
            }
        },
        yAxis: {
          floor: 0, // Start the y-axis from zero
            title: {
                text: 'Count'
            }
        },
        tooltip: {
            valueDecimals: 0 // Remove decimal places from tooltip values
        },
        series: [{
            name: 'Birth',
            data: birthCounts
        }, {
            name: 'Death',
            data: deathCounts
        }]
    });
</script>
<!-- jQuery -->
<script src="plugins/jquery/jquery.min.js"></script>
<!-- jQuery UI 1.11.4 -->
<script src="plugins/jquery-ui/jquery-ui.min.js"></script>
<!-- Resolve conflict in jQuery UI tooltip with Bootstrap tooltip -->
<script>
  $.widget.bridge('uibutton', $.ui.button)
</script>
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
<!-- AdminLTE for demo purposes -->
<script src="dist/js/demo.js"></script>
<!-- AdminLTE dashboard demo (This is only for demo purposes) -->
<script src="dist/js/pages/dashboard.js"></script>
</body>
</html>
