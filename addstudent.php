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


        if (!empty($_FILES['image']['name']) && !empty($_POST['txtstudentid']) && !empty($_POST['txtpassword']) && !empty($_POST['txtdob']) && !empty($_POST['txtfirstname']) &&
            !empty($_POST['txtlastname']) && !empty($_POST['txthouse']) && !empty($_POST['txttown']) &&
            !empty($_POST['txtcounty']) && !empty($_POST['txtcountry']) && !empty($_POST['txtpostcode']) ) {

            $fileName = basename($_FILES["image"]["name"]);
            $fileType = pathinfo($fileName, PATHINFO_EXTENSION);

            //Allow certain file formats
            $allowTypes = array('jpg', 'png', 'jpeg', 'gif');

            if (in_array($fileType,$allowTypes)) {
                $image = $_FILES['image']['tmp_name'];
                $imgContent = addslashes(file_get_contents($image));


                //create variables to store user inputs
                $id = $_POST['txtstudentid'];
                //hashing the password to make it more secure
                $password = password_hash($_POST['txtpassword'], PASSWORD_DEFAULT);
                $dob = $_POST['txtdob'];
                $name = $_POST['txtfirstname'];
                $surname = $_POST['txtlastname'];
                $house = $_POST['txthouse'];
                $town = $_POST['txttown'];
                $county = $_POST['txtcounty'];
                $country = $_POST['txtcountry'];
                $postcode = $_POST['txtpostcode'];

                // build an sql statment to add the student with details
                $stmt = $conn->prepare("INSERT INTO student ( image, studentid, password, dob, firstname, lastname, house, town, county, country, postcode) 
                    VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)");
                $stmt->bind_param("bisssssssss", $imgContent, $id, $password, $dob, $name, $surname, $house, $town, $county, $country, $postcode);
                $stmt->send_long_data(0, file_get_contents($_FILES['image']['tmp_name']));

                if ($stmt->execute()) {
                    $data['content'] = "<p>Student have been added.</p>";
                    $stmt->close();

                } else {
                    $data['content'] = "<p>Form not submitted.</p>";
                }

//                $result = mysqli_query($conn, $sql);
            }
            else {
                $data['content'] = "<p>Wrong picture file format. Please upload correct type: 'jpg', 'png', 'jpeg', 'gif'.</p>";
            }
        } else {
            $data['content'] = "<p>Please fill all the fields.</p>";
        }

    }
    else {

        $data['content'] = <<<EOD

   <h2>Add Student</h2>
   <form name="studentdetails" action="" method="post" enctype='multipart/form-data'>
   <div class="mb-3">
   <label for="image" class="form-label">Student Picture : </label> 
   <input id="image" name="image" type="file" /><br/>
   </div>
   Student id : 
   <input name="txtstudentid" type="text" value="" /><br/>
   Password : 
   <input name="txtpassword" type="text" value="" /><br/>
   Date of Birth : 
   <input name="txtdob" type="date" value="" /><br/>
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
   <input onclick='return checkDelete()' type="submit" value="Add student" name="addStudent"/>
   </form>

EOD;

    }
    //popup jquery confirm validation
    $data['content'] .= "<script language='JavaScript' type='text/javascript'>
           function checkDelete(){
               return confirm('Would you like to add this student/s?');
           }
      </script>";

    // render the template
    echo template("templates/default.php", $data);

} else {
    header("Location: index.php");
}

echo template("templates/partials/footer.php");

?>