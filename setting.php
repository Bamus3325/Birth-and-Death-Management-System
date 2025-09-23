<?php
require ('lib/header.php');
require ('lib/sidebar.php');
?>
<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
  <!-- Content Header (Page header) -->
  <div class="content-header">
    <div class="container-fluid">
      <div class="row mb-2">
        <div class="col-sm-6">
          <h1 class="m-0">Edit your Profile</h1>
        </div><!-- /.col -->
        <div class="col-sm-6">
          <ol class="breadcrumb float-sm-right">
            <li class="breadcrumb-item"><a href="#">Home</a></li>
            <li class="breadcrumb-item active">Setting</li>
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

      <!-- Main row -->
      <div class="row">
        <!-- Left col -->
        <section class="col-lg-12 connectedSortable">
          <!-- Custom tabs (Charts with tabs)-->
          <div class="card">
            <div class="card card-primary">
              <div class="card-header">
                <h3 class="card-title">Update your details</h3>
              </div>
              <!-- /.card-header -->
              <!-- form start -->
              <form id="quickForm" method="POST" action="<?php $_SERVER['PHP_SELF']; ?>">
                <div class="card-body">
                  <div class="row">
                    <div class="form-group col-12">
                      <label>Lastname</label>
                      <input type="text" name="nin" class="form-control">
                    </div>
                    <div class="form-group col-12">
                      <label>Firstname</label>
                      <input type="text" name="nin" class="form-control">
                    </div>
                    <div class="form-group col-12">
                      <label>Email</label>
                      <input type="text" name="nin" class="form-control">
                    </div>
                  </div>
                </div>
                <!-- /.card-body -->
                <div class="card-footer">
                  <button type="submit" name="register" class="btn btn-primary">Submit</button>
                  <button type="reset" class="btn btn-secondary">Clear</button>
                </div>
              </form>
            </div>
          </div>

          <div class="card">
            <div class="card card-primary">
              <div class="card-header">
                <h3 class="card-title">Update your Password</h3>
              </div>
              <!-- /.card-header -->
              <!-- form start -->
              <form id="quickForm" method="POST" action="">
                <div class="card-body">
                  <div class="row">
                    <div class="form-group col-12">
                      <label>Old Password</label>
                      <input type="password" name="nin" class="form-control">
                    </div>
                    <div class="form-group col-12">
                      <label>New Password</label>
                      <input type="password" name="nin" class="form-control">
                    </div>
                    <div class="form-group col-12">
                      <label>Confirm Password</label>
                      <input type="password" name="nin" class="form-control">
                    </div>
                  </div>
                </div>
                <!-- /.card-body -->
                <div class="card-footer">
                  <button type="submit" name="register" class="btn btn-primary">Submit</button>
                  <button type="reset" class="btn btn-secondary">Clear</button>
                </div>
              </form>
            </div>
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
<?php require ('lib/footer.php'); ?>
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