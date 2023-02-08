<?php
    include "../../config/base_url.php";
    session_start();
    if(isset($_SESSION['nickname'])){
        session_destroy();
        header("Location:$BASE_URL/index.php");
    }
?>




