<?php
    include "Components/_navbar.php";
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sign up</title>
    <style>
        .signupcontainer{
            width:400px;
            height:400px;
            border:7px solid;
            display:block;
            margin:auto;
            margin-top:70px;
            border-radius:15px;
            text-align:center;
        }
        .signupcontainer h1{
            font-size:40px;
        }
        .signupcontainer form{
            display:flex;
            flex-direction:column;
        }
        .signupcontainer form input{
            height:30px;
            text-align:center;
            margin:10px;
            border:2px solid;
            border-radius:15px;
            font-size:15px;
        }
    </style>
</head>
<body>
    <div class="signupcontainer">
        <h1>Signup</h1>
        <form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="post">
            <input type="text" name="user" id="user" placeholder="Enter your name">
            <input type="email" name="mail" id="mail" placeholder="Enter your mail">
            <input type="password" name="pass" id="pass" placeholder="Enter password">
            <input type="password" name="cpass" id="cpass" placeholder="confirm password">
            <input type="submit" value="Submit">
        </form>
    </div>
</body>
<script>
    
</script>
</html>

<?php
    //database connection
    $servername = "localhost";
    $username = "root";
    $password = "";
    $database = "blog";
    $conn = mysqli_connect($servername,$username,$password,$database);
    if(!$conn){
        die("Connection is not established".mysqli_connect_error());
    }else{
        if($_SERVER['REQUEST_METHOD']=='POST'){
            if(isset($_POST['user']) && isset($_POST['mail']) && isset($_POST['pass']) && isset($_POST['cpass'])){
                $user = $_POST['user'];
                $mail = $_POST['mail'];
                $pass = $_POST['pass'];
                $cpass = $_POST['cpass'];
                $un = "SELECT * FROM `blog_user_data` WHERE `user_name` LIKE '$user'";
                $result1 = mysqli_query($conn,$un);
                $rows = mysqli_num_rows($result1);
                if($rows == 0){
                    if($pass == $cpass){
                        $on = "INSERT INTO `blog_user_data` (`user_name`, `user_mail`, `user_pass`) VALUES ('$user', '$mail', '$pass')";
                        $result2 = mysqli_query($conn,$on);
                    }else{
                        echo "<script>alert('Reenter the password correctly')</scrip>";
                    }
                }else{
                    echo "<script>alert('user name is already taken')</script>";
                }
            }
        }
    }
?>