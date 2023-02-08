<?php
    include "../../config/base_url.php";
    include "../../config/db.php";

    $data = json_decode(file_get_contents("php://input"), true);
    if(isset($data['text'], $data['blog_id'], $data['author_id']) &&
    strlen($data['text']) > 0 &&
    intval($data['blog_id']) &&
    intval($data['author_id'])){
        $blog_id = $data['blog_id'];
        $author_id = $data['author_id'];
        $text = $data['text'];

        $prep = mysqli_prepare($con, 
        "INSERT INTO comments (text, blog_id, author_id) 
        VALUES(?, ?, ?)");
        mysqli_stmt_bind_param($prep, "sii", $text, $blog_id, $author_id);
        mysqli_stmt_execute($prep);
    }
?>