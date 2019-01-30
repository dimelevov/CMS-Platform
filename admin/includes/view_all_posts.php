<?php
if (isset($_POST['checkBoxArray'])) {
    foreach ($_POST['checkBoxArray'] as $postValueId) {
        $bulk_options = $_POST['bulk_options'];
        
        switch($bulk_options) {
            case 'published':
            $query = "UPDATE posts SET post_status = '{$bulk_options}' WHERE post_id = {$postValueId}";
            $update_to_publish_status = mysqli_query($connection, $query);
            confirmQuery($update_to_publish_status);
            break;
                
            case 'draft':
            $query = "UPDATE posts SET post_status = '{$bulk_options}' WHERE post_id = {$postValueId}";
            $update_to_draft_status = mysqli_query($connection, $query);
            confirmQuery($update_to_draft_status);
            break;
                
            case 'delete':
            $query = "DELETE FROM posts WHERE post_id = {$postValueId}";
            $update_to_delete_status = mysqli_query($connection, $query);
            confirmQuery($update_to_delete_status);
            break;
                
            case 'clone':
            $query = "SELECT * FROM posts WHERE post_id = {$postValueId}";
            $select_post_query = mysqli_query($connection, $query);
                
            while($row = mysqli_fetch_assoc($select_post_query)) {
                $db_post_title = $row['post_title'];
                $db_post_category_id = $row['post_category_id'];
                $db_post_author = $row['post_author'];
                $db_post_image = $row['post_image'];
                $db_post_content = $row['post_content'];
                $db_post_tag = $row['post_tag'];
                $db_post_status = $row['post_status'];
                $db_post_date = $row['post_date'];
            }    
            
            $query = "INSERT INTO posts(post_category_id, post_title, post_author, post_image, post_content, post_tag, post_date, post_status)";
            $query .= " VALUES({$db_post_category_id}, '{$db_post_title}', '{$db_post_author}', '{$db_post_image}', '{$db_post_content}', '{$db_post_tag}', now(), '{$db_post_status}') ";
            
            $copy_query = mysqli_query($connection, $query);
            if (!$copy_query) {
                die("QUERY FAILED!" . mysqli_error($connection));
            } else {
                echo "<div class='alert alert-success text-center' role='alert'>Post cloned.</div>";
            }
            break;
        }
    }
}
?>
<h1 class="text-center">All Posts</h1>
<hr>
<form action="" method="post">
    <table class="table table-bordered table-hover">
       <div id="bulkOptionContainer" class="col-xs-4">
           <select class="form-control" name="bulk_options" id="">
               <option value="">Select Option</option>
               <option value="published">Publish</option>
               <option value="draft">Draft</option>
               <option value="delete">Delete</option>
               <option value="clone">Clone</option>
           </select>
       </div>
       <div class="col-xs-4">
           <input type="submit" name="submit" class="btn btn-success" value="Apply">
           <a class="btn btn-primary" href="posts.php?source=add_post">Add New</a>
       </div>
       
        <thead>
            <tr>
                <th><input id="selectAllBoxes" type="checkbox"></th>
                <th>Id</th>
                <th>Author</th>
                <th>Title</th>
                <th>Category</th>
                <th>Status</th>
                <th>Image</th>
                <th>Tags</th>
                <th>Comments</th>
                <th>Date</th>
                <th>Views</th>
            </tr>
        </thead>
        <tbody>

           <?php
                $query = "SELECT * FROM posts ORDER BY post_id DESC";
                $select_posts = mysqli_query($connection, $query);

                while($row = mysqli_fetch_assoc($select_posts)) {
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
                    $post_views_count = $row['post_views_count'];
                    echo "<tr>";
                    ?>
                    <td><input class='checkBoxes' type='checkbox' name='checkBoxArray[]' value='<?php echo $post_id; ?>'></td>
                    <?php
                    echo "<td>{$post_id}</td>";
                    echo "<td>{$post_author}</td>";
                    echo "<td><a href='../post.php?p_id={$post_id}'>{$post_title}</a></td>";


                    $query = "SELECT * FROM categories WHERE cat_id = $post_category_id ";
                    $select_categoties_id = mysqli_query($connection, $query);
                    while($row = mysqli_fetch_assoc($select_categoties_id)) {
                        $cat_id = $row['cat_id'];
                        $cat_title = $row['cat_title'];

                    echo "<td>{$cat_title}</td>";
                    }
                    echo "<td>{$post_status}</td>";
                    echo "<td><img width='100' src='../images/{$post_image}'></td>";
                    echo "<td>{$post_tag}</td>";
                    echo "<td>{$post_comment_count}</td>";
                    echo "<td>{$newPostDate}</td>";
                    echo "<td><a href='posts.php?reset={$post_id}'>{$post_views_count}</a></td>";
                    echo "<td><a href='posts.php?source=edit_post&p_id={$post_id}'>Edit</a></td>";
                    echo "<td><a onClick=\"javasctipt: return confirm('Are you sure, do you wan to delete?'); \" href='posts.php?delete={$post_id}'>Delete</a></td>";
                    echo "</tr>";
                }
            ?>
        </tbody>
    </table>
</form>

<?php
if(isset($_GET['delete'])) {
    $the_post_id = $_GET['delete'];
    
    $query = "DELETE FROM posts WHERE post_id = {$the_post_id} ";
    $deletePost = mysqli_query($connection, $query);
    header ('Location: posts.php'); 
}

if(isset($_GET['reset'])) {
    $the_post_id = $_GET['reset'];
    
    $query = "UPDATE posts SET post_views_count = 0 WHERE post_id = {$the_post_id}";
    $reset_post_views = mysqli_query($connection, $query);
    header ('Location: posts.php'); 
}
?>




