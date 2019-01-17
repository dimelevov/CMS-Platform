<table class="table table-bordered table-hover">
    <thead>
        <tr>
            <th>Id</th>
            <th>Author</th>
            <th>Title</th>
            <th>Category</th>
            <th>Status</th>
            <th>Image</th>
            <th>Tags</th>
            <th>Comments</th>
            <th>Date</th>
        </tr>
    </thead>
    <tbody>

       <?php
            $query = "SELECT * FROM posts";
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
                echo "<tr>";
                echo "<td>{$post_id}</td>";
                echo "<td>{$post_author}</td>";
                echo "<td>{$post_title}</td>";
                
                
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
                echo "<td><a href='posts.php?draft={$post_id}'>Draft</a></td>";
                echo "<td><a href='posts.php?publish={$post_id}'>Publish</a></td>";
                echo "<td><a href='posts.php?source=edit_post&p_id={$post_id}'>Edit</a></td>";
                echo "<td><a href='posts.php?delete={$post_id}'>Delete</a></td>";
                echo "</tr>";
            }
        ?>
    </tbody>
</table>

<?php
if(isset($_GET['draft'])) {
    $draft_post_id = $_GET['draft'];
    
    $query = "UPDATE posts SET post_status = 'draft' WHERE post_id = {$draft_post_id}";
    $move_to_draft = mysqli_query($connection, $query);
    header ('Location: posts.php'); 
}
if(isset($_GET['publish'])) {
    $publish_post_id = $_GET['publish'];
    
    $query = "UPDATE posts SET post_status = 'published' WHERE post_id = {$publish_post_id}";
    $publish_post = mysqli_query($connection, $query);
    header ('Location: posts.php'); 
}
if(isset($_GET['delete'])) {
    $deletePostsId = $_GET['delete'];
    
    $query = "DELETE FROM posts WHERE post_id = {$deletePostsId} ";
    $deletePost = mysqli_query($connection, $query);
    header ('Location: posts.php'); 
}

?>




