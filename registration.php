<?php include_once "includes/db.php"; ?>
<?php include_once "includes/header.php"; ?>

<?php
if (isset($_POST['submit'])) {
    $reg_username = mysqli_real_escape_string($connection, $_POST['username']);
    $reg_password = mysqli_real_escape_string($connection, $_POST['password']);
    $reg_email = mysqli_real_escape_string($connection, $_POST['email']);
    $reg_firstname = mysqli_real_escape_string($connection, $_POST['firstname']);
    $reg_lastname = mysqli_real_escape_string($connection, $_POST['lastname']);
    $reg_password_hash = md5($reg_password);
    $reg_create_at = date('d-m-y');
    
    $query = "INSERT INTO users (username, user_password, user_email, user_firstname, user_lastname, user_role, user_create_at)";
    $query .= " VALUES('{$reg_username}', '{$reg_password_hash}', '{$reg_email}', '{$reg_firstname}', '{$reg_lastname}', 'subscriber', '{$reg_create_at}')";
    
    $register_user_query = mysqli_query($connection, $query);
    
    if (!$register_user_query) {
        die("QUERY FAILED!". mysqli_error($connection));
    } else {
        echo "<div class='alert alert-success text-center' role='alert'>User created.</div>";
    }
    
    
}
    

?>

<!-- Navigation -->
<?php include_once "includes/navigation.php"; ?>
 
<!-- Page Content -->
<div class="container">
    
    <section id="login">
        <div class="container">
            <div class="row">
                <div class="col-xs-6 col-xs-offset-3">
                    <div class="form-wrap">
                    <h1>Register</h1>
                        <form role="form" action="registration.php" method="post" id="login-form" autocomplete="off">
                            <div class="form-group">
                                <label for="username">Username *</label>
                                <input type="text" name="username" id="username" class="form-control" required>
                            </div>
                            <div class="form-group">
                                <label for="email">Email *</label>
                                <input type="email" name="email" id="email" class="form-control" required>
                            </div>
                            <div class="form-group">
                                <label for="password">Password *</label>
                                <input type="password" name="password" id="key" class="form-control" required>
                            </div>
                            <div class="form-group">
                                <label for="firstname">First Name *</label>
                                <input type="text" name="firstname" id="firstname" class="form-control" required>
                            </div>
                            <div class="form-group">
                                <label for="lastname">Last Name *</label>
                                <input type="text" name="lastname" id="lastname" class="form-control" required>
                            </div>
                            <input type="submit" name="submit" id="btn-login" class="btn btn-custom btn-lg btn-block" value="Register">
                        </form>
                    </div>
                </div> <!-- /.col-xs-12 -->
            </div> <!-- /.row -->
        </div> <!-- /.container -->
    </section>

    <hr>

<?php include_once "includes/footer.php";?>
