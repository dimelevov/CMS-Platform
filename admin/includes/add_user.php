<?php
if(isset($_POST['create_user'])) {
    $username = mysqli_real_escape_string($connection, $_POST['username']);
    $user_password = mysqli_real_escape_string($connection, $_POST['user_password']);
    $user_password_hash = md5($user_password);
    $user_firstname = mysqli_real_escape_string($connection, $_POST['user_firstname']);
    $user_lastname = mysqli_real_escape_string($connection, $_POST['user_lastname']);
    $user_image = $_FILES['image']['name'];
    $user_image_temp = $_FILES['image']['tmp_name'];
    $user_email = mysqli_real_escape_string($connection, $_POST['user_email']);
    $user_role = mysqli_real_escape_string($connection, $_POST['user_role']);
    $user_create_at = date('d-m-y');
    
    move_uploaded_file($user_image_temp, "../images/$user_image");
    
    $query = "INSERT INTO users(username, user_password, user_firstname, user_lastname, user_email, user_role, user_create_at, user_image)";
    
    $query .= " VALUE('{$username}', '{$user_password_hash}', '{$user_firstname}', '{$user_lastname}', '{$user_email}', '$user_role', '{$user_create_at}', '$user_image')";
    
    $create_user_query = mysqli_query($connection, $query);
    
    if (!$create_user_query) {
        die("QUERY FAILED" . mysqli_error($connection));
    } else {
        echo '<div class="alert alert-success text-center" role="alert">User created.</div>';
    }
}

?>
   
<h1 class="text-center">Add New User</h1>
<hr>
<form action="" method="post" enctype="multipart/form-data">
    <div class="form-group">
        <label for="user_firstname">Firstname</label>
        <input type="text" class="form-control" name="user_firstname">
    </div>
    <div class="form-group">
        <label for="user_lastname">Lastname</label>
        <input type="text" class="form-control" name="user_lastname">
    </div>
     <div class="form-group">
        <label for="user_role">User Role</label><br>
        <select name="user_role" id="">
            <option value="subscriber">Select Options</option>
            <option value="subscriber">Subscriber</option>
            <option value="admin">Admin</option>
        </select>
    </div>
    
    <div class="form-group">
        <label for="user_image">Profile Picture</label>
        <input type="file" name="image">
    </div>
    <div class="form-group">
        <label for="username">Username</label>
        <input type="text" class="form-control" name="username">
    </div>
    <div class="form-group">
        <label for="user_email">Email</label>
        <input type="email" class="form-control" name="user_email">
    </div>
    <div class="form-group">
        <label for="user_password">Password</label>
        <input type="password" class="form-control" name="user_password">
    </div>
    <div class="form group">
        <input type="submit" class="btn btn-primary" name="create_user" value="Create User">
    </div>
</form>