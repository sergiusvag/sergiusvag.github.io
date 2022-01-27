
<section id="before-game" class="before-game">
    <div class="container">
        <div class="before-wrap">
            <div class="user-login-wrap">
                <span class="loged-user-info">Здраствуйте! <span class="loged-user"><?= $_SESSION["gameUser"]['login'] ?></span></span>
                <a href="../user/logout.php" class="btn-user btn-logout">Выйти</a>
                <!-- <a href="./user/login.php" class="btn-user btn-user_login">Вход</a>
                <a href="./user/register.php" class="btn-user btn-user_register">Регистрация</a> -->
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
    </div>
</section>