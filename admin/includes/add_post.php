<?php
if(isset($_POST['create_post'])) {
    $post_title = $_POST['title'];
    $post_category_id = $_POST['post_category_id'];
    $post_author = $_POST['author'];
    $post_status = $_POST['post_status'];
    $post_image = $_FILES['image']['name'];
    $post_image_temp = $_FILES['image']['tmp_name'];
    $post_tags = $_POST['post_tag'];
    $post_content = $_POST['post_content'];
    $post_date = date('d-m-y');
//    $post_comment_count = 4;
    
    move_uploaded_file($post_image_temp, "../images/$post_image");
    
    $query = "INSERT INTO posts(post_category_id, post_title, post_author, post_date, post_image, post_content, post_tag, post_status) ";
    
    $query .= "VALUE({$post_category_id}, '{$post_title}', '{$post_author}', now(), '{$post_image}', '{$post_content}', '$post_tags', '{$post_status}' ) ";
    
    $create_post_query = mysqli_query($connection, $query);
    
    if (!$create_post_query) {
        die("QUERY FAILED" . mysqli_error($connection));
    } else {
        $the_post_id = mysqli_insert_id($connection);
        echo "<div class='alert alert-success text-center' role='alert'>Post created. <a href='../post.php?p_id={$the_post_id}'>View Post</a></div>";
    }
}

?>
<h1 class="text-center">Add New Post</h1>
<hr>
<form action="" method="post" enctype="multipart/form-data">
    <div class="form-group">
        <label for="title">Post Title</label>
        <input type="text" class="form-control" name="title">
    </div>
    <div class="form-group">
        <label for="post_category">Post Category Id</label><br>
        <select name="post_category_id" id="post_category">
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
        <input type="text" class="form-control" name="author">
    </div>
    <div class="form-group">
        <label for="post_status">Post Status</label><br>
        <select name="post_status" id="">
            <option value="draft">Select Options</option>
            <option value="draft">Draft</option>
            <option value="published">Published</option>
        </select>
    </div>
    <div class="form-group">
        <label for="post_image">Post Image</label>
        <input type="file" name="image">
    </div>
    <div class="form-group">
        <label for="post_tag">Post Tags</label>
        <input type="text" class="form-control" name="post_tag">
    </div>
    <div class="form-group">
        <label for="post_content">Post Content</label>
        <textarea name="post_content" id="body" cols="30" rows="10" class="form-control"></textarea>
    </div>
    <div class="form group">
        <input type="submit" class="btn btn-primary" name="create_post" value="Publish Post">
    </div>
</form>