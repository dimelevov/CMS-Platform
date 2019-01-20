<?php
    if (isset($_GET['p_id'])) {
        $p_id = $_GET['p_id'];
    }

    $query = "SELECT * FROM posts WHERE post_id = {$p_id}";
    $select_posts_by_id = mysqli_query($connection, $query);

    while ($row = mysqli_fetch_assoc($select_posts_by_id)) {
        $post_id = $row['post_id'];
        $post_category_id = $row['post_category_id'];
        $post_title = $row['post_title'];
        $post_author = $row['post_author'];
        $post_date = $row['post_date'];
        $newPostDate = date("d-M-Y", strtotime($post_date));
        $post_image = $row['post_image'];
        $post_tag = $row['post_tag'];
        $post_comment_count = $row['post_comment_count'];
        $post_status = $row['post_status'];
        $post_content = $row['post_content'];
    }

    if (isset($_POST['update_post'])) {
        $post_author = mysqli_real_escape_string($connection, $_POST['post_author']);
        $post_title = mysqli_real_escape_string($connection, $_POST['post_title']);
        $post_category_id = mysqli_real_escape_string($connection, $_POST['post_category']);
        $post_status = mysqli_real_escape_string($connection, $_POST['post_status']);
        $post_image = $_FILES['image']['name'];
        $post_image_temp = $_FILES['image']['tmp_name'];
        $post_content = mysqli_real_escape_string($connection, $_POST['post_content']);
        $post_tag = mysqli_real_escape_string($connection, $_POST['post_tag']);

    
    move_uploaded_file($post_image_temp, "../images/$post_image");
    
    if(empty($post_image)) {
        $query = "SELECT * FROM posts WHERE post_id = $p_id ";
        $select_image = mysqli_query($connection, $query);
        
        while($row = mysqli_fetch_assoc($select_image)) {
            $post_image = $row['post_image'];
        }
    }
    
    
    $query = "UPDATE posts SET ";
    $query .="post_title = '{$post_title}', ";
    $query .="post_category_id = '{$post_category_id}', ";
    $query .="post_date = now(), ";
    $query .="post_author = '{$post_author}', ";
    $query .="post_status = '{$post_status}', ";
    $query .="post_tag = '{$post_tag}', ";
    $query .="post_content = '{$post_content}', ";
    $query .="post_image = '{$post_image}' ";
    $query .= "WHERE post_id = {$p_id} ";
    
    $update_post_query = mysqli_query($connection, $query);
        
    if(!$update_post_query) {
        die("QUERY FAILED" . mysqli_error($connection));
    } else {
        echo '<div class="alert alert-info" role="alert">Post updated.</div>';
    }
}

?>
  

  <h1 class="text-center">Edit Posts</h1>
   <form action="" method="post" enctype="multipart/form-data">
    <div class="form-group">
        <label for="title">Post Title</label>
        <input type="text" value="<?php if(isset($post_title)) {echo $post_title;} ?>" class="form-control" name="post_title">
    </div>
    <div class="form-group">
        <label for="post_category">Post Category Id</label><br>
        <select name="post_category" id="post_category">
        <?php
            $query = "SELECT * FROM categories ";
            $select_categoties = mysqli_query($connection, $query);
            confirmQuery($select_categoties);    
        
            while($row = mysqli_fetch_assoc($select_categoties)) {
                $cat_id = $row['cat_id'];
                $cat_title = $row['cat_title'];
                
                echo "<option value='{$cat_id}'>{$cat_title}</option>";
            }
        ?>
        </select>
    </div>
    <div class="form-group">
        <label for="title">Post Author</label>
        <input type="text" value="<?php if(isset($post_author)) {echo $post_author;} ?>" class="form-control" name="post_author">
    </div>
    <div class="form-group">
        <label for="post_status">Post Status</label>
        <input type="text" value="<?php if(isset($post_status)) {echo $post_status;} ?>" class="form-control" name="post_status">
    </div>
    <div class="form-group">
        <label for="post_image">Post Image</label><br>
        <img width="100" src="../images/<?php if(isset($post_image)) {echo $post_image;} ?>" alt="">
        <input type="file" name="image">
    </div>
    <div class="form-group">
        <label for="post_tag">Post Tags</label>
        <input type="text" value="<?php if(isset($post_tag)) {echo $post_tag;} ?>" class="form-control" name="post_tag">
    </div>
    <div class="form-group">
        <label for="post_content">Post Content</label>
        <textarea name="post_content" id="" cols="30" rows="10" class="form-control"><?php if(isset($post_content)) {echo $post_content;} ?>
        </textarea>
    </div>
    <div class="form group">
        <input type="submit" class="btn btn-primary" name="update_post" value="Update Post">
    </div>
</form>