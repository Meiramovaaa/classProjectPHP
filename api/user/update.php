<?php
    include "../../config/base_url.php";
    include "../../config/db.php";

    if(isset($_POST['about'], 
    $_POST['email'], 
    $_POST['nickname'], 
    $_POST['full_name']) &&
    strlen($_POST['about']) > 0 &&
    strlen($_POST['email']) > 0 &&
    strlen($_POST['nickname']) > 0 &&
    strlen($_POST['full_name']) > 0){
        $email = $_POST['email'];
        $about = $_POST['about'];
        $nickname = $_POST['nickname'];
        $full_name = $_POST['full_name'];
        session_start();
        $id = $_SESSION['id'];

        if(isset($_FILES['image'],$_FILES['image']['name']) &&
        strlen($_FILES['image']['name']) > 0){

            $query = mysqli_query($con, 
            "SELECT img FROM users WHERE id=$id");
    
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
            "../../images/users/$image_name");
            $path = "images/users/".$image_name;

            $prep = mysqli_prepare($con, 
            "UPDATE users SET email=?, about=?, nickname=?, full_name=?,
            img=? WHERE id=?");

            mysqli_stmt_bind_param($prep, "sssssi",
            $email, $about, $nickname, $full_name, $path, $id);

            mysqli_stmt_execute($prep);
        }else{
            $prep = mysqli_prepare($con, 
            "UPDATE users SET email=?, about=?, nickname=?, full_name=? 
            WHERE id=?");
            mysqli_stmt_bind_param($prep, "ssssi", $email, 
            $about, $nickname, $full_name, $id);
            mysqli_stmt_execute($prep);
        }
        $_SESSION['nickname'] = $nickname;
        header("Location:$BASE_URL/profile.php?nickname=$nickname");

    }else{
        header("Location:$BASE_URL/editProfile.php?error=1");
    }
?>