<?php
// Initialize the session
    session_start();
 
// If session variable is not set it will redirect to login page
if(!isset($_SESSION['username']) || empty($_SESSION['username'])){
  header("location: index.php");
  exit;
}
?>
 
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Welcome</title>
    <link rel="stylesheet" href="../css/bootstrap.css">
	<link rel="stylesheet" href="../css/design.css">
	
    <script type="text/javascript" src="../js/bootstrap.min.js"></script>
    <script type="text/javascript" src="../js/jquery.min.js"></script>
    <style type="text/css">
        .custom{
            width: 249px;
            height: 150px;
            
            margin-top: 77px;
            background:#dae0e5; 
            border-radius: 25px;
            color: brown;
            cursor:pointer;
        }
        div.custom:hover {
            background-color:beige;
        }
        .inner-div{
            margin-top: 62px;
            margin-left: 66px;
        }
    </style>
    
</head>
<script>
    $(document).ready(function () {
        $("body").delegate('#user_management', "click",function(e){
           document.location.href="create_user.php";
        });
        $("body").delegate('#raw_material', "click",function(e){
           document.location.href="raw_material.php";
        });
		$("body").delegate('#tool_management', "click",function(e){
           document.location.href="manage_tools.php";
        });
    });
    
</script>
<body>
    <div class="jumbotron" style="padding: 2rem; margin-bottom: 0rem">  		
				<div id ="logo_div">
					<img id="logo_img" src="../img/akbc_logo.png"> </img>
				</div>
				
				<div id="slogan_div">
					<span class="slogan_text"> Shaheen Business Group</span><br>
					<span class="slogan_text2"> Chairman: Rana Ali Shan Khan </span>				
				</div>      
        </div>
    <div class="container" style="">
        
        
        <div class="row">
            <div class="custom" style="margin-left: 183px;">Cash</div>
            
            <div id="raw_material" class="custom" style="margin-left: 183px;">
                <div class="inner-div" >
                    <p>Manage
                        Raw Material</p>
                </div>
            </div>
            
            <div id="tool_management"  class="custom" style="margin-left: 183px;">
				<div class="inner-div" style="margin-top: 62px; margin-left: 66px;">
					Manage Tools
				</div>
				  
			</div>
            
            <div id="user_management" class="custom" style="margin-left: 183px;">
                <div class="inner-div" style="margin-top: 62px; margin-left: 66px;">
                    Create New User
                </div>
            </div>
        </div>
        
        
<!--        
        <p><a href="cash.php" class="button btn ">Cash </a></p>
        <p><a href="cash.php" class="button btn ">Cash </a></p>
        <p><a href="cash.php" class="button btn ">Cash </a></p>
        <p><a href="cash.php" class="button btn ">Cash </a></p>
        <p><a href="cash.php" class="button btn ">Cash </a></p>
        <p><a href="cash.php" class="button btn ">Cash </a></p>
        <p><a href="cash.php" class="button btn ">Cash </a></p>
        <p><a href="logOut.php" class="btn btn-danger">Sign Out of Your Account</a></p>-->
    </div>
</body>
</html>