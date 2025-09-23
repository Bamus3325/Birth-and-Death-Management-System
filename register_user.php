<?php
require ('lib/header.php');
require ('lib/sidebar.php');
if ($_SERVER['REQUEST_METHOD'] == "POST" && isset($_POST['register'])) {
  // code...
  $set = '0123456789123456789';
  $sett = '0123456789123456789';
  $code = substr(str_shuffle($set), 0, 7);
  $cde = substr(str_shuffle($sett), 0, 1);
  $nin = htmlentities($_POST['nin']) ?? null;
  $fnam = htmlentities($_POST['fnam']);
  $mnam = htmlentities($_POST['mnam']);
  $lnam = htmlentities($_POST['lnam']);
  $dob = htmlentities($_POST['dob']);
  $gender = htmlentities($_POST['gender']);
  $state = htmlentities($_POST['state']);
  $city = htmlentities($_POST['city']);
  $lga = htmlentities($_POST['lga']);
  $pob = htmlentities($_POST['pob']);
  $fnin = htmlentities($_POST['fnin']);
  $mnin = htmlentities($_POST['mnin']);
  $fetch = $con->prepare("SELECT * FROM ng_states WHERE id = :state");
  $fetch->bindParam(':state', $state, PDO::PARAM_STR);
  $fetch->execute();
  $abb = $fetch->fetch(PDO::FETCH_OBJ);
  if ($fetch->rowCount() > 0) {
    // code...
    $birth_id = $abb->abbr . $cde . '_' . $code;
    $sql = $con->prepare("SELECT * FROM biodata WHERE user = :birth_id OR nin = :nin");
    $sql->bindParam(':birth_id', $birth_id, PDO::PARAM_STR);
    $sql->bindParam(':nin', $nin, PDO::PARAM_STR);
    $sql->execute();
    $sql->fetch(PDO::FETCH_OBJ);
    if ($sql->rowCount() > 0) {
      $msg = '<div class="alert alert-danger left-icon-alert" role="alert">
            <strong>Oh snap!</strong> User already exist, please try again.
          </div>';
    } else {
      $query = $con->prepare("INSERT INTO biodata (nin, user, fnam, mnam, lnam, dob, gender, state, city, lga, pob, fnin, mnin) VALUES (:nin, :birth_id, :fnam, :mnam, :lnam, :dob, :gender, :state, :city, :lga, :pob, :fnin, :mnin)");
      $query->bindParam(':nin', $nin, PDO::PARAM_STR);
      $query->bindParam(':birth_id', $birth_id, PDO::PARAM_STR);
      $query->bindParam(':fnam', $fnam, PDO::PARAM_STR);
      $query->bindParam(':mnam', $mnam, PDO::PARAM_STR);
      $query->bindParam(':lnam', $lnam, PDO::PARAM_STR);
      $query->bindParam(':dob', $dob, PDO::PARAM_STR);
      $query->bindParam(':gender', $gender, PDO::PARAM_STR);
      $query->bindParam(':state', $state, PDO::PARAM_STR);
      $query->bindParam(':city', $city, PDO::PARAM_STR);
      $query->bindParam(':lga', $lga, PDO::PARAM_STR);
      $query->bindParam(':pob', $pob, PDO::PARAM_STR);
      $query->bindParam(':fnin', $fnin, PDO::PARAM_STR);
      $query->bindParam(':mnin', $mnin, PDO::PARAM_STR);
      $query->execute();
      if ($con->lastInsertId()) {
        // $msg = "<div class=\"alert alert-success left-icon-alert\" role=\"alert\">
        //           <strong>Well done!</strong> Registration successful
        //         </div>";
        echo "<script> alert('Well done!✅✅ Registration successful'); window.location='users'; </script>";
      } else {
        $msg = '<div class="alert alert-danger left-icon-alert" role="alert">
                <strong>Oh snap!</strong> Something went wrong, please try again
              </div>';
      }
    }
  } else {
    $msg = '<div class="alert alert-danger left-icon-alert" role="alert">
                  <strong>Oh snap!</strong> Something went wrong, please try again
                </div>';
  }
}
?>
<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1>Birth Registration</h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="dashboard">Home</a></li>
                        <li class="breadcrumb-item active">Birth</li>
                    </ol>
                </div>
            </div>
        </div><!-- /.container-fluid -->
    </section>

    <!-- Main content -->
    <section class="content">
        <div class="container-fluid">
            <div class="row">
                <!-- left column -->
                <div class="col-md-12">
                    <!-- jquery validation -->
                    <?= $msg ?? ''; ?>
                    <div class="card card-primary">
                        <div class="card-header">
                            <h3 class="card-title">Add new record</h3>
                        </div>
                        <!-- /.card-header -->
                        <!-- form start -->
                        <form id="quickForm" method="POST" action="<?php $_SERVER['PHP_SELF']; ?>">
                            <div class="card-body">
                                <div class="row">
                                    <div class="form-group col-12">
                                        <label>NIN</label>
                                        <input type="text" name="nin" class="form-control"
                                            onkeyup="GetDetail(this.value)" placeholder="Enter NIN" required>
                                    </div>
                                    <div class="form-group col-4">
                                        <label>Firstname</label>
                                        <input type="text" name="fnam" readonly class="form-control" id="first_name"
                                            placeholder="Enter Firstname" required>
                                    </div>
                                    <div class="form-group col-4">
                                        <label>Middlename</label>
                                        <input type="text" name="mnam" readonly class="form-control" id="middle_name"
                                            placeholder="Enter Middlename" required>
                                    </div>
                                    <div class="form-group col-4">
                                        <label>Lastname</label>
                                        <input type="text" name="lnam" readonly class="form-control" id="last_name"
                                            placeholder="Enter Lastname" required>
                                    </div>
                                    <div class="form-group col-6">
                                        <label>Date of Birth</label>
                                        <input type="date" class="form-control" name="dob" id="dob" required readonly>
                                    </div>
                                    <div class="form-group col-6">
                                        <label>Gender</label>
                                        <select class="form-control select2" style="width: 100%;" name="gender"
                                            required>
                                            <option disabled selected="selected">Select</option>
                                            <option value="1">Male</option>
                                            <option value="0">Female</option>
                                        </select>
                                    </div>
                                    <div class="form-group col-3">
                                        <label>State</label>
                                        <select class="form-control select2" style="width: 100%;" name="state"
                                            id="state" required>
                                            <option disabled selected="selected">Select State</option>
                                            <?php
                      $sql = $con->prepare("SELECT * FROM ng_states ORDER BY state_name");
                      $sql->execute();
                      $results = $sql->fetchAll(PDO::FETCH_OBJ);
                      if ($sql->rowCount() > 0) {
                        foreach ($results as $result) {
                          ?>
                                            <option value="<?php echo ($result->id); ?>">
                                                <?php echo ($result->state_name); ?></option>
                                            <?php
                        }
                      } else {
                        ?>
                                            <option selected="selected" disabled>No record</option>
                                            <?php
                      }
                      ?>
                                        </select>
                                    </div>
                                    <div class="form-group col-3">
                                        <label>L.G.A</label>
                                        <select class="form-control select2" style="width: 100%;" name="lga" id="lga"
                                            required>
                                            <option disabled selected="selected">Select State First</option>
                                        </select>
                                    </div>
                                    <div class="form-group col-3">
                                        <label>City/Town</label>
                                        <input type="text" name="city" class="form-control"
                                            placeholder="Enter City/Town" required>
                                    </div>
                                    <div class="form-group col-3">
                                        <label>Place of Birth</label>
                                        <input type="text" class="form-control" name="pob"
                                            placeholder="Enter Place of Birth" required>
                                    </div>
                                    <div class="form-group col-6">
                                        <label>Father's NIN</label>
                                        <input type="text" name="fnin" class="form-control"
                                            placeholder="Enter Father's NIN" onkeyup="GetDetail2(this.value)" required>
                                    </div>
                                    <div class="form-group col-6">
                                        <label>Mother's NIN</label>
                                        <input type="text" class="form-control" name="mnin"
                                            placeholder="Enter Mother's NIN" onkeyup="GetDetail3(this.value)" required>
                                    </div>
                                    <!-- <div class="form-group col-6">
                    <label>Father's Fullname</label>
                    <input type="text" class="form-control" name="ffnam" id="father_name" readonly placeholder="Enter Father's Fullname">
                  </div>
                  <div class="form-group col-6">
                    <label>Mother's Fullname</label>
                    <input type="text" class="form-control" name="mfnam" id="mother_name" readonly placeholder="Enter Mother's Fullname">
                  </div> -->
                                    <div class="form-group mb-0">
                                        <div class="custom-control custom-checkbox">
                                            <input type="checkbox" name="terms" class="custom-control-input"
                                                id="exampleCheck1" required>
                                            <label class="custom-control-label" for="exampleCheck1">I enter user details
                                                <a href="#">correctly</a>.</label>
                                        </div>
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
                    <!-- /.card -->
                </div>
                <!--/.col (left) -->
                <!-- right column -->
                <div class="col-md-6">

                </div>
                <!--/.col (right) -->
            </div>
            <!-- /.row -->
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

