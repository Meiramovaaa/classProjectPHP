<?php
	include "config/base_url.php";
	include "config/db.php";
	include "config/time.php";

	if(!isset($_GET['id'])){
		header("Location: $BASE_URL/index.php");
		exit();
	}
	$id = $_GET['id'];
	$query_blog = mysqli_query($con, 
	"SELECT b.*, c.name, u.nickname 
	FROM blogs b 
	LEFT OUTER JOIN categories c ON b.category_id=c.id
	LEFT OUTER JOIN users u ON b.author_id=u.id
	WHERE b.id=$id");

	if(mysqli_num_rows($query_blog) == 0){
		header("Location: $BASE_URL/index.php");
		exit();
	}

	$blog = mysqli_fetch_assoc($query_blog);

?>
<!DOCTYPE html>
<html lang="en">
<head>
	<title>Профиль</title>
    <?php
		include "views/head.php";
	?>
</head>
<body 
data-baseurl=<?=$BASE_URL?> data-blogid=<?=$id?> data-current=<?=$_SESSION['id']?> data-author=<?=$blog['author_id']?>>

<?php
	include "views/header.php";
?>

<section class="container page">
	<div class="page-content">
		<div class="blogs">
			<div class="blog-item">
				<img class="blog-item--img" src="<?=$BASE_URL?>/<?=$blog['img']?>" alt="">

                <div class="blog-info">
					<span class="link">
						<img src="images/date.svg" alt="">
						<?= time_elapsed_string(strtotime($blog['date']))?>
					</span>
					<span class="link">
						<img src="images/visibility.svg" alt="">
						21
					</span>
					<a class="link">
						<img src="images/message.svg" alt="">
						4
					</a>
					<span class="link">
						<img src="images/forums.svg" alt="">
						<?=$blog['name']?>
					</span>
					<a class="link">
						<img src="images/person.svg" alt="">
						<?=$blog['nickname']?>
					</a>
				</div>

				<div class="blog-header">
					<h3><?=$blog['title']?></h3>
				</div>
				<p class="blog-desc"><?=$blog['description']?></p>
			</div>
		</div>

        <div class="comments" id="comments"></div>

		<?php
			if(isset($_SESSION['nickname'])){
		?>
            <span class="comment-add">
                <textarea id="textarea" class="comment-textarea" placeholder="Введит текст комментария"></textarea>
                <button id="add_btn" class="button">Отправить</button>
            </span>
		<?php
			}else{
		?>
            <span class="comment-warning">
                Чтобы оставить комментарий <a href="<?=$BASE_URL?>/register.php">зарегистрируйтесь</a> , или  <a href="<?=$BASE_URL?>/login.php">войдите</a>  в аккаунт.
            </span>
		<?php
			}
		?>

	</div>
	

    <?php
		include "views/categories.php";
	?>
</section>	

	<script src="https://cdnjs.cloudflare.com/ajax/libs/axios/0.26.0/axios.min.js" integrity="sha512-bPh3uwgU5qEMipS/VOmRqynnMXGGSRv+72H/N260MQeXZIK4PG48401Bsby9Nq5P5fz7hy5UGNmC/W1Z51h2GQ==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
	<script src="js/comment.js"></script>
</body>
</html>