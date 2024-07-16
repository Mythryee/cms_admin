<?php
include "Components/_navbar.php";
session_start();
if(!isset($_SESSION['loggedin']) || $_SESSION['loggedin'] !== true){
    header("location: login.php");
    exit;
}

$servername = "localhost";
$username = "root";
$password = "";
$database = "blog";
$conn = mysqli_connect($servername, $username, $password, $database);

if (!$conn) {
    die("Connection is not established" . mysqli_connect_error());
}

// Function to check if the current user is admin
function isAdmin() {
    // Replace with your admin's email address
    $adminEmail = 'admin@gmail.com';
    return ($_SESSION['mail'] === $adminEmail);
}

// Delete post logic
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['delete_post'])) {
    if (isset($_POST['post_id'])) {
        $post_id = mysqli_real_escape_string($conn, $_POST['post_id']);
        
        // Fetch the author's email of the post
        $query = "SELECT mail FROM userposts WHERE id = '$post_id'";
        $result = mysqli_query($conn, $query);
        if ($result && mysqli_num_rows($result) > 0) {
            $row = mysqli_fetch_assoc($result);
            $author_mail = $row['mail'];

            // Check if the current user is the author or admin
            if ($_SESSION['mail'] === $author_mail || isAdmin()) {
                $delete_query = "DELETE FROM `userposts` WHERE `id` = '$post_id'";
                if (mysqli_query($conn, $delete_query)) {
                    header("Location: " . $_SERVER['PHP_SELF']);
                    exit();
                } else {
                    echo '<script>alert("Failed to delete post.");</script>';
                }
            } else {
                echo '<script>alert("You are not authorized to delete this post.");</script>';
            }
        } else {
            echo '<script>alert("Post not found.");</script>';
        }
    }
    mysqli_close($conn);
}

// Update post logic
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['update_post'])) {
    if (isset($_POST['post_id']) && isset($_POST['updated_post'])) {
        $post_id = mysqli_real_escape_string($conn, $_POST['post_id']);
        $updated_post = mysqli_real_escape_string($conn, $_POST['updated_post']);
        
        // Fetch the author's email of the post
        $query = "SELECT mail FROM userposts WHERE id = '$post_id'";
        $result = mysqli_query($conn, $query);
        if ($result && mysqli_num_rows($result) > 0) {
            $row = mysqli_fetch_assoc($result);
            $author_mail = $row['mail'];

            // Check if the current user is the author or admin
            if ($_SESSION['mail'] === $author_mail || isAdmin()) {
                $update_query = "UPDATE `userposts` SET `user_posts` = '$updated_post' WHERE `id` = '$post_id'";
                if (mysqli_query($conn, $update_query)) {
                    header("Location: " . $_SERVER['PHP_SELF']);
                    exit();
                } else {
                    echo '<script>alert("Failed to update post.");</script>';
                }
            } else {
                echo '<script>alert("You are not authorized to update this post.");</script>';
            }
        } else {
            echo '<script>alert("Post not found.");</script>';
        }
    }
    mysqli_close($conn);
}

// Insert new post logic
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['user_post'])) {
    $userpost = $_POST['user_post'];
    $postedmail = $_SESSION['mail'];
    $insert_query = "INSERT INTO `userposts` (`user_posts`,`mail`) VALUES ('$userpost','$postedmail')";
    $result = mysqli_query($conn, $insert_query);
    if($result){
        echo '<meta http-equiv="refresh" content="0">';
    } else {
        echo '<script>alert("Failed to insert post.");</script>';
    }
}

// Search posts logic
if ($_SERVER['REQUEST_METHOD'] == 'GET' && isset($_GET['search'])) {
    $search_term = mysqli_real_escape_string($conn, $_GET['search']);
    $query = "SELECT * FROM `userposts` WHERE `user_posts` LIKE '%$search_term%'";
} else {
    // Default query to fetch all posts
    $query = "SELECT * FROM `userposts`";
}

