<?php

include("_includes/config.inc");
include("_includes/dbconnect.inc");
include("_includes/functions.inc");

if (isset($_SESSION['id'])) {

    echo template("templates/partials/header.php");
    echo template("templates/partials/nav.php");

    if (isset($_POST['submit'])) {

        if (isset($_POST["check"])) {

            foreach ($_POST["check"] as $student) {

                $stmt = $conn->prepare("DELETE FROM student WHERE studentid = ?");
                $stmt->bind_param("i", $student);
                $stmt->execute();
                $stmt->close();

            }
            $data['content'] .= "Selected student/s deleted";
        }
        else{
            $data['content'] .= "Please select a student to be deleted.";
        }

    } else {

        $sql = "SELECT * FROM student;";
        $result = mysqli_query($conn, $sql);

        // prepare page content
        $data['content'] .= "<form name='checklist' action='' method='post'>";
        $data['content'] .= "<table border='1'>";
        $data['content'] .= "<tr><th colspan='12' align='center'>Students</th></tr>";
        $data['content'] .= "<tr><th>Select</th><th>Image</th><th>Student ID</th><th>dob</th><th>firstname</th><th>lastname</th>";
        $data['content'] .= "<th>house</th><th>town</th><th>county</th><th>country</th><th>postcode</th></tr>";

        // Display the students within the html table
        while ($row = mysqli_fetch_array($result)) {
            $data['content'] .= "<tr><td><input type='checkbox' id='checkItem' name='check[]' value='$row[studentid]'/></td>";
            $data['content'] .= "<td> <img src='data:image/jpeg;base64,".base64_encode( $row['image'] )."'/> </td><td> $row[studentid] </td><td> $row[dob] </td><td> $row[firstname] </td>";
            $data['content'] .= "<td> $row[lastname] </td><td> $row[house] </td><td> $row[town] </td><td> $row[county] </td><td> $row[country] </td><td> $row[postcode] </td></tr>";
        }
        $data['content'] .= "</table>";
        $data['content'] .= "<input onclick='return checkDelete()' type='submit' value='Delete' name='submit'/> </form>";

    }

    // render the template
    echo template("templates/default.php", $data);
}
?>

<!--$sql = "DELETE FROM student WHERE studentid ='" . $student . "'";-->
<!--$result = mysqli_query($conn, $sql);-->