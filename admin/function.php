<?php
require_once("../includes/db.php");

function users_online() {
    if (isset($_GET['onlineusers'])) {
        global $connection;

        if ($connection) {
            session_start();

            $session = session_id();
            $time = time();
            $time_out_in_seconds = 60;
            $time_out = $time - $time_out_in_seconds;

            $query = "SELECT * FROM users_online WHERE session = '$session'";
            $send_query = mysqli_query($connection, $query);
            $count = mysqli_num_rows($send_query);

            if ($count == NULL) {
                mysqli_query($connection, "INSERT INTO users_online(session, time) VALUES('$session', '$time')");
            } else {
                mysqli_query($connection, "UPDATE users_online SET time = '$time' WHERE session = '$session'");
            }

            $users_online_query = mysqli_query($connection, "SELECT * FROM users_online WHERE time > '$time_out'");
            echo $count_user = mysqli_num_rows($users_online_query);
        }
    } // get request isset
}

users_online();

function confirmQuery($result) {
    global $connection;
    if (!$result) {
        die("QUERY FAILED" . mysqli_error($connection));
    }
}

function insert_categories() {
    global $connection;
    if (isset($_POST['submit'])) {
        $cat_title = $_POST['cat_title'];

        if ($cat_title == "" || empty($cat_title)) {
            echo '<div class="alert alert-danger" role="alert">This field should not be empty!</div>';
        } else {
            $query = "INSERT INTO categories(cat_title)";
            $query .= " VALUE('{$cat_title}')";

            $create_category_query = mysqli_query($connection, $query);

            if (!$create_category_query) {
                die('QUERY FAILED' . mysqli_error($connection));
            }
        }
    }
}

function findAllCategories() {
    global $connection;
    $query = "SELECT * FROM categories";
    $select_categoties = mysqli_query($connection, $query);

    while ($row = mysqli_fetch_assoc($select_categoties)) {
        $cat_id = $row['cat_id'];
        $cat_title = $row['cat_title'];
        echo "<tr>";
        echo "<td>{$cat_id}</td>";
        echo "<td>{$cat_title}</td>";
        echo "<td><a href='categories.php?edit={$cat_id}'>Edit</a></td>";
        echo "<td><a href='categories.php?delete={$cat_id}'>Delete</a></td>";
        echo "</tr>";
     } 
}

function deleteCategories($catId = null) {
    global $connection;
    if (!isset($catId) && isset($_GET['delete'])) {
        $catId = $_GET['delete'];
    }
    
    if (isset($catId)) {
        $query = "DELETE FROM categories WHERE cat_id = {$catId}";
        $delete_categories = mysqli_query($connection, $query);
        header("Location: categories.php");
    }  
}