$result = mysqli_query($conn, $query);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Blog Page</title>
    <style>
        /* Your CSS styles here */
        body {
            font-family: Arial, sans-serif;
            background-color: #f0f0f0;
            margin: 0;
            padding: 0;
        }
        .container {
            max-width: 800px;
            margin: 20px auto;
            background-color: #fff;
            padding: 20px;
            border-radius: 10px;
            box-shadow: 0 0 10px rgba(0,0,0,0.1);
            text-align: center;
        }
        .post-form form {
            display: flex;
            flex-direction: row;
            justify-content: center;
            align-items: center;
            margin-bottom: 20px;
        }
        .post-form input[type="text"] {
            width: 70%;
            padding: 10px;
            font-size: 16px;
            border: 1px solid #ccc;
            border-radius: 5px 0 0 5px;
            outline: none;
        }
        .post-form input[type="submit"] {
            padding: 10px 20px;
            font-size: 16px;
            border: none;
            background-color: #007bff;
            color: #fff;
            border-radius: 0 5px 5px 0;
            cursor: pointer;
        }
        .search-form {
            margin-bottom: 20px;
        }
        .search-form input[type="text"] {
            width: 50%;
            padding: 10px;
            font-size: 16px;
            border: 1px solid #ccc;
            border-radius: 5px 0 0 5px;
            outline: none;
        }
        .search-form input[type="submit"] {
            padding: 10px 20px;
            font-size: 16px;
            border: none;
            background-color: #28a745;
            color: #fff;
            border-radius: 0 5px 5px 0;
            cursor: pointer;
        }
        .post-list {
            margin-top: 20px;
        }
        .post-item {
            background-color: #f9f9f9;
            padding: 10px;
            margin-bottom: 10px;
            border-radius: 5px;
            box-shadow: 0 0 5px rgba(0,0,0,0.1);
        }
        .post-item .post-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 10px;
        }
        .post-item .post-header .post-actions button {
            padding: 5px 10px;
            font-size: 14px;
            border: none;
            background-color: #dc3545;
            color: #fff;
            border-radius: 3px;
            cursor: pointer;
            margin-left: 10px;
        }
        .post-item .post-header .post-actions form {
            display: inline;
        }
        .post-item .post-content {
            margin-bottom: 10px;
        }
        .edit-form {
            display: none;
            margin-bottom: 10px;
        }
        .edit-form textarea {
            width: 100%;
            padding: 10px;
            font-size: 16px;
            border: 1px solid #ccc;
            border-radius: 5px;
            outline: none;
        }
        .edit-form input[type="submit"] {
            padding: 10px 20px;
            font-size: 16px;
            border: none;
            background-color: #28a745;
            color: #fff;
            border-radius: 5px;
            cursor: pointer;
        }
    </style>
</head>
<body>
    <div class="container">
        <h2>Welcome to the <?php echo $_SESSION['mail']?></h2>

        <!-- Post Input Form -->
        <div class="post-form">
            <form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="post">
                <input type="text" name="user_post" placeholder="Enter your post" required>
                <input type="submit" value="Post">
            </form>
        </div>

        <!-- Search Form -->
        <div class="search-form">
            <form method="get" action="<?php echo $_SERVER['PHP_SELF']; ?>">
                <input type="text" name="search" placeholder="Search posts">
                <input type="submit" value="Search">
            </form>
        </div>

        <!-- Display Posts -->
        <div class="post-list">
            <?php
            if (mysqli_num_rows($result) > 0) {
                while ($row = mysqli_fetch_assoc($result)) {
                    $postedmail = $row['mail'];
                    $post_date = date('d-m-y');
                    ?>
                    <div class="post-item">
                        <div class="post-header">
                            <span><strong>User:</strong> <?php echo $postedmail; ?></span>
                            <span><?php echo $post_date; ?></span>
                            <div class="post-actions">
                                <!-- Edit Button -->
                                <?php if ($_SESSION['mail'] === $postedmail || isAdmin()): ?>
                                    <button onclick="showEditForm(<?php echo $row['id']; ?>)">Edit</button>
                                <?php endif; ?>
                                <!-- Delete Form -->
                                <?php if ($_SESSION['mail'] === $postedmail || isAdmin()): ?>
                                    <form method="post" action="<?php echo $_SERVER['PHP_SELF']; ?>">
                                        <input type="hidden" name="post_id" value="<?php echo $row['id']; ?>">
                                        <button type="submit" name="delete_post">Delete</button>
                                    </form>
                                <?php endif; ?>
                            </div>
                        </div>
                        <div class="post-content">
                            <p><?php echo $row['user_posts']; ?></p>
                        </div>
                        <!-- Edit Form -->
                        <div id="edit-form-<?php echo $row['id']; ?>" class="edit-form">
                            <form method="post" action="<?php echo $_SERVER['PHP_SELF']; ?>">
                                <input type="hidden" name="post_id" value="<?php echo $row['id']; ?>">
                                <textarea name="updated_post" rows="4" placeholder="Update your post"><?php echo $row['user_posts']; ?></textarea>
                                <input type="submit" name="update_post" value="Update">
                            </form>
                        </div>
                    </div>
                    <?php
                }
            } else {
                echo "<p>No posts found.</p>";
            }

            mysqli_close($conn);
            ?>
        </div>
    </div>
    <script>
        document.getElementById("login").style.display="none";
        document.getElementById("logout").style.display="block";
    </script>
    <script>
        function showEditForm(postId) {
            var editForm = document.getElementById('edit-form-' + postId);
            if (editForm.style.display === "none") {
                editForm.style.display = "block";
            } else {
                editForm.style.display = "none";
            }
        }
    </script>
</body>
</html>
