<?php
    include "Components/_navbar.php";
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
    <style>
        .logincontainer{
            width:400px;
            height:300px;
            border:7px solid;
            display:block;
            margin:auto;
            margin-top:70px;
            border-radius:15px;
            text-align:center;
        }
        .logincontainer h1{
            font-size:40px;
        }
        .logincontainer form{
            display:flex;
            flex-direction:column;
        }
        .logincontainer form input{
            width:350px;
            height:30px;
            text-align:center;
            margin:10px;
            border:2px solid;
            border-radius:15px;
            font-size:15px;
        }
        .logincontainer form input[type="submit"]{
            display:block;
            margin:auto;
            margin-top:20px;
        }
    </style>
</head>
<body>
    <div class="logincontainer">
        <h1>Login</h1>
        <form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="post">
            <input type="email" name="mail" id="mail" placeholder="Enter your mail">
            <input type="password" name="pass" id="pass" placeholder="Enter password">
            <a href="http://localhost/CMS_admin/signup.php">Create a new account</a>
            <input type="submit" value="Submit">
        </form>
    </div>
    </body>
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
            if(isset($_POST['mail']) && isset($_POST['pass'])){
                $mail = $_POST['mail'];
                $pass = $_POST['pass'];
                $un = "SELECT * FROM `blog_user_data` WHERE `user_mail` = '$mail'";
                $result1 = mysqli_query($conn,$un);
                $noofrows = mysqli_num_rows($result1);
                if($noofrows == 1){
                    while($row = mysqli_fetch_assoc($result1)){
                        if($pass == $row['user_pass']){
                            session_start();
                            $_SESSION['loggedin'] = true;
                            $_SESSION['mail'] = $mail;
                            header("location:blog.php");
                        }else{
                            echo "<script>alert('Enter the password correctly')</script>";
                        }
                    }
                }
            }
        }
    }
?>