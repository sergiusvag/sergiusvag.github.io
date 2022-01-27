


<?php

    require_once '/OpenServer/domains/XO/includes/connect.php';	

    $tableNameMistake = 'mistakes';
    $mistakes = mysqli_query($connection, "SELECT * FROM `$tableNameMistake`");

    session_start();
    if(!$_SESSION["user"]) {
		require_once '/OpenServer/domains/XO/includes/components/head.php';
    }

?>

<!DOCTYPE html>
<html lang="ru">
<head>
<?php
    require_once '/OpenServer/domains/XO/includes/components/head.php';
?>
<link rel="stylesheet" href="/css/admin.css">
</head>
<body>
<!-- questions -->
<section id="questions" class="questions">
    <div class="user-wrap">
        <p class="user-info">Добро пожаловать, <span class="user-name"><?= $_SESSION["user"]["login"] ?></span></p>
        <a href="../logout.php" class="btn btn-logout">Выйти</a>
    </div>
    <div class="admin-panel">
        <div class="menu menu-buttons">
            <a href="./show.php"  class="admin-panel-btn admin-panel-btn_show">Показать</a>
            <a href="./add.php" class="admin-panel-btn admin-panel-btn_add">Добавить</a>
            <a href="./new.php" class="admin-panel-btn admin-panel-btn_new">Новое</a>
            <a href="./mistakes.php" class="admin-panel-btn admin-panel-btn_mistake">Ошибки</a>
        </div>
        <div class="container">
            <div class="form-wrapper d-block">
                <div class="form-question form-question_mistake">
                    <h3 class="form-question__title">Меню ошибок</h3>
                    <?php
                        if ($_SESSION["Message"]) {
                    ?>
                        <div class="message error-message">
                            <p><?= $_SESSION["Message"] ?> </p>
                        </div>
                    <?php
                        }

                        $_SESSION["Message"] = 0;
                    ?>
                    <div class="table-wrap">
                        <table class="table-question_mistake">
                            <thead >
                                <th scope="col" class="table-small-col">№ Ошибки</th>
                                <th scope="col" class="table-small-col">№ Вопроса</th>
                                <th scope="col">Ошибка</th>
                                <th scope="col">Действие</th>
                            </thead>
                        <?php
                            while ($mistake = mysqli_fetch_assoc($mistakes)){
                                ?>
                                    <tbody>
                                        <tr>
                                            <th scope="row"><?= $mistake["id"] ?></th>
                                            <td><?= $mistake["questionId"] ?></td>
                                            <td><?= $mistake["mistake"] ?></td>
                                            <td class="show-buttons table-small-col">
                                                <form action="../delete-question.php?backTo=mistakes" method="post">
                                                    <input type="hidden" name="id" value="<?= $mistake["id"] ?>">
                                                    <input type="hidden" name="tableName" value="<?= $tableNameMistake ?>">
                                                    <input type="hidden" name="item" value="Ошибка">
                                                    <input type="hidden" name="return" value="false">
                                                    <button type="submit" class="btn-show btn-show-delete">Удалить</button>
                                                </form>
                                                <a href="../edit-question.php?id=<?= $mistake["questionId"] ?>&tableName=questions&check=true&backTo=mistakes" class="btn-show btn-show-edit">Редактировать</a>
                                            </td>
                                        </tr>
                                    </tbody>
                                <?php
                            }
                        ?>
                        </table>
                    </div>
                </div>
                
            </div>
        </div>
    </div>
</section>
<!-- Connect JS -->
<!-- <script src="../admin/js/admin.js"></script> -->
</body>
</html>