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

   <form class="row g-3 m-3 ms-0 form border" name="studentdetails" action="" method="post" enctype='multipart/form-data'>
        <fieldset style="margin: 0 0 .25rem 0; padding: 0;">
            <legend>Add Student</legend>
            <div class="row mb-3">
                <label for="image" class="col-sm-2 col-form-label">Student Picture : </label> 
                <div class="col-sm-5">
                <input id="image" name="image" type="file" class="form-control" /><br/>
                </div>
            </div>
            <div class="row mb-3">
                <label for="studentid" class="col-sm-2 col-form-label">Student id :</label>
                <div class="col-sm-5"> 
                <input id="studentid" name="txtstudentid" type="text" value="" class="form-control"/><br/>
                </div>
            </div>
            <div class="row mb-3">
                <label for="password" class="col-sm-2 col-form-label">Password :</label>
                <div class="col-sm-5">
                <input id="password" name="txtpassword" type="text" value="" class="form-control"/><br/>
                </div>
            </div>
            <div class="row mb-3">
                <label for="dob" class="col-sm-2 col-form-label">Date of Birth :</label>
                <div class="col-sm-5">
                <input id="dov" name="txtdob" type="date" value="" class="form-control"/><br/>
                </div>
            </div>
            <div class="row mb-3">
                <label for="name" class="col-sm-2 col-form-label">First Name :</label>
                <div class="col-sm-5">
                <input id="name" name="txtfirstname" type="text" value="" class="form-control"/><br/>
                </div>
            </div>
            <div class="row mb-3">
                <label for="surname" class="col-sm-2 col-form-label">Surname :</label>
                <div class="col-sm-5">
                <input id="surname" name="txtlastname" type="text"  value="" class="form-control"/><br/>
                </div>
            </div>
            <div class="row mb-3">
                <label for="house" class="col-sm-2 col-form-label">Number and Street :</label>
                <div class="col-sm-5">
                <input id="house" name="txthouse" type="text"  value="" class="form-control"/><br/>
                </div>
            </div>
            <div class="row mb-3">
                <label for="town" class="col-sm-2 col-form-label">Town :</label>
                <div class="col-sm-5">
                <input id="town" name="txttown" type="text"  value="" class="form-control"/><br/>
                </div>
            </div>
            <div class="row mb-3">
                <label for="county" class="col-sm-2 col-form-label">County :</label>
                <div class="col-sm-5">
                <input id="county" name="txtcounty" type="text"  value="" class="form-control"/><br/>
                </div>
            </div>
            <div class="row mb-3">
                <label for="country" class="col-sm-2 col-form-label">Country :</label>
                <div class="col-sm-5">
                <input id="country" name="txtcountry" type="text"  value="" class="form-control"/><br/>
                </div>
            </div>
            <div class="row mb-3">
                <label for="code" class="col-sm-2 col-form-label">Postcode :</label>
                <div class="col-sm-5">
                <input id="code" name="txtpostcode" type="text"  value="" class="form-control"/><br/>
                </div>
            </div>
            <input onclick='return checkDelete()' type="submit" value="Add student" name="addStudent" class="btn btn-primary m-2"/>
        </fieldset>
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