<!-- jQuery -->
<script src="plugins/jquery/jquery.min.js"></script>
<!-- Bootstrap 4 -->
<script src="plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
<!-- Select2 -->
<script src="plugins/select2/js/select2.full.min.js"></script>
<!-- Bootstrap4 Duallistbox -->
<script src="plugins/bootstrap4-duallistbox/jquery.bootstrap-duallistbox.min.js"></script>
<!-- InputMask -->
<script src="plugins/moment/moment.min.js"></script>
<script src="plugins/inputmask/jquery.inputmask.min.js"></script>
<!-- date-range-picker -->
<script src="plugins/daterangepicker/daterangepicker.js"></script>
<!-- bootstrap color picker -->
<script src="plugins/bootstrap-colorpicker/js/bootstrap-colorpicker.min.js"></script>
<!-- Tempusdominus Bootstrap 4 -->
<script src="plugins/tempusdominus-bootstrap-4/js/tempusdominus-bootstrap-4.min.js"></script>
<!-- Bootstrap Switch -->
<script src="plugins/bootstrap-switch/js/bootstrap-switch.min.js"></script>
<!-- BS-Stepper -->
<script src="plugins/bs-stepper/js/bs-stepper.min.js"></script>
<!-- dropzonejs -->
<script src="plugins/dropzone/min/dropzone.min.js"></script>
<!-- AdminLTE App -->
<script src="dist/js/adminlte.min.js"></script>
<!-- AdminLTE for demo purposes -->
<script src="dist/js/demo.js"></script>
<!-- Page specific script -->
<script>
// onkeyup event will occur when the user 
// release the key and calls the function
// assigned to this event
function GetDetail(str) {
    if (str.length == 0) {
        document.getElementById("first_name").value = "";
        document.getElementById("middle_name").value = "";
        document.getElementById("last_name").value = "";
        document.getElementById("dob").value = "";
        return;
    } else {

        // Creates a new XMLHttpRequest object
        var xmlhttp = new XMLHttpRequest();
        xmlhttp.onreadystatechange = function() {

            // Defines a function to be called when
            // the readyState property changes
            if (this.readyState == 4 &&
                this.status == 200) {

                // Typical action to be performed
                // when the document is ready
                var myObj = JSON.parse(this.responseText);

                // Returns the response data as a
                // string and store this array in
                // a variable assign the value 
                // received to first name input field

                document.getElementById(
                    "first_name").value = myObj[0];

                // Assign the value received to
                // last name input field
                document.getElementById(
                    "middle_name").value = myObj[1];
                document.getElementById(
                    "last_name").value = myObj[2];
                document.getElementById(
                    "dob").value = myObj[3];
            }
        };

        // xhttp.open("GET", "filename", true);
        xmlhttp.open("GET", "get_user.php?user_id=" + str, true);

        // Sends the request to the server
        xmlhttp.send();
    }
}

