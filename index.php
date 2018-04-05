<?php
// Include config file
require_once 'config.php';

// Define variables and initialize with empty values
$username = $password1 = "";
$username_err = $password_err = "";
 
// Processing form data when form is submitted
if($_SERVER["REQUEST_METHOD"] == "POST"){
    
    $username = trim($_POST["username"]);
    $password1 = trim($_POST['password']);

    $sql = "SELECT * FROM logIn WHERE username = '$username' AND password='$password1' ";
    
    $result = mysqli_query($link,$sql);
    if($result)
    {
        if ($result->num_rows==1) {
            session_start();
            $_SESSION['username'] = $username;      
            header("location: dashboard.php");                
        }
        else
        {
            $err = 'Please enter valid username and password';                    
        } 
    }
    else {
        echo "Smoething went wrong with query or db\n";
        // echo 'MySQL Error: ' . mysql_error();
        exit;
    }

    
    
    // Close connection
    mysqli_close($link);
}
?>
 
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Login</title>
    <link rel="stylesheet" href="/css/bootstrap.css">
    <style type="text/css">
        body{ font: 14px sans-serif; }
        .wrapper{ width: 350px; padding: 20px; }
    </style>
</head>

<body>
    <div class="wrapper">
        <h2>Login</h2>
        <p>Please fill in your credentials to login.</p>
        <span class="help-block" style="color:red;"><?php echo $err; ?></span>
        <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
            <div class="form-group">
                <label>Username</label>
                <input type="text" required="required" name="username"class="form-control"> 
            </div>    
            <div class="form-group">
                <label>Password</label>
                <input type="password" required="required" name="password" class="form-control">
            </div>
            <div class="form-group">
                <input type="submit" id="submit" class="btn btn-primary" value="Login">
            </div>
        </form>
    </div>    
</body>

</html>