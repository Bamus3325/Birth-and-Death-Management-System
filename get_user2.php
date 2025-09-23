
<?php
  
// Get the user id 
$user_id = $_REQUEST['user_id'];
  
// Database connection
$con = mysqli_connect("localhost", "root", "", "birth");

if ($user_id !== "") {
      
    // Get corresponding first name and 
    // last name for that user id    
    $query = mysqli_query($con, "SELECT * FROM nin WHERE nin_number='$user_id'");
  
    $row = mysqli_fetch_array($query);
  
    // Get the first name
    $first_name = $row["fi_name"];

  // Get the middle name
    $middle_name = $row["mi_name"];
  
    // Get the first name
    $last_name = $row["la_name"];
}
  
// Store it in a array
$result = array("$first_name", "$middle_name", "$last_name", "$dob");
  
// Send in JSON encoded form
$myJSON = json_encode($result);
echo $myJSON;
?>