function GetDetail2(str) {
    if (str.length == 0) {
        document.getElementById("father_name").value = "";
        return;
    } else {

        // Creates a new XMLHttpRequest object
        var xmlhttp = new XMLHttpRequest();
        xmlhttp.onreadystatechange = function() {

            // Defines a function to be called when
            // the readyState property changes
            if (this.readyState == 4 &&
                this.status == 200) {

                // Typical action to be performed
                // when the document is ready
                var myObj = JSON.parse(this.responseText);

                // Returns the response data as a
                // string and store this array in
                // a variable assign the value 
                // received to first name input field

                document.getElementById(
                    "father_name").value = myObj[0] + " " + myObj[1] + " " + myObj[2];
            }
        };

        // xhttp.open("GET", "filename", true);
        xmlhttp.open("GET", "get_user2.php?user_id=" + str, true);

        // Sends the request to the server
        xmlhttp.send();
    }
}

function GetDetail3(str) {
    if (str.length == 0) {
        document.getElementById("mother_name").value = "";
        return;
    } else {

        // Creates a new XMLHttpRequest object
        var xmlhttp = new XMLHttpRequest();
        xmlhttp.onreadystatechange = function() {

            // Defines a function to be called when
            // the readyState property changes
            if (this.readyState == 4 &&
                this.status == 200) {

                // Typical action to be performed
                // when the document is ready
                var myObj = JSON.parse(this.responseText);

                // Returns the response data as a
                // string and store this array in
                // a variable assign the value 
                // received to first name input field

                document.getElementById(
                    "mother_name").value = myObj[0] + " " + myObj[1] + " " + myObj[2];
            }
        };

        // xhttp.open("GET", "filename", true);
        xmlhttp.open("GET", "get_user2.php?user_id=" + str, true);

        // Sends the request to the server
        xmlhttp.send();
    }
}
</script>
<script type="text/javascript">
$(document).ready(function() {
    $('#state').on('change', function() {
        var state = this.value;
        $.ajax({
            url: "./lga.php",
            type: "POST",
            data: {
                state: state
            },
            cache: false,
            success: function(result) {
                $("#lga").html(result);
            }
        });
    });
});
</script>
<script>
$(function() {
    //Initialize Select2 Elements
    $('.select2').select2()

    //Initialize Select2 Elements
    $('.select2bs4').select2({
        theme: 'bootstrap4'
    })

    //Datemask dd/mm/yyyy
    $('#datemask').inputmask('dd/mm/yyyy', {
        'placeholder': 'dd/mm/yyyy'
    })
    //Datemask2 mm/dd/yyyy
    $('#datemask2').inputmask('mm/dd/yyyy', {
        'placeholder': 'mm/dd/yyyy'
    })
    //Money Euro
    $('[data-mask]').inputmask()

    //Date picker
    $('#reservationdate').datetimepicker({
        format: 'L'
    });

    //Date and time picker
    $('#reservationdatetime').datetimepicker({
        icons: {
            time: 'far fa-clock'
        }
    });

    //Date range picker
    $('#reservation').daterangepicker()
    //Date range picker with time picker
    $('#reservationtime').daterangepicker({
        timePicker: true,
        timePickerIncrement: 30,
        locale: {
            format: 'MM/DD/YYYY hh:mm A'
        }
    })
    //Date range as a button
    $('#daterange-btn').daterangepicker({
            ranges: {
                'Today': [moment(), moment()],
                'Yesterday': [moment().subtract(1, 'days'), moment().subtract(1, 'days')],
                'Last 7 Days': [moment().subtract(6, 'days'), moment()],
                'Last 30 Days': [moment().subtract(29, 'days'), moment()],
                'This Month': [moment().startOf('month'), moment().endOf('month')],
                'Last Month': [moment().subtract(1, 'month').startOf('month'), moment().subtract(1, 'month')
                    .endOf('month')
                ]
            },
            startDate: moment().subtract(29, 'days'),
            endDate: moment()
        },
        function(start, end) {
            $('#reportrange span').html(start.format('MMMM D, YYYY') + ' - ' + end.format('MMMM D, YYYY'))
        }
    )

    //Timepicker
    $('#timepicker').datetimepicker({
        format: 'LT'
    })

    //Bootstrap Duallistbox
    $('.duallistbox').bootstrapDualListbox()

    //Colorpicker
    $('.my-colorpicker1').colorpicker()
    //color picker with addon
    $('.my-colorpicker2').colorpicker()

    $('.my-colorpicker2').on('colorpickerChange', function(event) {
        $('.my-colorpicker2 .fa-square').css('color', event.color.toString());
    })

    $("input[data-bootstrap-switch]").each(function() {
        $(this).bootstrapSwitch('state', $(this).prop('checked'));
    })

})
// BS-Stepper Init
document.addEventListener('DOMContentLoaded', function() {
    window.stepper = new Stepper(document.querySelector('.bs-stepper'))
})

