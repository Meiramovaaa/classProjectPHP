<?php
    include "../../config/base_url.php";
    include "../../config/db.php";

    if(!isset($_GET['id'])){
        exit();
    }

    $id = $_GET['id'];

    $query_comments = mysqli_query($con, 
    "SELECT c.*, u.full_name FROM comments c
    LEFT OUTER JOIN users u ON c.author_id=u.id
    WHERE c.blog_id=$id");

    // php => js 
    // echo json_encode(arr)

    // js => php
    // echo json_decode(arr)
    $comments = array();
    if(mysqli_num_rows($query_comments) == 0){
        echo json_encode($comments);
        exit();
    }

    while($com = mysqli_fetch_assoc($query_comments)){
        $comments[] = $com;
    }
    echo json_encode($comments);
?>