<?php
require_once 'config.php';
$username=$password1=$master_key="";
$err="";
if($_SERVER["REQUEST_METHOD"] == "POST"){
    $username = trim($_POST["username"]);    
    $password1 = trim($_POST['password']);
    $master_key = trim($_POST['master_key']);
    if(strtolower($username)=="master"){
        $err="You Can not Create a user with the name master/Master";
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
                $sql = "SELECT master_key FROM logIn WHERE username='master'" ;
                $result = mysqli_query($link,$sql);
                if($result)
                {
                    $row= mysqli_fetch_array($result);
                    if($row['master_key']==$master_key){
                        $insert= "INSERT INTO logIn (username, password) VALUES('$username', '$password1')";
                        $insert_r=  mysqli_query($link, $insert);
                        if($insert_r==1){
      ?>                      
                            die("record Successfully added");
        <?php                }
                    }  else {
                        $err="Master key you Entered is Wrong, Please Enter a Valid Master Key.";
                    }
                }
                else {
                    echo "Smoething went wrong with query or db\n";
                    // echo 'MySQL Error: ' . mysql_error();
                    exit;
                }    
            }
        }
        else {
            echo "Smoething went wrong with query or db\n";
            // echo 'MySQL Error: ' . mysql_error();
            exit;
        }
    }
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
        
        <span class="help-block" style="color:red;"><?php echo $err; ?></span>
        
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
                <label>Enter Master Key</label>
                <input type="password" name="master_key" required="required" class="form-control">
            </div>

            <div class="form-group">
                <input type="submit" class="btn btn-primary" value="Submit">
            </div>
            
        </form>
    </div>    
    <div id="mymodal" >
        <p>THis is my modal</p>
    </div>
         
</body>
</html>

