<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Blog Page</title>
    <style>
        body{
            margin:0;
            padding:0;
        }
        #navbar{
            top:0;
            position:sticky;
            background-color:black;
            color:white;
            display:flex;
            justify-content:center;
        }
        #navbar .navlist{
            display:flex;
            justify-content:space-evenly;
            width:700px;
            /* border:2px solid; */
        }
        #navbar .navlist li{
            list-style:none;
        }
        #navbar .navlist li a{
            text-decoration:none;
            color:white;
            font-size:25px;
            font-weight:bold;
        }
        #navbar .navlist li a:hover{
            text-decoration:underline;
        }
    </style>
</head>
<body>
    <nav id=navbar>
        <ul class="navlist">
            <li><a href="http://localhost/CMS_admin/">Home</a></li>
            <li><a href="http://localhost/CMS_admin/blog.php">Blog</a></li>
            <li><a id="login" href="http://localhost/CMS_admin/login.php">Login<a></li>
            <li><a id="logout" href="http://localhost/CMS_admin/logout.php">Logout</a></li>
        </ul>
    </nav>
    <script>
        document.getElementById("logout").style.display="none";
    </script>
</body>
</html>