<?php include_once ("includes/admin_header.php"); ?>
<?php
if (isset($_SESSION['username'])) {
    $username = $_SESSION['username'];
    
    $query = "SELECT * FROM users WHERE username = '{$username}'";
    $select_user_profile_query = mysqli_query($connection, $query);
    
    while ($row = mysqli_fetch_assoc($select_user_profile_query)) {
        $db_user_id = $row['user_id'];
        $db_username = $row['username'];
        $db_user_password = $row['user_password'];
        $db_user_firstname = $row['user_firstname'];
        $db_user_lastname = $row['user_lastname'];
        $db_user_email = $row['user_email'];
        $db_user_image = $row['user_image'];
        $db_user_role = $row['user_role'];
        $db_user_create_at = $row['user_create_at'];
    }
}

if (isset($_POST['update_user'])) {
    $no_error = true;
    $error_message = "";

    $user_firstname = mysqli_real_escape_string($connection, $_POST['user_firstname']);
    $user_lastname = mysqli_real_escape_string($connection, $_POST['user_lastname']);
    $user_role = mysqli_real_escape_string($connection, $_POST['user_role']);
    $new_username = mysqli_real_escape_string($connection, $_POST['new_username']);
    $user_image = $_FILES['image']['name'];
    $user_image_temp = $_FILES['image']['tmp_name'];
    $user_email = mysqli_real_escape_string($connection, $_POST['user_email']);     
    $old_user_password = mysqli_real_escape_string($connection, $_POST['old_user_password']);
    $new_user_password = mysqli_real_escape_string($connection, $_POST['new_user_password']);

    if ($old_user_password == $new_user_password) {
        $error_message = "Your old password and new is the same!";
        $no_error = false;
    } else if ($db_user_password != md5($old_user_password)) {
        $error_message = "Your old password is wrong!";
        $no_error = false;
    } 

    if ($no_error != false) {
        $user_password_hash = md5($new_user_password);

        move_uploaded_file($user_image_temp, "../images/$user_image");

        if (empty($user_image)) {
            $query = "SELECT * FROM users WHERE username = $username ";
            $select_image = mysqli_query($connection, $query);

            while($row = mysqli_fetch_assoc($select_image)) {
                $user_image = $row['user_image'];
            }
        }

        $query = "UPDATE users SET ";
        $query .="username = '{$new_username}', ";
        $query .="user_password = '{$user_password_hash}', ";
        $query .="user_firstname = '{$user_firstname}', ";
        $query .="user_lastname = '{$user_lastname}', ";
        $query .="user_email = '{$user_email}', ";
        $query .="user_image = '{$user_image}', ";
        $query .="user_role = '{$user_role}' ";
        $query .= "WHERE username = '{$username}' ";

        $update_user_query = mysqli_query($connection, $query);
        
        if (!$update_user_query) {
            die("QUERY FAILED" . mysqli_error($connection));
        } else {
            $updated_user_message = "User updated.";
        }
    }
}
?>

<div id="wrapper">
    <!-- Navigation -->
    <?php include "includes/admin_navigation.php"; ?>
    <div id="page-wrapper">
        <div class="container-fluid">
            <!-- Page Heading -->
            <div class="row">
                <div class="col-lg-12">
                   <?php
                    if (isset($no_error) &&  $no_error == false) {
                        echo '<div class="alert alert-danger" role="alert">' . $error_message . '</div>';
                    }
                    if (isset($updated_user_message)) {
                        echo '<div class="alert alert-info" role="alert">' . $updated_user_message . '</div>';
                    }
                    ?>
                    <h1 class="page-header text-center">Welcome to admin <small>Author</small></h1>
                    <h1 class="text-center">Edit User</h1>
                    <form action="" method="post" enctype="multipart/form-data">
                        <div class="form-group">
                            <label for="user_firstname">Firstname</label>
                            <input type="text" class="form-control" name="user_firstname" value="<?php if (isset($db_user_firstname)) {echo $db_user_firstname;} ?>">
                        </div>
                        <div class="form-group">
                            <label for="user_lastname">Lastname</label>
                            <input type="text" class="form-control" name="user_lastname" value="<?php if (isset($db_user_lastname)) {echo $db_user_lastname;} ?>">
                        </div>
                        <div class="form-group">
                            <label for="user_role">User Role</label><br>
                            <select name="user_role" id="">
                                <option value="subscriber"><?php echo $db_user_role; ?></option>
                                <?php
                                if ($db_user_role == 'admin') {
                                    echo '<option value="subscriber">subscriber</option>';
                                } else {
                                    echo '<option value="admin">admin</option>';
                                }
                                ?>            
                            </select>
                        </div>    
                        <div class="form-group">
                            <label for="user_image">Profile Picture</label><br>
                            <img width="100" src="../images/<?php if (isset($db_user_image)) {echo $db_user_image;} ?>" alt="">
                            <input type="file" name="image">
                        </div>
                        <div class="form-group">
                            <label for="username">Username</label>
                            <input type="text" class="form-control" name="new_username" value="<?php if (isset($username)) {echo $username;} ?>">
                        </div>
                        <div class="form-group">
                            <label for="user_email">Email</label>
                            <input type="email" class="form-control" name="user_email" value="<?php if (isset($db_user_email)) {echo $db_user_email;} ?>">
                        </div>
                        <p><strong>Change password</strong></p>
                        <div class="form-group">
                            <label for="old_user_password">Old Password</label>
                            <input type="password" class="form-control" name="old_user_password">
                        </div>
                        <div class="form-group">
                            <label for="new_user_password">New Password</label>
                            <input type="password" class="form-control" name="new_user_password">
                        </div>
                        <div class="form group">
                            <input type="submit" class="btn btn-primary" name="update_user" value="Update Profile">
                        </div>
                    </form>
                </div><!-- /.col-lg-12 -->
            </div><!-- /.row -->
        </div><!-- /.container-fluid -->
    </div><!-- /#page-wrapper -->

<?php include "includes/admin_footer.php"; ?>