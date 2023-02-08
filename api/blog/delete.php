<?php
    include "../../config/db.php";
    include "../../config/base_url.php";
    session_start();
    $nickname = $_SESSION['nickname'];

    if(isset($_GET['id'])){
        $id = $_GET['id'];
        $user = $_SESSION['id'];

        mysqli_query($con, 
        "DELETE FROM blogs WHERE id=$id AND author_id=$user");
        header("Location:$BASE_URL/profile.php?nickname=$nickname");
    }else{
        header("Location:$BASE_URL/profile.php?nickname=$nickname&error=1");
    }
?>