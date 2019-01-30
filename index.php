<!-- Connection -->
<?php include_once ("includes/db.php"); ?>
<!-- Header -->
<?php include_once ("includes/header.php"); ?>
<!-- Navigation -->
<?php include_once ("includes/navigation.php"); ?>

<!-- Page Content -->
<div class="container">

    <div class="row">

        <!-- Blog Entries Column -->
        <div class="col-md-8">
            <?php
            if (isset($_SESSION['error_mes'])) {
                echo '<div class="alert alert-danger" role="alert">' . $_SESSION['error_mes'] . '</div>';
                unset($_SESSION['error_mes']);
            }
            
            if (isset($_SESSION['error_login'])) {
                echo '<div class="alert alert-warning" role="alert">' . $_SESSION['error_login'] . '</div>';
                unset($_SESSION['error_login']); 
            }
            ?>
            
            <?php
            $per_page = 5;
            
            if (isset($_GET['page'])) {
                $page = $_GET['page'];
            } else {
                $page = "";
            }
            
            if ($page == "" || $page == 1) {
                $page_1 = 0;
            } else {
                $page_1 = ($page * $per_page) - $per_page;
            }
            
            $post_count_query = "SELECT * FROM posts";
            $find_count = mysqli_query($connection, $post_count_query);
            $count = mysqli_num_rows($find_count);
            $count = ceil($count / $per_page);
            
            $has_posts = false;
            $query = "SELECT * FROM posts LIMIT $page_1, $per_page";
            $select_all_posts_query = mysqli_query($connection, $query);
                
            while($row = mysqli_fetch_assoc($select_all_posts_query)) {
                $post_id = $row['post_id'];
                $post_title = $row['post_title'];
                $post_author = $row['post_author'];
                $post_date = $row['post_date'];
                $newDate = date("d-M-Y", strtotime($post_date));
                $post_image = $row['post_image'];
                $post_content = $row['post_content'];
                if (strlen($post_content) > 150) {
                    $cutString = substr($post_content, 0, 150) . "...";
                } else {
                    $cutString = $post_content;
                }
                
                $post_status = $row['post_status'];
                if ($post_status == 'published') {
                    $has_posts = true;
                ?>

            <!-- First Blog Post -->
            <h2>
                <a href="post.php?p_id=<?php echo $post_id; ?>"><?php echo $post_title; ?></a>
            </h2>
            <p class="lead">
                by <a href="author_posts.php?author=<?php echo $post_author; ?>&p_id=<?php echo $post_id; ?>"><?php echo $post_author; ?></a>
            </p>
            <p><span class="glyphicon glyphicon-time"></span> Post on <?php echo $newDate; ?></p>
            <hr>
            <a href="post.php?p_id=<?php echo $post_id; ?>">
            <img class="img-responsive" src="images/<?php echo $post_image; ?>" alt="">
            </a>
            <hr>
            <p><?php echo $cutString; ?></p>
            <a class="btn btn-primary" href="post.php?p_id=<?php echo $post_id; ?>">Read More <span class="glyphicon glyphicon-chevron-right"></span></a>

            <hr> 
                
            <?php 
                }
            } 
            if ($has_posts == false) {
                echo "<h2 class='text-center'>No Posts Published, Sorry</h2>";
            }
            
            ?>

            

        </div>

        <!-- Blog Sidebar Widgets Column -->
        <?php include "includes/sidebar.php"; ?>

    </div>
    <!-- /.row -->

    <hr>
    
    <ul class="pager">
        <?php
        for ($i=1; $i<=$count; $i++) {
            if ($i == $page) {
                echo "<li><a class='active_link' href='index.php?page=$i'>{$i}</a></li>";
            } else {
                echo "<li><a href='index.php?page=$i'>{$i}</a></li>";
            }
        }
        
        
        
        ?>
    </ul>
<!-- Footer -->
<?php include "includes/footer.php"; ?>