// DropzoneJS Demo Code Start
Dropzone.autoDiscover = false

// Get the template HTML and remove it from the doumenthe template HTML and remove it from the doument
var previewNode = document.querySelector("#template")
previewNode.id = ""
var previewTemplate = previewNode.parentNode.innerHTML
previewNode.parentNode.removeChild(previewNode)

var myDropzone = new Dropzone(document.body, { // Make the whole body a dropzone
    url: "/target-url", // Set the url
    thumbnailWidth: 80,
    thumbnailHeight: 80,
    parallelUploads: 20,
    previewTemplate: previewTemplate,
    autoQueue: false, // Make sure the files aren't queued until manually added
    previewsContainer: "#previews", // Define the container to display the previews
    clickable: ".fileinput-button" // Define the element that should be used as click trigger to select files.
})

myDropzone.on("addedfile", function(file) {
    // Hookup the start button
    file.previewElement.querySelector(".start").onclick = function() {
        myDropzone.enqueueFile(file)
    }
})

// Update the total progress bar
myDropzone.on("totaluploadprogress", function(progress) {
    document.querySelector("#total-progress .progress-bar").style.width = progress + "%"
})

myDropzone.on("sending", function(file) {
    // Show the total progress bar when upload starts
    document.querySelector("#total-progress").style.opacity = "1"
    // And disable the start button
    file.previewElement.querySelector(".start").setAttribute("disabled", "disabled")
})

// Hide the total progress bar when nothing's uploading anymore
myDropzone.on("queuecomplete", function(progress) {
    document.querySelector("#total-progress").style.opacity = "0"
})

// Setup the buttons for all transfers
// The "add files" button doesn't need to be setup because the config
// `clickable` has already been specified.
document.querySelector("#actions .start").onclick = function() {
    myDropzone.enqueueFiles(myDropzone.getFilesWithStatus(Dropzone.ADDED))
}
document.querySelector("#actions .cancel").onclick = function() {
    myDropzone.removeAllFiles(true)
}
// DropzoneJS Demo Code End
</script>
</body>

</html>