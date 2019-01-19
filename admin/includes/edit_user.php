<?php
    if (isset($_GET['user_id'])) {
        $user_id = $_GET['user_id'];
    }

    $query = "SELECT * FROM users WHERE user_id = {$user_id}";
    $select_user_by_id = mysqli_query($connection, $query);

    while ($row = mysqli_fetch_assoc($select_user_by_id)) {
        $user_id = $row['user_id'];
        $username = $row['username'];
        $user_password = $row['user_password'];
        $user_firstname = $row['user_firstname'];
        $user_lastname = $row['user_lastname'];
        $user_email = $row['user_email'];
        $user_image = $row['user_image'];
        $user_role = $row['user_role'];
        $randSalt = $row['randSalt'];
    }

    if (isset($_POST['update_user'])) {
        $user_firstname = mysqli_real_escape_string($connection, $_POST['user_firstname']);
        $user_lastname = mysqli_real_escape_string($connection, $_POST['user_lastname']);
        $user_role = mysqli_real_escape_string($connection, $_POST['user_role']);
        $username = mysqli_real_escape_string($connection, $_POST['username']);
        $user_image = $_FILES['image']['name'];
        $user_image_temp = $_FILES['image']['tmp_name'];
        $user_email = mysqli_real_escape_string($connection, $_POST['user_email']);
        $user_password = mysqli_real_escape_string($connection, $_POST['user_password']);

    
      move_uploaded_file($user_image_temp, "../images/$user_image");
    
    if(empty($user_image)) {
        $query = "SELECT * FROM users WHERE user_id = $user_id ";
        $select_image = mysqli_query($connection, $query);
        
        while($row = mysqli_fetch_assoc($select_image)) {
            $user_image = $row['user_image'];
        }
    }
    
    
    $query = "UPDATE users SET ";
    $query .="username = '{$username}', ";
    $query .="user_password = '{$user_password}', ";
    $query .="user_firstname = '{$user_firstname}', ";
    $query .="user_lastname = '{$user_lastname}', ";
    $query .="user_email = '{$user_email}', ";
    $query .="user_image = '{$user_image}', ";
    $query .="user_role = '{$user_role}' ";
    $query .= "WHERE user_id = {$user_id} ";
    
    $update_user_query = mysqli_query($connection, $query);
//    confirmQuery($update_post);
    if(!$update_user_query) {
        die("QUERY FAILED" . mysqli_error($connection));
    }
}

?>
  

  <h1 class="text-center">Edit User</h1>
   <form action="" method="post" enctype="multipart/form-data">
    <div class="form-group">
        <label for="user_firstname">Firstname</label>
        <input type="text" class="form-control" name="user_firstname" value="<?php if(isset($user_firstname)) {echo $user_firstname;} ?>">
    </div>
    <div class="form-group">
        <label for="user_lastname">Lastname</label>
        <input type="text" class="form-control" name="user_lastname" value="<?php if(isset($user_lastname)) {echo $user_lastname;} ?>">
    </div>
    <div class="form-group">
        <label for="user_role">User Role</label><br>
        <select name="user_role" id="">
            <option value="subscriber"><?php echo $user_role; ?></option>
            <?php
            if ($user_role == 'admin') {
                echo '<option value="subscriber">subscriber</option>';
            } else {
                echo '<option value="admin">admin</option>';
            }
            
            ?>            
        </select>
    </div>    
    <div class="form-group">
        <label for="user_image">Profile Picture</label><br>
        <img width="100" src="../images/<?php if(isset($user_image)) {echo $user_image;} ?>" alt="">
        <input type="file" name="image">
    </div>
    <div class="form-group">
        <label for="username">Username</label>
        <input type="text" class="form-control" name="username" value="<?php if(isset($username)) {echo $username;} ?>">
    </div>
    <div class="form-group">
        <label for="user_email">Email</label>
        <input type="email" class="form-control" name="user_email" value="<?php if(isset($user_email)) {echo $user_email;} ?>">
    </div>
    <div class="form-group">
        <label for="user_password">Password</label>
        <input type="password" class="form-control" name="user_password" value="<?php if(isset($user_password)) {echo $user_password;} ?>">
    </div>
    <div class="form group">
        <input type="submit" class="btn btn-primary" name="update_user" value="Update User">
    </div>
</form>