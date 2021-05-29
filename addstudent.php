<?php

include("_includes/config.inc");
include("_includes/dbconnect.inc");
include("_includes/functions.inc");


// check logged in
if (isset($_SESSION['id'])) {

    echo template("templates/partials/header.php");
    echo template("templates/partials/nav.php");

    // if the form has been submitted
    if (isset($_POST['addStudent'])) {


        if (!empty($_POST['txtfirstname']) && !empty($_POST['txtlastname']) && !empty($_POST['txthouse']) && !empty($_POST['txttown']) &&
            !empty($_POST['txtcounty']) && !empty($_POST['txtcountry']) && !empty($_POST['txtpostcode']) ) {

            // build an sql statment to add the student with details
            $id = $_POST['txtstudentid'];
            $password = $_POST['txtpassword'];
            $name = $_POST['txtfirstname'];
            $surname = $_POST['txtlastname'];
            $house = $_POST['txthouse'];
            $town = $_POST['txttown'];
            $county = $_POST['txtcounty'];
            $country = $_POST['txtcountry'];
            $postcode = $_POST['txtpostcode'];

            $sql = "INSERT INTO student ( studentid, password, firstname, lastname, house, town, county, country, postcode) 
                    VALUES ('$id', '$password','$name', '$surname', '$house', '$town', '$county', '$country', '$postcode')";
            $result = mysqli_query($conn, $sql);

            if ($result) {
                $data['content'] = "<p>Student have been added.</p>";

            } else {
                $data['content'] = "<p>Form not submitted.</p>";
            }
        } else {
            $data['content'] = "<p>All fields required.</p>";
        }


    }
    else {

        $data['content'] = <<<EOD

   <h2>Add Student</h2>
   <form name="studentdetails" action="" method="post">
   Student id : 
   <input name="txtstudentid" type="text" value="" /><br/>
   Password : 
   <input name="txtpassword" type="text" value="" /><br/>
   First Name :
   <input name="txtfirstname" type="text" value="" /><br/>
   Surname :
   <input name="txtlastname" type="text"  value="" /><br/>
   Number and Street :
   <input name="txthouse" type="text"  value="" /><br/>
   Town :
   <input name="txttown" type="text"  value="" /><br/>
   County :
   <input name="txtcounty" type="text"  value="" /><br/>
   Country :
   <input name="txtcountry" type="text"  value="" /><br/>
   Postcode :
   <input name="txtpostcode" type="text"  value="" /><br/>
   <input type="submit" value="Add student" name="addStudent"/>
   </form>

EOD;

    }

    // render the template
    echo template("templates/default.php", $data);

} else {
    header("Location: index.php");
}

echo template("templates/partials/footer.php");

?>