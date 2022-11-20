<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
<?php
// Include config file
session_start();
require_once "config.php";
 
// Define variables and initialize with empty values
$username = $password =$type="";
// Processing form data when form is submitted
if($_SERVER["REQUEST_METHOD"] == "POST"){
    $username=$_POST["username"];
    $password=$_POST["password"];
    $type=$_POST["type"];
    if($type=="Customer")
        $sql = "SELECT s_id,s_password FROM student WHERE c_id =? and s_password=?";
    else $sql = "SELECT f_id,f_password FROM facuilty WHERE f_id = ? and f_password=? ";
    if($stmt = mysqli_prepare($link, $sql)){
        mysqli_stmt_bind_param($stmt, "ss", $username,$password);
        if(mysqli_stmt_execute($stmt)){ 
                mysqli_stmt_store_result($stmt);
                
                if(mysqli_stmt_num_rows($stmt) == 1){
                    echo "login successfully";
                    $_SESSION["username"]=$username;
                    $_SESSION["logged_in"]=true;
                    if($type=="Customer") header("location:customer/c_dashboard.php");
                    else header("location:shopkeeper/s_dashboard.php");
                }
                else{
                    header("location:login.html");
                }
            } 
        else{
                echo "Oops! Something went wrong. Please try again later.";
        }

        // Close statement
        mysqli_stmt_close($stmt);
    }
    else echo"failed";
    mysqli_close($link);
}
?>
</body>
</html>