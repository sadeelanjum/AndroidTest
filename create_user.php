<?php
require_once 'config.php';
$username=$password=$master_key=$confirm_password="";
$err="";
if(isset($_POST['submit']))
{
	if($_SERVER["REQUEST_METHOD"] == "POST"){
		$username = trim($_POST["username"]);    
		$password = trim($_POST['password']);
		$master_key = trim($_POST['master_key']);
		$confirm_password = trim($_POST["confirm_password"]);
	  
		if(strtolower($username)=="master"){
			$err="You Can not Create a user with the name master";
		}
		else
		{
			$user = "SELECT username FROM logIn";
			$user_r = mysqli_query($link, $user);
			if($user_r)
			{   
				$count=0;
				while($row = mysqli_fetch_assoc($user_r))
				{
					if($row['username']==$username){
						$count= $count+1;
					}
				}
				if($count>0)
				{
					$err= "This user already exist, Please enter some other name.";
				}
				else
				{
					if($password != $confirm_password)
					{
						$err="Password does not match to Confirm password, please try again";
					}
					else
					{
						$sql = "SELECT master_key FROM logIn WHERE username='master'";
						$result = mysqli_query($link,$sql);
						if($result)
						{
							
							$row= mysqli_fetch_array($result);
							if($row['master_key']==$master_key){
								$insert= "INSERT INTO logIn (username, password) VALUES('$username', '$password')";
								$insert_r=  mysqli_query($link, $insert);
								//if(mysqli_num_rows($insert_r)==1){
								  if($insert_r){
									die("record Successfully added");
								}
							}  else {
								$err="Master key you Entered is Wrong, Please Enter a Valid Master Key.";
							}
						}			
						else {
							$err = "Smoething went wrong with query or db\n";
							// echo 'MySQL Error: ' . mysql_error();
							exit;
						}  
					}				
				}
			}
			else {
				$err = "Something went wrong with query or db\n";
				// echo 'MySQL Error: ' . mysql_error();
				exit;
			}
		}
	}
	//echo  "<span class='help-block' style='color:red;'>" . $err . "</span>" ;
}
else 
{
}

?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Create User</title>
    <link rel="stylesheet" href="/css/bootstrap.css">
    <style type="text/css">
        body{ font: 14px sans-serif; }
        .wrapper{ width: 350px; padding: 20px; }
    </style>
</head>
<body>
    <div class="wrapper">
        <h2>Create User</h2>
        <p>Please fill in User Details.</p>
		
		<span class='help-block' style='color:red;'> <?php echo $err ?> </span>
                
        <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
            
            <div class="form-group">
                <label>Enter Username</label>
                <input type="text" name="username" required="required" class="form-control">
            </div>   
            
            <div class="form-group">
                <label>Enter Password</label>
                <input type="password" name="password" required="required" class="form-control">
            </div>
            <div class="form-group">
                <label>Confirm Password</label>
                <input type="password" name="confirm_password" required="required" class="form-control">
            </div>

            <div class="form-group">
                <label>Enter Master Key</label>
                <input type="password" name="master_key" required="required" class="form-control">
            </div>

            <div class="form-group">
                <input type="submit" name="submit" class="btn btn-primary" value="Submit">
            </div>
            
        </form>
    </div>    
</body>
</html>