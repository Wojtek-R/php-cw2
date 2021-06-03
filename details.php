<?php

include("_includes/config.inc");
include("_includes/dbconnect.inc");
include("_includes/functions.inc");

// check logged in
if (isset($_SESSION['id'])) {

   echo template("templates/partials/header.php");
   echo template("templates/partials/nav.php");

   // if the form has been submitted
   if (isset($_POST['submit'])) {

      // build an sql statment to update the student details

      $stmt = $conn->prepare(
          "UPDATE student SET firstname = ?, lastname = ?, house = ?, town = ?, county = ?, country = ?, postcode = ? WHERE studentid = ?");
      $stmt->bind_param("sssssssi", $_POST['txtfirstname'], $_POST['txtlastname'], $_POST['txthouse'],
          $_POST['txttown'], $_POST['txtcounty'], $_POST['txtcountry'], $_POST['txtpostcode'],$_SESSION['id']);
      $stmt->execute();
      $stmt->close();

      $data['content'] = "<p>Your details have been updated</p>";

   }
   else {
      // Build a SQL statment to return the student record with the id that
      // matches that of the session variable.
      $sql = "select * from student where studentid='". $_SESSION['id'] . "';";
      $result = mysqli_query($conn,$sql);
      $row = mysqli_fetch_array($result);

      // using <<<EOD notation to allow building of a multi-line string
      // see http://stackoverflow.com/questions/6924193/what-is-the-use-of-eod-in-php for info
      // also http://stackoverflow.com/questions/8280360/formatting-an-array-value-inside-a-heredoc
      $data['content'] = <<<EOD
   
   <form class="row g-3 m-3 ms-0 form border" name="frmdetails" action="" method="post">
   <fieldset style="margin: 0 0 .25rem 0; padding: 0;">
   <legend>My Details</legend>
        <div class="row mb-3">
            <label for="name" class="col-sm-2 col-form-label">First Name :</label>
            <div class="col-sm-5">
            <input id="name" name="txtfirstname" type="text" value="{$row['firstname']}" class="form-control"/><br/>
            </div>
        </div>
   <div class="row mb-3">
                <label for="surname" class="col-sm-2 col-form-label">Surname :</label>
                <div class="col-sm-5">
                <input id="surname" name="txtlastname" type="text"  value="{$row['lastname']}" class="form-control"/><br/>
                </div>
            </div>
   <div class="row mb-3">
                <label for="house" class="col-sm-2 col-form-label">Number and Street :</label>
                <div class="col-sm-5">
                <input id="house" name="txthouse" type="text"  value="{$row['house']}" class="form-control"/><br/>
                </div>
            </div>
   <div class="row mb-3">
                <label for="town" class="col-sm-2 col-form-label">Town :</label>
                <div class="col-sm-5">
                <input id="town" name="txttown" type="text"  value="{$row['town']}" class="form-control"/><br/>
                </div>
            </div>
   <div class="row mb-3">
                <label for="county" class="col-sm-2 col-form-label">County :</label>
                <div class="col-sm-5">
                <input id="county" name="txtcounty" type="text"  value="{$row['county']}" class="form-control"/><br/>
                </div>
            </div>
   <div class="row mb-3">
                <label for="country" class="col-sm-2 col-form-label">Country :</label>
                <div class="col-sm-5">
                <input id="country" name="txtcountry" type="text"  value="{$row['country']}" class="form-control"/><br/>
                </div>
            </div>
   <div class="row mb-3">
                <label for="code" class="col-sm-2 col-form-label">Postcode :</label>
                <div class="col-sm-5">
                <input id="code" name="txtpostcode" type="text"  value="{$row['postcode']}" class="form-control"/><br/>
                </div>
            </div>
   <input onclick='return checkDelete()' type="submit" value="Save" name="submit" class="btn btn-warning m-2"/>
   </fieldset>
   </form>
   

EOD;

   }
    //popup jquery confirm validation
    $data['content'] .= "<script language='JavaScript' type='text/javascript'>
           function checkDelete(){
               return confirm('Are you sure you want to change details of this student?');
           }
      </script>";

   // render the template
   echo template("templates/default.php", $data);

} else {
   header("Location: index.php");
}

echo template("templates/partials/footer.php");

?>