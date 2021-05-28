<?php

include("_includes/config.inc");
include("_includes/dbconnect.inc");
include("_includes/functions.inc");

if (isset($_SESSION['id'])) {

    echo template("templates/partials/header.php");
    echo template("templates/partials/nav.php");

    $sql = "SELECT * FROM student;";
    $result = mysqli_query($conn, $sql);

    // prepare page content
    $data['content'] .= "<table border='1'>";
    $data['content'] .= "<tr><th colspan='10' align='center'>Students</th></tr>";
    $data['content'] .= "<tr><th>Student ID</th><th>password</th><th>dob</th><th>firstname</th><th>lastname</th>";
    $data['content'] .= "<th>house</th><th>town</th><th>county</th><th>country</th><th>postcode</th></tr>";

    // Display the modules within the html table
    while($row = mysqli_fetch_array($result)) {
        $data['content'] .= "<tr><td> $row[studentid] </td><td> $row[password] </td><td> $row[dob] </td><td> $row[firstname] </td>";
        $data['content'] .= "<td> $row[lastname] </td><td> $row[house] </td><td> $row[town] </td><td> $row[county] </td><td> $row[country] </td><td> $row[postcode] </td></tr>";
    }
    $data['content'] .= "</table>";


    // render the template
    echo template("templates/default.php", $data);
}

?>