<?php include "db.php"; ?>
<?php session_start(); ?>


<?php 
    if (isset($_POST['login'])) {
        $username_login = mysqli_real_escape_string($connection, $_POST['username']);
        $password_login = mysqli_real_escape_string($connection, $_POST['password']);

        $query = "SELECT * FROM users WHERE username = '{$username_login}'";
        $select_user_query = mysqli_query($connection, $query);

        if (!$select_user_query) {
            die("QUERY FAILED!".  mysqli_error($connection));
        }
        
        $db_user_username = "";
        $db_user_password = "";
        
        while ($row = mysqli_fetch_array($select_user_query)) {
            $db_user_id = $row['user_id'];
            $db_user_username = $row['username'];
            $db_user_firstname = $row['user_firstname'];
            $db_user_lastname = $row['user_lastname'];
            $db_user_password = $row['user_password'];
            $db_user_role = $row['user_role'];
        }
        
        if ($db_user_username && $db_user_password) {
            if ($db_user_username !== $username_login || $db_user_password !== md5($password_login)) {
                $_SESSION['error_mes'] = "Incorect username or password!";
                header("Location: ../index.php");
            } else if ($db_user_username == $username_login && $db_user_password == md5($password_login)) {
                $_SESSION['username'] = $db_user_username;
                $_SESSION['firstname'] = $db_user_firstname;
                $_SESSION['lastname'] = $db_user_lastname;
                $_SESSION['user_role'] = $db_user_role;
                header("Location: ../admin");
            } else {
                $_SESSION['error_mes'] = "Incorect username or password!";
                header("Location: ../index.php");
            }
        } else {
            $_SESSION['error_mes'] = "Incorect username or password!";
            header("Location: ../index.php");
        }
    }
?>