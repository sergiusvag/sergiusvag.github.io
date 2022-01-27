<?php

	require_once '../includes/connect.php';



	session_start();
    $id = $_SESSION["gameUser"]["id"];
    $user = mysqli_query($connection, "SELECT * FROM `users` WHERE `id` = $id");
    $user = mysqli_fetch_assoc($user);
    $_SESSION["gameUser"] = $user;
	if(!$_SESSION["gameUser"]) {
		header("Location: index.php");
	} 
    
    if($_SESSION["gameUser"]["opLogin"] != "0" ) {
        header("Location: ../online/index.php");
        exit();
    }
?>

<!DOCTYPE html>
<html lang="ru">
<head>
	<?php
		require_once '../includes/components/head.php';
	?>

    <link rel="stylesheet" href="/css/user-log.css">

</head>
<body>
	<!-- Advantages -->
    <div id="refresh"></div>
	<section id="before-game" class="before-game">
		<div class="container">
			<div class="before-wrap">
				<div class="user-login-wrap">
                    <span class="loged-user-info">Здраствуйте! <span class="loged-user"><?= $_SESSION["gameUser"]['login'] ?></span></span>
                    <a href="../user/logout.php" class="btn-user btn-logout">Выйти</a>
				</div>
                <form action="/online/create.php" class="form-room" method="POST">
                    <div class="form-group form-group_room form-group_room-create">
                        <input type="hidden" name="id" value="<?= $id ?>">
                        <button type="submit" class="btn btn_create">Создать</button>
                        <div class="create-room-id"><?php 
                            if($_SESSION["gameUser"]["gameId"] !=0 ) {
                                echo $_SESSION["gameUser"]["gameId"];
                            }
                        ?></div>
                    </div>
                </form>
                <form action="/online/join.php" class="form-room" method="POST">
                    <div class="form-group form-group_room form-group_room-join">
                        <input type="text" name="room-id" class="form-control form-control_room-id" id="room-id" placeholder="Номер комнаты">
                        <button type="submit" class="btn btn_join">Присоединиться</button>
                    </div>
                </form>

				<div class="main-menu-buttons main-menu-buttons_room">
                    <a href="../index.php" class="btn btn-go-back btn-go-back-suggestion">Назад</a>
				</div>
			</div>
            <div class="chat-wrap">
                <div class="loged-chatters">
                    
                </div>
            </div>
		</div>
	</section>
	<!-- Footer -->
	<footer id="footer" class="footer">
		<div class="container">
			
		</div>
	</footer>
	<!-- Connect JS -->
    
    <script src="../js/jquery-3.5.1.min.js"></script>
    <script src="../js/room-check.js"></script>
    <script src="../js/room-chat.js"></script>
</body>
</html>