<?php
    include "../../config/db.php";
    include "../../config/base_url.php";
    $id = $_GET['id'];
    if(isset($_POST['title'], 
        $_POST['description'],
        $_POST['category_id']) &&
        strlen($_POST['title']) > 0 &&
        strlen($_POST['description']) > 0 ){
            $title = $_POST['title'];
            $desc = $_POST['description'];
            $cat_id = $_POST['category_id'];
            session_start();
            $author_id = $_SESSION['id'];

            if(isset($_FILES['image'], $_FILES['image']['name']) &&
            strlen($_FILES['image']['name']) > 0){
                $query = mysqli_query($con, 
                "SELECT img FROM blogs WHERE id=$id");
    
                if(mysqli_num_rows($query) > 0){
                    // "../../images/blogs/1234567.png"
                    $row = mysqli_fetch_assoc($query);
                    $old_path = __DIR__."../../".$row['img'];
                    // __DIR__ = "localhost/web156/api/blog/../../images/blogs/1234567.png
                    if(file_exists($old_path)){
                        unlink($old_path);
                    }
                }
                $ext = end(explode(".", $_FILES['image']['name'])); // png
                $image_name = time().".".$ext;
                move_uploaded_file($_FILES['image']['tmp_name'],
                "../../images/blogs/$image_name");
                $path = "images/blogs/".$image_name;

                $prep = mysqli_prepare($con, 
                "UPDATE blogs SET title=?, description=?, category_id = ?, img = ?
                WHERE id = ? AND author_id=?");
    
                mysqli_stmt_bind_param($prep, "ssisii",
                $title, $desc, $cat_id, $path, $id, $author_id);
    
                mysqli_stmt_execute($prep);

            }else{
                $prep = mysqli_prepare($con, 
                "UPDATE blogs SET title=?, description=?, category_id = ?
                WHERE id = ? AND author_id=?");
    
                mysqli_stmt_bind_param($prep, "ssiii",
                $title, $desc, $cat_id, $id, $author_id);
    
                mysqli_stmt_execute($prep);
            }

            $nickname = $_SESSION['nickname'];
            header("Location:$BASE_URL/profile.php?nickname=$nickname");
    }else{
        header("Location:$BASE_URL/editblog.php?error=1&id=$id");
    }
?>