<?php
session_start();

include("includes/nav_header.php");
require_once 'config.php';



// If session variable is not set it will redirect to login page
if(!isset($_SESSION['username']) || empty($_SESSION['username'])){
    header("location: index.php");
    exit;
}

$query = "SELECT * FROM tools";
$query_r = mysqli_query($link, $query);

if($query_r)
		{
			echo "<table>";
			echo "<tr> <th> Tool Name </th> <th> Tool Count </th><th> Unit Price </th> <th> Description </th> </tr>";
			echo "<tr>";
			
			$count=0;
			while($row = mysqli_fetch_assoc($query_r))
			{
				echo "<tr>";
				echo "<td>" . $row["name"] . "</td>";
				echo "<td>" . $row["count"]  . "</td>";
				echo "<td>" . $row["unit_price"]  . "</td>";
				echo "<td>" . $row["description"] . "</td>";
				echo "</tr>";
				
			}
			echo "</table>";
		}

?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Create User</title>
    <link rel="stylesheet" href="/css/design.css">
    <style type="text/css">
        body{ font: 14px sans-serif; }
        .wrapper{ width: 350px; padding: 20px; }
    </style>
</head>
<body>
</body>

</html>