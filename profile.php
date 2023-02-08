<?php
	include "config/base_url.php";
	include "config/db.php";
	include "config/time.php";
	$nickname = $_GET['nickname'];
?>
<!DOCTYPE html>
<html lang="en">
<head>
	<title>Профиль</title>
	<?php
		include "views/head.php";
	?>
</head>
<body>

<?php
	include "views/header.php";
?>

<section class="container page">
	<div class="page-content">
		<div class="page-header">
			<?php
				if($nickname == $_SESSION['nickname']){
			?>
				<h2>Мои блоги</h2>
				<a class="button" href="newblog.php">Новый блог</a>
			<?php
				}else{
			?>
				<h2>Блоги <?=$nickname?></h2>
			<?php
				}
			?>

		</div>

		<div class="blogs">
			<?php
				

				$prep = mysqli_prepare($con, 
				"SELECT b.*, u.nickname, c.name FROM blogs b
				LEFT OUTER JOIN users u ON b.author_id = u.id
				LEFT OUTER JOIN categories c ON b.category_id=c.id
				WHERE u.nickname = ?");

				mysqli_stmt_bind_param($prep, "s", $nickname);

				mysqli_stmt_execute($prep);

				$blogs = mysqli_stmt_get_result($prep);

				if(mysqli_num_rows($blogs)>0){
					while($blog = mysqli_fetch_assoc($blogs)){
			?>
			<div class="blog-item">
				<img class="blog-item--img" src="<?=$BASE_URL?>/<?=$blog['img']?>" alt="">
				<div class="blog-header">
					<h3><?=$blog['title']?></h3>
					<?php
						if($nickname == $_SESSION['nickname']){
					?>
						<span class="link">
							<img src="images/dots.svg" alt="">
							Еще

							<ul class="dropdown">
								<li> <a href="<?=$BASE_URL?>/editblog.php?id=<?=$blog['id']?>">Редактировать</a> </li>
								<li> <a href="<?=$BASE_URL?>/api/blog/delete.php?id=<?=$blog['id']?>" class="danger">Удалить</a></li>
							</ul>
						</span>
					<?php
						}
					?>

				</div>
				<p class="blog-desc"><?=$blog['description']?></p>

				<div class="blog-info">
					<span class="link">
						<img src="images/date.svg" alt="">
						<?=time_elapsed_string(strtotime($blog['date']))?>
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
			</div>
			
			<?php
				}
			}else{
			?>

			<h1>0 blogs</h1>

			<?php
			}
			?>


		</div>
	</div>
	<div class="page-info">
		<?php
			$id = $_SESSION['id'];
			$currentUser = mysqli_query($con, 
			"SELECT * FROM users WHERE id=$id");
			$user = mysqli_fetch_assoc($currentUser);
		?>
		<div class="user-profile">
			<?php
				if(!$user['img'] == NULL){
			?>
				<img class="user-profile--ava" src="<?=$user['img']?>" alt="">
			<?php
				}else{
			?>
				<img class="user-profile--ava" src="images/incognito.png" alt="">
			<?php
				}
			?>

			<h1><?=$user['full_name']?></h1>
			<h2><?=$user['about']?></h2>
			<p><?=mysqli_num_rows($blogs)?> постов за все время</p>
			<a href="<?=$BASE_URL?>/editProfile.php" class="button">Редактировать</a>
			<a href="<?=$BASE_URL?>/api/user/signout.php" class="button button-danger"> Выход</a>
		</div>
	</div>
</section>	
</body>
</html>