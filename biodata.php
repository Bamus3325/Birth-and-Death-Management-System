<!DOCTYP<?php
require('lib/header.php');
require('lib/sidebar.php');
?>
  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1>Deaths</h1>
          </div>
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="#">Home</a></li>
              <li class="breadcrumb-item active">Deaths</li>
            </ol>
          </div>
        </div>
      </div><!-- /.container-fluid -->
    </section>

    <!-- Main content -->
    <section class="content">
      <div class="container-fluid">
        <div class="row">
          <div class="col-12">

            <div class="card">
              <div class="card-header">
                <h3 class="card-title">All Registered Deaths</h3>
                <a href="declare" class="btn btn-success float-right">Add new record</a>
              </div>
              <!-- /.card-header -->
              <div class="card-body">
                <?php
              if (isset($_POST['fetch'])) {
                $strt = htmlentities($_POST['from']);
                $stp = htmlentities($_POST['to']);
                // code...
                $sql = $con->prepare("SELECT * FROM biodata WHERE reg_date >= :strt AND reg_date WHERE status = 0 <= :stp ORDER BY reg_date DESC");
                $sql->bindParam(":strt", $strt, PDO::PARAM_STR);
                $sql->bindParam(":stp", $stp, PDO::PARAM_STR);
              }
              else {
                  $sql = $con->prepare("SELECT * FROM biodata WHERE status = 0 ORDER BY reg_date DESC");
              }
              $sql->execute();
              $results = $sql->fetchAll(PDO::FETCH_OBJ);
              if ($sql->rowCount() > 0) {

              ?>
                <table id="example1" class="table table-bordered table-striped">
                  <thead>
                  <tr>
                    <th>Fullname</th>
                    <th>Birth ID</th>
                    <th>Gender</th>
                    <th>Reg. Date</th>
                    <!-- <th>Action</th> -->
                  </tr>
                  </thead>
                  <tbody>
                    <?php
                    foreach ($results as $result) {
                    $reg_date = date("M d, Y", strtotime($result->reg_date));
                    $dob = date("M d, Y", strtotime($result->dob));
                    if ($result->gender == 0) {
                      $gender = 'Female';
                    }
                    else {
                      $gender = 'Male';
                    }
                    $user = $result->user;
                    $user = encrypt_decrypt($user, 'encrypt');
                    ?>
                  <tr>
                    <td><?= $result->fnam . ' ' . $result->lnam ?? ''; ?></td>
                    <td><?= $result->user ?? ''; ?></td>
                    <td><?= $gender ?? ''; ?></td>
                    <td><?= $reg_date ?? ''; ?></td>
                    <!-- <td>
                      <a href="" class="badge badge-primary"><i class="fas fa-folder"></i> View </a>
                      <a href="" class="badge badge-secondary"><i class="fas fa-edit"></i> Edit </a>
                      <a href="delete_user?biodata=<?= $user ?? ''; ?>" class="badge badge-danger"><i class="fas fa-trash"></i> Delete </a>
                    </td> -->
                  </tr>
                  <?php
                  }
                  ?>
                  </tbody>
                  <tfoot>
                  <tr>
                    <th>Fullname</th>
                    <th>Birth ID</th>
                    <th>Gender</th>
                    <th>Reg. Date</th>
                    <!-- <th>Action</th> -->
                  </tr>
                  </tfoot>
                </table>
                <?php
              }
              else {
                echo "<p>No record found</p>";
              }
              ?>
              </div>
              <!-- /.card-body -->
            </div>
            <!-- /.card -->
          </div>
          <!-- /.col -->
        </div>
        <!-- /.row -->
      </div>
      <!-- /.container-fluid -->
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

<!-- jQuery -->
<script src="plugins/jquery/jquery.min.js"></script>
<!-- Bootstrap 4 -->
<script src="plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
<!-- DataTables  & Plugins -->
<script src="plugins/datatables/jquery.dataTables.min.js"></script>
<script src="plugins/datatables-bs4/js/dataTables.bootstrap4.min.js"></script>
<script src="plugins/datatables-responsive/js/dataTables.responsive.min.js"></script>
<script src="plugins/datatables-responsive/js/responsive.bootstrap4.min.js"></script>
<script src="plugins/datatables-buttons/js/dataTables.buttons.min.js"></script>
<script src="plugins/datatables-buttons/js/buttons.bootstrap4.min.js"></script>
<script src="plugins/jszip/jszip.min.js"></script>
<script src="plugins/pdfmake/pdfmake.min.js"></script>
<script src="plugins/pdfmake/vfs_fonts.js"></script>
<script src="plugins/datatables-buttons/js/buttons.html5.min.js"></script>
<script src="plugins/datatables-buttons/js/buttons.print.min.js"></script>
<script src="plugins/datatables-buttons/js/buttons.colVis.min.js"></script>
<!-- AdminLTE App -->
<script src="dist/js/adminlte.min.js"></script>
<!-- AdminLTE for demo purposes -->
<script src="dist/js/demo.js"></script>
<!-- Page specific script -->
<script>
  $(function () {
    $("#example1").DataTable({
      "responsive": true, "lengthChange": false, "autoWidth": false,
      "buttons": ["copy", "csv", "excel", "pdf"]
    }).buttons().container().appendTo('#example1_wrapper .col-md-6:eq(0)');
    $('#example2').DataTable({
      "paging": true,
      "lengthChange": false,
      "searching": false,
      "ordering": true,
      "info": true,
      "autoWidth": false,
      "responsive": true,
    });
  });
</script>
</body>
</html>
