<header class="header container">
	<div class="header-logo">
	    <a href="index.php">Decode Blog</a>	
	</div>
	<form class="header-search" method="GET">
		<input name="q" type="text" class="input-search" placeholder="Поиск по блогам">
		<button type="submit" class="button button-search">
			<img src="images/search.svg" alt="">	
			Найти
		</button>
	</form>
<div>
	
	<?php
		if(isset($_SESSION['nickname'])){
			$id = $_SESSION['id'];
			$currentImg = mysqli_prepare($con, 
			"SELECT img FROM users WHERE id=?");
			mysqli_stmt_bind_param($currentImg, "i", $id);
			mysqli_stmt_execute($currentImg);
			$res = mysqli_stmt_get_result($currentImg);
			$path = mysqli_fetch_assoc($res);

			if(!$path['img'] == NULL){
				
			?>
				<a class="avatar-link" href="<?=$BASE_URL?>/profile.php?nickname=<?=$_SESSION['nickname']?>">
					<img class="avatar" src="<?=$path['img']?>" alt="Avatar">
				</a>
			<?php
			}else{
			?>
				<a class="avatar-link" href="<?=$BASE_URL?>/profile.php?nickname=<?=$_SESSION['nickname']?>">
					<img class="avatar" src="<?=$BASE_URL?>/images/incognito.png" alt="Avatar">
				</a>
			<?php
			}
			?>
	<?php
		}else{
	?>
		<div class="button-group">
			<a href="<?=$BASE_URL?>/register.php" class="button">Регистрация</a>
			<a href="<?=$BASE_URL?>/login.php" class="button">Вход</a>
		</div>
	<?php
		}
	?>
		
	</div>
</header>