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

   <h2>My Details</h2>
   <form name="frmdetails" action="" method="post">
   First Name :
   <input name="txtfirstname" type="text" value="{$row['firstname']}" /><br/>
   Surname :
   <input name="txtlastname" type="text"  value="{$row['lastname']}" /><br/>
   Number and Street :
   <input name="txthouse" type="text"  value="{$row['house']}" /><br/>
   Town :
   <input name="txttown" type="text"  value="{$row['town']}" /><br/>
   County :
   <input name="txtcounty" type="text"  value="{$row['county']}" /><br/>
   Country :
   <input name="txtcountry" type="text"  value="{$row['country']}" /><br/>
   Postcode :
   <input name="txtpostcode" type="text"  value="{$row['postcode']}" /><br/>
   <input onclick='return checkDelete()' type="submit" value="Save" name="submit"/>
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