<?php include_once ("includes/admin_header.php"); ?>

<div id="wrapper">

    <!-- Navigation -->
    <?php include "includes/admin_navigation.php"; ?>

    <div id="page-wrapper">

        <div class="container-fluid">

            <!-- Page Heading -->
            <div class="row">
                <div class="col-lg-12">
                    <?php
                        if (isset($_SESSION['delete_user_message'])) {
                            echo '<div class="alert alert-danger" role="alert">' . $_SESSION['delete_user_message'] . '</div>';
                            unset($_SESSION['delete_user_message']);
                        }
                    ?>
                    <?php 
                    
                    if(isset($_GET['source'])) {
                        $source = $_GET['source'];
                    } else {
                        $source = '';
                    }
                        
                    switch($source) {
                        case 'add_user';
                        include "includes/add_user.php";
                        break;

                        case 'edit_user';
                        include "includes/edit_user.php";
                        break;

                        case '36';
                        echo "nice 2";
                        break;

                        case '37';
                        echo "nice 3";
                        break;

                        default:
                        include "includes/view_all_users.php";
                        break;
                    } 
                    ?>
                </div><!-- /.col-lg-12 -->
            </div><!-- /.row -->
        </div><!-- /.container-fluid -->
    </div><!-- /#page-wrapper -->

<?php include "includes/admin_footer.php"; ?>