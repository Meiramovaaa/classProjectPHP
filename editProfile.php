<?php
    include "config/base_url.php";
    include "config/db.php";
?>

<!DOCTYPE html>
<html lang="en">
<head>
	<title>Редактирование профиля</title>
	<?php
		include "views/head.php";
	?>
</head>
<body>
<?php
	include "views/header.php";
?>
<?php
    $id = $_SESSION['id'];
    $user = mysqli_query($con,
    "SELECT * FROM users WHERE id=$id");
    $row = mysqli_fetch_assoc($user);
?>

	<section class="container page">
		<div class="auth-form">
            <h1>Редактирование профиля</h1>
			<form class="form" action="<?=$BASE_URL?>/api/user/update.php" method="POST" enctype="multipart/form-data">
                <fieldset class="fieldset">
                    <input class="input" type="text" name="email" value="<?=$row['email']?>">
                </fieldset>
                <fieldset class="fieldset">
                    <input class="input" type="text" name="full_name" value="<?=$row['full_name']?>">
                </fieldset>
                <fieldset class="fieldset">
                    <input class="input" type="text" name="nickname" value="<?=$row['nickname']?>">
                </fieldset>
                <fieldset class="fieldset">
					<button class="button button-yellow input-file">
						<input type="file" name="image">	
						Выберите картинку
					</button>
				</fieldset>
                <fieldset>
                    <textarea name="about" cols="52" rows="10" placeholer="About you"></textarea>
                </fieldset>

                <fieldset class="fieldset">
                    <button class="button" type="submit">Обновить</button>
                </fieldset>
			</form>
		</div>
	</section>
</body>
</html>