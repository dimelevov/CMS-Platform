<!-- Connection -->
<?php include "includes/db.php"; ?>
<!-- Header -->
<?php include "includes/header.php"; ?>
<!-- Navigation -->
<?php include "includes/navigation.php"; ?>

<!-- Page Content -->
<div class="container">

    <div class="row">

        <!-- Blog Entries Column -->
        <div class="col-md-8">
            
            
            <?php
            $has_posts = false;
            $query = "SELECT * FROM posts";
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
                    $citString = $post_content;
                }
                $post_status = $row['post_status'];
                
                if ($post_status == 'published') {
                    $has_posts = true;
                ?>
                
            <h1 class="page-header">
                Page Heading
                <small>Secondary Text</small>
            </h1>

            <!-- First Blog Post -->
            <h2>
                <a href="post.php?p_id=<?php echo $post_id; ?>"><?php echo $post_title; ?></a>
            </h2>
            <p class="lead">
                by <a href="index.php"><?php echo $post_author; ?></a>
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
<!-- Footer -->
<?php include "includes/footer.php"; ?>