<?php

include("_includes/config.inc");
include("_includes/dbconnect.inc");
include("_includes/functions.inc");


// check logged in
if (isset($_SESSION['id'])) {

   echo template("templates/partials/header.php");
   echo template("templates/partials/nav.php");

   // If a module has been selected
   if (isset($_POST['selmodule'])) {
      $sql = "insert into studentmodules values ('" .  $_SESSION['id'] . "','" . $_POST['selmodule'] . "');";
      $result = mysqli_query($conn, $sql);
      $data['content'] .= "<p>The module " . $_POST['selmodule'] . " has been assigned to you</p>";
   }
   else  // If a module has not been selected
   {

     // Build sql statment that selects all the modules
     $sql = "select * from module";
     $result = mysqli_query($conn, $sql);

     $data['content'] .= "<form class='row g-3 m-3 ms-0 form border' name='frmassignmodule' action='' method='post' >";
     $data['content'] .= "<fieldset style='margin: 0 0 .25rem 0; padding: 0;'>";
     $data['content'] .= "<legend>Module selection</legend>";
     $data['content'] .= '<label class="col-sm-4 col-form-label m-2" for="selmodule">Select a module to assign:</label><br/>';
     $data['content'] .= "<select class='form-select m-2' id='selmodule' name='selmodule' >";
     // Display the module name sin a drop down selection box
     while($row = mysqli_fetch_array($result)) {
        $data['content'] .= "<option value='$row[modulecode]'>$row[name]</option>";
     }
     $data['content'] .= "</select><br/>";
     $data['content'] .= "<input class='btn btn-primary m-2' type='submit' name='confirm' value='Save' /></fieldset>";
     $data['content'] .= "</form>";
   }

   // render the template
   echo template("templates/default.php", $data);

} else {
   header("Location: index.php");
}

echo template("templates/partials/footer.php");

?>
